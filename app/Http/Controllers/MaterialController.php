<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Material;

class MaterialController extends Controller
{
    public function all() {
        return Material::all();
    }

    public function store(MaterialRequestValidation $request) {
        if (Material::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Material $id, MaterialRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Material $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
