<?php
/**
 * Created by PhpStorm.
 * User: kvark
 * Date: 22/08/17
 * Time: 12:43
 */

namespace App\Http\Controllers;

use App\User;
use App\UserTime;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    /**
     * Main dashboard view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::loginUsingId(1, true);

        $responseArr = [];

        $users = User::all();
        foreach ($users as $user) {

            $userStatus = UserTime::where( 'user_id', $user->id )
                ->orderBy( 'id', 'desc' )
                ->first();

            $responseArr[] = [
                'id' => $user->id,
                'color' => $user->color,
                'name' => $user->name,
                'status' => ( $userStatus ) ? $userStatus->action : false
            ];

        }

        return view('welcome', [ 'users' => $responseArr ]);
    }
}