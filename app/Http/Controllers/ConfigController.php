<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Config;


class ConfigController extends Controller
{
    public function all() {
        return Config::all();
    }

    public function store(ConfigRequestValidation $request) {
        if (Config::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Config $id, ConfigRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
