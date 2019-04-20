<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Order;

class OrderController extends Controller
{
    public function all() {
        return Order::with('clients')->get();
//        return Order::all();
    }

    public function single(Order $id) {
        return Order::findOrFail($id);
    }

    public function store(OrderRequestValidation $request) {
        Order::create($request->all());
        return response('CREATED', Response::HTTP_CREATED);
    }

    public function update(Order $order, OrderRequestValidation $request) {
        $order->update($request->all());
        return response('OK', Response::HTTP_OK);
    }

    public function destroy(Order $id) {
        return Order::destroy($id);
    }
}
