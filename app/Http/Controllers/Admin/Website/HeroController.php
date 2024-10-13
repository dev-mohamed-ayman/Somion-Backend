<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\HeroRequest;
use App\Models\Hero;
use App\Models\HeroItem;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::query()->select('title', 'short_description', 'btn_title', 'updated_at as last_update')->first();
        $heroItems = HeroItem::query()->limit(5)->get();
        return apiResponse(true, 200, [
            'hero' => $hero,
            'items' => $heroItems,
        ]);
    }

    public function update(HeroRequest $request)
    {
        $hero = Hero::first();
        Hero::query()->updateOrCreate([
            'id' => $hero->id ?? null,
        ], [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'btn_title' => $request->btn_title,
        ]);

        if ($request->items) {
            foreach ($request->items as $item) {
                HeroItem::query()->updateOrCreate([
                    'id' => $item['id'],
                ], [
                    'number' => $item['number'],
                    'title' => $item['title'],
                ]);
            }
        }
        return apiResponse(true, 200, __('words.Successfully updated'));
    }
}
