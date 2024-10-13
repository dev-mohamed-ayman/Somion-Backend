<?php

namespace App\Http\Controllers\Admin\Website\Service;

use App\Http\Controllers\Controller;
use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceSectionController extends Controller
{

    public function index()
    {
        $serviceSection = ServiceSection::query()->select('title', 'updated_at as last_update')->first();
        return apiResponse(true, 200, $serviceSection);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.en' => 'required|string',
            'title.de' => 'required|string',
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }

        $serviceSection = ServiceSection::query()->first();
        $serviceSection->title = $request->title;
        $serviceSection->save();

        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
