<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\Project\SectionResource;
use App\Models\Project;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index(Project $project)
    {
        return apiResponse(true, 200, new SectionResource($project));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $section = new Section();
        $section->project_id = $request->project_id;
        $section->title = $request->title;
        $section->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $section = Section::findOr($request->section_id, function () {
            return apiResponse(true, 404, __('words.Section not found'));
        });

        $section->title = $request->title;
        $section->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required_with:data|exists:sections,id',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        foreach ($request->data as $key => $value) {
            $section = Section::find($value);
            $section->order = $key;
            $section->save();
        }

        return apiResponse(true, 200, __('words.Successfully updated'));

    }

    public function destroy(Section $section)
    {
        $section->delete();

        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}