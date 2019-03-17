<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Image;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImagesForProducts($id)
    {
        $images = Image::paginate(10)->where('productId', $id);
        return ImageResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('productImage')) {
            
            //Format filename to be stored
            $fileNameWithExt = $request->file('productImage')->getClientOriginalName();
            $fileNameWithoutExt = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('productImage')->getClientOriginalExtension();
            $fileName = $fileNameWithoutExt.'_'.time().'.'.$extension;

            //saveing file locally
            $path = $request->file('productImage')->storeAs('public/productImages', $fileName);
        }else{
            //If no file 
            $fileName = 'noImage.jpg';
        }

        $image = new Image();
        $image->productImage = $fileName;
        $image->productId = $request->input('productId');

        //Insert image
        $isSaved = $image->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        if ($image != null) {
            
            //Delete from localStorage
            if($image->productImage != 'noImage.jpg'){
                echo $image->productImage;
                Storage::delete('public/productImages'.$image->productImage);
            }

            //Delete from db
            $isDeleted = $image->delete();
            if ($isDeleted) {
                return new ImageResource($image);
            }
        }
    }
}
