<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use \App\UserAction;

class UserController extends Controller
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
    public function send(Request $request)
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

    public function action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $offset = ($request->get('page') == 1 ? 0 : $this->limitPage*$request->get('page'));
            $actions = \App\UserAction::offset($offset)->limit($this->limitPage)->get();
            return response()->json($actions, Response::HTTP_OK);
        }
    }
    public function getpost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'page' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $offset = ($request->get('page') == 1 ? 0 : $this->limitPage*$request->get('page'));
            $posts = \App\Post::where(['user_id' => $request->get('user_id')])->offset($offset)->limit($this->limitPage)->get();
            return response()->json($posts, Response::HTTP_OK);
        }

    }
    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',


        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $user = \App\User::where(['id' => $request->get('user_id')])->get();
            return response()->json($user, Response::HTTP_OK);
        }

    }
}
