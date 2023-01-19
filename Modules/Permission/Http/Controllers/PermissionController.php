<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Http\Requests\Permission\StorePermissionRequest;
use Modules\Permission\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionController extends Controller
{
    use AuthorizesRequests;
    
    /**
     *
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Permission::class);
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $permissions = Permission::sortable()->paginate();

        return view('permission::permission.index', compact('permissions'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $permission = new Permission;
        return view('permission::permission.create', compact('permission'));
    }

    /**
     * @param StorePermissionRequest $request
     * @return RedirectResponse
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $sanitized = $request->getSanitized();

        Permission::create($sanitized);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * @param Permission $permission
     * @return Factory|View|Application
     */
    public function show(Permission $permission): Factory|View|Application
    {
        return view('permission::permission.show', compact('permission'));
    }

    /**
     * @param Permission $permission
     * @return Factory|View|Application
     */
    public function edit(Permission $permission): Factory|View|Application
    {
        return view('permission::permission.edit', compact('permission'));
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $sanitized = $request->getSanitized();
        
        $permission->update($sanitized);

        return redirect()->route('permissions.edit', [$permission])
            ->with('success', 'Permission updated successfully');
    }

    /**
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
