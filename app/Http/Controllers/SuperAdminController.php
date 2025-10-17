<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function index()
    {

        try {
            $docs = Documents::all();
        } catch (Exception $e) {
            Log::error('Failed to load data', [
                'error' => $e->getMessage()
            ]);
        }

        return view('superadmin.index', compact('docs'));
    }
}
