<?php

namespace App\Http\Controllers;

use App\Models\PendingTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        // ensure variables are defined even if an exception is thrown
        $nik = null;
        $docs = collect();
        $status = collect();

        try {
            $nik = session('sso_user')['nik'];
            // $nik = '4444';
            // PIC is stored as JSON on the related `documents` table (Documents.pic)
            // PendingTask relation name is `document()` (singular) so use that
            $docs = PendingTask::with('document')
                ->whereHas('document', function ($q) use ($nik) {
                    // documents.pic is a JSON array, use whereJsonContains to match the PIC
                    $q->whereJsonContains('pic', $nik);
                })
                ->where('status', '=', 'waiting_document')
                ->get();

            // collect unique statuses from the docs to populate the filter
            $status = $docs->pluck('status')->unique()->filter()->values();
        } catch (Exception $e) {
            Log::error('Failed to load user pending task', [
                'error' => $e->getMessage(),
                'session' => $nik
            ]);
        }


        return view('user.index', compact('docs', 'status'));
    }

    // upload document for a pending task
    public function uploadDocument(Request $request, $id)
    {
        try {
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
        } catch (Exception $e) {
            Log::error('Failed to upload document', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);
        }

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }
}
