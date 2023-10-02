<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BannerRequest;
use App\Models\Banner;
use App\Models\Image;
use App\Service\FileService;

class BannerController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->hasPermissionTo('banner index')) {
            abort(403);
        }
        $banners = Banner::with('images')->paginate(10);

        return response([
            'Banners' => $banners,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        if (! auth()->user()->hasPermissionTo('banner store')) {
            abort(403);
        }
        $data = $request->validated();
        $dataexcimgages = $data;
        unset($dataexcimgages['images']);
        $banner = Banner::create($data);
        foreach ($data['images'] as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'banner')['path'],
                'name' => $image->getClientOriginalName(),
            ];
            $banner->images()->create($imageData);
        }

        return response([
            'banner' => $banner->load('images'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        if (! auth()->user()->hasPermissionTo('banner show')) {
            abort(403);
        }

        return response([
            'banner' => $banner,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        if (! auth()->user()->hasPermissionTo('banner update')) {
            abort(403);
        }
        $updateData = $request->validated();
        $updatedataexcimgages = $updateData;
        unset($updatedataexcimgages['images'], $updatedataexcimgages['imagedelete']);
        $banner->update($updatedataexcimgages);
        if (isset($updateData['imagedelete'])) {
            $imageToDelete = Image::whereIn('id', $updateData['imagedelete'])->get();
            foreach ($imageToDelete as $img) {
                $this->fileService->fileDelete($img['path']);
                $img->delete();
            }

        }
        foreach ($updateData['images'] as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'banner')['path'],
                'name' => $image->getClientOriginalName(),
            ];
            $banner->images()->create($imageData);
        }

        return response([
            'banner' => $banner->refresh()->load('images'),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if (! auth()->user()->hasPermissionTo('banner destroy')) {
            abort(403);
        }
        $banner->delete();

        return response([
            'message' => 'Banner Deleted',
        ], 200);
    }
}
