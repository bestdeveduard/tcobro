<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\BorrowerImport;

use App\Models\Country;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\Setting;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Clickatell\Api\ClickatellHttp;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
// use Excel;
use Maatwebsite\Excel\Facades\Excel;

class BorrowerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['sentinel', 'branch']);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Sentinel::hasAccess('borrowers')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $data = Borrower::where('branch_id', Sentinel::getUser()->business_id)->get();

        return view('borrower.data', compact('data'));
    }

    public function pending()
    {
        if (!Sentinel::hasAccess('borrowers')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $data = Borrower::where('branch_id', Sentinel::getUser()->business_id)->where('active', 0)->get();

        return view('borrower.pending', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('borrowers.create')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $users = User::all();
        $user = array();
        foreach ($users as $key) {
            $user[$key->id] = $key->first_name . ' ' . $key->last_name;
        }
        $countries = array();
        foreach (Country::all() as $key) {
            $countries[$key->id] = $key->name;
        }
        //get custom fields
        $custom_fields = CustomField::where('category', 'borrowers')->get();
        return view('borrower.create', compact('user', 'custom_fields','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Sentinel::hasAccess('borrowers.create')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = new Borrower();
        $borrower->first_name = $request->first_name;
        $borrower->last_name = $request->last_name;
        $borrower->user_id = Sentinel::getUser()->id;
        $borrower->gender = $request->gender;
        $borrower->country_id = $request->country_id;
        $borrower->title = $request->title;
        $borrower->branch_id = Sentinel::getUser()->business_id;
        $borrower->mobile = $request->mobile;
        $borrower->geolocation = $request->geolocation;
        $borrower->notes = $request->notes;
        $borrower->email = $request->email;
        $borrower->whatsapp_enabled = $request->whatsapp_enabled;
        $borrower->phone_business = $request->phone_business;
        $borrower->referencia_1 = $request->referencia_1;
        $borrower->referencia_2 = $request->referencia_2;        
        
        if ($request->hasFile('photo')) {
            $file = array('photo' => Input::file('photo'));
            $rules = array('photo' => 'required|mimes:jpeg,jpg,bmp,png');
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                Flash::warning(trans('general.validation_error'));
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $fname = "borrower_" . uniqid() .'.'. $request->file('photo')->guessExtension();
                $borrower->photo = $fname;
                $request->file('photo')->move('uploads',
                    $fname);
            }

        }
        $borrower->unique_number = $request->unique_number;
        $borrower->dob = $request->dob;
        $borrower->address = $request->address;
        $borrower->working_time = $request->working_time;
        $borrower->ingresos = $request->ingresos;
        $borrower->company_phone = $request->company_phone;
        $borrower->phone = $request->phone;
        $borrower->business_name = $request->business_name;
        $borrower->working_status = $request->working_status;
        $borrower->loan_officers = serialize($request->loan_officers);
        $date = explode('-', date("Y-m-d"));
        $borrower->year = $date[0];
        $borrower->month = $date[1];
        $files = array();
        if (!empty($request->file('files'))) {
            $count = 0;
            foreach ($request->file('files') as $key) {
                $file = array('files' => $key);
                $rules = array('files' => 'required|mimes:jpeg,jpg,bmp,png,pdf,docx,xlsx');
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    Flash::warning(trans('general.validation_error'));
                    return redirect()->back()->withInput()->withErrors($validator);
                } else {
                    $fname = "borrower_" . uniqid() .'.'. $key->guessExtension();
                    $files[$count] = $fname;
                    $key->move('uploads',
                        $fname);
                }
                $count++;
            }
        }
        $borrower->files = serialize($files);
        $borrower->username = $request->username;
        if (!empty($request->password)) {
            $rules = array(
                'repeatpassword' => 'required|same:password',
                'username' => 'required|unique:borrowers'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                Flash::warning('Passwords do not match');
                return redirect()->back()->withInput()->withErrors($validator);

            } else {
                $borrower->password = md5($request->password);
            }
        }
        $borrower->save();
        $custom_fields = CustomField::where('category', 'borrowers')->get();
        foreach ($custom_fields as $key) {
            $custom_field = new CustomFieldMeta();
            $id = $key->id;
            $custom_field->name = $request->$id;
            $custom_field->parent_id = $borrower->id;
            $custom_field->custom_field_id = $key->id;
            $custom_field->category = "borrowers";
            $custom_field->save();
        }
        GeneralHelper::audit_trail("Cliente creado con ID:" . $borrower->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('borrower/data');
    }


    public function show($borrower)
    {
        if (!Sentinel::hasAccess('borrowers.view')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $users = User::all();
        $user = array();
        foreach ($users as $key) {
            $user[$key->id] = $key->first_name . ' ' . $key->last_name;
        }
        //get custom fields
        $custom_fields = CustomFieldMeta::where('category', 'borrowers')->where('parent_id', $borrower->id)->get();
        return view('borrower.show', compact('borrower', 'user', 'custom_fields'));
    }


    public function edit($borrower)
    {
        if (!Sentinel::hasAccess('borrowers.update')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $users = User::all();
        $user = array();
        foreach ($users as $key) {
            $user[$key->id] = $key->first_name . ' ' . $key->last_name;
        }
        $countries = array();
        foreach (Country::all() as $key) {
            $countries[$key->id] = $key->name;
        }
        //get custom fields
        $custom_fields = CustomField::where('category', 'borrowers')->get();
        return view('borrower.edit', compact('borrower', 'user', 'custom_fields','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.update')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $borrower->first_name = $request->first_name;
        $borrower->last_name = $request->last_name;
        $borrower->gender = $request->gender;
        $borrower->country_id = $request->country_id;
        $borrower->title = $request->title;
        $borrower->mobile = $request->mobile;
        $borrower->notes = $request->notes;
        $borrower->email = $request->email;
        $borrower->geolocation = $request->geolocation;
        $borrower->branch_id = Sentinel::getUser()->business_id;
        $borrower->whatsapp_enabled = $request->whatsapp_enabled;
        $borrower->phone_business = $request->phone_business;
        $borrower->referencia_1 = $request->referencia_1;
        $borrower->referencia_2 = $request->referencia_2;           
        if ($request->hasFile('photo')) {
            $file = array('photo' => Input::file('photo'));
            $rules = array('photo' => 'required|mimes:jpeg,jpg,bmp,png');
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                Flash::warning(trans('general.validation_error'));
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $fname = "borrower_" . uniqid().'.'.$request->file('photo')->guessExtension();
                $borrower->photo = $fname;
                $request->file('photo')->move('uploads',
                    $fname);
            }

        }
        $borrower->unique_number = $request->unique_number;
        $borrower->dob = $request->dob;
        $borrower->address = $request->address;
        $borrower->working_time = $request->working_time;
        $borrower->ingresos = $request->ingresos;
        $borrower->company_phone = $request->company_phone;
        $borrower->phone = $request->phone;
        $borrower->business_name = $request->business_name;
        $borrower->working_status = $request->working_status;
        $borrower->loan_officers = serialize($request->loan_officers);
        $files = unserialize($borrower->files);
        $count = count($files);
        if (!empty($request->file('files'))) {
            foreach ($request->file('files') as $key) {
                $count++;
                $file = array('files' => $key);
                $rules = array('files' => 'required|mimes:jpeg,jpg,bmp,png,pdf,docx,xlsx');
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    Flash::warning(trans('general.validation_error'));
                    return redirect()->back()->withInput()->withErrors($validator);
                } else {
                    $fname = "borrower_" . uniqid() .'.'. $key->guessExtension();
                    $files[$count] = $fname;
                    $key->move('uploads',
                        $fname);
                }

            }
        }
        $borrower->files = serialize($files);
        $borrower->username = $request->username;
        if (!empty($request->password)) {
            $rules = array(
                'repeatpassword' => 'required|same:password'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                Flash::warning('Passwords do not match');
                return redirect()->back()->withInput()->withErrors($validator);

            } else {
                $borrower->password = md5($request->password);
            }
        }
        $borrower->save();
        $custom_fields = CustomField::where('category', 'borrowers')->get();
        foreach ($custom_fields as $key) {
            if (!empty(CustomFieldMeta::where('custom_field_id', $key->id)->where('parent_id', $id)->where('category',
                'borrowers')->first())
            ) {
                $custom_field = CustomFieldMeta::where('custom_field_id', $key->id)->where('parent_id',
                    $id)->where('category', 'borrowers')->first();
            } else {
                $custom_field = new CustomFieldMeta();
            }
            $kid = $key->id;
            $custom_field->name = $request->$kid;
            $custom_field->parent_id = $id;
            $custom_field->custom_field_id = $key->id;
            $custom_field->category = "borrowers";
            $custom_field->save();
        }
        GeneralHelper::audit_trail("Cliente actualizado con ID:" . $borrower->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect('borrower/data');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (!Sentinel::hasAccess('borrowers.delete')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        Borrower::destroy($id);
        Loan::where('borrower_id', $id)->delete();
        LoanRepayment::where('borrower_id', $id)->delete();
        GeneralHelper::audit_trail("Cliente eliminado con ID:" . $id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('borrower/data');
    }

    public function deleteFile(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.delete')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $files = unserialize($borrower->files);
        @unlink('uploads/' . $files[$request->id]);
        $files = array_except($files, [$request->id]);
        $borrower->files = serialize($files);
        $borrower->save();


    }

    public function approve(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.approve')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $borrower->active = 1;
        $borrower->save();
        GeneralHelper::audit_trail("Cliente aprobado con ID:" . $borrower->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function decline(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.approve')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $borrower->active = 0;
        $borrower->save();
        GeneralHelper::audit_trail("Cliente declinado con ID:" . $borrower->id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }
    public function blacklist(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.blacklist')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $borrower->blacklisted = 1;
        $borrower->save();
        GeneralHelper::audit_trail("Cliente agregado en lista negra con ID:" . $id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function unBlacklist(Request $request, $id)
    {
        if (!Sentinel::hasAccess('borrowers.blacklist')) {
            Flash::warning("Permiso Denegado");
            return redirect('/');
        }
        $borrower = Borrower::find($id);
        $borrower->blacklisted = 0;
        $borrower->save();
        GeneralHelper::audit_trail("Reverso cliente en lista negra con ID:" . $id);
        Flash::success(trans('general.successfully_saved'));
        return redirect()->back();
    }

    public function download_report(Request $request) {
        $excel_data = [];
        array_push($excel_data, [
            "Reporte de clientes ".date('d-m-Y')
        ]);
        array_push($excel_data, [
            "ID",
            "Nombre y Apellido",
            "Genero",
            "Movil",
            "Email",
            "ID/Pasaporte",
            "Estatus",
            "Calificacion",
            "Telefono",
            "Direccion",
            "Donde labora",
            "Estatus",
            "Telefono empresa",
            "Tiempo laborando",
            "Ingresos",
            "Pais",
            "Referencia",
            "Telefono",
            "Coordenadas",
            "Fecha de creacion"
        ]);
        
        $data = Borrower::where('branch_id', Sentinel::getUser()->business_id)->get();

        foreach($data as $key) {
            if ($key->gender == "Male") {
                $gend = "Masculino";
            } else {
                $gend = "Femenino";
            }

            if ($key->active == 0) {
                $estatus = "Lista negra";
            } else if (count($key->loans) == 0) {
                $estatus = "Inactivo";
            } else if (count($key->loans) > 0) {
                $estatus = "Activo";
            } else {
                $estatus = "";
            }

            $loanStatus = Loan::where('borrower_id', $key->id)->where('status', 'written_off')->get();
            if ($key->blacklisted == 1) {
                $score = '0%';
            } else if (count($loanStatus) > 0) {
                $score = '0%';
            } else {
                $score = '100%';
            }

            $country_name = Country::where('id', $key->country_id)->first()->name;

            $date_history = $key->created_at;
            $timestamp = strtotime($date_history);
            $fecha_historica = date("d/m/Y", $timestamp);
            
            array_push($excel_data, [
                $key->id,
                $key->first_name.' '.$key->last_name,
                $gend,
                $key->mobile,
                $key->email,
                $key->unique_number,
                $estatus,
                $score,
                $key->phone,                
                $key->address,
                $key->business_name,
                trans('general.'.$key->working_status),
                $key->phone_business,
                $key->working_time,
                $key->interesos,
                $country_name,
                $key->referencia_1,
                $key->company_phone,
                $key->geolocation,
                $fecha_historica
            ]);
        }
        Excel::create('borrowers_report_'.Sentinel::getUser()->business_id,
            function ($excel) use ($excel_data) {
                $excel->sheet('Sheet', function ($sheet) use ($excel_data) {
                    $sheet->fromArray($excel_data, null, 'A1', false, false);
                    $sheet->mergeCells('A1:T1');
                    $sheet->cells('A2:T2', function ($cells) {
                        $cells->setBackground('#cddaff');
                        $cells->setAlignment('center');
                    });
                    $sheet->getRowDimension(1)->setRowHeight(25);
                    $sheet->getRowDimension(2)->setRowHeight(20);
                    // $sheet->row(2, function($row) {                    
                    //     $row->setBackground('#cddaff');                    
                    // });
                });
            })->download('xls');
    }

    public function download_excel(Request $request) {
        $excel_data = [];
        array_push($excel_data, [
            "Nombre y Apellido",
            "Movil",
            "Email",
            "ID/Pasaporte",
            "Telefono",
            "Direccion",
            "Donde labora",
            "Telefono empresa",
            "Tiempo laborando",
            "Ingresos",
            "Referencia",
            "Telefono Referencia",
            "Coordenadas"
        ]);
        
        Excel::create('borrowers_template',
            function ($excel) use ($excel_data) {
                $excel->sheet('Sheet', function ($sheet) use ($excel_data) {
                    $sheet->fromArray($excel_data, null, 'A1', false, false);
                    $sheet->cells('A1:M1', function ($cells) {
                        $cells->setBackground('#cddaff');
                        $cells->setAlignment('center');
                    });
                    $sheet->getRowDimension(1)->setRowHeight(25);
                });
            })->download('xls');

    }

    public function upload_excel(Request $request)
    {
        $insert_data = array();
        
        $path = $request->file('file');
        $fname = "borrower_" . uniqid() . '.xls';
        $path->move(public_path() . '/uploads', $fname);

        $data = Excel::load(public_path().'/uploads/'.$fname)->get();

        if($data->count() > 0) {
            foreach($data->toArray() as $key => $value)
            {
                // echo json_encode($value);
                if ($value['nombre_y_apellido'] != '' && !empty($value['nombre_y_apellido'])) {
                    $borrower = new Borrower();
                    $borrower->first_name = $value['nombre_y_apellido'];
                    $borrower->last_name = '';
                    $borrower->user_id = Sentinel::getUser()->id;
                    $borrower->gender = "Male";
                    $borrower->country_id = '61';
                    $borrower->title = 'Mr';
                    $borrower->branch_id = Sentinel::getUser()->business_id;
                    $borrower->mobile = $value['movil'];
                    $borrower->geolocation = $value['coordenadas'];
                    $borrower->notes = '';
                    $borrower->email = $value['email'];
                    $borrower->whatsapp_enabled = '0';
                    $borrower->phone_business = $value['telefono_empresa'];
                    $borrower->referencia_1 = $value['referencia'];                
                    $borrower->unique_number = $value['idpasaporte'];
                    $borrower->dob = '';
                    $borrower->address = $value['direccion'];
                    $borrower->working_time = $value['tiempo_laborando'];
                    $borrower->ingresos = $value['ingresos'];
                    $borrower->company_phone = $value['telefono_referencia'];
                    $borrower->phone = $value['telefono'];
                    $borrower->business_name = $value['donde_labora'];
                    $borrower->working_status = "Employee";
                    $borrower->loan_officers = '';
                    $date = explode('-', date("Y-m-d"));
                    $borrower->year = $date[0];
                    $borrower->month = $date[1];
                    $files = array();                
                    $borrower->files = serialize($files);
                    $borrower->username = '';
                    
                    $borrower->save();
                }
            }

            Flash::success('Procesado crrectamente');
            return redirect('borrower/data');
        } else {
            Flash::warning('Error, intentar de nuevo');
            return redirect('borrower/data');
        }
        
    }
}
