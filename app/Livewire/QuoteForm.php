<?php

namespace App\Livewire;

use App\Support\Catalog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class QuoteForm extends Component
{
    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('required|email|max:160')]
    public string $email = '';

    #[Validate('nullable|string|max:40')]
    public string $phone = '';

    #[Validate('nullable|string|max:120')]
    public string $company = '';

    #[Validate('nullable|string|max:80')]
    public string $product = '';

    #[Validate('nullable|string|max:120')]
    public string $size = '';

    #[Validate('nullable|integer|min:1|max:100000')]
    public ?int $quantity = null;

    #[Validate('nullable|date|after:today')]
    public ?string $needed_by = null;

    #[Validate('required|string|min:10|max:3000')]
    public string $details = '';

    #[Validate('nullable|url|max:500')]
    public string $artwork_link = '';

    /** Honeypot: real people never see or fill this field. */
    public string $website = '';

    public string $heading = 'Tell us about your project';

    public bool $sent = false;

    public function submit(): void
    {
        $data = $this->validate();

        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        $body = collect($data)
            ->filter(fn ($v) => filled($v))
            ->map(fn ($v, $k) => str($k)->replace('_', ' ')->title().': '.$v)
            ->implode("\n");

        try {
            Mail::raw($body, fn ($m) => $m
                ->to(config('site.email'))
                ->replyTo($data['email'], $data['name'])
                ->subject('Quote request from '.$data['name']));
        } catch (\Throwable $e) {
            Log::error('Quote email failed', ['error' => $e->getMessage(), 'quote' => $data]);
        }

        $this->reset(['name', 'email', 'phone', 'company', 'product', 'size', 'quantity', 'needed_by', 'details', 'artwork_link']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.quote-form', [
            'categories' => Catalog::categories(),
        ]);
    }
}
