<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\PendingTask;
use App\Models\TypePeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {

        try {
            // retrieve documents where pic or approval contains the NIK
            $nik = session('sso_user')['nik'] ?? 'null';
            $docs = Documents::where(function ($query) use ($nik) {
                $query->where('pic', 'like', '%' . $nik . '%')
                    ->orWhere('approval', 'like', '%' . $nik . '%');
            })->get();
        } catch (Exception $e) {
            Log::error('Failed to load data', [
                'error' => $e->getMessage()
            ]);
        }

        return view('admin.index', compact('docs'));
    }

    public function addDocument(Request $request)
    {

        try {
            $request->validate([
                'type_document' => 'required|string|max:255',
                'pic' => 'required|array',
                'approval' => 'required|array',
                'type_periods' => 'required|string',
                'periods' => 'sometimes|array',
                // Set default value for periods if not present
                'creating_task' => 'required|string|max:255'
            ]);

            if (!$request->input('periods')) {
                $request->merge(['periods' => ['0']]);
            }

            $document = new Documents();
            $document->type_document = $request->input('type_document');
            $document->pic = json_encode($request->input('pic'));
            $document->approval = json_encode($request->input('approval'));
            $document->creating_task = $request->input('creating_task');
            $document->created_by = session('sso_user')['fullname'] ?? 'null';
            $document->deleted_at = null;
            $document->save();
        } catch (Exception $e) {
            // Log the error with context
            Log::error('Failed to add document', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);
        }

        try {
            $document_period = new TypePeriod();
            $document_period->id_documents = $document->id_documents;
            // Determine period_type based on the number of selected periods
            $selectedPeriods = $request->input('periods');
            $document_period->period_type = $request->input('type_periods');
            if (!$selectedPeriods) {
                $document_period->period_value = null;
            } else {
                $document_period->period_value = json_encode($selectedPeriods);
            }
            $document_period->save();
        } catch (Exception $e) {
            Log::error('Failed to add document', [
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'Document added successfully.');
    }

    public function updateDocument(Request $request, $id)
    {

        try {
            $request->validate([
                'type_document' => 'required|string|max:255',
                'pic' => 'required|array',
                'approval' => 'required|array',
                'type_periods' => 'required|string',
                'periods' => 'sometimes|array',
                'creating_task' => 'required|string|max:255',
            ]);

            $document = Documents::findOrFail($id);
            $document->type_document = $request->input('type_document');
            $document->pic = $request->input('pic');
            $document->approval = $request->input('approval');
            $document->creating_task = $request->input('creating_task');
            $document->updated_by = session('sso_user')['fullname'] ?? 'null';
            $document->save();
        } catch (Exception $e) {
            Log::error('Failed to edit document', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);
        }

        try {
            // Update or create TypePeriod entry
            $typePeriod = TypePeriod::firstOrNew(['id_documents' => $document->id_documents]);
            $typePeriod->period_type = $request->input('type_periods');
            $selected = $request->input('periods');
            $typePeriod->period_value = $selected ? $selected : null;
            $typePeriod->save();
        } catch (Exception $e) {
            Log::error('Failed to edit document', [
                'error' => $e->getMessage(),
                'input' => $typePeriod->period_type
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Document updated', 'document' => $document]);
        }


        return redirect()->back()->with('success', 'Document updated successfully.');
    }

    public function deleteDocument($id)
    {
        try {
            $document = Documents::findOrFail($id);
            $document->deleted_by = session('sso_user')['fullname'] ?? 'null';
            $document->delete();
        } catch (Exception $e) {
            Log::error("Failed to delete document", [
                'error' => $e->getMessage()
            ]);
        }
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function taskList(Request $request)
    {
        // allow searching by a free-text query across a few document fields
        $q = $request->input('q');

        $nik = session('sso_user')['nik'];

        // $nik = '1111';

        $docsQuery = Documents::where('approval', 'like', '%' . $nik . '%')
            ->with(['pendingTask' => function ($query) {
                $query->where('status', '!=', 'waiting_document');
            }])
            ->whereHas('pendingTask', function ($query) {
                $query->where('status', '!=', 'waiting_document');
            });

        if (!empty($q)) {
            $like = '%' . $q . '%';
            $docsQuery->where(function ($query) use ($like) {
                // search in visible text columns. pic and approval are stored as JSON/text,
                // so a LIKE search will still match common values.
                $query->where('type_document', 'like', $like)
                    ->orWhere('pic', 'like', $like)
                    ->orWhere('approval', 'like', $like);
            });
        }

        $docs = $docsQuery->get();

        return view('admin.taskList', compact('docs'));
    }

    public function approveDocument($id)
    {
        try {
            $task = PendingTask::findOrFail($id);
            $task->status = 'approved';
            $task->rejected_reason = null; // clear any previous rejection reason
            $task->approved_by = session('sso_user')['fullname'] ?? 'Admin'; // use auth user name if available
            $task->save();
        } catch (Exception $e) {
            Log::error('Failed to approve document', [
                'error' => $e->getMessage()
            ]);
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Document approved successfully.', 'approved_by' => $task->approved_by]);
        }

        return redirect()->back()->with('success', 'Document approved successfully.');
    }

    /**
     * Approve multiple pending tasks passed as an array of ids in the request.
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Invalid data submitted.'], 400);
            }
            return redirect()->back()->with('error', 'Invalid data submitted.');
        }

        try {
            $tasks = PendingTask::whereIn('id_pending_task', $ids)->get();
            foreach ($tasks as $task) {
                $task->status = 'approved';
                $task->approved_by = session('sso_user')['fullname'] ?? 'Admin';
                $task->save();
            }
        } catch (Exception $e) {
            Log::error('Failed to approve bulk document', [
                'error' => $e->getMessage()
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($tasks) . ' document(s) approved successfully.', 'approved_by' => session('sso_user')['fullname'] ?? 'Admin']);
        }

        return redirect()->back()->with('success', count($tasks) . ' document(s) approved successfully.');
    }

    public function rejectDocument(Request $request, $id)
    {
        try {
            $task = PendingTask::findOrFail($id);
            $task->status = 'rejected';
            $task->rejected_by = session('sso_user')['fullname'] ?? 'null';

            // Save rejection reason if provided
            $reason = $request->input('rejection_reason');
            if ($reason) {
                $task->rejected_reason = $reason;
            }

            // remove the uploaded file
            if ($task->upload && file_exists(public_path($task->upload))) {
                @unlink(public_path($task->upload));
            }
            $task->upload = '';
            // Optionally record who performed the rejection
            $task->approved_by = session('sso_user')['fullname'] ?? 'Admin';
            $task->save();
        } catch (Exception $e) {
            Log::error('Failed to reject document', [
                'error' => $e->getMessage()
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Document rejected successfully.',
                'rejected_by' => $task->approved_by,
                'rejection_reason' => $task->rejected_reason,
            ]);
        }

        return redirect()->back()->with('success', 'Document rejected successfully.');
    }

    public static function apiEmployees()
    {
        $response = Http::withToken(config('services.e-portal.bearer_token'))
            ->get(config('services.e-portal.url_portal') . '/app/ext/ssotcel/api/v1/emp/employees?trxid=123456789&channel=9999');
        if ($response->successful()) {
            $users = $response->json();
            return $users['data'];
        } else {
            return response()->json(['error' => 'Failed to fetch employees'], $response->status());
        }
    }

    /**
     * Generate pending tasks for a document from year start to today
     */
    public function generateDocumentTask($id)
    {
        try {
            $document = Documents::with('periods')->findOrFail($id);
            $today = now()->startOfDay();
            $yearStart = now()->startOfYear();
            $creatingTaskDays = (int) ($document->creating_task ?? 0);
            $tasksCreated = 0;

            foreach ($document->periods as $period) {
                $values = $this->normalizePeriodValue($period->period_value);

                switch ($period->period_type) {
                    case 'daily':
                        // Generate tasks for every day from year start to today
                        $currentDate = $yearStart->copy();
                        while ($currentDate->lte($today)) {
                            if ($this->createTaskIfNotExists($document->id_documents, $currentDate->copy())) {
                                $tasksCreated++;
                            }
                            $currentDate->addDay();
                        }
                        break;

                    case 'weekly':
                        foreach ($values as $dayName) {
                            $dayName = trim($dayName);
                            if ($dayName === '') continue;

                            // Get first occurrence of this weekday from year start
                            $occurrence = $this->getNextOrSameWeekday($yearStart->copy(), $dayName);

                            // Generate tasks for all occurrences from year start to today
                            while ($occurrence->lte($today)) {
                                $creationDate = $occurrence->copy()->subDays($creatingTaskDays);

                                // Create task if the creation date has passed
                                if ($today->gte($creationDate)) {
                                    if ($this->createTaskIfNotExists($document->id_documents, $occurrence->copy())) {
                                        $tasksCreated++;
                                    }
                                }

                                $occurrence->addWeek();
                            }
                        }
                        break;

                    case 'yearly':
                        foreach ($values as $dateString) {
                            $dateString = trim($dateString);
                            if ($dateString === '') continue;

                            // Try to parse the date for current year
                            try {
                                $occurrence = \Carbon\Carbon::createFromFormat('j F Y', $dateString . ' ' . $today->year);
                            } catch (\Exception $e) {
                                try {
                                    $occurrence = \Carbon\Carbon::createFromFormat('d F Y', $dateString . ' ' . $today->year);
                                } catch (\Exception $e2) {
                                    continue;
                                }
                            }

                            // Create task for any date in the current year (past or future)
                            if ($occurrence->year == $today->year) {
                                if ($this->createTaskIfNotExists($document->id_documents, $occurrence)) {
                                    $tasksCreated++;
                                }
                            }
                        }
                        break;
                }
            }

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $tasksCreated . ' document task(s) generated successfully.',
                    'tasks_created' => $tasksCreated
                ]);
            }

            return redirect()->back()->with('success', $tasksCreated . ' document task(s) generated successfully.');
        } catch (Exception $e) {
            Log::error('Failed to generate document task', [
                'error' => $e->getMessage(),
                'document_id' => $id
            ]);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate document task.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to generate document task.');
        }
    }

    /**
     * Helper method to normalize period value
     */
    private function normalizePeriodValue($value)
    {
        if (is_array($value)) return $value;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // fallback: split comma or semicolon
            $parts = preg_split('/[\,\;]+/', $value);
            return array_map('trim', array_filter($parts, fn($v) => $v !== ''));
        }

        return [];
    }

    /**
     * Helper method to get next or same weekday
     */
    private function getNextOrSameWeekday($reference, $weekday)
    {
        $map = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6
        ];

        $key = strtolower($weekday);
        if (!isset($map[$key])) return $reference->copy()->startOfDay();

        $target = $map[$key];
        $ref = $reference->copy()->startOfDay();

        $daysToAdd = ($target - $ref->dayOfWeek + 7) % 7;
        return $ref->copy()->addDays($daysToAdd);
    }

    /**
     * Helper method to create task if not exists
     * Returns true if task was created, false if it already existed
     */
    private function createTaskIfNotExists($documentId, $date)
    {
        $dateString = $date->toDateString();

        $exists = PendingTask::where('id_documents', $documentId)
            ->whereDate('periode_date', $dateString)
            ->exists();

        if (!$exists) {
            PendingTask::create([
                'id_documents' => $documentId,
                'periode_date' => $dateString,
                'upload' => '',
                'status' => 'waiting_document',
            ]);

            return true;
        }

        return false;
    }
}
