<?php

namespace App\Http\Controllers;

use App\Models\JobCardM;
use App\Models\Material;
use App\Models\NotifM;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function clearnotif(){
        NotifM::truncate();
        return redirect()->back()->with('success', 'Notifikasi telah dibersihkan');
    }

    public function sales(){
        $totalJobcards = JobCardM::count();

        // Total revisions (sum of `no_revisi` column)
        $totalRevisions = Material::count();

        // Monthly Jobcard Data for Chart
        $monthlyJobcards = JobCardM::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();     

        // Prepare data for Chart.js
        $monthlyJobcardLabels = $monthlyJobcards->pluck('month')->map(function ($month) {
            return \Carbon\Carbon::create()->month($month)->format('F'); // Convert month numbers to names
        });
        $monthlyJobcardData = $monthlyJobcards->pluck('count');
        return view('pages.produksi.index',compact('totalJobcards','totalRevisions','monthlyJobcardLabels',
            'monthlyJobcardData'));
        return view('pages.sales.index',compact('totalJobcards','totalRevisions','monthlyJobcardLabels',
        'monthlyJobcardData'));
    }
    public function pegawai()
    {
        // Total number of jobcards
        $totalJobcards = JobCardM::count();

        // Total revisions (sum of `no_revisi` column)
        $totalRevisions = Material::count();

        // Monthly Jobcard Data for Chart
        $monthlyJobcards = JobCardM::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();     

        // Prepare data for Chart.js
        $monthlyJobcardLabels = $monthlyJobcards->pluck('month')->map(function ($month) {
            return \Carbon\Carbon::create()->month($month)->format('F'); // Convert month numbers to names
        });
        $monthlyJobcardData = $monthlyJobcards->pluck('count');
        return view('pages.produksi.index',compact('totalJobcards','totalRevisions','monthlyJobcardLabels',
            'monthlyJobcardData'));
    }
    public function admin()
    {
        // Total number of jobcards
        $totalJobcards = JobCardM::count();

        // Total revisions (sum of `no_revisi` column)
        $totalRevisions = Material::count();

        // Monthly Jobcard Data for Chart
        $monthlyJobcards = JobCardM::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();     

        // Prepare data for Chart.js
        $monthlyJobcardLabels = $monthlyJobcards->pluck('month')->map(function ($month) {
            return \Carbon\Carbon::create()->month($month)->format('F'); // Convert month numbers to names
        });
        $monthlyJobcardData = $monthlyJobcards->pluck('count');

        return view('pages.pengadaan.index', compact(
            'totalJobcards',
            'totalRevisions',
            'monthlyJobcardLabels',
            'monthlyJobcardData'
        ));
    }

    public function direktur(){
        return view('pages.direktur.index');
    }


}
