<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOfDeliveryRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\PlaceOfDelivery;

class PlaceOfDeliveryController extends Controller
{
    public function all() {
        return PlaceOfDelivery::all();
    }

    public function store(PlaceOfDeliveryRequestValidation $request) {
        if (PlaceOfDelivery::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(PlaceOfDelivery $id, PlaceOfDeliveryRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(PlaceOfDelivery $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
