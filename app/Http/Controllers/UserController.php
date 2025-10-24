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
                })->orderBy('created_at', 'desc')
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
                'document_files.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:20480', // max 20MB per file
            ]);

            $task = PendingTask::findOrFail($id);

            $uploadedFiles = [];

            // Get existing uploads if any
            $existingUploads = is_array($task->upload) ? $task->upload : [];

            if ($request->hasFile('document_files')) {
                foreach ($request->file('document_files') as $file) {
                    $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                    // Store in storage/app/public/uploads
                    $path = $file->storeAs('uploads', $filename, 'public');

                    $uploadedFiles[] = $path;
                }
            }

            // Merge with existing uploads
            $allUploads = array_merge($existingUploads, $uploadedFiles);

            // Save paths array in DB
            $task->upload = $allUploads;
            $task->status = 'waiting_approval';
            $task->save();
        } catch (Exception $e) {
            Log::error('Failed to upload document', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Failed to upload documents. Please try again.');
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully.');
    }
}
