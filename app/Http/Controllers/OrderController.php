<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\pharmaceutical;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth('user')->check()) {
            $data = Order::where('user_id', auth()->user()->id)->get();
        } else if (auth('pharmacist')->check()) {
            $data = Order::where('pharmacist_id', auth()->user()->id)->get();
        } else {
            $data = Order::all();
        }
        return response()->view('cms.order.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $pharmacists = Pharmacist::where('blocked', false)->get();
        $pharmaceuticals = pharmaceutical::where('active', true)->get();
        // dd($pharmaceuticals);
        $users = User::where('blocked', false)->get();
        return response()->view('cms.order.creat', [
            'pharmacists' => $pharmacists,
            'pharmaceuticals' => $pharmaceuticals,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'location' => 'required|string|min:3',
            'totle' => 'required|string',
            'pharmaceutical_id' => 'required|numeric|exists:pharmaceuticals,id',
            'count' => 'required|string',
            'image' => 'required|image|max:2048|mimes:jpg,png'
        ]);

        if (!$validator->fails()) {
            $order = new Order();
            $order->totle = $request->input('totle');
            $order->count = $request->input('count');
            $order->location = $request->input('location');
            if (auth('user')->check()) {
                $order->pharmacist_id = $request->input('pharmacist_id');
            } else {
                $order->pharmacist_id = auth()->user()->id;
            }

            if (auth('user')->check()) {
                $order->user_id = auth()->user()->id;
            } else {
                $order->user_id = $request->input('user_id');
            }
            $order->pharmaceutical_id = $request->input('pharmaceutical_id');
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $order->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('user', $imageName, ['disk' => 'public']);
                $order->image = 'user/' . $imageName;
            }

            $isSaved = $order->save();
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
        $pharmacists = Pharmacist::where('blocked', false)->get();
        $pharmaceuticals = pharmaceutical::where('active', true)->get();
        return response()->view('cms.order.update', [
            'pharmacists' => $pharmacists,
            'pharmaceuticals' => $pharmaceuticals,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        $validator = Validator($request->all(), [
            'location' => 'required|string|min:3',
            'totle' => 'required|string|min:3',
            'pharmacist_id' => 'required|numeric|exists:pharmacist,id',
            'pharmaceutical_id' => 'required|numeric|exists:pharmacist,id',
            'user_id' => 'required|numeric|exists:user,id',
            'count' => 'required|string|min:10',
            'image' => 'required|image|max:2048|mimes:jpg,png'
        ]);

        if (!$validator->fails()) {
            $order = new Order();

            $order->totle = $request->input('totle');
            $order->count = $request->input('count');
            $order->location = $request->input('location');
            $order->pharmacist_id = $request->input('pharmacist_id');
            $order->user_id = $request->input('user_id');
            $order->pharmaceutical_id = $request->input('pharmaceutical_id');
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . str_replace(' ', '', $order->name) . '.' . $request->file('image')->extension();
                $request->file('image')->storePubliclyAs('user', $imageName, ['disk' => 'public']);
                $order->image = 'user/' . $imageName;
            }
            $isSaved = $order->save();
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
    public function destroy(Order $order)
    {
        //
        $deleted = $order->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
