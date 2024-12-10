<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Bank;
use App\Models\CaseBank;
use App\Models\CaseDisburse;
use App\Models\CaseList;
use App\Models\IndustryType;
use Livewire\Component;

class IndustryAmountReport extends Component
{
    public $categories_id;
    public $countIndustryAmount = [];
    public $newArray = [];

    public function mount(){

        $this->categories_id = IndustryType::pluck('id')->toArray();

        $case_ids = CaseDisburse::where('current_stage','>=',5)->pluck('case_list_id')->toArray();
        $count_industry_amount = CaseList::whereIn('id', $case_ids)
            ->with('case_disburse')
            ->orderBy('industry_type_id')
            ->get()
            ->groupBy('industry_type_id')
            ->map(function ($cases) {
                return $cases->sum(function ($case) {
                    return $case->case_disburse->sum('approved_amount');
                });
            })
            ->toArray();

        $counts = array_fill_keys($this->categories_id, 0);
        foreach ($count_industry_amount as $industryTypeId => $cases) {
            $counts[$industryTypeId] = $cases;
        }

        $sorting = arsort($counts);
        $this->countIndustryAmount = $counts;

        //Count Case
        $case_bank_ids = CaseBank::where('current_status','>=',5)->pluck('case_id')->toArray();
        $count_industry_case = CaseList::whereIn('id', $case_bank_ids)->orderBy('industry_type_id')->get()->groupBy('industry_type_id')->map(function ($cases_industry) {
            return count($cases_industry);
        })->toArray();

        $count_case= array_fill_keys($this->categories_id, 0);
        foreach ($count_industry_case as $industryTypeId => $cases) {
            $count_case[$industryTypeId] = $cases;
        }

        $sorting_case = arsort($count_case);
        $count_industry = $count_case;

        // Create New Array
        $newArray = [];
        foreach($this->countIndustryAmount as $key => $value) {
            $newArray[$key] = isset($count_industry[$key]) ? [$value, $count_industry[$key]] : [$value];
        }

        $this->newArray = $newArray;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.industry-amount-report');
    }
}
