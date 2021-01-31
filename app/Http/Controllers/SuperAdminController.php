<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\Setting;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['sentinel', 'branch']);
    }

    public function getAdmins()
    {
        if (!Sentinel::hasAccess('users')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }

        $role = Sentinel::findRoleByName('Administrador');
        $users = User::with('roles')->orderBy('id')->get();
        $data = array();
        foreach($users as $user) {
            if($user->roles->first()->id == $role->id) {
                if ($user->country_id) {
                    $country_name = DB::table('countries')->where('id', $user->country_id)->first()->name;
                    $user->country_name = $country_name;
                }
                $data[] = $user;
            }
        }
        return view('super_admin.users.data', compact('data'));
    }

    public function delete($id)
    {
        if (!Sentinel::hasAccess('users.delete')) {
            Flash::warning("Acceso no permitido");
            return redirect('super_admin/admin');
        }
        if ( Sentinel::getUser()->id == $id) {
            Flash::warning("No puedes borrar tu propia cuenta");
            return redirect('super_admin/admin');
        }

        DB::table('users')->where('id', $id)->delete();

        DB::table('role_users')->where('user_id', $id)->delete();

        DB::table('activations')->where('user_id', $id)->delete();

        GeneralHelper::audit_trail("Deleted successfully.");
        Flash::success("Procesado exitosamente");
        return redirect('super_admin/admin');
    }

    public function active($id)
    {
        if (!Sentinel::hasAccess('users.update')) {
            Flash::warning("Acceso no permitido");
            return redirect('super_admin/admin');
        }
        if ( Sentinel::getUser()->id == $id) {
            Flash::warning("No puedes borrar tu propia cuenta");
            return redirect('super_admin/admin');
        }
        $user = User::where('id', $id)->first();
        $user->active_status = 1;
        $user->save();
        GeneralHelper::audit_trail("Usuario eliminado ID:" . $id);
        Flash::success("Procesado exitosamente");
        return redirect('super_admin/admin');
    }

    public function deactive($id) {
        if (!Sentinel::hasAccess('users.update')) {
            Flash::warning("Acceso no permitido");
            return redirect('super_admin/admin');
        }
        if ( Sentinel::getUser()->id == $id) {
            Flash::warning("No puedes borrar tu propia cuenta");
            return redirect('super_admin/admin');
        }
        $user = User::where('id', $id)->first();
        $user->active_status = 2;
        $user->save();
        GeneralHelper::audit_trail("Usuario eliminado ID:" . $id);
        Flash::success("Procesado exitosamente");
        return redirect('super_admin/admin');
    }

    public function addAdmin() {
        $plans = DB::table('plans')->orderBy('id')->get();
        $countries = DB::table('countries')->orderBy('id')->get();
        return view('super_admin.users.create', compact('plans', 'countries'));
    }

    public function saveAdmin() {
        $rules = array(
            'email' => 'required|unique:users',
            'phone' => 'required',
            'country_id' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required',            
            'first_name' => 'required',
            'last_name' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Flash::warning(trans('login.failure'));
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            //process validation here            
            $email = Input::get('email');
            $first_name = Input::get('first_name');
            $last_name = Input::get('last_name');
            $plan_id = Input::get('plan_id');            

            $credentials = array(
                "email" => $email,
                "password" => Input::get('password'),
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone" => Input::get('phone'),
                "country_id" => Input::get('country_id'),
                "user_name" => Input::get('user_name'),                
                "otp_status" => '2',
                "active_status" => '1',
                "otp_created" => date('Y-m-d H:i:s')
            );
            $user = Sentinel::registerAndActivate($credentials);
            $role = Sentinel::findRoleByName('Administrador');
            $role->users()->attach($user);

            $u = User::where('id', $user->id)->first();
            $business = DB::table('users')->orderBy('business_id','DESC')->first();
            $plans = DB::table('plans')->where('id', $plan_id)->first();
            $u->business_id = $business->business_id + 1;
            $u->plan_id = $plan_id;
            $u->plan_status = 1;
            $u->plan_active_date = date('Y-m-d');
            $u->plan_expired_date = date_format(date_add(date_create(date('Y-m-d')), date_interval_create_from_date_string($plans->duration.' days')), 'Y-m-d');;
            $u->save();

            DB::table('branch_users')->insert([
                'branch_id' => 1,
                'user_id' => $user->id,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            GeneralHelper::audit_trail("Usuario eliminado ID:" . $user->id);
            Flash::success("Procesado exitosamente");
            return redirect('super_admin/admin');
        }
    }



    public function plans() {
        $plans = DB::table('plans')->orderBy('id')->get();
        // foreach ($plans as $plan) {
        //     $users = DB::table('users')->where('plan_id', $plan->id)->where('plan_status', '1')->count();
        //     $plan->users = $users;
        // }
        return view('super_admin.plans.data', compact('plans'));
    }

    public function createPlan() {
        return view('super_admin.plans.create');
    }

    public function makePlan() {
        $plan_id = DB::table('plans')->insertGetId([
            "name" => Input::get('plan_name'),
            'duration' => Input::get('plan_duration'),
            'amount' => Input::get('plan_amount'),
            'delimited_user' => Input::get('limited_users'),
            'delimited_route' => Input::get('limited_routes')
        ]);
        return redirect('super_admin/plans');
    }

    public function editPlan($id) {
        $plan = DB::table('plans')->where('id', $id)->first();
        return view('super_admin.plans.edit', compact('plan'));
    }

    public function updatePlan() {        
        DB::table('plans')->where('id', Input::get('plan_id'))->update([
            "name" => Input::get('plan_name'),
            'duration' => Input::get('plan_duration'),
            'amount' => Input::get('plan_amount'),
            'delimited_user' => Input::get('limited_users'),
            'delimited_route' => Input::get('limited_routes')
        ]);
        return redirect('super_admin/plans');
    }

    public function deletePlan($id) {
        DB::table('plans')->where('id', $id)->delete();
        return redirect('super_admin/plans');
    }
}
