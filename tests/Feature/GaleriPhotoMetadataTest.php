<?php

namespace Tests\Feature;

use App\Models\GaleriAlbum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GaleriPhotoMetadataTest extends TestCase
{
    use RefreshDatabase;

    public function test_photo_upload_can_store_optional_title_and_description(): void
    {
        $album = GaleriAlbum::create([
            'nama_album' => 'Album Test',
            'slug' => 'album-test',
        ]);

        $response = $this->postJson(route('admin.galeri_album.photos.upload', $album->id), [
            'photo_links' => 'https://example.com/photo.jpg',
            'judul' => 'Judul Foto',
            'deskripsi' => 'Deskripsi Foto',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('galeri_foto', [
            'album_id' => $album->id,
            'judul' => 'Judul Foto',
            'deskripsi' => 'Deskripsi Foto',
            'file_path' => 'https://example.com/photo.jpg',
        ]);
    }
}
