<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $form = [
        'email' => '',
        'password' => '',

    ];
    public function submit()
    {
        $this->validate([
            'form.email' => 'required|string|email|max:255',
            'form.password' => 'required|string|min:8',
        ]);
        Auth::attempt($this->form);
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.login');
    }
}
