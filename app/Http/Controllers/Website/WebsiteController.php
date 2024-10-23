<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandSection;
use App\Models\Footer;
use App\Models\Hero;
use App\Models\HeroItem;
use App\Models\HomeProject;
use App\Models\HomeProjectSection;
use App\Models\Rate;
use App\Models\RateSection;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use App\Models\StartSection;
use App\Models\Why;
use App\Models\WhySection;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $hero = [
            'section' => Hero::query()->select('title', 'short_description', 'btn_title')->first(),
            'items' => HeroItem::query()->limit(5)->get()
        ];

        $services = [
            'section' => ServiceSection::query()->select('title')->first(),
            'services' => ServiceCategory::query()
                ->select('id', 'title', 'main_title')
                ->with(['services' => function ($service) {
                    $service->select('id', 'title', 'main_title', 'sub_title', 'short_description', 'description', 'image', 'main_image', 'service_category_id');
                }])
                ->get()
        ];

        $projects = [
            'section' => HomeProjectSection::query()->select('title', 'sub_title', 'description')->first(),
            'projects' => HomeProject::query()
                ->select('id', 'title', 'description', 'link')
                ->with([
                    'categories' => function ($category) {
                        $category->select('id', 'name');
                    },
                    'images' => function ($image) {
                        $image->select('id', 'path');
                    }
                ])
                ->get()
        ];

        $brands = [
            'section' => BrandSection::query()->select('title')->first(),
            'brands' => Brand::query()->select('image')->get()
        ];

        $whies = [
            'section' => WhySection::query()->select('title')->first(),
            'whies' => Why::query()->select('title', 'description')->get()
        ];

        $rates = [
            'section' => RateSection::query()->select('title', 'sub_title', 'paragraph')->first(),
            'rates' => Rate::query()->where('status', true)
                ->select('first_name', 'last_name', 'image', 'message', 'rate')
                ->get()
        ];

        $startSection = StartSection::query()->select('title', 'description', 'btn_title')->first();

        $footer = Footer::query()
            ->select('logo', 'emails', 'phone', 'whatsapp', 'instagram', 'linkedin', 'x', 'be', 'location', 'subscription_paragraph', 'copyright')
            ->first();

        return apiResponse(true, 200, [
            'hero' => $hero,
            'services' => $services,
            'projects' => $projects,
            'brands' => $brands,
            'whies' => $whies,
            'rates' => $rates,
            'startSection' => $startSection,
            'footer' => $footer,
        ]);
    }
}
