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
    public function hero()
    {
        $hero = [
            'section' => Hero::query()->select('title', 'short_description', 'btn_title')->first(),
            'items' => HeroItem::query()->limit(5)->get()
        ];

        return apiResponse(true, 200, $hero);
    }

    public function services()
    {
        $services = [
            'section' => ServiceSection::query()->select('title')->first(),
            'services' => ServiceCategory::query()
                ->select('id', 'title')
                ->with(['services' => function ($service) {
                    $service->select('id', 'title', 'service_category_id');
                }])
                ->get()
        ];

        return apiResponse(true, 200, $services);
    }

    public function projects()
    {
        $projects = [
            'section' => HomeProjectSection::query()->select('title', 'sub_title', 'description')->first(),
            'projects' => HomeProject::query()
                ->select('id', 'title', 'description', 'link')
                ->with([
                    'categories' => function ($category) {
                        $category->select('home_project_categories.id', 'home_project_categories.name');
                    },
                    'images' => function ($image) {
                        $image->select('home_project_images.path', 'home_project_images.home_project_id');
                    }
                ])
                ->get()
        ];

        return apiResponse(true, 200, $projects);
    }

    public function brands()
    {
        $brands = [
            'section' => BrandSection::query()->select('title')->first(),
            'brands' => Brand::query()->select('image')->get()
        ];
        return apiResponse(true, 200, $brands);
    }

    public function whies()
    {
        $whies = [
            'section' => WhySection::query()->select('title')->first(),
            'whies' => Why::query()->select('title', 'description')->get()
        ];
        return apiResponse(true, 200, $whies);
    }

    public function rates()
    {
        $rates = [
            'section' => RateSection::query()->select('title', 'sub_title', 'paragraph')->first(),
            'rates' => Rate::query()->where('status', true)
                ->select('first_name', 'last_name', 'image', 'message', 'rate')
                ->get()
        ];
        return apiResponse(true, 200, $rates);
    }

    public function startSection()
    {
        $startSection = StartSection::query()->select('title', 'description', 'btn_title')->first();
        return apiResponse(true, 200, $startSection);
    }

    public function footer()
    {
        $footer = Footer::query()
            ->select('logo', 'emails', 'phone', 'whatsapp', 'instagram', 'linkedin', 'x', 'be', 'location', 'subscription_paragraph', 'copyright')
            ->first();

        $serviceCategories = ServiceCategory::query()->select('id', 'title')->get();
        return apiResponse(true, 200, [
            'footer' => $footer,
            'serviceCategories' => $serviceCategories,
        ]);
    }
}
