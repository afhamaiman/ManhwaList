<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManhwaController extends Controller
{
    public function index(Request $request)
    {
        $json = Storage::get('manhwa.json');
        $manhwas = collect(json_decode($json, true));

        // Filter
        if ($request->has('genre')) {
            $genres = explode(',', $request->genre);
            $manhwas = $manhwas->filter(function ($item) use ($genres) {
                return count(array_intersect($genres, $item['genre'])) > 0;
            });
        }

        if ($request->has('status')) {
            $manhwas = $manhwas->where('status', $request->status);
        }

        if ($request->has('rating')) {
            $manhwas = $manhwas->where('rating', $request->rating);
        }

        // Search
        if ($request->has('search')) {
            $keyword = strtolower($request->search);
            $manhwas = $manhwas->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['title']), $keyword);
            });
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $total = $manhwas->count();
        $paged = $manhwas->slice(($page - 1) * $perPage, $perPage)->values();

        return response()->json([
            'data' => $paged,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page
        ]);
    }

    public function show($id)
    {
        $json = Storage::get('manhwa.json');
        $manhwas = collect(json_decode($json, true));

        $manhwa = $manhwas->firstWhere('id', (int) $id);

        if (!$manhwa) {
            return response()->json(['message' => 'Manhwa not found'], 404);
        }

        return response()->json($manhwa);
    }
}
