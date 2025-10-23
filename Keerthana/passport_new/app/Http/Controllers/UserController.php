<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userRegister(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");

        $response = Http::asForm()->post(url('oauth/token'), [
            'grant_type' => 'authorization_code',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_PASSWORD'),
            'redirect_uri' => '/',
            'code' => $request->code,
            'email' => $email,
            'password' => $password,
        ]);

        info($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
