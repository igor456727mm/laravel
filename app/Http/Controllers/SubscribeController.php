<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
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
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $subscribe = \App\Subscribe::create($request->all());
            return response()->json($subscribe, Response::HTTP_OK);
        }

    }
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }else{
            $subscribe = \App\Subscribe::where(['user_id' => $request->get("subscribe_id"), 'user_id' => $request->get("user_id") ])->delete();
            return response()->json($subscribe, Response::HTTP_OK);
        }

    }
}
