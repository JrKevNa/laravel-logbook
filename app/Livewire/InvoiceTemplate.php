<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\InvoiceTemplate as InvoiceTemplateModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvoiceTemplate extends Component
{
    use AuthorizesRequests;

    #[Validate('required')]
    public $header = '';

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public array $sections;

    #[Validate('required')]
    public $position = '';

    #[Validate('required')]
    public $language = '';

    #[Validate('required')]
    public $currency = '';

    #[Validate('required')]
    public $note = '';

    public function mount()
    {
        $template = InvoiceTemplateModel::where('company_id', auth()->user()->company_id)->firstOrFail();

        $this->header = $template->header;
        $this->name = $template->name;
        $this->sections = json_decode($template->sections, true);
        $this->position = $template->position;
        $this->language = $template->language;
        $this->currency = $template->currency;
        $this->note = $template->note;
    }

    public function addSection()
    {
        $this->sections[] = [
            'label' => '',
            'value' => ''
        ];
    }

    public function removeSection($index)
    {
        unset($this->sections[$index]);

        // reindex array so Livewire doesn't break
        $this->sections = array_values($this->sections);
    }

    public function submit()
    {
		try
		{
			$documentTemplate = InvoiceTemplateModel::where('company_id', auth()->user()->company_id)->firstOrFail();

			$this->authorize('update', $documentTemplate);

			$validated=$this->validate();

			$documentTemplate->update([
				'header'       	=> $this->header,
				'name'         	=> $this->name,
                'sections'      => $this->sections,
				'position' 		=> $this->position,
                'language'      => $this->language,
                'currency'      => $this->currency,
				'note'     		=> $this->note,
			]);

			$this->dispatch('swal:modal', [
				'type' => 'success',
				'title' => 'Document Template updated',
				'text' => '',
			]);
		} catch (\Throwable $e) {
			$this->dispatch('swal:modal', [
				'type' => 'error',
				'title' => 'Error',
				'text' => $e->getMessage(),
			]);
		}
    }

    public function render()
    {
        return view('livewire.invoice-template');
    }
}
