<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();

        return view('admin.client.client_dashboard',compact('clients'));
    }
    public function viewAddClient(){
        $clients = Client::all();

        return view('admin.client.client_dashboard',compact('clients'));

    }
}
