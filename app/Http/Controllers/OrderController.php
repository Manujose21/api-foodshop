<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatuses;
use App\Enums\UserRole;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    //

    public function index(Request $request)
    {
        // get all orders
        $orders = Order::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->paginate(6);
        // return all orders
        return new OrderCollection($orders);
    }

    /**
     * 
     * Get all orders
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllOrders(Request $request)
    {
        // check if user is admin
        if ($request->user()->role !== UserRole::ADMIN) {
            return response()->json([
                'message' => 'You are not authorized to view all orders',
            ], 403);
        }

        // get all orders
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        
        // return all orders
        return new OrderCollection($orders);
    }

    public function store(OrderRequest $request)
    {

        $order = Order::create([
            'user_id' => $request->user()->id,
            'products' => $request->products,
            'total_price' => $request->total_price,
            'status' => OrderStatuses::PENDING,
        ]);


        // create new order
        return new OrderResource($order);
    }


    /**
     * 
     * complete or cancelled order
     * 
     */
    public function complete(Request $request, Order $order)
    {
        // validate is admin
        
        if( $request->user()->role !== UserRole::ADMIN ) {
            return response()->json([
                'message' => 'You are not authorized to update this order',
            ], 403);
        }

        //  validate request
        $request->validate([
            'status' => 'required|in:' . implode(',', OrderStatuses::getValues()),
        ]);

        $order->status = $request->status;
        $order->save();

        return new OrderResource($order);
    }

    public function delete(Request $request, Order $order)
    {

        // check if order belongs to user
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this order',
            ], 403);
        }

        $order->delete();
        // delete order
        return new OrderResource($order);
    }

}
