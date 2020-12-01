<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Roles\RoleInterface;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class BaseController extends Controller
{
    public function __construct()
    {
        // if (Sentinel::check()) {
        //     return redirect('dashboard')->send();
        // }
    }

    public function index()
    {
        $bases = DB::table('tb_base')
            ->leftJoin('users', 'tb_base.user_id', '=', 'users.id')
            ->leftJoin('loan_products', 'tb_base.route_id', '=', 'loan_products.id')
            ->select('tb_base.*', 'users.first_name', 'users.last_name', 'loan_products.name as route_name')
            ->where('tb_base.created_user', Sentinel::getUser()->id)
            ->orderBy('tb_base.id', 'asc')
            ->get();
        return view('base/data', compact('bases'));
    }

    public function create()
    {        
        $routes = \App\Models\LoanProduct::all();        
        $users = \App\Models\User::where('business_id', Sentinel::getUser()->business_id)->where('id', '!=', Sentinel::getUser()->id)->get();
        return view('base/create', compact('routes', 'users'));
    }

    public function store()
    {
        $route_id = Input::get('route_id');
        $user_id = Input::get('user_id');
        $amount = Input::get('amount');

        DB::table('tb_base')->insert([
            'route_id' => $route_id,
            'user_id' => $$route_id,
            'amount' => $amount,
            'created_user' => Sentinel::getUser()->id,
            'create_at' => date('Y-m-d'),
            'status' => 1
        ]);

        return redirect('baseuser/data');
    }

    public function edit($id)
    {
        $routes = \App\Models\LoanProduct::all();        
        $users = \App\Models\User::where('business_id', Sentinel::getUser()->business_id)->where('id', '!=', Sentinel::getUser()->id)->get();
        $base = DB::table('tb_base')->where('id', $id)->first();
        return view('base/edit', compact('routes', 'users', 'base'));
    }

    public function update()
    {
        $route_id = Input::get('route_id');
        $user_id = Input::get('user_id');
        $amount = Input::get('amount');
        $id = Input::get('base_id');

        DB::table('tb_base')->where('id', $id)->update([
            'route_id' => $route_id,
            'user_id' => $$route_id,
            'amount' => $amount
        ]);
        return redirect('baseuser/data');
    }

    public function delete()
    {
        $id = Input::get('plan_id');
        DB::table('tb_base')->where('id', $id)->delete();
        return redirect('baseuser/data');
    }
}
