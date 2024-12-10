<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function view;

class AppLayout extends Component
{
    public $custom_errors;

    public function __construct($customErrors="")
    {
        $this->custom_errors = $customErrors;
    }

    public function render(): Factory|View
    {
        // dd("Shibah");

        return view('layouts.admin.app');
    }
}
