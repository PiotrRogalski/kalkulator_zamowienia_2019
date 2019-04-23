<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GlassModelRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\GlassModel;


class GlassModelController extends Controller
{
    public function all() {
        return GlassModel::all();
    }

    public function single(GlassModel $model, $id) {
        return $model->findOrFail($id)->with(['material','materialType'])->first();
    }

    public function store(GlassModelRequestValidation $request) {
        if (GlassModel::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(GlassModel $id, GlassModelRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(GlassModel $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
