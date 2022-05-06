<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Marketplace\Item;
use App\Models\User\Item as UserItem;
use App\Providers\UserBalanceChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $currentPage = $request->get('currentPage');
        $perPage = $request->get('perPage');
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $sortDesc = $request->get('sortDesc') === 'true' ? 'ASC' : 'DESC';
        $offset = $currentPage * $perPage - $perPage;
        $count = Item::where('title', 'LIKE', "%${search}")
            ->count();
        $items = Item::where('title', 'LIKE', "%${search}")
            ->orderBy('highlighted', 'DESC')
            ->orderBy($sortBy, $sortDesc)
            ->offset($offset)
            ->limit($perPage)
            ->get();
        return compact('count', 'items');
    }

    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    public function highlights()
    {
        $items = Item::where('highlighted', true)->get();
        return response()->json($items);
    }

    public function buy(Request $request, Item $item)
    {
        if (Auth::user()->balance < $item->price) {
            return response()->json(['error' => 'Not enough balance'], 400);
        }
        $currentBalance = $request->user()->balance;
        $request->user()->buyItem($item);
        UserItem::create([
            'user_id' => $request->user()->id,
            'item_id' => $item->id,
            'purchased_at' => now(),
        ]);
        event(new UserBalanceChanged(Auth::user(), $item, $currentBalance));

        return response()->json(['message' => 'Item bought succesfully', 'item' => $item]);
    }
}
