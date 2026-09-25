<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $data = [
            'spkMenunggu' => Order::where('status', 'MenungguVerifikasi')->count(),
            'leadsBaru' => Lead::where('status', 'Baru')->count(),
            'servisAktif' => ServiceBooking::whereIn('status', ['Menunggu', 'Dikonfirmasi', 'Dikerjakan'])->count(),
            'unitTersedia' => Unit::tersedia()->count(),
        ];

        if ($user->hasRole('sales')) {
            $data['leadsSaya'] = Lead::where('sales_id', $user->id)->whereNotIn('status', ['Deal', 'Batal'])->count();
            $data['followupJatuh'] = Lead::where('sales_id', $user->id)->whereNotNull('followup_at')->where('followup_at', '<=', now()->addDay())->count();
        }

        if ($user->hasRole('mekanik')) {
            $data['tugasSaya'] = ServiceBooking::where('mekanik_id', $user->id)->whereIn('status', ['Dikonfirmasi', 'Dikerjakan'])->count();
        }

        if (!$user->roles()->exists()) {
            $data['spkSaya'] = Order::whereHas('customer', fn ($q) => $q->where('user_id', $user->id))->count();
        }

        $data['spkTerbaru'] = Order::with(['customer', 'unit.variant'])->latest()->limit(5)->get();

        return view('dashboard', $data);
    }
}
