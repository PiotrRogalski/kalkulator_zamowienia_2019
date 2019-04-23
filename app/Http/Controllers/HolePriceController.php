<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolePriceRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\HolePrice;

class HolePriceController extends Controller
{
    public function all() {
        return HolePrice::all();
    }

    public function store(HolePriceRequestValidation $request) {
        if (HolePrice::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(HolePrice $id, HolePriceRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(HolePrice $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
