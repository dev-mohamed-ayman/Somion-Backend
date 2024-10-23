<?php

namespace App\Http\Controllers\Admin\Website\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ContactSection::query()->select(
            'first_title',
            'second_title',
            'three_title',
            'four_title',
            'updated_at as last_update'
        )->first();
        return apiResponse(true, 200, $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_title' => 'required|array',
            'first_title.en' => 'required_with:first_title|string',
            'first_title.de' => 'required_with:first_title|string',

            'second_title' => 'required|array',
            'second_title.en' => 'required_with:second_title|string',
            'second_title.de' => 'required_with:second_title|string',

            'three_title' => 'required|array',
            'three_title.en' => 'required_with:three_title|string',
            'three_title.de' => 'required_with:three_title|string',

            'four_title' => 'required|array',
            'four_title.en' => 'required_with:four_title|string',
            'four_title.de' => 'required_with:four_title|string',

        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }

        $contactSection = ContactSection::query()->first();
        if (!$contactSection) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $contactSection->first_title = $request->first_title;
        $contactSection->second_title = $request->second_title;
        $contactSection->three_title = $request->three_title;
        $contactSection->four_title = $request->four_title;
        $contactSection->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
