<?php

namespace App\View\Components\Admin\Dashboard;

use App\Models\PaymentHistory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SalesChart extends Component
{
    public function render(): View
    {
        $request = request();
        $labels = collect([])->toJson(1);
        $data = collect([])->toJson(1);
        if ($request->has('week')) {
            $labels = collect(range(1, 7))
                ->map(function ($day) {
                    return today()->startOfWeek()->addDays($day - 1)->format('Y-m-d');
                });
            $data = PaymentHistory::selectRaw('SUM(amount) as total_amount, DATE(payment_date) as payment_date')
                ->groupByRaw('DATE(payment_date)')
                ->pluck('total_amount', 'payment_date')
                ->all();
            $data = $labels->map(function ($label) use ($data) {
                return $data[$label] ?? 0;
            })->toJson(1);
            $labels = $labels->toJson(1);
        }
        if ($request->has('month')) {
            $labels = collect(range(1, today()->startOfMonth()->daysInMonth))
                ->map(function ($day) {
                    return today()->startOfMonth()->addDays($day - 1)->format('Y-m-d');
                });
            $data = PaymentHistory::selectRaw('SUM(amount) as total_amount, DATE(payment_date) as payment_date')
                ->groupByRaw('DATE(payment_date)')
                ->pluck('total_amount', 'payment_date')
                ->all();
            $data = $labels->map(function ($label) use ($data) {
                return $data[$label] ?? 0;
            })->toJson(1);
            $labels = $labels->toJson(1);
        }
        if ($request->has('year')) {
            $labels = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
            $data = PaymentHistory::selectRaw('SUM(amount) as total_amount, MONTH(payment_date) as payment_date')
                ->groupByRaw('MONTH(payment_date)')
                ->pluck('total_amount', 'payment_date')
                ->all();
            $data = $labels->map(function ($label) use ($data) {
                return $data[$label] ?? 0;
            })->toJson(1);

            $labels = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->toJson(1);
        }


        return view('admin.dashboard.shared.sales-chart', compact('data', 'labels'));
    }
}
