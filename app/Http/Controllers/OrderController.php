<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Order;

class OrderController extends Controller
{
    public function all() {
        return Order::with(['clients','glassPanes'])->get();
    }

    public function single(Order $order, $id) {
        return $order->findOrFail($id)->with('clients')->withGlassPanes()->first();
    }

    public function store(OrderRequestValidation $request) {
        if (Order::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Order $id, OrderRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Order $id) {
        if ($id->delete()) {
            return response('OK - force deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
