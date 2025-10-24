<?php

namespace App\Http\Controllers;

use App\Models\PendingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

class DocumentController extends Controller
{

    public function view(Request $request, $id)
    {
        $id = Hashids::decode($id)[0];
        $doc = PendingTask::findOrFail($id);

        // Check if file exists
        if (!$doc->upload || (is_array($doc->upload) && count($doc->upload) === 0)) {
            abort(404, 'File not found.');
        }

        // Handle array of files
        $filePath = null;
        if (is_array($doc->upload)) {
            // If a specific file is requested
            $requestedFile = $request->query('file');
            if ($requestedFile) {
                // Find the file in the array
                foreach ($doc->upload as $file) {
                    if (basename($file) === $requestedFile) {
                        $filePath = $file;
                        break;
                    }
                }
            } else {
                // Default to first file if no specific file requested
                $filePath = $doc->upload[0];
            }
        } else {
            // Backward compatibility for old single file format
            $filePath = $doc->upload;
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Optional: Check user permissions here

        if ($ext === 'pdf') {
            // Inline preview
            return response()->file(storage_path('app/public/' . $filePath));
        }

        // Force download for other types
        $fullPath = storage_path('app/public/' . $filePath);
        return response()->download($fullPath, basename($filePath));
    }
}
