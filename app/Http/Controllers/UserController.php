<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::withCount('permissions')->with('city')->get();
        $user = User::with('roles')->with('city')->get();

        return response()->view('cms.user.index', ['user' => $user, 'roles' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $citys = City::where('active', '=', true)->get();
        $roles = Role::where('guard_name', '=', 'user')->get();
        return response()->view('cms.user.creat', ['citys' => $citys, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'age' => 'required|string|max:2',
            'gender' => 'required|string|in:M,F',
            'city_id' => 'required|numeric|exists:cities,id',
            'phoneNumper' => 'required|string|min:10',
            'image' => 'required|image|max:2048|mimes:jpg,png'
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->city_id = $request->input('city_id');
            $user->password = Hash::make($request->input('password'));
            $user->age = $request->input('age');
            $user->gender = $request->input('gender');
            $user->phone = $request->input('phoneNumper');
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $user->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('user', $imageName, ['disk' => 'public']);
                $user->image = 'user/' . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved) {
                $user->assignRole(Role::findOrFail($request->input('role_id')));
            }
            return Response()->json(

                ['message' => $isSaved ? 'created successfully' : 'created failed!'],

                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $roles = Role::where('guard_name', '=', 'user')->get();
        $userRoles = $user->roles[0];
        $citys = City::where('active', '=', true)->get();
        return response()->view('cms.user.update', [
            'user' => $user,
            'roles' => $roles,
            'cities' => $citys,
            'userRole' => $user
        ]);
        // 'Pharmacist' => $user,);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            // 'password' => 'required|string',
            'age' => 'required|string|max:2',
            'gender' => 'required|string|in:M,F',
            'city_id' => 'required|numeric|exists:cities,id',
            'phoneNumper' => 'required|string|min:10',
            'image' => 'required|image|max:2048|mimes:jpg,png'
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->city_id = $request->input('city_id');
            // $user->password = Hash::make('password');
            $user->age = $request->input('age');
            $user->gender = $request->input('gender');
            $user->phone = $request->input('phoneNumper');
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $user->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('user', $imageName, ['disk' => 'public']);
                $user->image = 'user/' . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved) {
                $user->assignRole(Role::findOrFail($request->input('role_id')));
            }
            return Response()->json(

                ['message' => $isSaved ? 'created successfully' : 'created failed!'],

                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        $deleted = $user->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
