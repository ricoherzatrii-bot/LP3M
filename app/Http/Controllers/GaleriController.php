<?php

namespace App\Http\Controllers;

class GaleriController extends GalleryControllerBase
{
    public function getAlbums()
    {
        return (new GaleriAlbumController())->index();
    }

    public function uploadAlbum($request)
    {
        return (new GaleriAlbumController())->uploadAlbum($request);
    }

    public function updateAlbum($request, $id)
    {
        return (new GaleriAlbumController())->updateAlbum($request, $id);
    }

    public function deleteAlbum($id)
    {
        return (new GaleriAlbumController())->deleteAlbum($id);
    }

    public function getVideos()
    {
        return (new GaleriVideoController())->index();
    }

    public function uploadVideo($request)
    {
        return (new GaleriVideoController())->uploadVideo($request);
    }

    public function updateVideo($request, $id)
    {
        return (new GaleriVideoController())->updateVideo($request, $id);
    }

    public function deleteVideo($id)
    {
        return (new GaleriVideoController())->deleteVideo($id);
    }

    public function getPhotos($album_id)
    {
        return (new GaleriFotoController())->index($album_id);
    }

    public function uploadPhotos($request, $album_id)
    {
        return (new GaleriFotoController())->uploadPhotos($request, $album_id);
    }

    public function updatePhoto($request, $id)
    {
        return (new GaleriFotoController())->updatePhoto($request, $id);
    }

    public function deletePhoto($id)
    {
        return (new GaleriFotoController())->deletePhoto($id);
    }
}
