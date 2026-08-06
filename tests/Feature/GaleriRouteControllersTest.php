<?php

namespace Tests\Feature;

use Tests\TestCase;

class GaleriRouteControllersTest extends TestCase
{
    public function test_gallery_routes_use_separated_controllers(): void
    {
        $router = $this->app['router'];

        $albumStoreRoute = $router->getRoutes()->getByName('admin.galeri_album.store');
        $this->assertNotNull($albumStoreRoute);
        $this->assertStringContainsString('GaleriAlbumController@uploadAlbum', $albumStoreRoute->getActionName());

        $videoStoreRoute = $router->getRoutes()->getByName('admin.galeri_video.store');
        $this->assertNotNull($videoStoreRoute);
        $this->assertStringContainsString('GaleriVideoController@uploadVideo', $videoStoreRoute->getActionName());

        $photoUpdateRoute = $router->getRoutes()->getByName('admin.galeri_foto.update');
        $this->assertNotNull($photoUpdateRoute);
        $this->assertStringContainsString('GaleriFotoController@updatePhoto', $photoUpdateRoute->getActionName());
    }
}
