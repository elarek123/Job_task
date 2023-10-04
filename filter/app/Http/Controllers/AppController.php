<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $appList = App::all();
        $slugs = explode('/', $request->getRequestUri());
        $slugs = array_values(array_filter($slugs));
        $subCategoryIdList = [];
        foreach ($slugs as $slug) {
            $anotherSlugs = explode('-', $slug);
            foreach ($anotherSlugs as $anotherSlug) {
                array_push($subCategoryIdList, SubCategory::where('slug', $anotherSlug)->first()->id);
            }
        }
        if (count($subCategoryIdList) > 0) {
            $appList = $this->filter($subCategoryIdList);
        }
        $categories = Category::all();
        return view('MyApp', ['objectList' => $appList, 'categories' => $categories, 'subCategoryIdList' => $subCategoryIdList]);
    }

    public function filter($subcategoryIds)
    {
        $appList = App::all();
        $appList = App::whereIn('id', function ($query) use ($subcategoryIds) {
            $query->select('object_id')
            ->from('objects_subcategories')
            ->whereIn('subcategory_id', $subcategoryIds)
            ->groupBy('object_id')
            ->havingRaw('COUNT(DISTINCT subcategory_id) = ?', [count($subcategoryIds)]);
        })->get();
        return $appList;
    }    
    public function getApps(Request $request)
    {
        $appList = $this->filter($request->input('dataId'));
        return response()->json(['Objects' => view('Object', ['objectList' => $appList])->render()]);
    }
}
