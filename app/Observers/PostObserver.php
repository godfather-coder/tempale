<?php

namespace App\Observers;

use App\Models\Post;
use App\Service\FileService;

class PostObserver
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        foreach ($post->images as $image) {
            $this->fileService->fileDelete($image['path']);
            $image->delete();
        }
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
