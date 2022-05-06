<?php

namespace App\Http\Controllers;

use App\Models\OpenSourceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OpenSourceCategoryController extends Controller
{
    public function categories(Request $request, $currentPage, $itemsQty): Response
    {
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $sortDesc = $request->get('sortDesc') === 'true' ? 'ASC' : 'DESC';
        $offset = $currentPage * $itemsQty - $itemsQty;
        $count = OpenSourceCategory::where('1', '=', "1")
            ->count();
        $items = OpenSourceCategory::where('1', '=', "1")
            ->orderBy($sortBy, $sortDesc)
            ->offset($offset)
            ->limit($itemsQty)
            ->get();
        return Response(compact('count', 'items'));
    }

    public function createCategory(Request $request): Response
    {
        $openSourceCategory = new OpenSourceCategory();
        $openSourceCategory->fill($request->all());
        $openSourceCategory->save();
        return new Response($openSourceCategory);
    }

    public function deleteCategory(Request $request): Response
    {
        $openSourceCategoryId = $request->get("open_source_category_id");
        $openSourceCategory = OpenSourceCategory::find($openSourceCategoryId);
        return new Response($openSourceCategory->delete());
    }
}
