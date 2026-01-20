<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Url::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
            'short_code' => 'nullable|unique:urls,short_code|alpha_dash',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shortCode = $request->short_code ?: Url::generateUniqueShortCode();

        $url = Url::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'description' => $request->description,
            'is_enabled' => true,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json($url, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $shortCode)
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        if (!$url->is_enabled || ($url->expires_at && $url->expires_at->isPast())) {
            abort(404, 'URL is disabled or expired');
        }

        $url->increment('clicks');

        return redirect($url->original_url);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        $request->validate([
            'is_enabled' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $url->update($request->only(['is_enabled', 'description']));

        return response()->json($url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        $url->delete();
        return response()->json(null, 204);
    }
}
