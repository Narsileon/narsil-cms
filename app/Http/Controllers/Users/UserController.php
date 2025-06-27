<?php

namespace App\Http\Controllers\Users;

#region USE

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $users = User::query()
            ->paginate(15);

        return Inertia::render('users/index', [
            "users" => $users,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('users/form');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validated();

        User::create($attributes);

        return redirect(route('users.index'))
            ->with('success', 'models.users.events.created');
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        return Inertia::render('users/form', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $attributes = $request->validated();

        $user->update($attributes);

        return redirect(route('users.index'))
            ->with('success', 'models.users.events.updated');
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return redirect(route('users.index'))
            ->with('success', 'models.users.events.deleted');
    }

    #endregion
}
