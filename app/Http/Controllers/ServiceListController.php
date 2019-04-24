<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceListRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\ServiceList;

class ServiceListController extends Controller
{
    public function all() {
        return ServiceList::all();
    }

    public function store(ServiceListRequestValidation $request) {
        if (ServiceList::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(ServiceList $id, ServiceListRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(ServiceList $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
