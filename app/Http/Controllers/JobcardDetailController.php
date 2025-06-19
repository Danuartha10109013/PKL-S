<?php

namespace App\Http\Controllers;

use App\Models\JobCardDetailM;
use App\Models\JobCardM;
use App\Models\Material;
use App\Models\NotifM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobcardDetailController extends Controller
{
    public function add($id){
        $mt = Material::all();

    // Kelompokkan berdasarkan nama
    $grouped = $mt->groupBy('name');

    // Proses penamaan ulang jika ada nama yang sama
    $material = $mt->map(function ($item) use ($grouped) {
        if ($grouped[$item->name]->count() > 1) {
            // Tambahkan nama supplier jika nama material duplikat
            $item->name = $item->name . ' (' . $item->supplier . ')';
        }
        return $item;
    });
        return view('pages.pengadaan.job_card.add',compact('material','id'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        // Validate incoming request data
       $request->validate([
            'qty' => 'required|integer|min:1|max:5000',
            'description' => 'required|string|max:255',
            'unit_bop' => 'required|numeric|min:0|max:99999999999',
            'total_bop' => 'required|numeric|min:0|max:99999999999',
            'unit_sp' => 'required|numeric|min:0|max:99999999999',
            'total_sp' => 'required|numeric|min:0|max:99999999999',
            'unit_bp' => 'required|numeric|min:0|max:99999999999',
            'total_bp' => 'required|numeric|min:0|max:99999999999',
            'supplier' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Store the data in the database (assuming you have a JobCardDetail model)
        $jobcard = new JobCardDetailM();
        $jobcard->jobcard_id = $request->job_card_id;
        $jobcard->qty = $request->qty;
        $jobcard->description = $request->description;
        $jobcard->unit_bop = $request->unit_bop;
        $jobcard->total_bop = $request->total_bop;
        $jobcard->unit_sp = $request->unit_sp;
        $jobcard->total_sp = $request->total_sp;
        $jobcard->unit_bp = $request->unit_bp; // Corrected this line
        $jobcard->total_bp = $request->total_bp;
        $jobcard->supplier = $request->supplier;
        $jobcard->remarks = $request->remarks;
        $jobcard->save();

        $material = Material::find($request->id);
        $material->stok = $material->stok - $request->qty;
        // dd($material->stok);
        $material->save();

        $jc = JobCardM::find($request->job_card_id);
        $jc->totalbop = $jc->totalbop + $request->total_bop;
        $jc->totalsp = $jc->totalsp + $request->total_sp;
        $jc->totalbp = $jc->totalbp + $request->total_bp;
        $jc->save();
    
        // Redirect back with a success message
        return redirect()->route('pengadaan.jobcard')->with('success', 'Job card detail added successfully!');
    }
    
    public function addPengadaan($id,$qty,$prd){
        $data = JobCardM::find($id);
        // dd($data);  
        $material = Material::find($prd);
        $notif = new NotifM();
        $notif->judul = 'Pengadaan '.$material->name;
        $notif->no_jobcard = $data->no_jobcard;
        $notif->jumlah_pengadaan = $qty;
        $notif->user_id = Auth::user()->id;
        $notif->material_id = $material->id;
        $notif->save();
        return redirect()->back()->with('success','Pengadaan telah Diajukan');
    }
}
