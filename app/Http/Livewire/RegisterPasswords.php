<?php

namespace App\Http\Livewire;

use ZxcvbnPhp\Zxcvbn;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegisterPasswords extends Component
{
    public string $password = '';

    public string $passwordConfirmation = '';

    public int $strengthScore = 0;

    public array $strengthLevels = [
        1 => 'Week',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Strong'
    ];

    public function updatedPassword($value)
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    public function generatePassword()
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $digit = range(0, 9);
        $specials = ['!', '@', '#', '$', '%', '^', '&', '*'];
        $chars = array_merge($lowercase, $uppercase, $digit, $specials);
        $length = 12;
        do {
            $password = [];
            for ($i = 0; $i <= $length; $i++) {
                $int = rand(0, count($chars) - 1);
                $password[] = $chars[$int];
            }
        } while (empty(array_intersect($specials, $password)));
        $this->setPasswords(implode('', $password));
    }

    public function setPasswords($value)
    {
        $this->password = $value;
        $this->passwordConfirmation = $value;
        $this->updatedPassword($value);
    }

    public function render()
    {
        return view('livewire.register-passwords');
    }
}
