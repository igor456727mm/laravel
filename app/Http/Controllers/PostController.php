<?php

namespace App\Http\Controllers;

use App\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public $limitPage = 10;
    public function __construct(Request $response)
    {
        if($response->headers->get('token') && $response->headers->get('token') != '') {
            $currentuser = \App\User::find($response->headers->get('token'));

            if($currentuser)
            {
                Auth::login($currentuser);
            }else{
                die();
            }
        }else{
            die();
        }
    }
    //$response->headers
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'text' => 'required|max:1000',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $post = \App\Post::create($request->all());
            return response()->json($post, Response::HTTP_OK);
        }

    }
    public function usersend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $user = \App\User::create($request->all());
            return response()->json($user, Response::HTTP_OK);
        }

    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $offset = ($request->get('page') == 1 ? 0 : $this->limitPage*$request->get('page'));
            $posts = \App\Post::offset($offset)->limit($this->limitPage)->orderBy('created_at')->get();
            return response()->json($posts, Response::HTTP_OK);
        }



    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $offset = ($request->get('page') == 1 ? 0 : $this->limitPage*$request->get('page'));
            $posts = \App\Post::whereIn('user_id', function($query ) use ($request) {
                        $query->select('subscribe_id')
                            ->from(with(new Subscribe)->getTable())
                            ->where(['user_id' => $request->get('user_id')]);
                        })
                ->offset($offset)
                ->limit($this->limitPage)
                ->orderBy('created_at')
                ->get();
            return response()->json($posts, Response::HTTP_OK);
        }

    }

    public function delete()
    {
        \App\Post::where('created_at', '<=', Carbon::now()->subDays(2)->toDateTimeString())->delete();
    }
}
