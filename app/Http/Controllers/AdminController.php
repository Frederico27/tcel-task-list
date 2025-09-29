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

    public function deleteDocument($id)
    {
        $document = Documents::findOrFail($id);
        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function taskList()
    {
        $docs = Documents::with('pendingTask')
            ->whereHas('pendingTask', function ($query) {
                $query->where('status', '!=', 'waiting_document');
            })
            ->get();

        return view('admin.taskList', compact('docs'));
    }

    public function approveDocument($id)
    {
        $task = PendingTask::findOrFail($id);
        $task->status = 'approved';
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

    public function rejectDocument($id)
    {
        $task = PendingTask::findOrFail($id);
        $task->status = 'rejected';
        //remove the uploaded file
        if ($task->upload && file_exists(public_path($task->upload))) {
            unlink(public_path($task->upload));
        }
        $task->upload = '';
        $task->save();

        return redirect()->back()->with('success', 'Document rejected successfully.');
    }
}
