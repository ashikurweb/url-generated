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
        return response()->json(Url::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'long_url' => 'required|url',
            'url_id' => 'nullable|unique:urls,url_id|alpha_dash|max:20',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $urlId = $request->url_id ?: Url::generateUniqueUrlId();

        $url = Url::create([
            'long_url' => $request->long_url,
            'url_id' => $urlId,
            'description' => $request->description,
            'is_enabled' => true,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json($url, 201);
    }

    public function redirectOrHome(Request $request)
    {
        if ($request->has('url_id')) {
            $url = Url::where('url_id', $request->query('url_id'))->first();
            
            if ($url && $url->is_enabled && (!$url->expires_at || $url->expires_at->isFuture())) {
                $url->increment('click_count');
                return redirect($url->long_url);
            }
            
            abort(404, 'URL not found or disabled');
        }

        return view('welcome');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $urlId)
    {
        $url = Url::where('url_id', $urlId)->firstOrFail();

        if (!$url->is_enabled || ($url->expires_at && $url->expires_at->isPast())) {
            abort(404, 'URL is disabled or expired');
        }

        $url->increment('click_count');

        return response()->json($url);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        $request->validate([
            'long_url' => 'sometimes|required|url',
            'url_id' => 'sometimes|nullable|alpha_dash|max:20|unique:urls,url_id,' . $url->id,
            'description' => 'nullable|string|max:255',
            'is_enabled' => 'sometimes|boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $url->update($request->only(['long_url', 'url_id', 'description', 'is_enabled', 'expires_at']));

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
