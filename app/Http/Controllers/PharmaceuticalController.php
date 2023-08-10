<?php

namespace App\Http\Controllers;

use App\Models\pharmaceutical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PharmaceuticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('pharmacist')->check()) {
            $data = pharmaceutical::with('pharmacist')->get();
        } else {
            $data = pharmaceutical::where('pharmacist_id', auth()->user()->id)->get();
        }
        return response()->view('cms.pharmaceutical.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return response()->view('cms.Pharmaceutical.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|min:3',
            'price' => 'required|string',
            'content' => 'required|string|min:3',
            'active' => 'required|boolean',
            'image' => 'required|image|max:2048|mimes:jpg,png',

        ]);
        if (!$validator->fails()) {
            $pharmaceutical = new Pharmaceutical();
            $pharmaceutical->name = $request->input('name');
            $pharmaceutical->price = $request->input('price');
            $pharmaceutical->content = $request->input('content');
            $pharmaceutical->active = $request->input('active');
            $pharmaceutical->pharmacist_id = auth()->user()->id;

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $pharmaceutical->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('pharmaceutical', $imageName, ['disk' => 'public']);
                $pharmaceutical->image = 'pharmaceutical/' . $imageName;
            }
            $issaved = $pharmaceutical->save();
            return response()->json(
                ['message' => $issaved ? 'pharmaceutical created successfully' : 'pharmaceutical created failed'],
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
    public function show(pharmaceutical $pharmaceutical)
    {
        //
        $data = pharmaceutical::where('id', $pharmaceutical->id)->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pharmaceutical $pharmaceutical)
    {

        return response()->view('cms.pharmaceutical.update', [
            'pharmaceutical' => $pharmaceutical,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pharmaceutical $pharmaceutical)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|min:3',
            'price' => 'required|string',
            'content' => 'required|string|min:3',
            'active' => 'required|boolean',
            'image' => 'nullable|image|max:2048|mimes:jpg,png',

        ]);
        if (!$validator->fails()) {
            $pharmaceutical->name = $request->input('name');
            $pharmaceutical->price = $request->input('price');
            $pharmaceutical->content = $request->input('content');
            $pharmaceutical->active = $request->input('active');
            $pharmaceutical->pharmacist_id = auth()->user()->id;
            if ($request->hasFile('image')) {
                if ($pharmaceutical->image !== Null) {
                    Storage::disk('public')->delete($pharmaceutical->image);
                }
                $imageName = time() . '_' . str_replace(' ', '', $pharmaceutical->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('pharmaceutical', $imageName, ['disk' => 'public']);
                $pharmaceutical->image = 'pharmaceutical/' . $imageName;
            }
            $issaved = $pharmaceutical->save();
            return response()->json(
                ['message' => $issaved ? 'pharmaceutical created successfully' : 'pharmaceutical created failed'],
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
    public function destroy(pharmaceutical $pharmaceutical)
    {
        $deleted = $pharmaceutical->delete();
        if ($deleted) {
            if ($pharmaceutical->image !== Null) {
                Storage::disk('public')->delete($pharmaceutical->image);
            }
        }
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
