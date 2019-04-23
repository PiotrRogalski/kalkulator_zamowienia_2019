<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GlassPaneRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\GlassPane;


class GlassPaneController extends Controller
{
    public function all() {
        return GlassPane::all();
    }

    public function single(GlassPane $model, $id) {
        return $model->findOrFail($id)->with(['glassModel','cutModel'])->first();
    }

    public function store(GlassPaneRequestValidation $request) {
        if (GlassPane::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(GlassPane $id, GlassPaneRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(GlassPane $id) {
        if ($id->delete()) {
            return response('OK - soft deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
