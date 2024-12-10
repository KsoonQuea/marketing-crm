<?php

namespace App\Http\Livewire;

use App\Models\ApplicationType;
use App\Models\Bank;
use App\Models\CaseCreditCheckType;
use App\Models\City;
use App\Models\Country;
use App\Models\Director;
use App\Models\FinancingInstrument;
use App\Models\IndustryType;
use App\Models\RequestType;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\CaseList;

class CaseCreate extends Component
{
    public $totalSteps = 4;
    public $currentStep = 1;

    public $forms = [
        /** KYC Part **/
        'case_code' => '',
        'salesman' => '',
        'company_name' => '',
        'incorporation_date' => '',
        'industry_type' => '',
        'business_activity' => '',
        'operating_address' => '',
        'application_type' => '',
        'application_date' => '',
        'bfe' => '',

        'customer_request' => [
            [
                'requestType' => '',
            ],
            [
                'requestType' => '',
            ],
            [
                'requestType' => '',
            ],
        ],
        'mgmt_team' => [
            [
                'mgmt_team_name' => '',
            ],
            [
                'mgmt_team_name' => '',
            ],
            [
                'mgmt_team_name' => '',
            ],
        ],
        'credit_check' => [
            [
                'credit_check_type' => '',
            ],
            [
                'credit_check_type' => '',
            ],
            [
                'credit_check_type' => '',
            ],
        ],
        'directorCommitments' => []
    ];

    public function mount()
    {
        $this->currentStep = 1;
//        $this->forms['salesman'] = $id->id;
    }

    public function updateCurrentStep($step)
    {
        $this->resetErrorBag();
        $this->currentStep = $step;
    }

    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
    }

    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function validateData()
    {

        if ($this->currentStep == 1) {
//            $this->validate([
//                'first_name'=>'required|string',
//                'last_name'=>'required|string',
//                'gender'=>'required',
//                'age'=>'required|digits:2'
//            ]);
        } elseif ($this->currentStep == 2) {
//            $this->validate([
//                'email'=>'required|email|unique:students',
//                'phone'=>'required',
//                'country'=>'required',
//                'city'=>'required'
//            ]);
        } elseif ($this->currentStep == 3) {
//            $this->validate([
//                'frameworks'=>'required|array|min:2|max:3'
//            ]);
        }
    }

    public function render()
    {
        $salesmen = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //catch salesman id,name
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_id')
            ->where('role_id', '=', '2')
            ->where('model_type', '=', 'App\Models\User')
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //end

        $directors = Director::pluck('name', 'id');

        $industry_types = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $application_types = ApplicationType::pluck('name', 'id');

        $request_types = RequestType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');
//
//        dd($request_types);

        $case_credit_check_types = CaseCreditCheckType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $banks = Bank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $financingInstruments_loan = FinancingInstrument::where('type', '=', '0')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month']);

        $financingInstruments_capboost = FinancingInstrument::where('type', '=', '1')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month']);

        return view('livewire.case-create', compact('application_types', 'users', 'cities', 'countries', 'directors', 'industry_types', 'salesmen', 'states', 'financingInstruments_loan', 'financingInstruments_capboost', 'banks', 'case_credit_check_types', 'request_types'));
    }
}
