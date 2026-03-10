<?php

namespace App\Livewire;

use App\Models\InvoiceTemplate;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Invoice;
use Livewire\Component;
use Carbon\Carbon;
use NumberToWords\NumberToWords;

class InvoiceCreator extends Component
{
    public $header = '';

    #[Validate('required')]
    public $documentNumber = '';

    public $title = '';
    public array $sections;
    public $amount = '';
    public $city = '';
    public $dayDate = '';
    public $name = '';
    public $position = '';
    public $note = '';

    public ?Invoice $invoice = null;

    public function mount($invoice = null)
    {
        $this->invoice = $invoice;

        if ($invoice) {
            $this->authorize('update', $invoice);

            // =========================
            // EDIT MODE → load invoice
            // =========================
            $this->header = $invoice->header;
            $this->documentNumber = $invoice->document_number;
            $this->title = $invoice->title;
            $this->sections = $invoice->sections;
            $this->amount = $invoice->amount;
            $this->city = $invoice->city;
            $this->dayDate = $invoice->day_date;
            $this->name = $invoice->name;
            $this->position = $invoice->position;
            $this->note = $invoice->note;

            return;
        }

        // =========================
        // CREATE MODE → load template
        // =========================
        $this->authorize('create', Invoice::class);
        $template = InvoiceTemplate::where('company_id', auth()->user()->company_id)->firstOrFail();

        // dd($template);

        $this->header = $template?->header ?? '';
        $this->documentNumber = '';
        $this->title = '**INVOICE**';
        $this->city = 'Jakarta';
        $this->sections = json_decode($template->sections, true);
        $this->dayDate = Carbon::now('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('d F Y');
        $this->name = $template?->name ?? '';
        $this->position = $template?->position ?? '';
        $this->note = $template?->note ?? '';
    }

    protected function normalizedAmount(): int
    {
        if ($this->amount === null || $this->amount === '') {
            return 0;
        }

        return (int) preg_replace('/[^0-9]/', '', $this->amount);
    }

    // protected function terbilang($number): string
    // {
    //     $angka = [
    //         '', 'satu', 'dua', 'tiga', 'empat', 'lima',
    //         'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
    //     ];

    //     if ($number < 12) {
    //         return $angka[$number];
    //     } elseif ($number < 20) {
    //         return $this->terbilang($number - 10) . ' belas';
    //     } elseif ($number < 100) {
    //         return $this->terbilang(intdiv($number, 10)) . ' puluh ' . $this->terbilang($number % 10);
    //     } elseif ($number < 200) {
    //         return 'seratus ' . $this->terbilang($number - 100);
    //     } elseif ($number < 1000) {
    //         return $this->terbilang(intdiv($number, 100)) . ' ratus ' . $this->terbilang($number % 100);
    //     } elseif ($number < 2000) {
    //         return 'seribu ' . $this->terbilang($number - 1000);
    //     } elseif ($number < 1000000) {
    //         return $this->terbilang(intdiv($number, 1000)) . ' ribu ' . $this->terbilang($number % 1000);
    //     } elseif ($number < 1000000000) {
    //         return $this->terbilang(intdiv($number, 1000000)) . ' juta ' . $this->terbilang($number % 1000000);
    //     }

    //     return 'terlalu besar';
    // }

    protected function numbersToWords($number): string
    {
        $template = InvoiceTemplate::where(
            'company_id',
            auth()->user()->company_id
        )->first();

        $language = $template?->language ?? 'en'; // fallback

        $numberToWords = new NumberToWords();
        $transformer = $numberToWords->getNumberTransformer($language);

        return $transformer->toWords($number);
    }

    public function saveInvoice()
    {
        try {
            $validated = $this->validate();

            $data = [
                'user_id' => auth()->id(),
                'header' => $this->header,
                'title' => $this->title,
                'sections' => $this->sections,
                'amount' => $this->amount,
                'city' => $this->city,
                'day_date' => $this->dayDate,
                'name' => $this->name,
                'position' => $this->position,
                'note' => $this->note,
                'company_id' => auth()->user()->company_id,
            ];

            $invoice = Invoice::updateOrCreate(
                [
                    'document_number' => $this->documentNumber, // lookup key
                ],
                $data
            );

            $this->invoice = $invoice;

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => $invoice->wasRecentlyCreated
                    ? 'Invoice Saved'
                    : 'Invoice Updated',
                'text' => '',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scroll-to-top');
            throw $e;
        }
    }

    protected function currencyWord($currency): string
    {
        return match ($currency) {
            'IDR' => 'rupiah',
            'USD' => 'dollar',
            'SGD' => 'dollar',
            'EUR' => 'euro',
            default => strtolower($currency),
        };
    }

    function currency_symbol($code)
    {
        return match ($code) {
            'IDR' => 'Rp',
            'USD' => '$',
            'SGD' => 'S$',
            'EUR' => '€',
            default => $code,
        };
    }

    public function print()
    {
        $amount = $this->normalizedAmount();

        $template = InvoiceTemplate::where(
            'company_id',
            auth()->user()->company_id
        )->first();

        $currency = $template?->currency ?? 'USD';

        $symbol = $this->currency_symbol($currency);
        $totalWithCurrencyLabel = "Total {$symbol}:";

        $terbilang = ucfirst(trim($this->numbersToWords($amount))) . ' ' . $this->currencyWord($currency);
        $printSections = $this->sections;

        array_splice($printSections, 1, 0, [[
            'label' => 'Terbilang',
            'value' => '# ' . $terbilang . ' #',
        ]]);

        session([
            'invoice_data' => [
                'header' => $this->header,
                'documentNumber' => $this->documentNumber,
                'title' => $this->title,
                'sections' => $printSections,
                'dayDate' => $this->dayDate,
                'totalWithCurrencyLabel' => $totalWithCurrencyLabel,
                'amount' => $amount,
                'city' => $this->city,
                'name' => $this->name,
                'position' => $this->position,
                'note' => $this->note,
            ]
        ]);

        $this->dispatch('open-print');
    }


    public function render()
    {
        return view('livewire.invoice-creator');
    }
}
