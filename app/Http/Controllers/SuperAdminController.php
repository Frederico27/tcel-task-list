<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {

        $q = $request->input('q');

        $nik = session('sso_user')['nik'];

        // $nik = '1111';

        $docsQuery = Documents::where('approval', 'like', '%' . $nik . '%')
            ->with(['pendingTask']);

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


        return view('superadmin.index', compact('docs'));
    }
}
