<?php

namespace App\Http\Controllers;

use App\Models\PendingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function view($id)
    {
        $doc = PendingTask::findOrFail($id);

        // Check if file exists
        if (!$doc->upload || !Storage::exists($doc->upload)) {
            abort(404, 'File not found.');
        }

        $ext = strtolower(pathinfo($doc->upload, PATHINFO_EXTENSION));

        // Optional: Check user permissions here

        if ($ext === 'pdf') {
            // Inline preview
            return response()->file(storage_path('app/' . $doc->upload));
        }

        // Force download for other types
        return Storage::download($doc->upload);
    }
}
