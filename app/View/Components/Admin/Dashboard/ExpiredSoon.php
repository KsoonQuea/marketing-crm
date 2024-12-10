<?php

namespace App\View\Components\Admin\Dashboard;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExpiredSoon extends Component
{
    public function render(): View
    {
        $expiredSoonOrder = Order::query()
            ->where('status', 2)
            ->where('expired_date', '>=', today()->startOfMonth()->toDateTimeString())
            ->where('expired_date', '<=', today()->addMonth()->endOfMonth()->toDateTimeString())
            ->get();

        return view('admin.dashboard.shared.expired-soon', compact('expiredSoonOrder'));
    }
}
