<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FlipPlayApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_media_can_be_created_searched_shown_updated_and_deleted(): void
    {
        $title = 'FlipPlayProbe '.uniqid();

        $this->postJson('/api/media', [
            'type' => 'Anime',
            'genre' => 'Action',
            'rating' => 80,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['title']);

        $response = $this->postJson('/api/media', [
            'title' => $title,
            'type' => 'Anime',
            'genre' => 'Action/Fantasy',
            'rating' => 92.5,
            'episodes' => 87,
            'studio' => 'MAPPA',
        ])->assertCreated()
            ->assertJsonPath('data.title', $title)
            ->assertJsonMissingPath('data.collected_by');

        $mediaId = $response->json('data.id');

        $this->getJson('/api/media?search=FlipPlayProbe')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->getJson("/api/media/{$mediaId}")
            ->assertOk()
            ->assertJsonPath('data.collected_by', []);

        $this->patchJson("/api/media/{$mediaId}", ['rating' => 99])
            ->assertOk()
            ->assertJsonPath('data.rating', 99);

        $this->deleteJson("/api/media/{$mediaId}")
            ->assertOk();
    }

    public function test_users_can_manage_media_in_their_collection(): void
    {
        $user = User::factory()->create();
        $media = Media::create([
            'title' => 'API Frieren '.uniqid(),
            'type' => 'Anime',
            'genre' => 'Adventure/Drama',
            'rating' => 95,
        ]);

        $this->getJson("/api/users/{$user->id}/collection")
            ->assertOk()
            ->assertJsonPath('data.collection', []);

        $this->postJson("/api/users/{$user->id}/collection", ['media_id' => 999999])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['media_id']);

        $this->postJson("/api/users/{$user->id}/collection", ['media_id' => $media->id])
            ->assertCreated();

        $this->postJson("/api/users/{$user->id}/collection", ['media_id' => $media->id])
            ->assertStatus(409);

        $this->getJson("/api/users/{$user->id}/collection")
            ->assertOk()
            ->assertJsonPath('data.collection.0.title', $media->title);

        $this->deleteJson("/api/users/{$user->id}/collection/{$media->id}")
            ->assertOk();

        $this->deleteJson("/api/users/{$user->id}/collection/{$media->id}")
            ->assertNotFound();
    }
}
