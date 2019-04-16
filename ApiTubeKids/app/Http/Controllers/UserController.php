<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $rules = [
            'name' => 'required',
            'first_last_name' => 'required',
            'second_last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'country' => 'required',
            'birthdate' => 'required',
            'phone' => 'required'
        ];
        $this->validate($request, $rules);

        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $dateUser = Carbon::parse($request->birthdate)->format('d-m-Y');
        $date = Carbon::createFromDate($dateUser)->age;

        $request['verifide'] = User::USUARIO_NO_VERIFICADO;
        $request['verification_token'] = User::generarVerificationToken();

        if($date<18){
         return response()->json(['error'=>'Tienes que ser mayor de 18 años', 'code'=>409], 409);
        }else{
         $user = User::create($request->all());
         return response()->json($user, 201); 
     }

 }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if($user){
            return response()->json($user, 200);  
        } else{
            return response()->json($user,404);
        }
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
        $user = User::find($id);

        $sku = $request->input('sku');
        $name = $request->input('name');
        $description = $request->input('description');
        $stock = $request->input('stock');
        $id_category = $request->input('id_category');
        $price = $request->input('price');


        $user->sku = $sku;
        $user->name = $name;
        $user->description = $description;
        $user->stock = $stock;
        $user->id_category = $id_category;
        $user->price = $price;


        $user->save();
        return response()->json($user, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response()->json($user, 204);  
        } else{
            return response()->json($user,404);
        }
    }
}
