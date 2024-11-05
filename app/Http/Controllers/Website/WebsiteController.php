<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Brand;
use App\Models\BrandSection;
use App\Models\ContactSection;
use App\Models\Footer;
use App\Models\Hero;
use App\Models\HeroItem;
use App\Models\HomeProject;
use App\Models\HomeProjectSection;
use App\Models\HomeSetting;
use App\Models\Imprint;
use App\Models\Rate;
use App\Models\RateSection;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use App\Models\StartSection;
use App\Models\Subscription;
use App\Models\Why;
use App\Models\WhySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                ->select('id', 'title', 'image')
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
            'rates' => Rate::query()->active()
                ->select('first_name', 'last_name', 'image', 'message', 'rate')
                ->get()
        ];
        return apiResponse(true, 200, $rates);
    }

    public function rate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'message' => 'required|string',
            'rate' => 'required|gte:0|lte:5',
            'image' => 'nullable|image'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 422, $validator->messages()->all());
        }
        $rate = new Rate();
        $rate->first_name = $request->first_name;
        $rate->last_name = $request->last_name;
        if ($request->image)
            $rate->image = uploadFile('rates', $request->image);
        $rate->message = $request->message;
        $rate->rate = $request->rate;
        $rate->save();
        return apiResponse(true, 201, __('words.Successfully created'));
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

    public function subscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:subscriptions,email'],
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }

        $subscription = new Subscription();
        $subscription->email = $request->email;
        $subscription->save();

        return apiResponse(true, 200, __('words.Successfully subscribed'));
    }

    public function imprint()
    {
        $imprint = Imprint::query()
            ->select('title', 'body', 'meta_description', 'meta_keywords')
            ->first();

        return apiResponse(true, 200, $imprint);
    }

    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email',
            'company_name' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'type' => 'required|string',
            'message' => 'required|string'
        ]);
        if ($validator->fails()) {
            return apiResponse(false, 400, $validator->messages()->all());
        }

        $contact = new \App\Models\Contact();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->company_name = $request->company_name;
        $contact->service_id = $request->service_id;
        $contact->type = $request->type;
        $contact->message = $request->message;
        $contact->save();

        return apiResponse(true, 200, __('words.Successfully created'));

    }

    public function contactSection()
    {
        $contactSection = ContactSection::query()
            ->select('first_title', 'second_title', 'three_title', 'four_title', 'meta_description', 'meta_keywords')
            ->first();
        $footerData = Footer::query()
            ->select('instagram', 'linkedin', 'x', 'be', 'location', 'phone', 'whatsapp', 'emails')
            ->first();

        return apiResponse(true, 200, [
            'contactSection' => $contactSection,
            'footerData' => $footerData,
        ]);
    }

    public function about()
    {
        $about = About::query()
            ->select('title', 'sub_title', 'description', 'last_title', 'items', 'our_mission', 'meta_description', 'meta_keywords')
            ->first();
        return apiResponse(true, 200, $about);
    }

    public function serviceCategory($id)
    {
        $serviceCategory = ServiceCategory::find($id);
        if (!$serviceCategory) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        $services = Service::query()
            ->where('service_category_id', $id)
            ->select('id', 'title', 'main_title', 'sub_title', 'description', 'short_description', 'image', 'main_image', 'meta_description', 'meta_keywords')
            ->get();

        return apiResponse(true, 200, [
            'category' => $serviceCategory,
            'services' => $services,
        ]);
    }

    public function service($id)
    {
        $service = Service::query()
            ->with('features', 'plans')
            ->find($id);
        if (!$service) {
            return apiResponse(false, 404, __('words.Not found'));
        }

        return apiResponse(true, 200, $service);
    }

    public function setting()
    {
        $data = HomeSetting::query()
            ->select('title', 'meta_description', 'meta_keywords')
            ->first();

        return apiResponse(true, 200, $data);
    }

}
