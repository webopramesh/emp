<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/address",
     *     tags={"User Address"},
     *     summary="adds user address",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get adds user address",
     *     operationId="addressStore",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"street1", "street2","city","state","zip","country"},
     *             @OA\Property(property="street1", type="string", format="string", example="Biratnagar Bargachi"),
     *             @OA\Property(property="street2", type="string", format="string", example="Biratnagar Morang"),
     *             @OA\Property(property="city", type="string", format="string", example="Biratnagar"),
     *             @OA\Property(property="state", type="string", format="string", example="1"),
     *             @OA\Property(property="zip", type="string", format="string", example="54000"),
     *             @OA\Property(property="country", type="string", format="string", example="Nepal"),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful Created",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $response = Address::create([
            "street1" => $request->street1,
            "street2" => $request->street2,
            "city" => $request->city,
            "state" => $request->state,
            "zip" => $request->zip,
            "country" => $request->country
        ]);

        return response()->json(['message' => 'Address stored successfully!', 'data' => $response], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/address/{id}",
     *     tags={"User Address"},
     *     summary="updates user address",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get updates user address",
     *     operationId="addressUpdate",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="address id",
     *         required=true,
     *      ),
     *     @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *             @OA\Property(property="street1", type="string", format="string", example="1Biratnagar Bargachi"),
     *             @OA\Property(property="street2", type="string", format="string", example="1Biratnagar Morang"),
     *             @OA\Property(property="city", type="string", format="string", example="1Biratnagar"),
     *             @OA\Property(property="state", type="string", format="string", example="11"),
     *             @OA\Property(property="zip", type="string", format="string", example="154000"),
     *             @OA\Property(property="country", type="string", format="string", example="1Nepal"),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Updated",
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $response = Address::where('id', $request->id)->update([
            "street1" => $request->street1,
            "street2" => $request->street2,
            "city" => $request->city,
            "state" => $request->state,
            "zip" => $request->zip,
            "country" => $request->country
        ]);
        return response()->json(['message' => 'Address updated successfully!', 'address_id' => $request->id], 200);
    }


    /**
     * @OA\Delete(
     *     path="/address/{id}",
     *     tags={"User Address"},
     *     summary="deletes user address",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Deletes user address",
     *     operationId="addressDelete",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="address id",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Deleted",
     *     )
     * )
     */
    public function destroy(Request $request, $id)
    {
        Address::find($request->id)->delete();
        return response()->json(['message' => 'Address deleted successfully!', 'address_id' => $request->id], 200);
    }
}
