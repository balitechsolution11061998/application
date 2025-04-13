<?php

namespace App\Http\Controllers;

use App\Models\DataKependudukan;
use Illuminate\Http\Request;

class DashboardDataKependudukanController extends Controller
{
    //
    public function index()
    {
        $totalPenduduk = DataKependudukan::count();
        $totalLaki = DataKependudukan::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = DataKependudukan::where('jenis_kelamin', 'P')->count();
        $totalKtpElektronik = DataKependudukan::where('ktp_elektronik', 1)->count();
        
        // Distribusi usia
        $distribusiUsia = [
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 19')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 30')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 31 AND 45')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 46 AND 60')->count(),
            DataKependudukan::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60')->count()
        ];
        
        // Status kawin
        $statusKawin = DataKependudukan::selectRaw('status_kawin, COUNT(*) as total')
            ->groupBy('status_kawin')
            ->pluck('total', 'status_kawin')
            ->toArray();
        
        $penduduk = DataKependudukan::orderBy('nama')->paginate(10);
        
        return view('dashboard.kependudukan.index', compact(
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'totalKtpElektronik',
            'distribusiUsia',
            'statusKawin',
            'penduduk'
        ));
    }
}
