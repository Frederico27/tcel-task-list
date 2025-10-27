<?php

namespace App\Http\Controllers;

use App\Models\PendingTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    // Get existing files for a task
    public function getTaskFiles($id)
    {
        try {
            Log::info('Getting files for task', ['task_id' => $id]);

            $task = PendingTask::findOrFail($id);

            Log::info('Task found', [
                'task_id' => $task->id_pending_task,
                'upload' => $task->upload,
                'upload_type' => gettype($task->upload)
            ]);

            $files = [];
            if (is_array($task->upload) && count($task->upload) > 0) {
                foreach ($task->upload as $index => $filePath) {
                    $files[] = [
                        'index' => $index,
                        'path' => $filePath,
                        'name' => basename($filePath),
                        'url' => asset('storage/' . $filePath)
                    ];
                }
            }

            Log::info('Files prepared', ['files_count' => count($files), 'files' => $files]);

            return response()->json([
                'success' => true,
                'files' => $files
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get task files', [
                'error' => $e->getMessage(),
                'task_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load files',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Remove a specific file from a task
    public function removeTaskFile(Request $request, $id)
    {
        try {
            $task = PendingTask::findOrFail($id);
            $fileIndex = $request->input('file_index');

            if (!is_array($task->upload)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No files to remove'
                ], 400);
            }

            if (!isset($task->upload[$fileIndex])) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found'
                ], 404);
            }

            // Remove file from storage
            $filePath = $task->upload[$fileIndex];
            Storage::disk('public')->delete($filePath);

            // Remove from array
            $uploads = $task->upload;
            unset($uploads[$fileIndex]);
            $task->upload = array_values($uploads); // Re-index array
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'File removed successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to remove file', [
                'error' => $e->getMessage(),
                'task_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove file'
            ], 500);
        }
    }

    // upload document for a pending task
    public function uploadDocument(Request $request, $id)
    {
        try {
            $request->validate([
                'document_files.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:50480', // max 50MB per file
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
