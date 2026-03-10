<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class InvoiceList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    #[On('refresh-invoice')]
    public function refreshInvoice() {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $invoice = Invoice::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->firstOrFail();

            $this->authorize('delete', $invoice);

            $invoice->delete();

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'Invoice has been deleted.'
            ]);

            $this->refreshInvoice();
        } catch (\Throwable $e) { 
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        };
    }

    public function render()
    {
        $invoices = Invoice::visibleTo(auth()->user())
            ->where('document_number', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.invoice-list', compact('invoices'));
    }

}
