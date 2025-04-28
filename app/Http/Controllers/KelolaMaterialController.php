<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\NotifM;
use Illuminate\Http\Request;

class KelolaMaterialController extends Controller
{
    public function index(){
        $data = Material::all();
        return view('pages.produksi.kmaterial.index',compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Find the material by ID
        $material = Material::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'stok' => 'required|integer',
            'unit_price' => 'required|numeric',
            'buying_price' => 'required|numeric',
            'supplier' => 'required|string|max:255',
        ]);

        // Update the material with new data
        $material->update([
            'name' => $request->name,
            'stok' => $request->stok,
            'unit_price' => $request->unit_price,
            'buying_price' => $request->buying_price,
            'supplier' => $request->supplier,
        ]);

        $same = NotifM::where('material_id',$material->id)->value('id');
        $notif = NotifM::find($same);
        if($notif){
            $notif->status=1;
            $notif->save();
        } 

        // Redirect with a success message
        return redirect()->route('produksi.kmaterial')->with('success', 'Material updated successfully.');
    }

    // Delete the material data
    public function destroy($id)
    {
        // Find the material by ID and delete it
        $material = Material::findOrFail($id);
        $material->delete();

        // Redirect with a success message
        return redirect()->route('produksi.kmaterial')->with('success', 'Material deleted successfully.');
    }

    public function store(Request $request)
{
    // Validate the form input
    $request->validate([
        'name' => 'required|string|max:255',
        'stok' => 'required|integer',
        'unit_price' => 'required|numeric',
        'buying_price' => 'required|numeric',
        'supplier' => 'required|string|max:255',
    ]);

    // Create a new material record
    Material::create([
        'name' => $request->name,
        'stok' => $request->stok,
        'unit_price' => $request->unit_price,
        'buying_price' => $request->buying_price,
        'supplier' => $request->supplier,
    ]);

    // Redirect with success message
    return redirect()->route('produksi.kmaterial')->with('success', 'New material added successfully.');
}

}
