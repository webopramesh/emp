<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/address",
     *     tags={"Address"},
     *     summary="Get all addresses",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get all addresses",
     *     operationId="getAllAddress",
     *     @OA\Response(
     *         response=201,
     *         description="Addresses fetched successfully"
     *     )
     * )
     */
    public function index()
    {
        try {
            $addresses = Address::all();
            if (!$addresses) {
                throw new \Exception('No addresses found!');
            }
            return response()->json(['message' => 'Addresses fetched successfully', 'data' => $addresses]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something wrong with server'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/user-addresses",
     *     tags={"User Actions"},
     *     summary="Get the logged in user addresses",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get the logged in user addresses",
     *     operationId="userAddresses",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     )
     * )
     */
    public function userAddresses()
    {
        try {
            $id = auth()->user()->id;
            $addresses = Address::where('user_id', $id)->get();
            return response()->json(['message' => 'Logged in users addresses fetched successfully', 'addresses' => $addresses], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/address",
     *     tags={"Address"},
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
        try {
            DB::beginTransaction();
            $response = Address::create([
                'user_id' => auth()->user()->id,
                "street1" => $request->street1,
                "street2" => $request->street2,
                "city" => $request->city,
                "state" => $request->state,
                "zip" => $request->zip,
                "country" => $request->country
            ]);
            DB::commit();
            return response()->json(['message' => 'Address stored successfully!', 'data' => $response], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something wrong with server'], 500);
        }
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
     *     tags={"Address"},
     *     summary="updates user address",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get updates user address",
     *     operationId="addressUpdate",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
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
        try {
            $address = Address::find($id);
            if (!$address) {
                throw new \Exception('No addresses founds!');
            }

            DB::beginTransaction();
            $address->update([
                "street1" => $request->street1,
                "street2" => $request->street2,
                "city" => $request->city,
                "state" => $request->state,
                "zip" => $request->zip,
                "country" => $request->country
            ]);
            DB::commit();
            return response()->json(['message' => 'Address updated successfully!', 'data' => ['address_id' => $id]], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/address/{id}",
     *     tags={"Address"},
     *     summary="deletes user address",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Deletes user address",
     *     operationId="addressDelete",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="address id",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Deleted",
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $address = Address::find($id);
            if (!$address) {
                throw new \Exception('No records found!');
            }
            Address::find($id)->delete();
            return response()->json(['message' => 'Address deleted successfully!', 'data' => ['address_id' => $id]], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
