<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class Register extends Component
{
    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];
    public function submit()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|string|email|max:255',
            'form.password' => 'required|string|min:8|confirmed',
        ]);
        User::create($this->form);
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.register');
    }
}
