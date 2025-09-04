<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest as QuoteRequestModel;
use App\Http\Requests\QuoteRequest;

class QuoteRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteRequest $request)
    {
        $validated = $request->validated();

        // Remove non-model fields
        $modelData = collect($validated)->except(['website', 'terms_accepted', 'service_type', 'budget'])->toArray();

        QuoteRequestModel::create($modelData);

        // Log successful quote request
        \Illuminate\Support\Facades\Log::info('Quote request submitted', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'ip' => $request->ip(),
            'service_type' => $validated['service_type'] ?? null,
        ]);

        return redirect()->route('thanks')->with('success', 'Thank you! We\'ll contact you soon.');
    }
}