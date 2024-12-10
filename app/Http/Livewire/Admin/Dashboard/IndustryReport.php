<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Bank;
use App\Models\CaseBank;
use App\Models\CaseList;
use App\Models\IndustryType;
use Livewire\Component;

class IndustryReport extends Component
{
    public $industries;
    public $bank_id;




    public $banks;
    public $categories_id;

    public $countIndustry = [];

    public function mount(){
        $this->industries = IndustryType::get();
        $this->industry_id = $this->industries->first()->id;

        $this->bank_id = Bank::pluck('id')->toArray();

        $industryID = $this->industry_id;

        $caseBanks = CaseBank::with('case')
            ->whereHas('case', function ($query) use ($industryID) {
                $query->where('industry_type_id', $industryID);
            })
            ->where('current_status', '>=', 5)
            ->get();

        $counts = $caseBanks->groupBy('current_bank_id')
            ->map(fn ($caseBanks) => $caseBanks->count())
            ->toArray();

        $count_bank = array_fill_keys($this->bank_id, 0);
        foreach ($counts as $industryTypeId => $cases) {
            $count_bank[$industryTypeId] = $cases;
        }

        $sorting = arsort($count_bank);
        $this->countIndustry = $count_bank;
    }

    public function updatedIndustryId($id)
    {
        $caseBanks = CaseBank::with('case')
            ->whereHas('case', function ($query) use ($id) {
                $query->where('industry_type_id', $id);
            })
            ->where('current_status', '>=', 5)
            ->get();

        $counts = $caseBanks->groupBy('current_bank_id')
            ->map(fn ($caseBanks) => $caseBanks->count())
            ->toArray();

        $count_bank = array_fill_keys($this->bank_id, 0);
        foreach ($counts as $industryTypeId => $cases) {
            $count_bank[$industryTypeId] = $cases;
        }

        $sorting = arsort($count_bank);
        $this->countIndustry = $count_bank;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.industry-report');
    }
}
