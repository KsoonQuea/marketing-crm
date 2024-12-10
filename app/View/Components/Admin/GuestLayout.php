<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('layouts.admin.guest');
    }
}
