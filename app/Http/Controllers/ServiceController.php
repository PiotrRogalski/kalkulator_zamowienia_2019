<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Service;

class ServiceController extends Controller
{
    public function all() {
        return Service::with('serviceList')->get();
    }

    public function store(ServiceRequestValidation $request) {
        if (Service::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Service $id, ServiceRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Service $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
