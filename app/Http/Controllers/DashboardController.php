<?php

namespace App\Http\Controllers;

use App\Models\JobCardM;
use App\Models\Material;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
        return view('pages.pegawai.index',compact('totalJobcards','totalRevisions','monthlyJobcardLabels',
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

        return view('pages.admin.index', compact(
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
