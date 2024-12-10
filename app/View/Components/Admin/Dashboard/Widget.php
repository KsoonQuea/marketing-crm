<?php

namespace App\View\Components\Admin\Dashboard;

use App\Models\Claim;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Widget extends Component
{
    public function render(): View
    {
        $orders = Order::query()
            ->when(request()->has('week'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfWeek()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfWeek()->toDateTimeString());
            })
            ->when(request()->has('month'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfMonth()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfMonth()->toDateTimeString());
            })
            ->when(request()->has('year'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfYear()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfYear()->toDateTimeString());
            })
            ->count();

        $users = User::query()
            ->when(request()->has('week'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfWeek()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfWeek()->toDateTimeString());
            })
            ->when(request()->has('month'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfMonth()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfMonth()->toDateTimeString());
            })
            ->when(request()->has('year'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfYear()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfYear()->toDateTimeString());
            })
            ->count();

        $claims = Claim::query()
            ->when(request()->has('week'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfWeek()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfWeek()->toDateTimeString());
            })
            ->when(request()->has('month'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfMonth()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfMonth()->toDateTimeString());
            })
            ->when(request()->has('year'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfYear()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfYear()->toDateTimeString());
            })
            ->count();

        $claimAmount = Claim::query()
            ->when(request()->has('week'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfWeek()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfWeek()->toDateTimeString());
            })
            ->when(request()->has('month'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfMonth()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfMonth()->toDateTimeString());
            })
            ->when(request()->has('year'), function ($query): void {
                $query->where('created_at', '>=', today()->startOfYear()->toDateTimeString())
                    ->where('created_at', '<=', today()->endOfYear()->toDateTimeString());
            })
            ->sum('approved_amount');

        return view('admin.dashboard.shared.widget', compact('orders', 'users', 'claims', 'claimAmount'));
    }
}
