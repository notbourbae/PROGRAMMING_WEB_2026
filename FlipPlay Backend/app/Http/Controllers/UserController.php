<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showCollection(User $user): UserResource
    {
        return new UserResource($user->load('media'));
    }

    public function addToCollection(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => ['required', 'exists:media,id'],
        ]);
        $mediaId = $validated['media_id'];

        if ($user->media()->where('media.id', $mediaId)->exists()) {
            return response()->json(['message' => 'Media sudah ada di koleksi pengguna.'], 409);
        }

        $user->media()->attach($mediaId);

        return response()->json(['message' => 'Media berhasil ditambahkan ke koleksi.'], 201);
    }

    public function removeFromCollection(User $user, Media $media): JsonResponse
    {
        if (! $user->media()->where('media.id', $media->id)->exists()) {
            return response()->json(['message' => 'Media tidak ditemukan di koleksi pengguna.'], 404);
        }

        $user->media()->detach($media->id);

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi.']);
    }
}
