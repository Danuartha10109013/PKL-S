<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCard; // Ensure you have this model for Job Card
use App\Models\JobCardDetailM;
use App\Models\JobCardM;
use App\Models\Material;
use App\Models\POM;
use Illuminate\Support\Facades\Validator;

class JobCardController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // Fetch job cards, filtered by search if provided
    $jobCards = JobCardM::when($search, function($query, $search) {
        return $query->where('no_jobcard', 'like', "%{$search}%")
                     ->orWhere('customer_name', 'like', "%{$search}%");
    })->paginate(10); // Modify pagination as needed

    $orders = []; 
    $datePrefix = 'JC.' . now()->format('dmY'); 
    $lastJobCard = JobCardM::where('no_jobcard', 'like', "$datePrefix%")
        ->orderBy('no_jobcard', 'desc')
        ->first();
    
    // Ambil tahun saat ini
    $currentYear = date('Y');

    // Cari job card terakhir yang dibuat di tahun ini
    $lastJobCard = JobCardM::whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();

    if ($lastJobCard) {
        // Ambil 3 digit terakhir dari nomor jobcard terakhir
        $lastNumber = (int) substr($lastJobCard->no_jobcard, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada, mulai dari 001
        $newNumber = '001';
    }

    // Format nomor jobcard
    $noJobCard = 'JC.' . date('dmY') . '-' . $newNumber;

    $newJobCard = $noJobCard; 
    
    $material = Material::all();

    // Chart data preparation
    $monthlyTotals = JobCardM::whereYear('created_at', $currentYear)
        ->selectRaw('MONTH(created_at) as month, SUM(totalsp) as totalsp')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Prepare chart data
    $chartLabels = [];
    $chartData = [];

    foreach ($monthlyTotals as $total) {
        $chartLabels[] = \Carbon\Carbon::create()->month($total->month)->format('F'); // Get month name
        $chartData[] = $total->totalsp;
    }

    $currentMonth = now()->month; // Returns current month as integer (1-12)
    $sumJobcard = JobCardM::whereMonth('created_at', $currentMonth)->count();

    // dd($sumJobcard);
    $po = POM::all();
    return view('pages.pengadaan.job_card.index', compact('po','jobCards','sumJobcard', 'orders', 'material', 'newJobCard', 'chartLabels', 'chartData'));
}


    // Show the form for creating a new job card
    public function create()
    {
        return view('jobcard.create'); // Create a form view if necessary
    }

    // Store a newly created job card
    public function store(Request $request)
    {
        // dd($request->all());
        // Validation
        $validator = Validator::make($request->all(), [
            'no_jobcard' => 'required|string|max:255|unique:jobcard',
            'date' => 'required|date',
            'kurs' => 'required|numeric',
            'customer_name' => 'required|string|max:255',
            'nomor_po' => 'required|string|max:255',
            'tanggal_permintaan' => 'required|date',
            'tanggal_terima_po' => 'required|date',
            // 'totalbop' => 'required|numeric',
            // 'totalsp' => 'required|numeric',
            // 'totalbp' => 'required|numeric',
            'no_form' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'no_revisi' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new Job Card
        $jobCard = new JobCardM();
        $jobCard->no_jobcard = $request->no_jobcard;
        $jobCard->date = $request->date;
        $jobCard->kurs = $request->kurs;
        $jobCard->customer_name = $request->customer_name;
        $jobCard->no_po = $request->nomor_po;
        $jobCard->po_date = $request->tanggal_permintaan;
        $jobCard->po_received = $request->tanggal_terima_po;
        $jobCard->totalbop = $request->totalbop;
        $jobCard->totalsp = $request->totalsp;
        $jobCard->totalbp = $request->totalbp;
        $jobCard->no_form = $request->no_form;
        $jobCard->effective_date = $request->effective_date;
        $jobCard->no_revisi = $request->no_revisi;
        $jobCard->save();

        return redirect()->route('pengadaan.jobcard')->with('success', 'Job Card added successfully!');
    }

    // Show a specific job card
    public function show($id)
    {
        $jobCard = JobCardM::findOrFail($id);

        return view('jobcard.show', compact('jobCard'));
    }

    // Show the form for editing a job card
    public function edit($id)
    {
        $jobCard = JobCardM::findOrFail($id);

        return view('jobcard.edit', compact('jobCard'));
    }

    // Update a job card
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validation
        $validator = Validator::make($request->all(), [
            'no_jobcard' => 'required|string|max:255',
            'date' => 'required|date',
            'kurs' => 'required|numeric',
            'customer_name' => 'required|string|max:255',
            'no_po' => 'required|string|max:255',
            'po_date' => 'required|date',
            'po_received' => 'required|date',
            'totalbop' => 'required|numeric',
            'totalsp' => 'required|numeric',
            'totalbp' => 'required|numeric',
            'no_form' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'no_revisi' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update Job Card
        $jobCard = JobCardM::findOrFail($id);
        $jobCard->no_jobcard = $request->no_jobcard;
        $jobCard->date = $request->date;
        $jobCard->kurs = $request->kurs;
        $jobCard->customer_name = $request->customer_name;
        $jobCard->no_po = $request->no_po;
        $jobCard->po_date = $request->po_date;
        $jobCard->po_received = $request->po_received;
        $jobCard->totalbop = $request->totalbop;
        $jobCard->totalsp = $request->totalsp;
        $jobCard->totalbp = $request->totalbp;
        $jobCard->no_form = $request->no_form;
        $jobCard->effective_date = $request->effective_date;
        $jobCard->no_revisi = $request->no_revisi;
        $jobCard->save();

        return redirect()->route('pengadaan.jobcard')->with('success', 'Job Card updated successfully!');
    }

    // Delete a job card
    public function destroy($id)
    {
        // dd($id);
        $jobCard = JobCardM::findOrFail($id);
        $loop = JobCardDetailM::where('jobcard_id',$id)->get();
        foreach($loop as $l){
            $same = JobCardDetailM::where('jobcard_id',$l->jobcard_id)->value('id');
            $materi = JobCardDetailM::findOrFail($same);
            $materi->delete();
        }
        $jobCard->delete();

        return redirect()->route('pengadaan.jobcard')->with('success', 'Job Card deleted successfully!');
    }

    public function print($id){

        $data = JobCardM::find($id);
        $detail = JobCardDetailM::where('jobcard_id',$data->id)->get();
        return view('pages.pengadaan.job_card.print',compact('data','detail'));
    }

    public function material($id){
        $data = JobCardM::find($id);
        $detail = JobCardDetailM::where('jobcard_id',$data->id)->get();

        return view('pages.pengadaan.job_card.material',compact('data','detail'));
    }

    public function material_delete($id){
        $data = JobCardDetailM::find($id);
        $jobcard = JobCardM::find($data->jobcard_id);
        $jobcard->totalbop = $jobcard->totalbop -$data->total_bop;
        $jobcard->totalbp = $jobcard->totalbp - $data->total_bp;
        $jobcard->totalsp = $jobcard->totalsp - $data->total_sp;
        $jobcard->save();
        $data->delete();

        return redirect()->back()->with('success','Item Telah berhasil dihapus');
    }
}

