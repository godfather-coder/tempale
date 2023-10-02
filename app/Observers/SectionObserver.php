<?php

namespace App\Observers;

use App\Models\Section;
use App\Service\FileService;

class SectionObserver
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Handle the Section "created" event.
     */
    public function created(Section $section): void
    {
        //
    }

    /**
     * Handle the Section "updated" event.
     */
    public function updated(Section $section): void
    {
        //
    }

    /**
     * Handle the Section "deleted" event.
     */
    public function deleted(Section $section): void
    {
        foreach ($section->images as $image) {
            $this->fileService->fileDelete($image['path']);
            $image->delete();
        }
    }

    /**
     * Handle the Section "restored" event.
     */
    public function restored(Section $section): void
    {
        //
    }

    /**
     * Handle the Section "force deleted" event.
     */
    public function forceDeleted(Section $section): void
    {
        //
    }
}
