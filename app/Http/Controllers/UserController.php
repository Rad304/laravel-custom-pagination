<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ??!!
        $columns = ['id','name','email', 'dob']; 
        $cursor = ['id']; // fields to use as a cursor

        //Get Users Where Birth Date of Birth is between '1968-02-07 13:45:00' and '1970-02-07 21:45:00' 
        $query = User::select($columns);
                    //->whereBetween('dob', ['1968-02-07 13:45:00', '1970-02-07 21:45:00']);
                    //->where('email', 'like', '%example.net%');
        
        // Fonction 
        $result = custom_paginator($query, $cursor, $cache = null, $sort = '>', $perPage = 10);
        //dd($result,json_encode($result), base64_encode(json_encode($result)));
        //$result = json_decode(json_encode($result), true);
        //dd($prev_btn_router_options, $next_btn_router_options, $route);
        // Return paginator
        //dd($result);
        return view('users')->with($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
