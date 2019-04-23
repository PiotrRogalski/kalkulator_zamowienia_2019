<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialTypeRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\MaterialType;

class MaterialTypeController extends Controller
{
    public function all() {
        return MaterialType::all();
    }

    public function store(MaterialTypeRequestValidation $request) {
        if (MaterialType::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(MaterialType $id, MaterialTypeRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(MaterialType $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
