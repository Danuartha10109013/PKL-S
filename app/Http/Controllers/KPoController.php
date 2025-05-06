<?php

namespace App\Http\Controllers;

use App\Models\NotifM;
use App\Models\NotifPengadaanM;
use App\Models\POM;
use App\Models\ProductM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KPoController extends Controller
{

    public function updateProduct(Request $request)
    {
        $product = ProductM::find($request->id);
        if (!$product) return response()->json(['error' => 'Product not found'], 404);
    
        $product->name = $request->name;
        $product->status = $request->status;
        $product->save();
    
        return response()->json(['success' => true]);
    }

    public function po_detail($id){
        
    }
    
    public function addProduct(Request $request)
    {
        $product = ProductM::create([
            'name' => '',
            'status' => 0
        ]);
    
        return response()->json(['id' => $product->id]);
    }
    
    public function deleteProduct(Request $request)
    {
        $product = ProductM::find($request->id);
        if (!$product) return response()->json(['error' => 'Product not found'], 404);
    
        $product->delete();
    
        return response()->json(['success' => true]);
    }
    


    public function search(Request $request)
    {
        $query = $request->get('term');
        $poList = POM::where('nomor_po', 'LIKE', '%' . $query . '%')->get();

        return response()->json($poList);
    }

    // Menangani pengambilan detail PO berdasarkan nomor PO yang dipilih
    public function getPoDetails($nomor_po)
    {
        $po = POM::where('nomor_po', $nomor_po)->first();

        if ($po) {
            return response()->json([
                'nama_customer' => $po->nama_customer,
                'tanggal_terima_po' => $po->tanggal_terima_po,
                'tanggal_permintaan' => $po->tanggal_permintaan,
            ]);
        }

        return response()->json([], 404);
    }

    public function index(){
        $data = POM::orderBy('created_at', 'desc')->get();
        $productList =ProductM::where('status', 0)->get();
        $listProduct =ProductM::all();
        $currentDate = Carbon::now()->format('Y-m-d');

        // Check if the last PO number for the current date exists
        $lastPo = POM::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->first();
    
        // If a PO exists for the current day, increment the unique number
        if ($lastPo) {
            // Extract the last unique number (last 2 digits) from the last PO number
            preg_match('/(\d{2})$/', $lastPo->nomor_po, $matches);
    
            // Increment the unique number (e.g., from 01 to 02)
            $newUniqueNumber = str_pad((int)$matches[0] + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // If no PO exists for today, start with 01
            $newUniqueNumber = '01';
        }
    
        // Generate the new PO number
        $newPoNumber = 'PO/' . Carbon::now()->format('Y-m') . '/' . $newUniqueNumber;

       
        return view('pages.penjualan.po.index',compact('listProduct','data','productList', 'newPoNumber'));
    }

    public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'nomor_po' => 'required',
        'tanggal_penawaran' => 'required|date',
        'nama_customer' => 'required',
        'product' => 'required|array',
        'product.*' => 'required|string',
        'qty' => 'required|array',
        'qty.*' => 'required|integer|min:1',
        // 'no_penawaran' => 'required',
        'status_penawaran' => 'required',
        'tanggal_permintaan' => 'required|date',
        'tanggal_terima_po' => 'required|date',
        'harga_ditawarkan' => 'required|numeric',
        'harga_disetujui' => 'required|numeric',
        'catatan' => 'nullable|string',
    ]);

    // Combine 'product' and 'qty' arrays into a JSON structure
    $productsWithQty = [];
    foreach ($request->product as $index => $product) {
        $productsWithQty[] = [
            'product' => $product,
            'qty' => $request->qty[$index],
        ];
    }
    // dd(json_encode($productsWithQty));
    // Create the Purchase Order (PO) record with JSON data
    $po = POM::create([
        'nomor_po' => $request->nomor_po,
        'tanggal_penawaran' => $request->tanggal_penawaran,
        'nama_customer' => $request->nama_customer,
        // 'no_penawaran' => $request->no_penawaran,
        'status_penawaran' => $request->status_penawaran,
        'tanggal_permintaan' => $request->tanggal_permintaan,
        'tanggal_terima_po' => $request->tanggal_terima_po,
        'harga_ditawarkan' => $request->harga_ditawarkan,
        'harga_disetujui' => $request->harga_disetujui,
        'catatan' => $request->catatan,
        'product' => json_encode($productsWithQty),  // Store the products and qty as JSON
    ]);

    $notif = new NotifPengadaanM(); // Membuat instance baru dari model NotifPengadaanM
    $notif->title = "PO Baru terdeteksi"; // Mengisi kolom 'title' dengan teks "PO Baru terdeteksi"
    $notif->value = "PO dengan nomor ".$request->nomor_po; // Mengisi kolom 'value' dengan teks berisi nomor PO dari request
    $notif->pengirm_id = Auth::user()->id; // Mengisi kolom 'pengirim_id' dengan ID user yang sedang login
    $notif->status = 0; // Menetapkan status notifikasi ke 0 (mungkin berarti 'belum dibaca' atau 'baru')
    $notif->po_id = $po->id; // Menetapkan status notifikasi ke 0 (mungkin berarti 'belum dibaca' atau 'baru')
    $notif->save(); // Menyimpan data notifikasi ke database


    return back()->with('success', 'Purchase Order added successfully.');
}

    
public function edit($id)
{
    $order = POM::findOrFail($id);
    $productList = ProductM::all();  // Fetch all products if needed for the dropdown

    return view('pages.penjualan.po.edit', compact('order', 'productList'));
}



public function update(Request $request, $id)
{
    // dd($request->all());
    // Validate the incoming data
    $validated = $request->validate([
        'nomor_po' => 'required|string|max:255',
        'tanggal_penawaran' => 'required|date',
        'nama_customer' => 'required|string|max:255',
        // 'no_penawaran' => 'required|string|max:255',
        'catatan' => 'nullable|string',
        'status_penawaran' => 'required|string|max:255',
        'tanggal_permintaan' => 'required|date',
        'tanggal_terima_po' => 'required|date',
        'harga_ditawarkan' => 'required|numeric',
        'harga_disetujui' => 'required|numeric',
        'products' => 'required|array',
        'products.*.product' => 'required|string',
        'products.*.qty' => 'required|numeric',
    ]);

    // dd($validated);

    // Find the order by ID
    $order = POM::findOrFail($id);

   // Prepare products for saving
$products = [];
foreach ($request->input('products') as $product) {
    $products[] = [
        'product' => $product['product'],
        'qty' => $product['qty'],
    ];
}

// Update the order
$order->update([
    'nomor_po' => $request->input('nomor_po'),
    'tanggal_penawaran' => $request->input('tanggal_penawaran'),
    'nama_customer' => $request->input('nama_customer'),
    // 'no_penawaran' => $request->input('no_penawaran'),
    'catatan' => $request->input('catatan'),
    'status_penawaran' => $request->input('status_penawaran'),
    'tanggal_permintaan' => $request->input('tanggal_permintaan'),
    'tanggal_terima_po' => $request->input('tanggal_terima_po'),
    'harga_ditawarkan' => $request->input('harga_ditawarkan'),
    'harga_disetujui' => $request->input('harga_disetujui'),
    'product' => json_encode($products),  // Store products as JSON
]);

    // Redirect back with a success message
    return redirect()->route('penjualan.po')
                     ->with('success', 'PO updated successfully!');
}


    public function destroy($id)
    {
        $purchaseOrder = POM::findOrFail($id);
        $purchaseOrder->delete();

        return back()->with('success', 'Purchase Order deleted successfully.');
    }
}
