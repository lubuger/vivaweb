<?php
/**
 * Created by PhpStorm.
 * User: kvark
 * Date: 22/08/17
 * Time: 14:08
 */

namespace App\Http\Controllers;


use App\User;
use App\UserTime;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ApiController
{

    /**
     * Gets all users and return "groups" for vis.js
     * @return array
     */
    public function getUsers()
    {
        $users = User::all();
        $responseArr = [];

        foreach ($users as $user)
        {
            $responseArr[] = [
                'id' => $user->id,
                'content' => $user->name,
                'value' => $user->id
            ];
        }

        return response()->json($responseArr);
    }

    /**
     * Finds user by user_id and changes action ( 1 = online, 0 - offline )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeUserStatus( Request $request )
    {
        $userId = $request->input('userId');
        $status = $request->input('status');

        $userTime = new UserTime;

        $userTime->user_id = $userId;
        $userTime->action = ( $status === 'true' ) ? 1 : 0;

        $userTime->save();

        return response()->json( ['success' => true, 'user_id' => $userId] );
    }

    /**
     * Gets all user times operations
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersTimes()
    {
        $userTime = UserTime::all();
        $responseArr = [];

        foreach ($userTime as $time)
        {

            $next = UserTime::where('created_at', '>', $time->created_at)
                ->where('user_id', $time->user_id)
                ->first();

            $userColor = User::findOrFail( $time->user_id )->color;

            $responseArr[] = [
                'id'      => $time->id,
                'group'   => $time->user_id,
                'content' => 'Row id: '.$time->id,
                'start'   => $time->created_at->toW3cString(),
                'end'     => ( $next && $next->action != $time->action ) ? $next->created_at->toW3cString() : Carbon::now()->toW3cString(),
                'style'   => 'background-color: '.$userColor.';'
            ];

        }

        return response()->json( $responseArr );
    }


    /**
     * Saves user color
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserColor( Request $request )
    {
        $userId = $request->input('userId');
        $color = $request->input('color');

        $user = User::find( $userId );

        $user->color = $color;
        $user->save();

        return response()->json( ['success' => true, 'user_id' => $userId] );
    }
}