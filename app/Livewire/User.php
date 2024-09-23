<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Users')]




class User extends Component
{

    public \App\Models\User $user;

    public function render()
    {
        return view('livewire.user')->title('User: '. $this->user->name);
    }

}
