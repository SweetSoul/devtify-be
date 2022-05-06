<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Providers\UserBalanceChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\String_;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $currentPage = $request->get('currentPage');
        $perPage = $request->get('perPage');
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $sortDesc = $request->get('sortDesc') === 'true' ? 'ASC' : 'DESC';
        $offset = $currentPage * $perPage - $perPage;
        $count = Workshop::where('title', 'LIKE', "%${search}")
            ->count();
        $items = Workshop::where('title', 'LIKE', "%${search}")
            ->orderBy($sortBy, $sortDesc)
            ->offset($offset)
            ->limit($perPage)
            ->with('user', 'likes')
            ->get();
        return compact('count', 'items');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->workshops()->where('date', '>=', now())->count()) {
            return response()->json(['error' => 'You can only have one active workshop.'], 403);
        }
        if ($request->date < now()) {
            return response()->json(['error' => 'Workshop date must be in the future.'], 403);
        }
        $workshop = new Workshop;
        $workshop->fill($request->all());
        $workshop->user_id = $request->user()->id;
        $workshop->category_id = 1;
        $workshop->meeting_password = rand(1000000, 9999999);
        $workshop->meeting_link = JitsiMeetingController::createMeeting($workshop);
        $workshop->save();

        $request->user()->balance += 10;
        $request->user()->save();

        return $workshop;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function featured(Request $request)
    {
        $category = $request->get('category') ?? null;
        if ($category) {
            return Workshop::where('category_id', $category)
                ->with('user', 'likes')
                ->withCount('attendees')
                ->orderByDesc("attendees_count")
                ->get();
        }
        return Workshop::with('user', 'likes')
            ->withCount('attendees')
            ->orderByDesc("attendees_count")
            ->get();
    }

    /**
     * Adds the user as an attendee to the workshop.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request, Workshop $workshop)
    {
        if ($request->user()->id === $workshop->user_id) {
            return response()->json(['error' => 'You cannot attend your own workshop.'], 403);
        }
        if ($workshop->attendees()->find($request->user()->id)) {
            return response()->json(['error' => 'You are already attending this workshop.'], 403);
        }
        if ($workshop->price > $request->user()->balance) {
            return response()->json(['error' => 'You do not have enough funds to attend this workshop.'], 403);
        }

        $currentBuyerBalance = $request->user()->balance;
        $workshop->attend($request->user());
        event(new UserBalanceChanged(Auth::user(), $workshop, $currentBuyerBalance));

        $currentSellerBalance = $workshop->user->balance;
        $workshop->user->soldWorkshop($workshop);
        event(new UserBalanceChanged($workshop->user, $workshop, $currentSellerBalance));

        return response()->json(['success' => 'You have successfully attended this workshop.']);
    }

    public function show(Workshop $workshop)
    {
        return Workshop::with('user', 'category')->find($workshop->id);
    }

    public function like(Request $request, Workshop $workshop)
    {
        if ($request->user()->id === $workshop->user_id) {
            return response()->json(['error' => 'You cannot like your own workshop.'], 403);
        }
        if ($workshop->likes()->find($request->user()->id)) {
            return response()->json(['error' => 'You have already liked this workshop.'], 403);
        }
        $workshop->like($request->user());
        return response()->json(['success' => 'You have successfully liked this workshop.']);
    }

    public function unlike(Request $request, Workshop $workshop)
    {
        if ($request->user()->id === $workshop->user_id) {
            return response()->json(['error' => 'You cannot unlike your own workshop.'], 403);
        }
        if (!$workshop->likes()->find($request->user()->id)) {
            return response()->json(['error' => 'You have not liked this workshop.'], 403);
        }
        $workshop->unlike($request->user());
        return response()->json(['success' => 'You have successfully unliked this workshop.']);
    }
}
