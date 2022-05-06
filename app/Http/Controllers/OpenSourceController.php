<?php

namespace App\Http\Controllers;

use App\Models\OpenSourcePost;
use App\Models\OpenSourceReaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OpenSourceController extends Controller
{
    public function posts(Request $request, $currentPage, $itemsQty): Response
    {
        $search = $request->get('search');
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $sortDesc = $request->get('sortDesc') === 'true' ? 'ASC' : 'DESC';
        $offset = $currentPage * $itemsQty - $itemsQty;
        $count = OpenSourcePost::where('title', 'LIKE', "%${search}%")
            ->count();
        $items = OpenSourcePost::where('title', 'LIKE', "%${search}%")
            ->orderBy($sortBy, $sortDesc)
            ->offset($offset)
            ->limit($itemsQty)
            ->get();
        return Response(compact('count', 'items'));
    }

    public function createPost(Request $request): Response
    {
        $openSourcePost = new OpenSourcePost();
        $openSourcePost->fill($request->all());
        $openSourcePost->user_id = Auth::id();
        $openSourcePost->save();
        return new Response($openSourcePost);
    }

    public function editPost(Request $request, $id): Response
    {
        $openSourcePost = OpenSourcePost::find($id);
        if ( $openSourcePost->user_id == Auth::id() )
        {
            $openSourcePost->fill($request->all());
            $openSourcePost->save();
        }
        return new Response($openSourcePost);
    }

    public function postsByCategory(Request $request, $category, $currentPage, $itemsQty): Response
    {
        $search = $request->get('search');
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $sortDesc = $request->get('sortDesc') === 'true' ? 'ASC' : 'DESC';
        $offset = $currentPage * $itemsQty - $itemsQty;
        $count = OpenSourcePost::where([['title', 'LIKE', "%${search}%"], ['open_source_category_id', '=', $category]])
            ->count();
        $items = OpenSourcePost::where([['title', 'LIKE', "%${search}%"], ['open_source_category_id', '=', $category]])
            ->orderBy($sortBy, $sortDesc)
            ->offset($offset)
            ->limit($itemsQty)
            ->get();
        return Response(compact('count', 'items'));
    }

    public function createPostLike(Request $request): Response
    {
        $openSourceReaction = new OpenSourceReaction();
        $openSourceReaction->open_source_post_id = $request->get("open_source_post_id");
        $openSourceReaction->user_id = Auth::id();
        $openSourceReaction->save();
        return new Response($openSourceReaction);
    }

    public function deletePostLike(Request $request): Response
    {
        $openSourcePostId = $request->get("open_source_post_id");
        $result = OpenSourceReaction::where([['open_source_post_id', '=', $openSourcePostId], ['user_id', '=', Auth::id()]])->delete();
        return new Response($result);
    }

    public function deletePost(Request $request): Response
    {
        $openSourcePostId = $request->get("open_source_post_id");
        $result = OpenSourcePost::where([['id', '=', $openSourcePostId], ['user_id', '=', Auth::id()]])->delete();
        return new Response($result);
    }
}
