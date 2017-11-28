<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Http\Requests\DestroyUser;
use Acacha\Events\Http\Requests\UpdateUser;
use Acacha\Events\Http\Requests\ListUsers;
use Acacha\Events\Http\Requests\ShowUser;
use Acacha\Events\Http\Requests\StoreUser;
use App\User;

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
     * @param ListUsers $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ListUsers $request)
    {
        return User::all();
    }

    /**
     * Show and user
     *
     * @param ShowUser $request
     * @param User $user
     * @return User
     */
    public function show(ShowUser $request, User $user)
    {
        return $user;
    }

    /**
     * Store and user.
     *
     * @param StoreUser $request
     * @return mixed
     */
    public function store(StoreUser $request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }

    /**
     * Edit and user.
     *
     * @param UpdateUser $request
     * @param $user
     * @return mixed
     */
    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->only('name',''));
        $user->save();
        return $user;
    }

    /**
     * Delete user.
     *
     * @param DestroyUser $request
     * @param $user
     * @return mixed
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();
        return $user;
    }

}
