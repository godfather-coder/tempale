<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PostRequest;
use App\Models\Image;
use App\Models\Post;
use App\Service\FileService;

class PostController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->hasPermissionTo('post index')) {
            abort(403);
        }
        $posts = Post::with('images')->with('section')->paginate(10);

        return response([
            'posts' => $posts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        if (! auth()->user()->hasPermissionTo('post store')) {
            abort(403);
        }
        $data = $request->validated();
        $dataexcimgages = $data;
        unset($dataexcimgages['images']);
        $post = Post::create($dataexcimgages);
        foreach ($data['images'] as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'post')['path'],
                'name' => $image->getClientOriginalName(),
            ];
            $post->images()->create($imageData);
        }

        return response([
            'post' => $post->load('images'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (! auth()->user()->hasPermissionTo('post show')) {
            abort(403);
        }

        return response([
            'post' => $post->load('images'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        if (! auth()->user()->hasPermissionTo('post Update')) {
            abort(403);
        }
        $updateData = $request->validated();
        $updatedataexcimgages = $updateData;
        unset($updatedataexcimgages['images'], $updatedataexcimgages['imagedelete']);
        $post->update($updatedataexcimgages);
        if (isset($updateData['imagedelete'])) {
            $imageToDelete = Image::whereIn('id', $updateData['imagedelete'])->get();
            foreach ($imageToDelete as $img) {
                $this->fileService->fileDelete($img['path']);
                $img->delete();
            }

        }
        foreach ($updateData['images'] as $image) {
            $imageData = [
                'path' => $this->fileService->fileUpload($image, 'post')['path'],
                'name' => $image->getClientOriginalName(),
            ];
            $post->images()->create($imageData);
        }

        return response([
            'section' => $post->refresh()->load('images'),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (! auth()->user()->hasPermissionTo('post destroy')) {
            abort(403);
        }
        $post->delete();

        return response([
            'message' => 'Post Deleted',
        ], 200);
    }
}
