<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\ClientRequestValidation;
use Symfony\Component\HttpFoundation\Response;
use App\Client;

class ClientController extends Controller
{
    public function all() {
        return Client::with('placeOfDelivery')->get();
    }

    public function single(Client $client, $id) {
        return $client->findOrFail($id)->with('orders')->first();
    }

    public function store(ClientRequestValidation $request) {
        if (Client::create($request->all())) {
            return response('CREATED', Response::HTTP_CREATED);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function update(Client $id, ClientRequestValidation $request) {
        if ($id->update($request->all())) {
            return response('OK', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Client $id) {
        if ($id->delete()) {
            return response('OK - force deleted', Response::HTTP_OK);
        }
        return response('Error - bad request', Response::HTTP_BAD_REQUEST);
    }
}
