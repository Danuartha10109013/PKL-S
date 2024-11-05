<?php

namespace App\Http\Controllers;

use App\Models\JobCardDetailM;
use App\Models\JobCardM;
use App\Models\Material;
use Illuminate\Http\Request;

class JobcardDetailController extends Controller
{
    public function add($id){
        $material = Material::all();
        return view('pages.admin.job_card.add',compact('material','id'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        // Validate incoming request data
        $validatedData = $request->validate([
            'qty' => 'required|integer',
            'description' => 'required|string|max:255',
            'unit_bop' => 'required|numeric',
            'total_bop' => 'required|numeric',
            'unit_sp' => 'required|numeric',
            'total_sp' => 'required|numeric',
            'unit_bp' => 'required|numeric',
            'total_bp' => 'required|numeric',
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
        return redirect()->route('admin.jobcard')->with('success', 'Job card detail added successfully!');
    }
    
    public function addPengadaan($id){
        // dd($id);
        return redirect()->back()->with('success','Pengadaan telah Diajukan');
    }
}
