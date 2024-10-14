<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\FooterRequest;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footer = Footer::query()->first();
        return apiResponse(true, 200, $footer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterRequest $request)
    {

        $footer = Footer::query()->first();
        if ($request->logo) {
            deleteFile($footer->logo);
            $footer->logo = uploadFile('', $request->logo);
        }
        $footer->emails = $request->emails;
        $footer->phone = $request->phone;
        $footer->whatsapp = $request->whatsapp;
        $footer->instagram = $request->instagram;
        $footer->linkedin = $request->linkedin;
        $footer->x = $request->x;
        $footer->be = $request->be;
        $footer->location = $request->location;
        $footer->subscription_paragraph = $request->subscription_paragraph;
        $footer->copyright = $request->copyright;
        $footer->save();
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
