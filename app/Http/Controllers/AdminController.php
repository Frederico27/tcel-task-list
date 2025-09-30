<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\PendingTask;
use App\Models\TypePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {

        $docs = Documents::all();

        return view('admin.index', compact('docs'));
    }

    public function addDocument(Request $request)
    {

        $request->validate([
            'type_document' => 'required|string|max:255',
            'pic' => 'required|array',
            'approval' => 'required|array',
            'type_periods' => 'required|string',
            'periods' => 'sometimes|array',
            // Set default value for periods if not present
            'creating_task' => 'required|string|max:255',
        ]);

        if (!$request->input('periods')) {
            $request->merge(['periods' => ['0']]);
        }

        $document = new Documents();
        $document->type_document = $request->input('type_document');
        $document->pic = json_encode($request->input('pic'));
        $document->approval = json_encode($request->input('approval'));
        $document->creating_task = $request->input('creating_task');
        $document->save();

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

        return redirect()->back()->with('success', 'Document added successfully.');
    }

    public function updateDocument(Request $request, $id)
    {
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
        $document->save();

        // Update or create TypePeriod entry
        $typePeriod = TypePeriod::firstOrNew(['id_documents' => $document->id_documents]);
        $typePeriod->period_type = $request->input('type_periods');
        $selected = $request->input('periods');
        $typePeriod->period_value = $selected ? $selected : null;
        $typePeriod->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Document updated', 'document' => $document]);
        }

        return redirect()->back()->with('success', 'Document updated successfully.');
    }

    public function deleteDocument($id)
    {
        $document = Documents::findOrFail($id);
        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function taskList(Request $request)
    {
        // allow searching by a free-text query across a few document fields
        $q = $request->input('q');

        $docsQuery = Documents::with(['pendingTask' => function ($query) {
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
        $task = PendingTask::findOrFail($id);
        $task->status = 'approved';
        $task->rejected_reason = null; // clear any previous rejection reason
        $task->approved_by = Auth::check() ? Auth::user()->name : 'Admin'; // use auth user name if available
        $task->save();

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

        $tasks = PendingTask::whereIn('id_pending_task', $ids)->get();
        foreach ($tasks as $task) {
            $task->status = 'approved';
            $task->approved_by = Auth::check() ? Auth::user()->name : 'Admin';
            $task->save();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($tasks) . ' document(s) approved successfully.', 'approved_by' => Auth::check() ? Auth::user()->name : 'Admin']);
        }

        return redirect()->back()->with('success', count($tasks) . ' document(s) approved successfully.');
    }

    public function rejectDocument(Request $request, $id)
    {
        $task = PendingTask::findOrFail($id);
        $task->status = 'rejected';

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
        $task->approved_by = Auth::check() ? Auth::user()->name : 'Admin';
        $task->save();

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
}
