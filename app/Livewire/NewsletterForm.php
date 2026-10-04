<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterForm extends Component
{
    #[Validate('required|email|max:160')]
    public string $email = '';

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate();
        Subscriber::firstOrCreate(['email' => strtolower($this->email)]);

        try {
            Mail::raw("New newsletter subscriber: {$this->email}", fn ($m) => $m
                ->to(config('site.email'))
                ->subject('Newsletter signup'));
        } catch (\Throwable $e) {
            Log::error('Newsletter email failed', ['error' => $e->getMessage(), 'email' => $this->email]);
        }

        $this->subscribed = true;
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
