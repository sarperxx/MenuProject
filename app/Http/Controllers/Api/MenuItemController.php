<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = MenuItem::with(['category', 'allergens']);

    if ($search = $request->query('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('description', 'like', "%$search%");
        });
    }

    if ($categoryId = $request->query('category_id')) {
        $query->where('category_id', $categoryId);
    }

if ($excludedAllergens = $request->query('excluded_allergens')) {
    foreach ($excludedAllergens as $allergenId) {
        $query->whereDoesntHave('allergens', function ($q) use ($allergenId) {
            $q->where('allergens.id', $allergenId);
        });
    }
}

    $perPage = $request->query('per_page', 10);
    $items = $query->orderBy('created_at', 'desc')->paginate($perPage);

    return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin check
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|file|image|max:2048', // Accept image file
            'category_id' => 'nullable|exists:categories,id',
            'allergens' => 'nullable|array',
            'allergens.*' => 'exists:allergens,id',

        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_items', 'public');
            $validated['image'] = '/storage/' . $path;
        } else if ($request->has('image') && is_string($request->image)) {
            $validated['image'] = $request->image;
        }

        $item = MenuItem::create($validated);
        $item->allergens()->sync($validated['allergens'] ?? []);
        return response()->json($item->load('category'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = MenuItem::with('category')->findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Admin check
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
       
        $item = MenuItem::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|file|image|max:2048', // Accept image file
            'category_id' => 'nullable|exists:categories,id',
            'allergens' => 'nullable|array',
            'allergens.*' => 'exists:allergens,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_items', 'public');
            $validated['image'] = '/storage/' . $path;
        } else if ($request->has('image') && is_string($request->image)) {
            $validated['image'] = $request->image;
        }

        $item->update($validated);
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
