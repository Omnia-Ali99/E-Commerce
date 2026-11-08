<?php

namespace App\Livewire\Website;

use App\Models\Admin;
use App\Models\Contact;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Notification;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5',
        ];
    }

    public function updated($field): void
    {
        $this->validateOnly($field);
    }

    public function submitContactForm()
    {
        $this->validate();

        $contact = Contact::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_read' => false,
        ]);


        if (!$contact) {
            $this->dispatch('contact-form-submitted', __('website.try_again_latter'));
        }
        // send contact notification to all admins
        $admins = Admin::all();
        Notification::send($admins, new ContactNotification($contact));

        $this->reset('name', 'email', 'phone', 'subject', 'message');
        $this->dispatch('contact-form-submitted', __('website.contact_stored_successfully'));
    }

    public function render()
    {
        return view('livewire.website.contact-form');
    }
}