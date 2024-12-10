<?php

namespace App\View\Components\Admin\Dashboard;

use App\Models\Claim;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PendingApprove extends Component
{
    public function render(): View
    {
        $pendingApprove = Claim::pending()->get();

        return view('admin.dashboard.shared.pending-approve', compact('pendingApprove'));
    }
}
