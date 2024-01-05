<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Schema(
 *     schema="Order",
 *     @OA\Property(property="name", type="string", default="test"),
 *     @OA\Property(property="image", type="string", default="test"),
 *     @OA\Property(property="status", type="integer", default="1"),
 *     @OA\Property(property="company_id", type="integer", default="1"),
 *     @OA\Property(property="driver_id", type="integer", default="1")
 *  )
 */
class OrderController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get a list of orders",
     *     @OA\Response(
     *         response=200,
     *         description="List of orders",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Order")
     *         )
     *     ),
     *     security={
     *         {"api_token": {}}
     *     }
     * )
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $getOrders = Order::with('creator', 'driver')->get();

        return OrderResource::collection($getOrders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Order")
     *         )
     *     ),
     *     security={
     *         {"api_token": {}}
     *     }
     * )
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        return new OrderResource($order);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get a order by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found"),
     *         )
     *     )
     * )
     *     security={
     *         {"api_token": {}}
     *     }
     * )
     */
    public function show(string $id)
    {
        try {
            $order = Order::with('creator', 'driver')->findOrFail($id);
            return new OrderResource($order);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Update a order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Order")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found"),
     *         )
     *     )
     * )
     *     security={
     *         {"api_token": {}}
     *     }
     * )
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update($request->validated());
            return new OrderResource($order);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Delete a order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order deleted successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found"),
     *         )
     *     )
     * )
     *     security={
     *         {"api_token": {}}
     *     }
     * )
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }
}
