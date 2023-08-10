<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    public function __construct()
    {
        return $this->authorizeResource(Admin::class, 'admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Admin::with('cities')->get();
        return response()->view('cms.admins.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cities = City::where('active', '=', true)->get();
        $roles = Role::where('guard_name', '=', 'admin')->get();
        return response()->view('cms.admins.creat', [
            'cities' => $cities,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'cities' => 'required|numeric|exists:cities,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins',
            'phone' => 'required|string|min:10',
            'image' => 'required|image|max:2048|mimes:jpg,png',
            'password' => 'required|string',

        ]);
        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->phone = $request->input('phone');
            $admin->email = $request->input('email');
            $admin->city_id = $request->input('cities');
            $admin->password = Hash::make($request->input('password'));
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $admin->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('admin', $imageName, ['disk' => 'public']);
                $admin->image = 'admin/' . $imageName;
            }
            $issaved = $admin->save();
            if ($issaved) {
                $admin->assignRole(Role::findOrFail($request->input('role_id')));
            }
            return response()->json(
                ['message' => $issaved ? 'Admin created successfully' : 'Admin created failed'],
                $issaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST

            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
        $roles = Role::where('guard_name', '=', 'admin')->get();
        $adminRole = $admin->roles[0];
        $cities = City::where('active', '=', true)->get();
        return response()->view('cms.admins.update', [
            'admin' => $admin,
            'cities' => $cities,
            'roles' => $roles,
            'adminRole' => $adminRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        //
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'cities' => 'required|numeric|exists:cities,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'image' => 'nullable', 'image|max:2048|mimes:jpg,png',

        ]);
        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->phone = $request->input('phone');
            $admin->email = $request->input('email');
            $admin->city_id = $request->input('cities');
            if ($request->hasFile('image')) {
                if ($admin->image !== Null) {
                    Storage::disk('public')->delete($admin->image);
                }
                $imageName = time() . '_' . str_replace(' ', '', $admin->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('admin', $imageName, ['disk' => 'public']);
                $admin->image = 'admin/' . $imageName;
            }
            $issaved = $admin->save();
            if ($issaved) $admin->syncRoles(Role::findOrFail($request->input('role_id')));

            return response()->json(
                ['message' => $issaved ? 'Admin Update successfully' : 'Admin Update failed'],
                $issaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST

            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $admin)
    {
        if (auth('admin')->id() != $admin->id) {
            $deleted = $admin->delete();
            if ($deleted) {
                if ($admin->image !== Null) {
                    Storage::disk('public')->delete($admin->image);
                }
            }
            return response()->json(
                ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
                $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' =>  'Can\'t dleste your Acoount '],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
