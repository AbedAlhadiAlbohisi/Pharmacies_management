<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class PharmacistController extends Controller
{

    public function __construct()
    {
        return $this->authorizeResource(Pharmacist::class, 'pharmacist');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pharmacist::all();
        return response()->view('cms.Pharmacist.index', ['data' => $data]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', '=', 'pharmacist')->get();
        return response()->view('cms.Pharmacist.creat', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:pharmacists',
            'password' => 'required|string|min:3',
            'phone' => 'required|string|min:10',
            'blocked' => 'required|boolean',
            'location' => 'required|string|min:3',
            'namepharmacy' => 'required|string|min:3',
            'image' => 'required|image|max:2048|mimes:jpg,png',
        ]);
        if (!$validator->fails()) {
            $pharmacist = new Pharmacist();
            $pharmacist->name = $request->input('name');
            $pharmacist->phone = $request->input('phone');
            $pharmacist->location = $request->input('location');
            $pharmacist->namepharmacy = $request->input('namepharmacy');
            $pharmacist->email = $request->input('email');
            $pharmacist->password = Hash::make($request->input('password'));
            $pharmacist->blocked = $request->input('blocked');
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $pharmacist->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('pharmacist', $imageName, ['disk' => 'public']);
                $pharmacist->image = 'pharmacist/' . $imageName;
            }
            $issaved = $pharmacist->save();
            if ($issaved) {
                $pharmacist->assignRole(Role::findOrFail($request->input('role_id')));
            }
            return response()->json(
                ['message' => $issaved ? 'pharmacist created successfully' : 'pharmacist created failed'],
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
    public function show(Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacist $pharmacist)
    {
        $roles = Role::where('guard_name', '=', 'pharmacist')->get();
        $adminRole = $pharmacist->roles[0];
        return response()->view('cms.Pharmacist.update', [
            'Pharmacist' => $pharmacist,
            'roles' => $roles,
            'adminRole' => $adminRole

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacist $pharmacist)
    {
        $validator = validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'blocked' => 'required|boolean',
            'location' => 'required|string|min:3',
            'namepharmacy' => 'required|string|min:3',
            'image' => 'nullable', 'image|max:2048|mimes:jpg,png',
        ]);
        if (!$validator->fails()) {
            $pharmacist->name = $request->input('name');
            $pharmacist->phone = $request->input('phone');
            $pharmacist->location = $request->input('location');
            $pharmacist->namepharmacy = $request->input('namepharmacy');
            $pharmacist->email = $request->input('email');
            $pharmacist->blocked = $request->input('blocked');
            if ($request->hasFile('image')) {
                if ($pharmacist->image !== Null) {
                    Storage::disk('public')->delete($pharmacist->image);
                }
                $imageName = time() . '_' . str_replace(' ', '', $pharmacist->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('pharmacist', $imageName, ['disk' => 'public']);
                $pharmacist->image = 'pharmacist/' . $imageName;
            }
            $issaved = $pharmacist->save();
            if ($issaved) {
                $pharmacist->assignRole(Role::findOrFail($request->input('role_id')));
            }
            return response()->json(
                ['message' => $issaved ? 'pharmacist created successfully' : 'pharmacist created failed'],
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
    public function destroy(Pharmacist $pharmacist)
    {
        $deleted = $pharmacist->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
