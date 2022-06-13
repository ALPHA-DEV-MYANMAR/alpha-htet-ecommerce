<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::all();

        return response()->json([
            'message' => 'success',
            'data'    => $photos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {

        if(!Storage::exists('public/thumbnail')){
            Storage::makeDirectory('public/thumbnail');
        }

        if($request->hasFile('path')){
            $photo = $request->file('path');
            $newName = uniqid().'_photo.'.$photo->extension();
            $photo->storeAs('public/photos',$newName);
            $img = Image::make($photo);
            $img->fit('500','500');
            $img->save('storage/thumbnail/'.$newName);
            $url = asset('storage/thumbnail/'.$newName);

            $photo = new Photo();
            $photo->path = $url;
            $photo->save();
        }

        return response()->json([
            'message' => 'success',
            'data'    => $photo
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhotoRequest  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return response()->json([
            'message' => 'success',
            'data'    => $photo
        ]);
    }
}
