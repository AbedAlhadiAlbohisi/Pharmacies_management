<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class Rolecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::withcount('permissions')->get();
        return response()->view('cms.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.roles.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'guard_name' => 'required|string|in:admin,user,pharmacist'
        ]);
        if (!$validator->fails()) {
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard_name');
            $issaved = $role->save();
            return response()->json(
                ['message' => $issaved ? 'Saved successfully' : 'Save failed'],
                $issaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->join(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();

        $rolepermissions = $role->permissions;
        if (count($rolepermissions) > 0) {
            foreach ($permissions as $permission) {
                $permission->setAttribute('assigned', false);
                foreach ($rolepermissions as $rolepermission) {
                    if ($permission->id == $rolepermission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return response()->view('cms.roles.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }

    public function updateRolePermission(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if (!$validator->fails()) {
            $role = Role::findOrFail($request->input('role_id'));
            $permission = Permission::findOrFail($request->input('permission_id'));
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
            } else {
                $role->givePermissionTo($permission);
            }
            return response()->json(
                ['message' => 'Saved successfully'],
                Response::HTTP_OK
            );
        } else {

            return response()->join(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return response()->view('cms.roles.update', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'guard_name' => 'required|string|in:admin,user,pharmacist'
        ]);
        if (!$validator->fails()) {
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard_name');
            $issaved = $role->save();
            return response()->json(
                ['message' => $issaved ? 'Saved successfully' : 'Save failed'],
                $issaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->join(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();
        return response()->json(
            ['message' => $deleted ? 'Dleted successfully' : 'Dlete failed'],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
