<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Role\Entities\Role;
use Modules\Role\Http\Requests\Role\StoreRoleRequest;
use Modules\Role\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;
    
    /**
     *
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Role::class);
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $roles = Role::sortable()->paginate();

        return view('role::role.index', compact('roles'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $role = new Role;        
        return view('role::role.create', compact('role'));
    }

    /**
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $sanitized = $request->getSanitized();

        Role::create($sanitized);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * @param Role $role
     * @return Factory|View|Application
     */
    public function show(Role $role): Factory|View|Application
    {
        return view('role::role.show', compact('role'));
    }

    /**
     * @param Role $role
     * @return Factory|View|Application
     */
    public function edit(Role $role): Factory|View|Application
    {
        return view('role::role.edit', compact('role'));
    }

    /**
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $sanitized = $request->getSanitized();
        
        $role->update($sanitized);

        return redirect()->route('roles.edit', [$role])
            ->with('success', 'Role updated successfully');
    }

    /**
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
