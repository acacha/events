<?php

namespace Acacha\Events\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

/**
 * Class APIUsersController.
 *
 * @package App\Http\Controllers
 */
class APIUsersController extends Controller
{
    /**
     * Show list of users.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        return User::all();
    }

}
