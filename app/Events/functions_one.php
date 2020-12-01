<?php

use App\Helpers\GeneralHelper;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\Email;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\Loan;
use App\Models\LoanCharge;
use App\Models\LoanOverduePenalty;
use App\Models\LoanProductCharge;
use App\Models\LoanRepayment;
use App\Models\LoanSchedule;
use App\Models\LoanTransaction;
use App\Models\Payroll;
use App\Models\PayrollMeta;
use App\Models\PayrollTemplateMeta;
use App\Models\Saving;
use App\Models\SavingProduct;
use App\Models\SavingsCharge;
use App\Models\SavingsProductCharge;
use App\Models\SavingTransaction;
use App\Models\Setting;
use App\Models\Sms;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Requests;

function updateCron() {
  $last_update_date = Setting::where('setting_key', 'cron_last_run')->first()->setting_value;
  $last_date_format = date_format(date_add(date_create($last_update_date), date_interval_create_from_date_string('0 days')),
  'Y-m-d');
  if ($last_date_format >= date("Y-m-d")) {
    echo 'Already cron job done';
  } else {
  
    
  }
}

?>