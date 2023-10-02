<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SectionRequest;
use App\Models\Image;
use App\Models\Section;
use App\Service\FileService;
use Illuminate\Support\Arr;

class SectionController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('section index')) {
            abort(403);
        }
        $sections = Section::with('images')->paginate(10);

        return response([
            'sections' => $sections,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('section store')) {
            abort(403);
        }
        $data = Arr::except($request->validated(), 'images');
        $images = $request->images;
        $section = Section::create($data);
        foreach ($images as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'section')['path'],
                'name' => $image->getClientOriginalName(),
                //remove this
            ];
            $section->images()->create($imageData);
        }

        return response([
            'section' => $section->load('images'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        if (!auth()->user()->hasPermissionTo('section show')) {
            abort(403);
        }

        return response([
            'section' => $section->load('images'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section)
    {
        if (!auth()->user()->hasPermissionTo('section update')) {
            abort(403);
        }
        $updateData = $request->validated();
        $section->update($updateData);

        if (isset($updateData['imagedelete'])) {
            $imageToDelete = Image::whereIn('id', $updateData['imagedelete'])->get();
            foreach ($imageToDelete as $img) {
                $this->fileService->fileDelete($img['path']);
                $img->delete();
            }
        }

        foreach ($updateData['images'] as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'section')['path'],
                'name' => $image->getClientOriginalName(),
            ];
            $section->images()->create($imageData);
        }

        return response([
            'section' => $section->refresh()->load('images'),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        if (!auth()->user()->hasPermissionTo('section destroy')) {
            abort(403);
        }
        $section->delete();

        return response([
            'message' => 'Section Deleted',
        ], 200);
    }

    public function types()
    {
        return response([
            'types' => config('section.types'),
        ], 200);
    }
}