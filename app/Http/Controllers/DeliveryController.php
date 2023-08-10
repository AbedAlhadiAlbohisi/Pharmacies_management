<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(Delivery::class, 'delivery');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Delivery::with('pharmacists')->get();
        return response()->view('cms.delivery.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pharmacists = Pharmacist::where('blocked', '=', false)->get();
        return response()->view('cms.delivery.creat', ['pharmacists' => $pharmacists]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'pharmacists' => 'required|numeric|exists:pharmacists,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:deliveries',
            'password' => 'required|string|min:3',
            'phone' => 'required|string|min:10',
            'TypeVehicle' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $delivery = new Delivery();
            $delivery->name = $request->input('name');
            $delivery->email = $request->input('email');
            $delivery->password = Hash::make($request->input('password'));
            $delivery->phone = $request->input('phone');
            $delivery->Pharmacist_id = $request->input('pharmacists');
            $delivery->TypeVehicle = $request->input('TypeVehicle');


            $issaved = $delivery->save();
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
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {

        $pharmacists = Pharmacist::where('blocked', '=', false)->get();
        return response()->view('cms.delivery.update', [
            'Delivery' => $delivery,
            'pharmacists' => $pharmacists,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validator = validator($request->all(), [
            'pharmacists' => 'required|numeric|exists:pharmacists,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'TypeVehicle' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $delivery->Pharmacist_id = $request->input('pharmacists');
            $delivery->name = $request->input('name');
            $delivery->email = $request->input('email');
            $delivery->phone = $request->input('phone');
            $delivery->TypeVehicle = $request->input('TypeVehicle');
            $issaved = $delivery->save();
            return response()->json(
                ['message' => $issaved ? 'delivery created successfully' : 'delivery created failed'],
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
    public function destroy(Delivery $delivery)
    {
        $deleted = $delivery->delete();
        return response()->json(
            ['message' => $deleted ? 'Deleted successfully' : 'Deleted failled '],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
