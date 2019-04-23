<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoleRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Hole;

class HoleController extends Controller
{
    public function all() {
        return Hole::all();
    }

    public function store(HoleRequestValidation $request) {
        if (Hole::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Hole $id, HoleRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Hole $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
