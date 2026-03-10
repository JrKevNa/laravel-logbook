<?php

namespace App\Livewire;

use App\Models\Company as CompanyModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Company extends Component
{
    use AuthorizesRequests;

    public $id;
    public $name;
    public $language;

    public function mount() {
        $company = CompanyModel::where('id', auth()->user()->company_id)
            ->firstOrFail();

        $this->id = $company->id;
        $this->name = $company->name;
    }

    public function submit() {

    }

    public function render()
    {
        return view('livewire.company');
    }
}
