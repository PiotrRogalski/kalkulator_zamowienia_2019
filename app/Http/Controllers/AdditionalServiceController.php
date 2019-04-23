<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdditionalServiceRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\AdditionalService;

class AdditionalServiceController extends Controller
{
    public function all() {
        return AdditionalService::all();
    }

    public function store(AdditionalServiceRequestValidation $request) {
        if (AdditionalService::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(AdditionalService $id, AdditionalServiceRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(AdditionalService $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
