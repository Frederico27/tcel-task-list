<?php

namespace App\Http\Controllers;

use App\Models\PendingTask;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $docs = PendingTask::all();

        return view('user.index', compact('docs'));
    }

    // upload document for a pending task
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document_file' => 'required|file|mimes:pdf,doc,docx|max:20480', // max 20MB
        ]);

        $task = PendingTask::findOrFail($id);
        $file = $request->file('document_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $task->upload = 'uploads/' . $filename;
        $task->status = 'waiting_approval';
        $task->save();

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }
}
