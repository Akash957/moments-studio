<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->getGroupedPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role [' . $role->name . '] created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $this->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $id,
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role [' . $role->name . '] updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if (in_array($role->name, ['Super Admin', 'Admin', 'super-admin', 'admin'])) {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }

    private function getGroupedPermissions()
    {
        $defaultPermissions = [
            'Bookings & Leads'   => ['view_bookings', 'manage_bookings', 'delete_bookings', 'manage_enquiries'],
            'Content & Services' => ['manage_services', 'manage_gallery', 'manage_albums', 'manage_packages', 'manage_videos'],
            'Blog & Media'       => ['manage_blogs', 'manage_testimonials', 'manage_media', 'manage_awards', 'manage_team'],
            'System & Settings'  => ['manage_settings', 'manage_seo', 'manage_users', 'manage_roles'],
        ];

        foreach ($defaultPermissions as $group => $perms) {
            foreach ($perms as $pName) {
                Permission::findOrCreate($pName, 'web');
            }
        }

        return $defaultPermissions;
    }
}
