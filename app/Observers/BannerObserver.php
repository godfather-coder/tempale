<?php

namespace App\Observers;

use App\Models\Banner;
use App\Service\FileService;

class BannerObserver
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Handle the Banner "created" event.
     */
    public function created(Banner $banner): void
    {
        //
    }

    /**
     * Handle the Banner "updated" event.
     */
    public function updated(Banner $banner): void
    {
        //
    }

    /**
     * Handle the Banner "deleted" event.
     */
    public function deleted(Banner $banner): void
    {
        foreach ($banner->images as $image) {
            $this->fileService->fileDelete($image['path']);
            $image->delete();
        }
    }

    /**
     * Handle the Banner "restored" event.
     */
    public function restored(Banner $banner): void
    {
        //
    }

    /**
     * Handle the Banner "force deleted" event.
     */
    public function forceDeleted(Banner $banner): void
    {
        //
    }
}
