<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\User\StoreUserRequest;
use Modules\User\Http\Requests\User\UpdateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    
    /**
     *
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(User::class);
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $users = User::sortable()->paginate();

        return view('user::user.index', compact('users'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $user = new User;
        return view('user::user.create', compact('user'));
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $sanitized = $request->getSanitized();

        User::create($sanitized);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * @param User $user
     * @return Factory|View|Application
     */
    public function show(User $user): Factory|View|Application
    {
        return view('user::user.show', compact('user'));
    }

    /**
     * @param User $user
     * @return Factory|View|Application
     */
    public function edit(User $user): Factory|View|Application
    {
        return view('user::user.edit', compact('user'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $sanitized = $request->getSanitized();
        
        $user->update($sanitized);

        return redirect()->route('users.edit', [$user])
            ->with('success', 'User updated successfully');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
