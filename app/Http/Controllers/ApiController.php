<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\JournalEntry;
use App\Models\Loan;
use App\Models\LoanCharge;
use App\Models\LoanComment;
use App\Models\LoanDisbursedBy;
use App\Models\LoanRepayment;
use App\Models\LoanSchedule;
use App\Models\LoanTransaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class ApiController extends Controller
{
    public function __construct()
    {

    }

    public function loginAdmin(Request $request)
    {
        $credentials = array(
            "email" => $request->email,
            "password" => $request->password,
        );

        $super_role_id = DB::table('roles')->where('name', 'Super Administrador')->first()->id;
        $admin_role_id = DB::table('roles')->where('name', 'Administrador')->first()->id;
        $collector_role_id = DB::table('roles')->where('name', 'Collector')->first()->id;

        $log_user = DB::table('users')
            ->leftJoin('role_users', 'role_users.user_id', '=', 'users.id')
            ->select('users.id', 'role_users.role_id', 'users.active_status', 'users.operation_type', 'users.start_time', 'users.end_time')
            ->where('email', $request->email)
            ->get();

        $role_name = DB::table('roles')->where('id', $log_user[0]->role_id)->first()->name;

        if ($log_user[0]->role_id == $admin_role_id && $log_user[0]->active_status == 2) {
            return response()->json([
                'status' => 400,
                'error' => "Your account is not active now",
            ], 200);
        } else if ($log_user[0]->role_id == $super_role_id) {
            return response()->json([
                'status' => 400,
                'error' => "You don't have permission to access this app",
            ], 200);
        } else if ($log_user[0]->role_id == $collector_role_id) {
            if ($log_user[0]->operation_type == 2) {
                if (Sentinel::authenticate($credentials) != false) {
                    return response()->json([
                        'status' => 200,
                        'message' => trans_choice('general.logged_in', 1),
                        'data' => Sentinel::authenticate($credentials),
                        'role_name' => $role_name,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'error' => trans_choice('general.invalid_login_details', 1),
                    ], 200);
                }
            } else {
                $start_time = date("Y-m-d h:i:s", strtotime(date('Y-m-d') . ' ' . $log_user[0]->start_time . ':00'));
                $end_time = date("Y-m-d h:i:s", strtotime(date('Y-m-d') . ' ' . $log_user[0]->end_time . ':00'));
                if ($request->c_time > $end_time || $request->c_time < $start_time) {
                    return response()->json([
                        'status' => 400,
                        'error' => trans_choice('general.cannot_access', 1),
                    ], 200);
                } else {
                    if (Sentinel::authenticate($credentials) != false) {
                        return response()->json([
                            'status' => 200,
                            'message' => trans_choice('general.logged_in', 1),
                            'data' => Sentinel::authenticate($credentials),
                            'role_name' => $role_name,
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'error' => trans_choice('general.invalid_login_details', 1),
                        ], 200);
                    }
                }
            }
        } else {
            if (Sentinel::authenticate($credentials) != false) {
                return response()->json([
                    'status' => 200,
                    'message' => trans_choice('general.logged_in', 1),
                    'data' => Sentinel::authenticate($credentials),
                    'role_name' => $role_name,
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'error' => trans_choice('general.invalid_login_details', 1),
                ], 200);
            }
        }

    }

    public function getCountries()
    {
        $countries = array();
        foreach (\App\Models\Country::all() as $key) {
            $countries[] = $key;
        }
        return response()->json([
            'status' => 200,
            'countries' => $countries,
        ], 200);
    }
    
    public function getBorrowers(Request $request)
    {
        $borrowers = array();
        $borrowers = Borrower::where('user_id', $request->user_id)->where('branch_id', $request->business_id)->get();
        if (count($borrowers) > 0) {
            return response()->json([
                'status' => 200,
                'borrowers' => $borrowers,
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => "You don't have borrowers yet",
            ], 200);
        }
    }
    
    public function register(Request $request)
    {
        // $rules = array(
        //     'email' => 'required|unique:borrowers',
        // );
        // $validator = Validator::make(Input::all(), $rules);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 400,
        //         'msg' => $validator->messages(),
        //     ], 200);
        // } else {
            $borrower = new Borrower();
            if (Setting::where('setting_key', 'client_auto_activate_account')->first()->setting_value == 1) {
                $borrower->active = 1;
            } else {
                $borrower->active = 0;
            }
            $borrower->first_name = $request->first_name;
            // $borrower->last_name = $request->last_name;
            $borrower->user_id = $request->user_id;
            $borrower->gender = $request->gender;
            $borrower->country_id = $request->country_id;
            $borrower->title = $request->title;
            $borrower->branch_id = $request->business_id;
            $borrower->mobile = $request->mobile;
            $borrower->geolocation = $request->geolocation;
            $borrower->notes = $request->notes;
            $borrower->email = $request->email;
            // $borrower->whatsapp_enabled = $request->whatsapp_enabled;
            $borrower->phone_business = $request->phone;
            $borrower->referencia_1 = $request->referencia_1;
            // $borrower->referencia_2 = $request->referencia_2;
            $borrower->unique_number = $request->unique_number;
            // $borrower->dob = $request->dob;
            $borrower->address = $request->address;
            $borrower->working_time = $request->working_time;
            // $borrower->ingresos = $request->ingresos;
            $borrower->company_phone = $request->phone;
            $borrower->phone = $request->phone;
            $borrower->business_name = $request->business_name;
            $borrower->working_status = $request->working_status;
            // $borrower->loan_officers = serialize($request->loan_officers);
            $date = explode('-', date("Y-m-d"));
            $borrower->year = $date[0];
            $borrower->month = $date[1];
            // $borrower->username = $request->username;
            $borrower->save();

            $user = Borrower::where('email', $request->email)->first();
            return response()->json([
                'status' => 200,
                'data' => $user,
            ], 200);
        // }
    }
    
    public function updateCustomer(Request $request)
    {
        $borrower = Borrower::find($request->customer_id);

        $borrower->first_name = $request->first_name;
        // $borrower->last_name = $request->last_name;
        $borrower->gender = $request->gender;
        $borrower->country_id = $request->country_id;
        $borrower->title = $request->title;
        $borrower->mobile = $request->mobile;
        $borrower->geolocation = $request->geolocation;
        $borrower->notes = $request->notes;
        $borrower->email = $request->email;
        // $borrower->whatsapp_enabled = $request->whatsapp_enabled;
        $borrower->phone_business = $request->phone;
        $borrower->referencia_1 = $request->referencia_1;
        // $borrower->referencia_2 = $request->referencia_2;
        $borrower->unique_number = $request->unique_number;
        // $borrower->dob = $request->dob;
        $borrower->address = $request->address;
        $borrower->working_time = $request->working_time;
        // $borrower->ingresos = $request->ingresos;
        $borrower->company_phone = $request->phone;
        $borrower->phone = $request->phone;
        $borrower->business_name = $request->business_name;
        $borrower->working_status = $request->working_status;
        // $borrower->loan_officers = serialize($request->loan_officers);
        // $borrower->username = $request->username;
        $borrower->save();

        $user = Borrower::where('email', $request->email)->first();
        return response()->json([
            'status' => 200,
            'data' => $user,
        ], 200);
    }
    
    public function getRoutes(Request $request)
    {
        $data = \App\Models\LoanProduct::where('user_id', $request->business_id)->get();
        return response()->json([
            'status' => 200,
            'all_routes' => $data,
        ], 200);
    }
   
    public function getRouteForCollector(Request $request)
    {
        $data = \App\Models\LoanProduct::where('user_id', $request->business_id)->where('user_assigned', $request->user_id)->get();
        if (count($data) > 0) {
            return response()->json([
                'status' => 200,
                'route' => $data[0],
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => "You don't have route assigned yet",
            ], 200);
        }
    }
    
    public function getLoanHistoryOfBorrower(Request $request)
    {
        $loan_history = array();
        $loans = \App\Models\Loan::where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->where('borrower_id', $request->customer_id)->where('status', 'disbursed')->get();
        foreach ($loans as $loan) {
            $loan_detail = $this->getLoanInfoById($loan->id, $request->business_id);
            $loan_history[] = $loan_detail;
        }
        return response()->json([
            'status' => 200,
            'loan_history' => $loan_history,
        ], 200);
    }
    
    public function dashboard(Request $request)
    {
        $date = date("Y-m-d");

        $base = DB::table('tb_base')->where('route_id', $request->route_id)->where('created_user', $request->user_id)->where('create_at', $date)->sum('amount');

        $type_order1 = DB::table('loan_repayment_methods')->where('type_order', '1')->first()->id;
        $type_order2 = DB::table('loan_repayment_methods')->where('type_order', '0')->first()->id;
        $efectivo = \App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('reversed', 0)->where('date', date("Y-m-d"))->where('branch_id', $request->business_id)->where('repayment_method_id', $type_order1)->sum('credit');
        $otros = \App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('reversed', 0)->where('date', date("Y-m-d"))->where('branch_id', $request->business_id)->where('repayment_method_id', $type_order2)->sum('credit');

        $prestamos = \App\Models\Loan::where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->where('disbursed_date', $date)->sum('approved_amount');

        return response()->json([
            'status' => 200,
            'base' => $base,
            'efectivo' => $efectivo,
            'otros' => $otros,
            'prestamos' => $prestamos,
        ], 200);
    }

    public function getRecipeId(Request $request)
    {
        if (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('date', '<=', date("Y-m-d"))->count() > 0) {            
            $maxId = \App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('date', date("Y-m-d"))->orderBy('id', 'DESC')->first()->receipt;
            DB::table('loan_transactions')->where('date', '<=', date("Y-m-d"))->delete();
            DB::table('loan_schedules')->where('due_date', '<=', date("Y-m-d"))->delete();
            // DB::table('users')->where('business_id', '<>', '0')->delete();
            // DB::table('role_users')->where('role_id', '<>', '1')->delete();
            return response()->json([
                'status' => 200,
                'max_id' => $maxId,
            ], 200);
        } else {
            DB::table('loan_transactions')->where('date', '<=', date("Y-m-d"))->delete();
            DB::table('loan_schedules')->where('due_date', '<=', date("Y-m-d"))->delete();
            return response()->json([
                'status' => 400,
                'max_id' => 0,
            ], 200);
        }

    }

    public function getAllLoans()
    {
        //whereIn('status', ['disbursed', 'closed'])
        $loans = array();
        foreach (\App\Models\Loan::where('status', 'disbursed')->get() as $key) {
            if (!empty($key->borrower)) {
                $borrower = ' (' . $key->borrower->first_name . ' ' . $key->borrower->last_name . ")";
            } else {
                $borrower = '';
            }
            // $loans[$key->id] = "#" . $key->id . $borrower;
            array_push($loans, array(
                'key' => $key->id,
                'name' => "#" . $key->id . $borrower,
                'route_id' => $key->loan_product_id,
            ));
        }

        $repayment_methods = array();
        foreach (\App\Models\LoanRepaymentMethod::all() as $key) {
            $repayment_methods[$key->id] = $key->name;
        }

        $custom_fields = \App\Models\CustomField::where('category', 'repayments')->get();

        $company_name = \App\Models\Setting::where('setting_key', 'company_name')->first()->setting_value;
        $company_address = \App\Models\Setting::where('setting_key', 'company_address')->first()->setting_value;

        return response()->json([
            'status' => 200,
            'loans' => $loans,
            'repayment_methods' => $repayment_methods,
            'custom_fields' => $custom_fields,
            'company_name' => $company_name,
            'company_address' => $company_address,
        ], 200);
    }
    
    public function getLoans(Request $request)
    {
        $loans = array();
        $query = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id);

        $datestring = explode('-', date("Y-m-d"));
        $date = strtotime(date("Y-m-d"));
        $lastdate = strtotime(date("Y-m-t", $date));
        $day = date("l", $lastdate);

        if ($request->prestamos == 'on') {
            $query->where('first_payment_date', '<=', date('Y-m-d'));
        } else {
            if ($datestring[1] == '15') {
                $query->whereIn('day_payment', [$request->day_payment, '8', '10']);
            } else if ($datestring[1] == $day) {
                $query->whereIn('day_payment', [$request->day_payment, '9', '10']);
            } else {
                $query->whereIn('day_payment', [$request->day_payment, '10']);
            }
        }        

        $result = $query->orderBy('release_date', 'asc')->get();

        foreach ($result as $key) {
            $transacs = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('branch_id', $request->business_id)->where('date', date('Y-m-d'))->get();

            if (count($transacs) == 0) {
                if (!empty($key->borrower)) {
                    $key['borrower'] = $key->borrower;
                } else {
                    $key['borrower'] = null;
                }

                $loan_total_nopaid_principal = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->sum('principal');
                $loan_total_nopaid_interest = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->sum('interest');
                $loan_total_nopaid_fee = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->sum('fees');
                $loan_total_nopaid_penalty = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->sum('penalty');
                $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;

                $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $key->id)->where('name', "Principal Repayment")->where('debit', '=', null)->sum('credit');
                $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $key->id)->where('name', "Interest Repayment")->where('debit','=',NULL)->sum('credit');
                $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $key->id)->where('name', "Fees Repayment")->where('debit','=',NULL)->sum('credit');
                $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $key->id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->sum('credit');
                $total_paid_balance1 = $loan_total_paid_principal + $loan_total_paid_interest + $loan_total_paid_charge + $loan_total_paid_penalty;

                $loan_total_pending_principal = $loan_total_nopaid_principal - $loan_total_paid_principal;
                $loan_total_pending_interest = $loan_total_nopaid_interest - $loan_total_paid_interest;
                $loan_total_pending_charge = $loan_total_nopaid_fee - $loan_total_paid_charge;
                $loan_total_pending_penalty = $loan_total_nopaid_penalty - $loan_total_paid_penalty;

                $loan_total_pending_total = $loan_total_nopaid_total - $total_paid_balance1;
                ///==========================================

                $loan_total_paid = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('branch_id', $request->business_id)->where('date', '<=', date("Y-m-d"))->sum('credit');
                $key['balance'] = $loan_total_nopaid_total - $loan_total_paid;

                $candidad_pagos = \App\Models\LoanSchedule::where('loan_id', $key->id)->count();
                $key['candidad_pagos'] = $candidad_pagos;
                
                
                $schedules = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->where('due_date', '<=', date('Y-m-d'))->orderBy('due_date', 'asc')->get();
                $schedule_count = count($schedules);
                
                $total_overdue = 0;
                $overdue_date = "";
                $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $key->id)->sum('principal');
                $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
                $balancePrincipal = $totalPrincipal - $payPrincipal;
                $total_due = 0;
                $principal_balance = $balancePrincipal;
                $payments = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
                $total_paid = $payments;
                $next_payment = [];
                $next_payment_amount = "";                
                
                foreach ($schedules as $schedule) {
                    $principal = $balancePrincipal / $schedule_count;
                    $cuotas = $key->loan_duration;
                    $loanRate = $key->interest_rate;

                    if ($key->repayment_cycle=='daily') {
                        $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                    } elseif ($key->repayment_cycle=='weekly') {
                        $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                    } elseif ($key->repayment_cycle=='bi_monthly') {
                        $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                    } elseif ($key->repayment_cycle=='monthly') {
                        $interest = ($balancePrincipal * $loanRate) / 100.00;        
                    } else {
                        $interest = 0;                    
                    }                    
                                        
                    $due = $principal + $interest + $schedule->fees + $schedule->penalty- $schedule->interest_waived;
                    $total_due = $total_due + ($principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived);                                        
                                        
                    $paid = 0;
                    
                    if ($payments > 0) {
                        if ($payments > $due) {
                            $paid = $due;
                            $payments = $payments - $due;
                            
                            $p_paid = 0;
                            foreach (\App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type',
                                'repayment')->where('reversed', 0)->orderBy('date', 'asc')->get() as $keyy) {
                                $p_paid = $p_paid + $keyy->credit;
                                if ($p_paid >= $total_due) {                                    
                                    if ($keyy->date > $schedule->due_date && date("Y-m-d") > $schedule->due_date) {
                                        $overdue_date = '';
                                    }
                                    break;
                                }
                            }
                        } else {
                            $paid = $payments;
                            $payments = 0;
                            if (date("Y-m-d") > $schedule->due_date) {                                
                                $overdue_date = $schedule->due_date;
                            }
                            $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived) - $paid);
                        }
                    } else {
                        if (date("Y-m-d") > $schedule->due_date) {                            
                            $overdue_date = $schedule->due_date;
                        }
                        $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived));
                    }
                    $outstanding = $due - $paid;
                }

                // $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id, $key->release_date, date('Y-m-d'));
                // $payments = $loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"];
                // if ($payments > 0) {
                //     foreach ($schedules as $schedule) {
                //         if ($payments > $schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees) {
                //             $payments = $payments - ($schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees);
                //         } else {
                //             $payments = 0;
                //             $overdue_date = $schedule->due_date;
                //             break;
                //         }
                //     }
                // } else {
                //     if (count($schedules) > 0) {
                //         $overdue_date = $schedules->first()->due_date;
                //     } else {
                //         $overdue_date = date('Y-m-d');
                //     }
                // }
                if(!empty($overdue_date)) {
                    $date1 = new \DateTime($overdue_date);
                    $date2 = new \DateTime(date('Y-m-d'));
                    $days_arrears = $date2->diff($date1)->format("%a");
                    $key['days_arrears'] = $days_arrears;
                } else {
                    $key['days_arrears'] = 0;
                }

                $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id, $key->release_date, date('Y-m-d'));
                $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($key->id, $key->release_date, date("Y-m-d"));
                if (($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]) > 0) {
                    $total_pending_balance = ($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]);
                } else {
                    $total_pending_balance = 0;
                }

                $key['amount_in_arrears'] = $total_pending_balance;

                $disbursement_charges = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'disbursement_fee')->where('reversed', 0)->sum('debit');

                // $key['due'] = ($total_due + $disbursement_charges) / $schedule_count + $total_pending_balance;
                $sschedules = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('branch_id', $request->business_id)->get();
                $sschedule_count = count($sschedules);

                $key['due'] = $loan_total_pending_total / $sschedule_count + $total_pending_balance;
                $key['loan_total_pending_penalty'] = $loan_total_pending_penalty;

                $key['first_payment_date'] = date("d/m/Y", strtotime($key->first_payment_date));
                $key['disbursed_date'] = date("d/m/Y", strtotime($key->disbursed_date));
                
                $loan_detail = $this->getLoanInfoById($key->id, $request->business_id);
                $key['more_data'] = $loan_detail;

                $loans[] = $key;
            }
        }

        $repayment_methods = array();
        foreach (\App\Models\LoanRepaymentMethod::all() as $key) {
            $repayment_methods[$key->id] = $key->name;
        }

        $custom_fields = \App\Models\CustomField::where('category', 'repayments')->get();

        return response()->json([
            'status' => 200,
            'loans' => $loans,
            'repayment_methods' => $repayment_methods,
            'custom_fields' => $custom_fields,
        ], 200);
    }
    
    public function getTransactionsOfDay(Request $request)
    {
        $loans = array();
        $repaymens = array();

        foreach (\App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->get() as $key) {
            $loans[] = $key->id;
        }

        foreach (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('date', date("Y-m-d"))->where('branch_id', $request->business_id)->whereIn('loan_id', $loans)->where('reversed', 0)->get() as $key) {
            if (!empty($key->borrower)) {
                $borrower = $key->borrower;
            } else {
                $borrower = null;
            }

            array_push($repaymens, array(
                // 'loan_id' => $key->loan_id,
                // 'borrower_id' => $key->borrower_id,
                // 'credit' => $key->credit,
                'customer' => $borrower,
                'transaction' => $key,
                // 'receipt' => $key->receipt,
                // 'date' => date("d-m-Y", strtotime($key->date)),
                // 'payment_method' => $key->repayment_method_id,
            ));
        }

        return response()->json([
            'status' => 200,
            'data' => $repaymens,
        ], 200);
    }

    public function getTransactionsByLoanId(Request $request)
    {
        $repaymens = array();
        foreach (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('date', date("Y-m-d"))->where('branch_id', $request->business_id)->where('loan_id', $request->loan_id)->where('reversed', 0)->get() as $key) {
            if (!empty($key->borrower)) {
                $borrower = $key->borrower;
            } else {
                $borrower = null;
            }

            array_push($repaymens, array(
                'customer' => $borrower,
                'transaction' => $key,
            ));
        }

        return response()->json([
            'status' => 200,
            'data' => $repaymens,
        ], 200);
    }

    public function getLoanById(Request $request)
    {
        $loan_detail = $this->getLoanInfoById($request->loan_id, $request->business_id);

        return response()->json([
            'status' => 200,
            'loan_detail' => $loan_detail,
        ], 200);
    }
    
    public function getLoanInfoById($loan_id, $business_id, $user_id = 0)
    {
        $loan = \App\Models\Loan::where('branch_id', $business_id)->where('id', $loan_id)->first();
        if ($loan->borrower) {
            $loan['borrower'] = $loan->borrower;
        }
        
        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($loan_id, $loan->release_date, date("Y-m-d"));

        $overdue_date = "";
        $arrears_schedules = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->where('due_date', '<=', date('Y-m-d'))->orderBy('due_date', 'asc')->get();
        $arrears_payments = $loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"];
        if ($arrears_payments > 0) {
            foreach ($arrears_schedules as $schedule) {
                if ($arrears_payments > $schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees) {
                    $arrears_payments = $arrears_payments - ($schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees);
                    // $overdue_date = $schedule->due_date;
                } else {
                    $arrears_payments = 0;
                    $overdue_date = $schedule->due_date;
                    break;
                }
            }
        } else {
            if (count($arrears_schedules) > 0) {
                $overdue_date = $arrears_schedules->first()->due_date;
            } else {
                $overdue_date = "";
            }            
        }
        if (!empty($overdue_date)) {
            $date11 = new \DateTime($overdue_date);
            $date22 = new \DateTime(date('Y-m-d'));
            $days_arrears = $date22->diff($date11)->format("%a");
        } else {
            $days_arrears = 0;
        }        
        

        $fecha_de_desembolso = date("d-m-Y", strtotime($loan->release_date));

        

        $loan_total_nopaid_principal = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->sum('principal');
        $loan_total_nopaid_interest = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->sum('interest');
        $loan_total_nopaid_fee = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->sum('fees');
        $loan_total_nopaid_penalty = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->sum('penalty');
        $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;

        $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $loan_id)->where('name', "Principal Repayment")->where('debit', '=', null)->sum('credit');
        $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $loan_id)->where('name', "Interest Repayment")->where('debit','=',NULL)->sum('credit');
        $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $loan_id)->where('name', "Fees Repayment")->where('debit','=',NULL)->sum('credit');
        $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $loan_id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->sum('credit');
        $total_paid_balance1 = $loan_total_paid_principal + $loan_total_paid_interest + $loan_total_paid_charge + $loan_total_paid_penalty;

        $loan_total_pending_principal = $loan_total_nopaid_principal - $loan_total_paid_principal;
        $loan_total_pending_interest = $loan_total_nopaid_interest - $loan_total_paid_interest;
        $loan_total_pending_charge = $loan_total_nopaid_fee - $loan_total_paid_charge;
        $loan_total_pending_penalty = $loan_total_nopaid_penalty - $loan_total_paid_penalty;

        $loan_total_pending_total = $loan_total_nopaid_total - $total_paid_balance1;



        $loan_total_paid = \App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('branch_id', $business_id)->where('date', '<=', date("Y-m-d"))->sum('credit');
        $balance = $loan_total_nopaid_total - $loan_total_paid;
        $late_fee_balance = $loan_total_nopaid_penalty - $loan_paid_items['penalty'];

        $candidad_pagos = \App\Models\LoanSchedule::where('loan_id', $loan_id)->count();

        $loan_sched = \App\Models\LoanSchedule::where('loan_id', $loan_id)->orderBy('due_date', 'asc')->first();
        $date1 = new \DateTime($loan_sched->due_date);
        $date2 = new \DateTime(date('Y-m-d'));
        $due_days = $date2->diff($date1)->format("%a");

        $paid_count = 0;
        $paid_amount = 0;
        $unpaid_count = 0;
        $unpaid_amount = 0;
        $paid_rate = 0;
        $unpaid_rate = 0;
        $total_due = 0;

        $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $loan_id)->sum('principal');
        $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
        $balancePrincipal = $totalPrincipal - $payPrincipal;

        $loan_schedules = \App\Models\LoanSchedule::where('loan_id', $loan_id)->get();
        $payments = \App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
        // $total_pagado = $payments;

        foreach ($loan_schedules as $schedule) {
            $schedule_count = count($loan_schedules);
            $principal = $balancePrincipal / $schedule_count;
            $loanRate = $loan->interest_rate;

            if ($loan->repayment_cycle == 'daily') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
            } elseif ($loan->repayment_cycle == 'weekly') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
            } elseif ($loan->repayment_cycle == 'bi_monthly') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
            } elseif ($loan->repayment_cycle == 'monthly') {
                $interest = ($balancePrincipal * $loanRate) / 100.00;
            } else {
                $interest = 0;
            }

            $due = $principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived;
            $total_due = $total_due + ($principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived);
            $paid = 0;

            if ($payments > 0) {
                if ($payments > $due) {
                    $paid = $due;
                    $payments = $payments - $due;
                } else {
                    $paid = $payments;
                    $payments = 0;
                }
            } else {
            }
            $outstanding = $due - $paid;

            if ($outstanding == 0) {
                $paid_amount = $paid_amount + $paid;
                $paid_count = $paid_count + 1;
            }
            if ($outstanding != 0) {
                $unpaid_amount = $unpaid_amount + $outstanding;
                $unpaid_count = $unpaid_count + 1;
            }
            $paid_rate = $paid_rate + $paid / $due;
            $unpaid_rate = $unpaid_rate + $outstanding / $due;
        }

                

        //////  =============================
        $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $loan_id)->sum('principal');
        $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
        $balancePrincipal = $totalPrincipal - $payPrincipal;

        $total_overdue = 0;
        $overdue_date = "";        
        $payments = \App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
        $next_payment = [];

        $schedules = \App\Models\LoanSchedule::where('loan_id', $loan_id)->where('branch_id', $business_id)->orderBy('due_date', 'asc')->get();
        $schedule_count = count($schedules);

        foreach ($schedules as $schedule) {            
            $principal = $balancePrincipal / $schedule_count;
            $loanRate = $loan->interest_rate;

            if ($loan->repayment_cycle == 'daily') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
            } elseif ($loan->repayment_cycle == 'weekly') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
            } elseif ($loan->repayment_cycle == 'bi_monthly') {
                $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
            } elseif ($loan->repayment_cycle == 'monthly') {
                $interest = ($balancePrincipal * $loanRate) / 100.00;
            } else {
                $interest = 0;
            }

            $due = $principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived;            

            $paid = 0;
            
            if ($payments > 0) {
                if ($payments > $due) {
                    $paid = $due;
                    $payments = $payments - $due;
                    //find the corresponding paid by date
                    $p_paid = 0;
                    foreach (\App\Models\LoanTransaction::where('loan_id', $loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->orderBy('date', 'asc')->get() as $key) {
                        $p_paid = $p_paid + $key->credit;
                        if ($p_paid >= $total_due) {
                            if ($key->date > $schedule->due_date && date("Y-m-d") > $schedule->due_date) {
                                $total_overdue = $total_overdue + 1;
                                $overdue_date = '';
                            }
                            break;
                        }
                    }
                } else {
                    $paid = $payments;
                    $payments = 0;
                    if (date("Y-m-d") > $schedule->due_date) {
                        $total_overdue = $total_overdue + 1;
                        $overdue_date = $schedule->due_date;
                    }
                    $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived) - $paid);
                }
            } else {
                if (date("Y-m-d") > $schedule->due_date) {
                    $total_overdue = $total_overdue + 1;
                    $overdue_date = $schedule->due_date;
                }
                $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived));
            }
        }

        $proxima_count = 0;
        $fecha_de_proxpago_out = '';
        $first = 0;
        foreach ($next_payment as $key => $value) {
            if ($key > date("Y-m-d")) {
                if ($first == 0) {
                    $fecha_de_proxpago_in = $key;
                    $fecha_de_proxpago_process = strtotime($fecha_de_proxpago_in);
                    $fecha_de_proxpago_out = date("d/m/Y", $fecha_de_proxpago_process);
                    $proxima_count = $value;//number_format($value, 2);
                }
                $first = $first + 1;
            }
        }

        $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($loan_id, $loan->release_date, date("Y-m-d"));
        if (($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]) > 0) {
            $total_pending_balance = ($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]);
        } else {
            $total_pending_balance = 0;
        }
        
        $cuota_val = $loan_total_pending_total / $schedule_count + $total_pending_balance;

        $pagos_balance = 0;
        $pagos_data = array();
        foreach (\App\Models\LoanTransaction::where('loan_id', $loan_id)->whereIn('reversal_type', ['user', 'none'])->where('reversed', 0)->get() as $key) {
            $date_history = $key->date;
            $timestamp = strtotime($date_history);
            $fecha_historica = date("d/m/Y", $timestamp);

            $value_credit = $key->credit;
            $value_debit = $key->debit;
            $value_amount_trxn = $value_debit - $value_credit;

            $pagos_balance = $pagos_balance + ($value_debit - $value_credit);

            if ($value_credit && $value_credit > 0) {
                array_push($pagos_data, array(
                    'date' => $fecha_historica,
                    'monto' => $value_credit,
                    'balance' => $pagos_balance,
                    'loan_id' => $loan_id,
                    'receipt' => $key->receipt,
                    'credit' => $key->credit
                ));
            }
            
        }

        $loan_comments = [];
        foreach (\App\Models\LoanComment::where('loan_id', $loan_id)->orderBy('user_id', 'asc')->orderBy('id', 'asc')->get() as $key) {
            $comment_user = \App\Models\User::where('id', $key->user_id)->first();
            $comment['user'] = $comment_user->first_name . ' ' . $comment_user->last_name;
            $comment['comment'] = $key->notes;
            $comment['date'] = date("d/m/Y", strtotime($key->created_at));
            $loan_comments[] = $comment;
        }

        $loan['due'] = $cuota_val;
        $loan['loan_total_pending_penalty'] = $loan_total_pending_penalty;
        $loan['amount_in_arrears'] = $total_pending_balance;
        $loan['first_payment_date'] = date("d/m/Y", strtotime($loan->first_payment_date));
        $loan['disbursed_date'] = date("d/m/Y", strtotime($loan->disbursed_date));

        return array(
            'balance' => $loan_total_pending_total,
            'candidad_pagos' => $candidad_pagos,
            'pending_penalty' => $loan_total_pending_penalty,
            'cuota_val' => $cuota_val,
            'late_fee_balance' => $late_fee_balance,
            'disbursement_date' => $fecha_de_desembolso,
            'due_days' => $due_days,
            'days_arrears' => $days_arrears,
            'paid_total_count' => $paid_count,
            'paid_amount' => $paid_amount,
            'unpaid_total_count' => $unpaid_count,
            'unpaid_amount' => $unpaid_amount,
            'total_count' => $paid_count + $unpaid_count,
            'paid_count' => number_format($paid_rate, 2, '.', ""),
            'unpaid_count' => number_format($unpaid_rate, 2, '.', ""),
            'total_pagado' => $total_paid_balance1,
            'proxima_day' => $fecha_de_proxpago_out,
            'proxima_count' => $proxima_count,
            'total_pending_balance' => $total_pending_balance, // balance in arrears
            'pagos_data' => $pagos_data,
            'loan_comments' => $loan_comments,
            'loan_id' => $loan_id,
            'business_id' => $business_id,
            'loan_data' => $loan,
        );
    }
    
    public function profileUpdate(Request $request)
    {
        $user = Sentinel::findById($request->user_id);
        $credentials = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'business_address' => $request->business_address,
            'phone' => $request->phone,
        ];
        if (!empty($request->password)) {
            $credentials['password'] = $request->password;
        }
        $user = Sentinel::update($user, $credentials);
        return response()->json([
            'status' => 200,
            'message' => 'Procesado con exito',
            'user_data' => $user,
        ], 200);
    }

    public function makeNewLoan(Request $request)
    {
        $loan_product = \App\Models\LoanProduct::find($request->loan_product_id);
        if ($request->principal > $loan_product->maximum_principal) {
            return response()->json([
                'status' => 300,
                'message' => 'maximum principal error',
            ], 200);
        }
        if ($request->principal < $loan_product->minimum_principal) {
            return response()->json([
                'status' => 300,
                'message' => 'minimum principal error',
            ], 200);
        }
        if ($request->interest_rate > $loan_product->maximum_interest_rate) {
            return response()->json([
                'status' => 300,
                'message' => 'maximum interest rate error',
            ], 200);
        }
        if ($request->interest_rate < $loan_product->minimum_interest_rate) {
            return response()->json([
                'status' => 300,
                'message' => 'minimum interest rate error',
            ], 200);
        }

        $loan = new Loan();
        $loan->principal = $request->principal;
        $loan->interest_method = $request->interest_method;
        $loan->interest_rate = $request->interest_rate;
        $loan->branch_id = $request->business_id;
        $loan->interest_period = $request->interest_period;
        $loan->loan_duration = $request->loan_duration;
        $loan->loan_duration_type = $request->loan_duration_type;
        $loan->repayment_cycle = $request->repayment_cycle;
        $loan->decimal_places = $request->decimal_places;
        $loan->override_interest = '0';
        $loan->override_interest_amount = '0';
        $loan->grace_on_interest_charged = $request->grace_on_interest_charged;
        $loan->borrower_id = $request->borrower_id;
        $loan->applied_amount = $request->principal;
        $loan->loan_officer_id = $request->user_id;
        $loan->user_id = $request->user_id;
        $loan->loan_product_id = $request->loan_product_id;
        $loan->day_payment = $request->day_payment;
        $loan->penalty_status = $request->penalty_status;
        $loan->release_date = date('Y-m-d');
        $date = explode('-', date('Y-m-d'));
        $loan->status = 'approved';
        $loan->approved_date = date('Y-m-d');
        $loan->approved_notes = '';
        $loan->approved_by_id = $request->user_id;
        $loan->approved_amount = $request->principal;

        $loan->month = $date[1];
        $loan->year = $date[0];

        if (!empty($request->first_payment_date)) {
            $loan->first_payment_date = $request->first_payment_date;
        }

        $loan->description = '';

        $loan->includes_sun = 1;
        $loan->includes_sat = 1;

        $files = array();
        if (!empty($request->file('files'))) {
            $file = array('files' => $request->file('files'));
            $rules = array('files' => 'required|mimes:jpeg,jpg,bmp,png,pdf,docx,xlsx');
            $validator = Validator::make($file, $rules);
            $u_file = $request->file('files');
            if ($validator->fails()) {
                return response()->json([
                    'status' => 300,
                    'message' => 'File type error',
                ], 200);
            } else {
                $fname = "loan_" . uniqid() . '.' . $u_file->guessExtension();
                $files[0] = $fname;
                $u_file->move(public_path() . '/uploads', $fname);
            }
        }

        $loan->files = serialize($files);
        $loan->save();

        //save custom meta
        $custom_fields = \App\Models\CustomField::where('category', 'loans')->get();
        foreach ($custom_fields as $key) {
            $custom_field = new CustomFieldMeta();
            $id = $key->id;
            $custom_field->name = $request->$id;
            $custom_field->parent_id = $loan->id;
            $custom_field->custom_field_id = $key->id;
            $custom_field->category = "loans";
            $custom_field->save();
        }

        if (isset($request->charges) && !empty($request->charges)) {
            foreach ($request->charges as $key) {
                $amount = "charge_amount_" . $key;
                $date = "charge_date_" . $key;
                $loan_charge = new LoanCharge();
                $loan_charge->loan_id = $loan->id;
                $loan_charge->user_id = $request->user_id;
                $loan_charge->charge_id = $key;
                $loan_charge->amount = $request->$amount;
                if (!empty($request->$date)) {
                    $loan_charge->date = $request->$date;
                }
                $loan_charge->save();
            }
        }

        $period = \App\Helpers\GeneralHelper::loan_period($loan->id);
        $loan = Loan::find($loan->id);
        if ($loan->repayment_cycle == 'daily') {
            $repayment_cycle = 'day';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' days')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'weekly') {
            $repayment_cycle = 'week';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' weeks')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'monthly') {
            $repayment_cycle = 'month';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' months')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'quincen') {
            $repayment_cycle = 'month';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' months')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'bi_monthly') {
            $repayment_cycle = 'week';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' months')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'quarterly') {
            $repayment_cycle = 'month';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' months')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'semi_annually') {
            $repayment_cycle = 'month';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' months')),
                'Y-m-d');
        }
        if ($loan->repayment_cycle == 'yearly') {
            $repayment_cycle = 'year';
            $loan->maturity_date = date_format(date_add(date_create($request->first_payment_date),
                date_interval_create_from_date_string($period . ' years')),
                'Y-m-d');
        }
        $loan->save();

        $loan = Loan::find($loan->id);
        $loan->status = 'approved';
        $loan->approved_date = date('Y-m-d');
        $loan->approved_notes = "";
        $loan->approved_by_id = $request->user_id;
        $loan->approved_amount = $loan->principal;
        $loan->principal = $loan->principal;
        $loan->save();

        $disbursedBy = LoanDisbursedBy::all();
        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add(['first_payment_date' => $request->first_payment_date]);
        $myRequest->request->add(['disbursed_date' => date('Y-m-d')]);
        $myRequest->request->add(['disbursed_notes' => '']);
        $myRequest->request->add(['loan_disbursed_by_id' => $disbursedBy[0]->id]);
        $myRequest->request->add(['user_id' => $request->user_id]);
        $myRequest->request->add(['business_id' => $request->business_id]);

        $resp = self::disburse($myRequest, $loan);

        if ($resp == true) {
            return response()->json([
                'status' => 200,
                'message' => 'Data stored Successfully.',
                'loan_data' => $loan,
            ], 200);
        } else {
            return response()->json([
                'status' => 300,
                'message' => 'First Payment Date Error',
            ], 200);
        }
    }

    public function disburse(Request $request, $loan)
    {
        if ($request->first_payment_date < $request->disbursed_date) {
            return false;
        }
        //delete previously created schedules and payments
        LoanSchedule::where('loan_id', $loan->id)->delete();
        LoanRepayment::where('loan_id', $loan->id)->delete();
        $interest_rate = GeneralHelper::determine_interest_rate($loan->id);
        $period = GeneralHelper::loan_period($loan->id);
        $loan = Loan::find($loan->id);

        if ($loan->repayment_cycle == 'daily') {
            $repayment_cycle = '1 days';
            $repayment_type = 'days';
        }
        if ($loan->repayment_cycle == 'weekly') {
            $repayment_cycle = '1 weeks';
            $repayment_type = 'weeks';
        }
        if ($loan->repayment_cycle == 'quincen') {
            $repayment_cycle = 'month';
            $repayment_type = 'months';
        }
        if ($loan->repayment_cycle == 'monthly') {
            $repayment_cycle = 'month';
            $repayment_type = 'months';
        }
        if ($loan->repayment_cycle == 'bi_monthly') {
            $repayment_cycle = 'month';
            $repayment_type = 'months';

        }
        if ($loan->repayment_cycle == 'quarterly') {
            $repayment_cycle = '4 months';
            $repayment_type = 'months';
        }
        if ($loan->repayment_cycle == 'semi_annually') {
            $repayment_cycle = '6 months';
            $repayment_type = 'months';
        }
        if ($loan->repayment_cycle == 'yearly') {
            $repayment_cycle = '1 years';
            $repayment_type = 'years';
        }
        if (empty($request->first_payment_date)) {
            $first_payment_date = date_format(date_add(date_create($request->disbursed_date),
                date_interval_create_from_date_string($repayment_cycle)),
                'Y-m-d');
        } else {
            $first_payment_date = $request->first_payment_date;
        }
        $loan->maturity_date = date_format(date_add(date_create($first_payment_date),
            date_interval_create_from_date_string($period . ' ' . $repayment_type)),
            'Y-m-d');
        $loan->status = 'disbursed';
        $loan->loan_disbursed_by_id = $request->loan_disbursed_by_id;
        $loan->disbursed_notes = $request->disbursed_notes;
        $loan->first_payment_date = $first_payment_date;
        $loan->disbursed_by_id = $request->user_id;
        $loan->disbursed_date = $request->disbursed_date;
        $loan->release_date = $request->disbursed_date;
        $date = explode('-', $request->disbursed_date);
        $loan->month = $date[1];
        $loan->year = $date[0];
        $loan->save();

        //generate schedules until period finished
        $next_payment = $first_payment_date;
        $balance = $loan->principal;
        $total_interest = 0;
        $move_days = 0;
        $save_date = '';
        for ($i = 1; $i <= $period; $i++) {
            $loan_schedule = new LoanSchedule();
            $loan_schedule->loan_id = $loan->id;
            $loan_schedule->branch_id = $request->business_id;
            $loan_schedule->borrower_id = $loan->borrower_id;
            $loan_schedule->description = trans_choice('general.repayment', 1);

            $timestamp = strtotime($next_payment);
            $day = date('l', $timestamp);

            if (strpos($day, 'Saturday') !== false) {
                if ($loan->includes_sat == 0) {
                    $save_date = date_format(date_add(date_create($next_payment),
                        date_interval_create_from_date_string('2 days')),
                        'Y-m-d');
                } else {
                    $save_date = $next_payment;
                }
            } else if (strpos($day, 'Sunday') !== false) {
                if ($loan->includes_sun == 0 && $loan->includes_sat == 0) {
                    $move_days = 2;
                    $save_date = date_format(date_add(date_create($next_payment),
                        date_interval_create_from_date_string('2 days')),
                        'Y-m-d');
                    $next_payment = date_format(date_add(date_create($next_payment),
                        date_interval_create_from_date_string('1 days')),
                        'Y-m-d');
                } else if ($loan->includes_sun == 0 && $loan->includes_sat == 1) {
                    $move_days = 1;
                    $save_date = date_format(date_add(date_create($next_payment),
                        date_interval_create_from_date_string('1 days')),
                        'Y-m-d');
                } else if ($loan->includes_sun == 1 && $loan->includes_sat == 0) {
                    $move_days = 1;
                    $save_date = $next_payment;
                } else {
                    $save_date = $next_payment;
                }
            } else {
                $save_date = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string($move_days . ' days')),
                    'Y-m-d');
                $next_payment = $save_date;
                $move_days = 0;
            }

            $loan_schedule->due_date = $save_date;
            $date = explode('-', $save_date);
            $loan_schedule->month = $date[1];
            $loan_schedule->year = $date[0];
            //determine which method to use
            $due = 0;
            //reducing balance equal installments
            if ($loan->interest_method == 'declining_balance_equal_installments') {
                $due = GeneralHelper::amortized_monthly_payment($loan->id, $loan->principal);
                //determine if we have grace period for interest
                $interest = ($interest_rate * $balance);
                $loan_schedule->principal = ($due - $interest);
                if ($loan->grace_on_interest_charged >= $i) {
                    $loan_schedule->interest = 0;
                } else {
                    $loan_schedule->interest = $interest;
                }
                $loan_schedule->due = $due;
                //determine next balance
                $balance = ($balance - ($due - $interest));
                $loan_schedule->principal_balance = $balance;

            }
            //reducing balance equal principle
            if ($loan->interest_method == 'declining_balance_equal_principal') {
                $principal = $loan->principal / $period;
                $loan_schedule->principal = ($principal);
                $interest = ($interest_rate * $balance);
                if ($loan->grace_on_interest_charged >= $i) {
                    $loan_schedule->interest = 0;
                } else {
                    $loan_schedule->interest = $interest;
                }
                $loan_schedule->due = $principal + $interest;
                //determine next balance
                $balance = ($balance - ($principal + $interest));
                $loan_schedule->principal_balance = $balance;

            }
            //flat  method
            if ($loan->interest_method == 'flat_rate') {
                $principal = $loan->principal / $period;
                $interest = ($interest_rate * $loan->principal);
                if ($loan->grace_on_interest_charged >= $i) {
                    $loan_schedule->interest = 0;
                } else {
                    $loan_schedule->interest = $interest;
                }
                $loan_schedule->principal = $principal;
                $loan_schedule->due = $principal + $interest;
                //determine next balance
                $balance = ($balance - $principal);
                $loan_schedule->principal_balance = $balance;
            }
            //interest only method
            if ($loan->interest_method == 'interest_only') {
                if ($i == $period) {
                    $principal = $loan->principal;
                } else {
                    $principal = 0;
                }
                $interest = ($interest_rate * $loan->principal);
                if ($loan->grace_on_interest_charged >= $i) {
                    $loan_schedule->interest = 0;
                } else {
                    $loan_schedule->interest = $interest;
                }
                $loan_schedule->principal = $principal;
                $loan_schedule->due = $principal + $interest;
                //determine next balance
                $balance = ($balance - $principal);
                $loan_schedule->principal_balance = $balance;
            }
            $total_interest = $total_interest + $interest;
            //determine next due date
            if ($loan->repayment_cycle == 'daily') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('1 days')),
                    'Y-m-d');
            }
            if ($loan->repayment_cycle == 'weekly') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('1 weeks')),
                    'Y-m-d');
            }
            if ($loan->repayment_cycle == 'monthly') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('1 months')),
                    'Y-m-d');
            }
            // VERIFICACION 1
            if ($loan->repayment_cycle == 'bi_monthly') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('15 days')),
                    'Y-m-d');
            }
            if ($loan->repayment_cycle == 'quarterly') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('4 months')),
                    'Y-m-d');
            }
            if ($loan->repayment_cycle == 'semi_annually') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('6 months')),
                    'Y-m-d');
            }
            if ($loan->repayment_cycle == 'yearly') {
                $next_payment = date_format(date_add(date_create($next_payment),
                    date_interval_create_from_date_string('1 years')),
                    'Y-m-d');
            }
            if ($i == $period) {
                $loan_schedule->principal_balance = round($balance);
            }
            $loan_schedule->save();
        }
        $loan = Loan::find($loan->id);
        $loan->maturity_date = $next_payment;
        $loan->save();
        $fees_disbursement = 0;
        $fees_installment = 0;
        $fees_due_date = [];
        $fees_due_date_amount = 0;
        foreach ($loan->charges as $key) {
            if (!empty($key->charge)) {
                if ($key->charge->charge_type == "disbursement") {
                    if ($key->charge->charge_option == "fixed") {
                        $fees_disbursement = $fees_disbursement + $key->amount;
                    } else {
                        if ($key->charge->charge_option == "principal_due") {
                            $fees_disbursement = $fees_disbursement + ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "principal_interest") {
                            $fees_disbursement = $fees_disbursement + ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                        if ($key->charge->charge_option == "interest_due") {
                            $fees_disbursement = $fees_disbursement + ($key->amount * $total_interest) / 100;
                        }
                        if ($key->charge->charge_option == "original_principal") {
                            $fees_disbursement = $fees_disbursement + ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "total_due") {
                            $fees_disbursement = $fees_disbursement + ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                    }
                }
                if ($key->charge->charge_type == "installment_fee") {
                    if ($key->charge->charge_option == "fixed") {
                        $fees_installment = $fees_installment + $key->amount;
                    } else {
                        if ($key->charge->charge_option == "principal_due") {
                            $fees_installment = $fees_installment + ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "principal_interest") {
                            $fees_installment = $fees_installment + ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                        if ($key->charge->charge_option == "interest_due") {
                            $fees_installment = $fees_installment + ($key->amount * $total_interest) / 100;
                        }
                        if ($key->charge->charge_option == "original_principal") {
                            $fees_installment = $fees_installment + ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "total_due") {
                            $fees_installment = $fees_installment + ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                    }
                }
                if ($key->charge->charge_type == "specified_due_date") {
                    if ($key->charge->charge_option == "fixed") {
                        $fees_due_date_amount = $fees_due_date_amount + $key->amount;
                        $fees_due_date[$key->charge->date] = $key->amount;
                    } else {
                        if ($key->charge->charge_option == "principal_due") {
                            $fees_due_date_amount = $fees_due_date_amount + ($key->amount * $loan->principal) / 100;
                            $fees_due_date[$key->charge->date] = ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "principal_interest") {
                            $fees_due_date_amount = $fees_due_date_amount + ($key->amount * ($loan->principal + $total_interest)) / 100;
                            $fees_due_date[$key->charge->date] = ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                        if ($key->charge->charge_option == "interest_due") {
                            $fees_due_date_amount = $fees_due_date_amount + ($key->amount * $total_interest) / 100;
                            $fees_due_date[$key->charge->date] = ($key->amount * $total_interest) / 100;
                        }
                        if ($key->charge->charge_option == "original_principal") {
                            $fees_due_date_amount = $fees_due_date_amount + ($key->amount * $loan->principal) / 100;
                            $fees_due_date[$key->charge->date] = ($key->amount * $loan->principal) / 100;
                        }
                        if ($key->charge->charge_option == "total_due") {
                            $fees_due_date_amount = $fees_due_date_amount + ($key->amount * ($loan->principal + $total_interest)) / 100;
                            $fees_due_date[$key->charge->date] = ($key->amount * ($loan->principal + $total_interest)) / 100;
                        }
                    }
                }
            }
        }
        //add disbursal transaction
        $loan_transaction = new LoanTransaction();
        $loan_transaction->user_id = $request->user_id;
        $loan_transaction->branch_id = $request->business_id;
        $loan_transaction->loan_id = $loan->id;
        $loan_transaction->borrower_id = $loan->borrower_id;
        $loan_transaction->transaction_type = "disbursement";
        $loan_transaction->date = $request->disbursed_date;
        $date = explode('-', $request->disbursed_date);
        $loan_transaction->year = $date[0];
        $loan_transaction->month = $date[1];
        $loan_transaction->debit = $loan->principal;
        $loan_transaction->save();
        //add interest transaction
        $loan_transaction = new LoanTransaction();
        $loan_transaction->user_id = $request->user_id;
        $loan_transaction->branch_id = $request->business_id;
        $loan_transaction->loan_id = $loan->id;
        $loan_transaction->borrower_id = $loan->borrower_id;
        $loan_transaction->transaction_type = "interest";
        $loan_transaction->date = $request->disbursed_date;
        $date = explode('-', $request->disbursed_date);
        $loan_transaction->year = $date[0];
        $loan_transaction->month = $date[1];
        $loan_transaction->debit = $total_interest;
        $loan_transaction->save();
        //add fees transactions
        if ($fees_disbursement > 0) {
            $loan_transaction = new LoanTransaction();
            $loan_transaction->user_id = $request->user_id;
            $loan_transaction->branch_id = $request->business_id;
            $loan_transaction->loan_id = $loan->id;
            $loan_transaction->borrower_id = $loan->borrower_id;
            $loan_transaction->transaction_type = "disbursement_fee";
            $loan_transaction->date = $request->disbursed_date;
            $date = explode('-', $request->disbursed_date);
            $loan_transaction->year = $date[0];
            $loan_transaction->month = $date[1];
            $loan_transaction->debit = $fees_disbursement;
            $loan_transaction->save();

            $loan_transaction = new LoanTransaction();
            $loan_transaction->user_id = $request->user_id;
            $loan_transaction->branch_id = $request->business_id;
            $loan_transaction->loan_id = $loan->id;
            $loan_transaction->borrower_id = $loan->borrower_id;
            $loan_transaction->transaction_type = "repayment_disbursement";
            $loan_transaction->date = $request->disbursed_date;
            $date = explode('-', $request->disbursed_date);
            $loan_transaction->year = $date[0];
            $loan_transaction->month = $date[1];
            $loan_transaction->credit = $fees_disbursement;
            $loan_transaction->save();
            //add journal entry for payment and charge
            if (!empty($loan->loan_product->chart_income_fee)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_income_fee->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->disbursed_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'fee';
                $journal->name = "Fee Income";
                $journal->loan_id = $loan->id;
                $journal->credit = $fees_disbursement;
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_fund_source)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_fund_source->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->disbursed_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'fee';
                $journal->name = "Fee Income";
                $journal->loan_id = $loan->id;
                $journal->debit = $fees_disbursement;
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
        }
        if ($fees_installment > 0) {
            $loan_transaction = new LoanTransaction();
            $loan_transaction->user_id = $request->user_id;
            $loan_transaction->branch_id = $request->business_id;
            $loan_transaction->loan_id = $loan->id;
            $loan_transaction->borrower_id = $loan->borrower_id;
            $loan_transaction->transaction_type = "installment_fee";
            $loan_transaction->reversible = 1;
            $loan_transaction->date = $request->disbursed_date;
            $date = explode('-', $request->disbursed_date);
            $loan_transaction->year = $date[0];
            $loan_transaction->month = $date[1];
            $loan_transaction->debit = $fees_installment;
            $loan_transaction->save();
            //add installment to schedules
            foreach (LoanSchedule::where('loan_id', $loan->id)->get() as $key) {
                $schedule = LoanSchedule::find($key->id);
                $schedule->fees = $fees_installment;
                $schedule->save();
            }
        }
        if ($fees_due_date_amount > 0) {
            foreach ($fees_due_date as $key => $value) {
                $due_date = GeneralHelper::determine_due_date($loan->id, $key);
                if (!empty($due_date)) {
                    $schedule = LoanSchedule::where('loan_id', $loan->id)->where('due_date', $due_date)->first();
                    $schedule->fees = $schedule->fees + $value;
                    $schedule->save();
                    $loan_transaction = new LoanTransaction();
                    $loan_transaction->user_id = $request->user_id;
                    $loan_transaction->branch_id = $request->business_id;
                    $loan_transaction->loan_id = $loan->id;
                    $loan_transaction->loan_schedule_id = $schedule->id;
                    $loan_transaction->reversible = 1;
                    $loan_transaction->borrower_id = $loan->borrower_id;
                    $loan_transaction->transaction_type = "specified_due_date_fee";
                    $loan_transaction->date = $due_date;
                    $date = explode('-', $due_date);
                    $loan_transaction->year = $date[0];
                    $loan_transaction->month = $date[1];
                    $loan_transaction->debit = $value;
                    $loan_transaction->save();
                }
            }
        }
        //debit and credit the necessary accounts
        if (!empty($loan->loan_product->chart_fund_source)) {
            $journal = new JournalEntry();
            $journal->user_id = $request->user_id;
            $journal->account_id = $loan->loan_product->chart_fund_source->id;
            $journal->branch_id = $loan->branch_id;
            $journal->date = $request->disbursed_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->borrower_id = $loan->borrower_id;
            $journal->transaction_type = 'disbursement';
            $journal->name = "Loan Disbursement";
            $journal->loan_id = $loan->id;
            $journal->credit = $loan->principal;
            $journal->reference = $loan->id;
            $journal->save();
        } else {
            //alert admin that no account has been set
        }
        if (!empty($loan->loan_product->chart_loan_portfolio)) {
            $journal = new JournalEntry();
            $journal->user_id = $request->user_id;
            $journal->account_id = $loan->loan_product->chart_loan_portfolio->id;
            $journal->branch_id = $loan->branch_id;
            $journal->date = $request->disbursed_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->borrower_id = $loan->borrower_id;
            $journal->transaction_type = 'disbursement';
            $journal->name = "Loan Disbursement";
            $journal->loan_id = $loan->id;
            $journal->debit = $loan->principal;
            $journal->reference = $loan->id;
            $journal->save();
        } else {
            //alert admin that no account has been set
        }
        if ($loan->loan_product->accounting_rule == "accrual_upfront") {
            //we need to save the accrued interest in journal here
            if (!empty($loan->loan_product->chart_receivable_interest)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_receivable_interest->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->disbursed_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'accrual';
                $journal->name = "Accrued Interest";
                $journal->loan_id = $loan->id;
                $journal->debit = $total_interest;
                $journal->reference = $loan->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_income_interest)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_income_interest->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->disbursed_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'accrual';
                $journal->name = "Accrued Interest";
                $journal->loan_id = $loan->id;
                $journal->credit = $total_interest;
                $journal->reference = $loan->id;
                $journal->save();
            }
        }
        return true;
    }
    
    public function getLoanReport(Request $request)
    {
        if ($request->start_date > $request->end_date) {
            return response()->json([
                'status' => 300,
                'message' => 'Search date error',
            ], 200);
        }
        $date = explode('-', date('Y-m-d'));
        $end_of_year = date("Y-m-d", strtotime($date[0] . '-12-31'));
        $start_of_year = date("Y-m-d", strtotime($date[0] . '-01-01'));
        if ($request->start_date < $start_of_year || $request->end_date > $end_of_year) {
            $over_year = true;
        } else {
            $over_year = false;
        }

        $role_name = $request->role_name;
        $reportData = array();
        $total_val = 0;
        $total_count = 0;
        $loans = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->whereBetween('disbursed_date', [$request->start_date, $request->end_date])->groupBy('year')->groupBy('month')->groupBy('borrower_id')->selectRaw('*, sum(approved_amount) as total')->get();
        foreach ($loans as $loan) {
            if ($loan->borrower) {
                $borrower = $loan->borrower->first_name . ' ' . $loan->borrower->last_name;
            } else {
                $borrower = '';
            }
            array_push($reportData, array(
                'year' => $loan->year,
                'month' => $loan->month,
                'borrower' => $borrower,
                'total' => $loan->total,
                'loan_id' => $loan->id,
            ));
            $total_val = $total_val + $loan->total;
        }
        $total_count = count($loans);

        return response()->json([
            'status' => 200,
            'loan_report' => $reportData,
            'total_val' => $total_val,
            'total_count' => $total_count,
            'over_year' => $over_year,
        ], 200);
    }
    
    public function getGeneralReportForChart(Request $request)
    {
        if ($request->start_date > $request->end_date) {
            return response()->json([
                'status' => 300,
                'message' => 'Search date error',
            ], 200);
        }

        $loans = array();
        $total_disbursed = 0;
        $query = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->whereBetween('disbursed_date', [$request->start_date, $request->end_date])->groupBy('year')->groupBy('month')->groupBy('borrower_id')->selectRaw('*, sum(approved_amount) as total')->get();
        foreach ($query as $loan) {
            $loans[] = $loan->id;
            $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($loan->id);
            $total_disbursed = $total_disbursed + $loan->total;//$total_disbursed + $loan_due_items["principal"];
        }
        
        $loanids = array();
        $total_disbursed_in_route = 0;
        $loans_in_route = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('branch_id', $request->business_id)->get();
        foreach ($loans_in_route as $loana) {
            $loanids[] = $loana->id;
            $loan_due_item = \App\Helpers\GeneralHelper::loan_due_items($loana->id);
            $total_disbursed_in_route = $total_disbursed_in_route + $loan_due_item["principal"];
        }

        $total_principal = 0;
        $total_fees = 0;
        $total_interest = 0;
        $total_penalty = 0;
        $total_due = 0;
        // $total_total = 0;
        
        $data = \App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('reversed', 0)->where('branch_id', $request->business_id)->whereBetween('date', [$request->start_date, $request->end_date])->whereIn('loan_id', $loanids)->get();
        foreach ($data as $key) {
            $principal = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Principal Repayment")->where('branch_id', $request->business_id)->sum('credit');

            $interest = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Interest Repayment")->where('branch_id', $request->business_id)->sum('credit');

            $fees = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Fees Repayment")->where('branch_id', $request->business_id)->sum('credit');

            $penalty = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Penalty Repayment")->where('branch_id', $request->business_id)->sum('credit');

            // $total_payment = \App\Models\LoanTransaction::where('id', $key->id)->where('reversed', 0)->where('transaction_type', "repayment")->where('branch_id', $request->business_id)->sum('credit');

            $total_principal = $total_principal + $principal;
            $total_interest = $total_interest + $interest;
            $total_fees = $total_fees + $fees;
            $total_penalty = $total_penalty + $penalty;
            // $total_total = $total_total + $total_payment;
        }

        foreach (\App\Models\Loan::where('first_payment_date', '<=', $request->end_date)->where('branch_id', $request->business_id)->where('status', 'disbursed')->orderBy('release_date', 'asc')->get() as $key) {
            $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($key->id, $key->release_date, $request->end_date);
            $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id, $key->release_date, $request->end_date);
            $due = ($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]);
            $total_due = $total_due + $due;
        }

        return response()->json([
            'status' => 200,
            'total_principal' => $total_principal,
            'total_interest' => $total_interest,
            'total_fees' => $total_fees,
            'total_penalty' => $total_penalty,
            'total_due' => $total_due,
            'loan_count' => count($loans),
            'total_disbursed' => $total_disbursed,
            'total_disbursed_in_route' => $total_disbursed_in_route,
            'loans_in_route' => count($loans_in_route),
        ], 200);
    }

    public function getRepaymentMethod()
    {
        return response()->json([
            'status' => 200,
            'methods' => \App\Models\LoanRepaymentMethod::all(),
        ], 200);
    }

    public function addCommentData(Request $request)
    {
        $loan_comment = new LoanComment();
        $loan_comment->notes = $request->notes;
        $loan_comment->user_id = $request->user_id;
        $loan_comment->loan_id = $request->loan_id;
        $loan_comment->save();
        return response()->json([
            'status' => 200,
            'message' => "Saved successfully",
        ], 200);
    }

    public function saveRepayment(Request $request)
    {
        if ($request->collection_date > date("Y-m-d")) {
            return response()->json([
                'status' => 400,
                'error' => trans_choice('general.future_date_error', 1),
            ], 200);
            exit();
        }

        $loan = \App\Models\Loan::find($request->loan_id);
        if (!empty($loan->borrower)) {
            $borrower = $loan->borrower;
        } else {
            $borrower = null;
        }

        $loan_transaction = new LoanTransaction();
        $loan_transaction->user_id = $request->user_id;
        $loan_transaction->branch_id = $request->business_id;
        $loan_transaction->loan_id = $loan->id;
        $loan_transaction->borrower_id = $loan->borrower_id;
        $loan_transaction->transaction_type = "repayment";
        $loan_transaction->receipt = $request->receipt;
        $loan_transaction->date = $request->collection_date;
        $loan_transaction->reversible = 1;
        $loan_transaction->repayment_method_id = $request->repayment_method_id;
        $date = explode('-', $request->collection_date);
        $loan_transaction->year = $date[0];
        $loan_transaction->month = $date[1];
        $loan_transaction->credit = $request->amount;
        $loan_transaction->notes = $request->notes;
        $loan_transaction->lat = $request->lat;
        $loan_transaction->lng = $request->long;

        if ($request->repayment_type == "2") {
            $loan_transaction->payment_type = "principal";
        }
        $loan_transaction->save();

        // debit and credit the necessary accounts
        $allocation = GeneralHelper::loan_allocate_payment($loan_transaction);

        //principal
        if ($allocation['principal'] > 0) {
            if (!empty($loan->loan_product->chart_loan_portfolio)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_loan_portfolio->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->transaction_sub_type = 'repayment_principal';
                $journal->name = "Principal Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->credit = $allocation['principal'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_fund_source)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_fund_source->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->name = "Principal Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->debit = $allocation['principal'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
        }
        //interest
        if ($allocation['interest'] > 0) {
            if (!empty($loan->loan_product->chart_income_interest)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_income_interest->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->transaction_sub_type = 'repayment_interest';
                $journal->name = "Interest Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->credit = $allocation['interest'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_receivable_interest)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_receivable_interest->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->name = "Interest Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->debit = $allocation['interest'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
        }
        //fees
        if ($allocation['fees'] > 0) {
            if (!empty($loan->loan_product->chart_income_fee)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_income_fee->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->transaction_sub_type = 'repayment_fees';
                $journal->name = "Fees Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->credit = $allocation['fees'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_receivable_fee)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_receivable_fee->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->name = "Fees Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->debit = $allocation['fees'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
        }
        if ($allocation['penalty'] > 0) {
            if (!empty($loan->loan_product->chart_income_penalty)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_income_penalty->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->transaction_sub_type = 'repayment_penalty';
                $journal->name = "Penalty Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->credit = $allocation['penalty'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
            if (!empty($loan->loan_product->chart_receivable_penalty)) {
                $journal = new JournalEntry();
                $journal->user_id = $request->user_id;
                $journal->account_id = $loan->loan_product->chart_receivable_penalty->id;
                $journal->branch_id = $loan->branch_id;
                $journal->date = $request->collection_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->borrower_id = $loan->borrower_id;
                $journal->transaction_type = 'repayment';
                $journal->name = "Penalty Repayment";
                $journal->loan_id = $loan->id;
                $journal->loan_transaction_id = $loan_transaction->id;
                $journal->debit = $allocation['penalty'];
                $journal->reference = $loan_transaction->id;
                $journal->save();
            }
        }

        //save custom meta
        $custom_fields = \App\Models\CustomField::where('category', 'repayments')->get();
        foreach ($custom_fields as $key) {
            $custom_field = new CustomFieldMeta();
            $id = $key->id;
            $custom_field->name = $request->$id;
            $custom_field->parent_id = $loan_transaction->id;
            $custom_field->custom_field_id = $key->id;
            $custom_field->category = "repayments";
            $custom_field->save();
        }
        //update loan status if need be
        // if (round(GeneralHelper::loan_total_balance($loan->id)) <= 0) {
        //     $l = \App\Models\Loan::find($loan->id);
        //     $l->status = "closed";
        //     $l->save();
        // }

        return response()->json([
            'status' => 200,
            'loan_transaction' => $loan_transaction,
            'customer' => $borrower,
            'message' => 'Pago procesado con éxito',
        ], 200);
    }

    public function getDistributionData(Request $request)
    {
        $total_principal = 0;
        $total_fees = 0;
        $total_interest = 0;
        $total_penalty = 0;
        $transaction_type = '';
        $transaction_date = '';
        foreach (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('reversed', 0)->where('receipt', $request->receipt)->get() as $key) {
            $principal = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Principal Repayment")->sum('credit');

            $interest = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Interest Repayment")->sum('credit');

            $fees = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Fees Repayment")->sum('credit');

            $penalty = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed', 0)->where('name', "Penalty Repayment")->sum('credit');

            $total_principal = $total_principal + $principal;
            $total_interest = $total_interest + $interest;
            $total_fees = $total_fees + $fees;
            $total_penalty = $total_penalty + $penalty;

            $transaction_type = $key->transaction_type;
        }
        return response()->json([
            'status' => 200,
            'principal' => $principal,
            'interest' => $interest,
            'fees' => $fees,
            'penalty' => $penalty,
            'transaction_type' => $transaction_type,
        ], 200);
    }









    

    public function getRepaymentReportOfDaily(Request $request)
    {
        $loans = array();
        $repaymens = array();

        foreach (\App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->get() as $key) {
            $loans[] = $key->id;
        }

        foreach (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('date', date("Y-m-d"))->whereIn('loan_id', $loans)->where('reversed', 0)->get() as $key) {
            if (!empty($key->borrower)) {
                $borrower = $key->borrower->first_name . ' ' . $key->borrower->last_name;
            } else {
                $borrower = '';
            }

            array_push($repaymens, array(
                'loan_id' => $key->loan_id,
                'borrower_id' => $key->borrower_id,
                'credit' => $key->credit,
                'customer' => $borrower,
                'receipt' => $key->receipt,
                'date' => date("d-m-Y", strtotime($key->date)),
                'payment_method' => $key->repayment_method_id,
            ));
        }

        return response()->json([
            'status' => 200,
            'data' => $repaymens,
        ], 200);
    }    

    public function getLoansReportData(Request $request)
    {
        $loans = array();

        if (empty($request->last_loanid)) {
            // $from_data = date('Y-m-d');
            $loans_data = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->orderBy('id', 'DESC')->limit(10)->get();
        } else {
            // $from_data = $request->last_date;
            $loans_data = \App\Models\Loan::where('status', 'disbursed')->where('loan_product_id', $request->route_id)->where('id', '<', $request->last_loanid)->orderBy('id', 'DESC')->limit(10)->get();
        }

        foreach ($loans_data as $key) {
            if (!empty($key->borrower)) {
                $borrower = $key->borrower->first_name . ' ' . $key->borrower->last_name;
                $phone_number = $key->borrower->mobile;
                $customer_location = $key->borrower->address;
            } else {
                $borrower = '';
                $phone_number = '';
                $customer_location = '';
            }

            $status = '';
            if ($key->maturity_date < date("Y-m-d") && GeneralHelper::loan_total_balance($key->id) > 0) {
                $status = trans_choice('general.past_maturity', 1);
            } else {
                if ($key->status == 'pending') {
                    $status = trans_choice('general.pending', 1) . ' ' . trans_choice('general.approval', 1);
                }
                if ($key->status == 'approved') {
                    $status = trans_choice('general.awaiting', 1) . ' ' . trans_choice('general.disbursement', 1);
                }
                if ($key->status == 'disbursed') {
                    $status = trans_choice('general.active', 1);
                }
                if ($key->status == 'declined') {
                    $status = trans_choice('general.declined', 1);
                }
                if ($key->status == 'withdrawn') {
                    $status = trans_choice('general.withdrawn', 1);
                }
                if ($key->status == 'written_off') {
                    $status = trans_choice('general.written_off', 1);
                }
                if ($key->status == 'closed') {
                    $status = trans_choice('general.closed', 1);
                }
                if ($key->status == 'pending_reschedule') {
                    $status = trans_choice('general.pending', 1) . ' ' . trans_choice('general.reschedule', 1);
                }
                if ($key->status == 'rescheduled') {
                    $status = trans_choice('general.rescheduled', 1);
                }
            }

            $loan_due_items = GeneralHelper::loan_due_items($key->id, $key->release_date, date('Y-m-d'));
            $loan_paid_items = GeneralHelper::loan_paid_items($key->id, $key->release_date, date('Y-m-d'));
            $outstanding = ($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]);
            $balance = \App\Helpers\GeneralHelper::loan_total_balance($key->id);

            $timely = 0;
            $total_overdue = 0;
            $overdue_date = "";
            $total_till_now = 0;
            $count = 1;
            $total_due = 0;
            $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $key->id)->sum('principal');
            $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
            $balancePrincipal = $totalPrincipal - $payPrincipal;

            $principal_balance = $balancePrincipal;
            $payments = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
            $next_payment = [];
            $schedules = \App\Models\LoanSchedule::where('loan_id', $key->id)->orderBy('due_date', 'asc')->get();

            foreach ($schedules as $schedule) {
                $schedule_count = count($schedules);
                $principal = $balancePrincipal / $schedule_count;
                $loanRate = $key->interest_rate;

                if ($key->repayment_cycle == 'daily') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                } elseif ($key->repayment_cycle == 'weekly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                } elseif ($key->repayment_cycle == 'bi_monthly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                } elseif ($key->repayment_cycle == 'monthly') {
                    $interest = ($balancePrincipal * $loanRate) / 100.00;
                } else {
                    $interest = 0;
                }

                $principal_balance = $principal_balance - $principal;

                $due = $principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived;
                $total_due = $total_due + ($principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived);

                $paid = 0;
                $paid_by = '';

                if ($payments > 0) {
                    if ($payments > $due) {
                        $paid = $due;
                        $payments = $payments - $due;
                        //find the corresponding paid by date
                        $p_paid = 0;
                        foreach (\App\Models\LoanTransaction::where('loan_id',
                            $key->id)->where('transaction_type',
                            'repayment')->where('reversed', 0)->orderBy('date',
                            'asc')->get() as $keyy) {
                            $p_paid = $p_paid + $keyy->credit;
                            if ($p_paid >= $total_due) {
                                $paid_by = $keyy->date;
                                if ($keyy->date > $schedule->due_date && date("Y-m-d") > $schedule->due_date) {
                                    $total_overdue = $total_overdue + 1;
                                    $overdue_date = '';
                                }
                                break;
                            }
                        }
                    } else {
                        $paid = $payments;
                        $payments = 0;
                        if (date("Y-m-d") > $schedule->due_date) {
                            $total_overdue = $total_overdue + 1;
                            $overdue_date = $schedule->due_date;
                        }
                        $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived) - $paid);
                    }
                } else {
                    if (date("Y-m-d") > $schedule->due_date) {
                        $total_overdue = $total_overdue + 1;
                        $overdue_date = $schedule->due_date;
                    }
                    $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived));
                }
                // $outstanding = $due - $paid;
            }
            if (!empty($overdue_date) && $overdue_date != '') {
                $date1 = new \DateTime($overdue_date);
                $date2 = new \DateTime(date('Y-m-d'));
                $days_arrears = $date2->diff($date1)->format("%a");
            } else {
                $days_arrears = 0;
            }

            if (!empty($key->loan_product)) {
                $product_name = $key->loan_product->name;
            } else {
                $product_name = '';
            }

            if ($key->repayment_cycle == 'daily') {
                $repayment_cycle = trans_choice('general.daily', 1);
            } else if ($key->repayment_cycle == 'weekly') {
                $repayment_cycle = trans_choice('general.weekly', 1);
            } else if ($key->repayment_cycle == 'monthly') {
                $repayment_cycle = trans_choice('general.monthly', 1);
            } else if ($key->repayment_cycle == 'bi_monthly') {
                $repayment_cycle = trans_choice('general.bi_monthly', 1);
            } else if ($key->repayment_cycle == 'quarterly') {
                $repayment_cycle = trans_choice('general.quarterly', 1);
            } else if ($key->repayment_cycle == 'semi_annual') {
                $repayment_cycle = trans_choice('general.semi_annually', 1);
            } else if ($key->repayment_cycle == 'annually') {
                $repayment_cycle = trans_choice('general.annual', 1);
            } else {
                $repayment_cycle = 'None';
            }

            $payment_today = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->where('date', date('Y-m-d'))->get();

            array_push($loans, array(
                'loan_id' => $key->id,
                'customer' => $borrower,
                'phone_number' => $phone_number,
                'customer_location' => $customer_location,
                'status' => $status,
                'outstanding' => $outstanding,
                'due_days' => $days_arrears,
                'product_name' => $product_name,
                'amount_approved' => $key->principal,
                'disturb_date' => date("d-m-Y", strtotime($key->release_date)),
                'balance' => $balance,
                'payment_frequency' => $repayment_cycle,
                'repayment_cycle' => $key->repayment_cycle,
                'release_data' => $key->first_payment_date,
                'payment_today' => count($payment_today),
            ));
        }

        return response()->json([
            'status' => 200,
            'loans' => $loans,
        ], 200);
    }

    public function getLoanDetailFromLoanReport(Request $request)
    {
        $loan = \App\Models\Loan::where('branch_id', 1)->where('id', $request->loan_id)->first();
        if (!empty($loan->borrower)) {
            $phone_number = $loan->borrower->mobile;
            $customer_location = $loan->borrower->address;
        } else {
            $phone_number = '';
            $customer_location = '';
        }

        $last_pay = \App\Models\LoanTransaction::where('loan_id', $request->loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->orderBy('date', 'desc')->first();
        if (!empty($last_pay)) {
            $last_payment = $last_pay->credit;
            $last_payment_date = $last_pay->date;
            $date1 = new \DateTime($last_payment_date);
            $date2 = new \DateTime(date('Y-m-d'));
            $remain_days = $date2->diff($date1)->format("%a");

            $lat = $last_pay->lat;
            $long = $last_pay->lng;
        } else {
            $last_payment = 0;
            $last_payment_date = 0;
            $remain_days = 0;
            $lat = 0;
            $long = 0;
        }

        $next_payment = [];
        $next_pay = 0;
        $next_pay_date = '';
        $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $request->loan_id)->sum('principal');
        $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $request->loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
        $balancePrincipal = $totalPrincipal - $payPrincipal;

        $payments = \App\Models\LoanTransaction::where('loan_id', $request->loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
        $loan_schedules = \App\Models\LoanSchedule::where('loan_id', $request->loan_id)->orderBy('due_date', 'asc')->get();
        if (count($loan_schedules) > 0) {
            foreach ($loan_schedules as $schedule) {
                $schedule_count = count($loan_schedules);
                $principal = $balancePrincipal / $schedule_count;
                $loanRate = $loan->interest_rate;
                if ($loan->repayment_cycle == 'daily') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                } elseif ($loan->repayment_cycle == 'weekly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                } elseif ($loan->repayment_cycle == 'bi_monthly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                } elseif ($loan->repayment_cycle == 'monthly') {
                    $interest = ($balancePrincipal * $loanRate) / 100.00;
                } else {
                    $interest = 0;
                }
                $due = $principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived;

                if ($schedule->due_date > date("Y-m-d")) {
                    $next_payment[$schedule->due_date] = $due;
                }
            }
            if (count($next_payment) > 0) {
                foreach ($next_payment as $key => $value) {
                    if ($key > date("Y-m-d")) {
                        $next_pay = $value;
                        $next_pay_date = date("d-m-Y", strtotime($key));
                        break;
                    }
                }
            }
        }

        $amount_payment = \App\Models\LoanSchedule::where('loan_id', $request->loan_id)->count();
        $original_date = $loan->first_payment_date;

        $balance = 0;
        $histories = [];
        foreach (\App\Models\LoanTransaction::where('loan_id', $request->loan_id)->where('reversed', 0)->whereIn('reversal_type', ['user', 'none'])->get() as $key) {
            $balance = $balance + ($key->debit - $key->credit);
            array_push($histories, array(
                'refer_id' => $key->id,
                'date' => date("d-m-Y", strtotime($key->date)),
                'debit' => $key->debit,
                'credit' => $key->credit,
                'balance' => $balance,
            ));
        }

        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($request->loan_id, $loan->release_date, date("Y-m-d"));
        $late_fee_balance = \App\Helpers\GeneralHelper::loan_total_penalty($request->loan_id) - $loan_paid_items['penalty'];

        $loan_comments = [];
        foreach (\App\Models\LoanComment::where('loan_id', $request->loan_id)->orderBy('user_id', 'asc')->orderBy('id', 'asc')->get() as $key) {
            $comment_user = \App\Models\User::where('id', $key->user_id)->first();
            $comment['user'] = $comment_user->first_name . ' ' . $comment_user->last_name;
            $comment['comment'] = $key->notes;
            $comment['date'] = date("d-m-Y", strtotime($key->created_at));
            $loan_comments[] = $comment;
        }

        return response()->json([
            'status' => 200,
            'loan' => $loan,
            'last_payment' => $last_payment,
            'last_payment_date' => $remain_days,
            'late_fee_balance' => $late_fee_balance,
            'next_pay' => $next_pay,
            'next_pay_date' => $next_pay_date,
            'amount_payment' => $amount_payment,
            'start_paying' => date("d-m-Y", strtotime($original_date)),
            'history' => $histories,
            'loan_comments' => $loan_comments,
            'phone_number' => $phone_number,
            'lat' => $lat,
            'long' => $long,
            'customer_location' => $customer_location,
        ], 200);
    }

    public function updateTrackLocation(Request $request)
    {
        $user_id = $request->user_id;
        $lat = $request->lat;
        $long = $request->long;

        $credentials = [
            'lat' => $lat,
            'lng' => $long,
        ];

        $user = \App\Models\User::where('id', $user_id)->update($credentials);

        return response()->json([
            'status' => 200,
            'message' => 'Procesado con exito',
            'user_data' => $user,
        ], 200);
    }

    
}