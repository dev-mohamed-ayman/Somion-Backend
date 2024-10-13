<?php

namespace App\Http\Controllers\Admin\Website\Project;

use App\Http\Controllers\Controller;
use App\Models\HomeProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeProjectImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'home_project_id' => 'required|exists:home_projects,id',
            'image' => 'required|image'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }
        $homeProjectImage = new HomeProjectImage();
        $homeProjectImage->home_project_id = $request->home_project_id;
        $homeProjectImage->image = uploadFile('home_projects', $request->image);
        $homeProjectImage->save();
        return apiResponse(true, 200, __('words.Successfully created'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homeProjectImage = HomeProjectImage::find($id);
        if (!$homeProjectImage) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        deleteFile($homeProjectImage->path);
        $homeProjectImage->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
