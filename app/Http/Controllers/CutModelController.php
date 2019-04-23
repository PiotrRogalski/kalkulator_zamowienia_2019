<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CutModelRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\CutModel;


class CutModelController extends Controller
{
    public function all() {
        return CutModel::all();
    }

    public function single(CutModel $model, $id) {
        return $model->findOrFail($id)->with(['material','materialType'])->first();
    }

    public function store(CutModelRequestValidation $request) {
        if (CutModel::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(CutModel $id, CutModelRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(CutModel $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
