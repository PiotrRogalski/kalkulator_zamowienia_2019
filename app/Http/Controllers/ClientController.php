<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequestValidation;
use App\Client;

class ClientController extends Controller
{
    public function all() {
        return Client::all();
    }
}
