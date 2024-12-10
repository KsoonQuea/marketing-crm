<?php

namespace App\View\Components\User;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function view;

class AppLayout extends Component
{
    public function render(): Factory|View
    {
        return view('layouts.user.app');
    }
}
