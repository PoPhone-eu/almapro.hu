<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Http\Controllers\Controller;

class LegalDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = LegalDocument::query()->orderBy('order', 'asc')->get();
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation: title is required and must be at least 3 characters, body is required and is_active is required as boolean:
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required',
            'order' => 'required',
            'is_active' => 'required|boolean',
        ]);
        $input = $request->all();

        $newDocument = LegalDocument::create($input);
        // return to index page with success message:
        return redirect()->route('legaldocuments.index')->with('success', 'Document created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = LegalDocument::find($id);
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation: title is required and must be at least 3 characters, body is required and is_active is required as boolean:
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required',
            'order' => 'required',
            'is_active' => 'required|boolean',
        ]);
        $input = $request->all();

        $document = LegalDocument::find($id);
        $document->update($input);
        // return to index page with success message:
        return redirect()->route('legaldocuments.index')->with('success', 'Document updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = LegalDocument::find($id);
        $document->delete();
        // return to index page with success message:
        return redirect()->route('legaldocuments.index')->with('success', 'Document deleted successfully');
    }
}
