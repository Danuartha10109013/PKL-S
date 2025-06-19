<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\NotifM;
use Illuminate\Http\Request;

class KelolaMaterialController extends Controller
{
    public function index(){
    $materials = Material::all();

    // Kelompokkan berdasarkan nama
    $grouped = $materials->groupBy('name');

    // Proses penamaan ulang jika ada nama yang sama
    $data = $materials->map(function ($item) use ($grouped) {
        if ($grouped[$item->name]->count() > 1) {
            // Tambahkan nama supplier jika nama material duplikat
            $item->name = $item->name . ' (' . $item->supplier . ')';
        }
        return $item;
    });

    return view('pages.produksi.kmaterial.index', compact('data'));
}


    public function update(Request $request, $id)
    {
        // Find the material by ID
        $material = Material::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'stok' => 'required|integer|min:1|max:5000',
            'unit_price' => 'required|numeric|min:1|max:2147483647',
            'buying_price' => 'required|numeric|min:1|max:2147483647',
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
        'stok' => 'required|integer|min:1|max:5000',
        'unit_price' => 'required|numeric|min:1|max:2147483647',
        'buying_price' => 'required|numeric|min:1|max:2147483647',
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

    $notif = NotifM::where('judul', 'like', "%$request->name%")->first();
    if($notif){
        $notif->delete();
    }
    // Redirect with success message
    return redirect()->route('produksi.kmaterial')->with('success', 'New material added successfully.');
}

}
