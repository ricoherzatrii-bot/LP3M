<?php

namespace Tests\Feature;

use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GaleriPhotoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_photo_upload_and_update_support_title_and_description(): void
    {
        Storage::fake('public');

        $album = GaleriAlbum::create([
            'nama_album' => 'Album Uji',
            'slug' => 'album-uji',
            'sampul_foto' => null,
        ]);

        $file = UploadedFile::fake()->image('photo.jpg', 600, 400);

        $uploadResponse = $this->postJson("/admin/galeri-album/{$album->id}/photos/upload", [
            'photos' => [$file],
            'judul' => 'Judul Foto Uji',
            'deskripsi' => 'Deskripsi Foto Uji',
        ]);

        $uploadResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        $photo = GaleriFoto::latest()->first();
        $this->assertNotNull($photo);
        $this->assertSame('Judul Foto Uji', $photo->judul);
        $this->assertSame('Deskripsi Foto Uji', $photo->deskripsi);

        $updateResponse = $this->postJson("/admin/galeri-foto/{$photo->id}/update", [
            'judul' => 'Judul Foto Baru',
            'deskripsi' => 'Deskripsi Foto Baru',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        $photo->refresh();
        $this->assertSame('Judul Foto Baru', $photo->judul);
        $this->assertSame('Deskripsi Foto Baru', $photo->deskripsi);
    }
}
