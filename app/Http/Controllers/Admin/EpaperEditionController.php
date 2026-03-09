<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEpaperEditionRequest;
use App\Http\Requests\UpdateEpaperEditionRequest;
use App\Jobs\GenerateEditionPagesJob;
use App\Models\EpaperEdition;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EpaperEditionController extends Controller
{
    /**
     * Display a listing of all editions.
     */
    public function index(): View
    {
        $editions = EpaperEdition::query()
            ->latest('issue_date')
            ->paginate(20);

        return view('admin.epaper.index', compact('editions'));
    }

    /**
     * Show the form for creating a new edition.
     */
    public function create(): View
    {
        return view('admin.epaper.create');
    }

    /**
     * Store a newly created edition with PDF upload.
     */
    public function store(StoreEpaperEditionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create the edition record
        $edition = EpaperEdition::query()->create([
            'edition_name' => $validated['edition_name'],
            'issue_date' => $validated['issue_date'],
            'status' => 'draft',
            'pdf_path' => '', // Will be set after file upload
            'total_pages' => 0,
        ]);

        // Store the PDF file
        $pdf = $request->file('pdf');
        $pdfPath = $pdf->storeAs(
            "epaper/editions/{$edition->id}",
            'source.pdf',
            'public'
        );

        // Update edition with PDF path
        $edition->update(['pdf_path' => $pdfPath]);

        // Dispatch job to generate pages
        GenerateEditionPagesJob::dispatch($edition->id);

        return redirect()
            ->route('admin.epaper.editions.mapper', $edition)
            ->with('success', 'Edition created successfully. Pages are being generated.');
    }

    /**
     * Show the mapper screen for defining hotspots/regions.
     */
    public function mapper(EpaperEdition $edition): View
    {
        $edition->loadCount('pages');

        if ($edition->pages_count === 0 && ! empty($edition->pdf_path)) {
            if (! extension_loaded('imagick')) {
                session()->flash('error', 'Imagick extension is not loaded in PHP. Enable imagick and restart Laragon to generate page previews.');
            } else {
                try {
                    GenerateEditionPagesJob::dispatchSync($edition->id);
                } catch (\Throwable $e) {
                    report($e);

                    session()->flash('error', 'Pages could not be generated automatically. Please verify PDF/Imagick setup.');
                }
            }

            $edition->refresh();
        }

        $edition->load(['pages', 'articles']);

        return view('admin.epaper.mapper', compact('edition'));
    }

    /**
     * Display the specified edition.
     */
    public function show(EpaperEdition $edition): View
    {
        $edition->load(['pages.regions.article', 'articles']);

        return view('admin.epaper.show', compact('edition'));
    }

    /**
     * Show the form for editing the specified edition.
     */
    public function edit(EpaperEdition $edition): View
    {
        return view('admin.epaper.edit', compact('edition'));
    }

    /**
     * Update the specified edition.
     */
    public function update(UpdateEpaperEditionRequest $request, EpaperEdition $edition): RedirectResponse
    {
        $validated = $request->validated();

        $edition->update([
            'edition_name' => $validated['edition_name'],
            'issue_date' => $validated['issue_date'],
            'status' => $validated['status'] ?? $edition->status,
        ]);

        // Handle PDF re-upload if provided
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfPath = $pdf->storeAs(
                "epaper/editions/{$edition->id}",
                'source.pdf',
                'public'
            );

            $edition->update(['pdf_path' => $pdfPath]);

            // Regenerate pages
            GenerateEditionPagesJob::dispatch($edition->id);
        }

        return redirect()
            ->route('admin.epaper.editions.show', $edition)
            ->with('success', 'Edition updated successfully.');
    }

    /**
     * Remove the specified edition from storage.
     */
    public function destroy(EpaperEdition $edition): RedirectResponse
    {
        // Delete associated pages and regions
        foreach ($edition->pages as $page) {
            $page->regions()->delete();
        }
        $edition->pages()->delete();
        $edition->articles()->delete();

        // Delete the edition
        $edition->delete();

        return redirect()
            ->route('admin.epaper.editions.index')
            ->with('success', 'Edition deleted successfully.');
    }
}
