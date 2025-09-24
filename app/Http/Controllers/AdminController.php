<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\TypePeriod;
use Illuminate\Http\Request;

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
}
