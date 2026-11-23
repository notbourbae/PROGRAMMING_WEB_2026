<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::query()
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where('title', 'like', '%'.$request->query('search').'%'),
            )
            ->paginate(10);

        return MediaResource::collection($media);
    }

    public function store(StoreMediaRequest $request): JsonResponse
    {
        $medium = Media::create($request->validated());

        return (new MediaResource($medium))->response()->setStatusCode(201);
    }

    public function show(Media $medium): MediaResource
    {
        return new MediaResource($medium->load('users'));
    }

    public function update(StoreMediaRequest $request, Media $medium): MediaResource
    {
        $medium->update($request->validated());

        return new MediaResource($medium);
    }

    public function destroy(Media $medium): JsonResponse
    {
        $medium->delete();

        return response()->json(['message' => 'Media berhasil dihapus.']);
    }
}
