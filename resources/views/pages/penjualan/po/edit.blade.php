@extends('layout.produksi.main')
@section('title', 'Edit PO || Penjualan')

@section('pages', 'Edit PO - ' . $order->nomor_po)

@section('content')
<div class="container-fluid py-4">

    <div class="container">
        <h3>Edit Purchase Order - {{ $order->nomor_po }}</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('penjualan.po.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_po" class="form-label">Nomor PO</label>
                                <input type="text" class="form-control" name="nomor_po" value="{{ $order->nomor_po }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="tanggal_penawaran" class="form-label">Tanggal Penawaran</label>
                                <input type="date" class="form-control" name="tanggal_penawaran" value="{{ $order->tanggal_penawaran }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="nama_customer" class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" name="nama_customer" value="{{ $order->nama_customer }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="no_penawaran" class="form-label">No Penawaran</label>
                                <input type="text" class="form-control" name="no_penawaran" value="{{ $order->no_penawaran }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" name="catatan" rows="3">{{ $order->catatan }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_penawaran" class="form-label">Status Penawaran</label>
                                <input type="text" class="form-control" name="status_penawaran" value="{{ $order->status_penawaran }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                                <input type="date" class="form-control" name="tanggal_permintaan" value="{{ $order->tanggal_permintaan }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="tanggal_terima_po" class="form-label">Tanggal Terima PO</label>
                                <input type="date" class="form-control" name="tanggal_terima_po" value="{{ $order->tanggal_terima_po }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="harga_ditawarkan" class="form-label">Harga Ditawarkan</label>
                                <input type="number" class="form-control" name="harga_ditawarkan" value="{{ $order->harga_ditawarkan }}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="harga_disetujui" class="form-label">Harga Disetujui</label>
                                <input type="number" class="form-control" name="harga_disetujui" value="{{ $order->harga_disetujui }}" required>
                            </div>
        
                        </div>
                    </div>
                    
                    <!-- Dynamic Product and Quantity Fields -->
                    <div id="product-fields-container">
                        @foreach(json_decode($order->product, true) as $index => $product)
                            <div class="mb-3 product-field" data-index="{{ $index }}">
                                <label for="product_{{ $index }}" class="form-label">Product</label>
                                <select name="products[{{ $index }}][product]" id="product_{{ $index }}" class="form-control">
                                    <option value="" disabled>--Pilih Product--</option>
                                    @foreach ($productList as $p)
                                        <option value="{{ $p->name }}" 
                                            @if ($product['product'] == $p->name) selected @endif>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="qty_{{ $index }}" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="products[{{ $index }}][qty]" value="{{ $product['qty'] }}" required>
                                <button type="button" class="btn btn-danger remove-product" onclick="removeProduct({{ $index }})">Remove</button>
                            </div>
                        @endforeach

                    </div>

                    <button type="button" class="btn btn-success" id="add-product">Add Product</button>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('penjualan.po') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Track selected products
    let selectedProducts = @json(json_decode($order->product, true)).map(product => product.product);

    document.getElementById('add-product').addEventListener('click', function() {
    let container = document.getElementById('product-fields-container');
    let index = container.children.length;
    let newProductField = `
        <div class="mb-3 product-field" data-index="${index}">
            <label for="product_${index}" class="form-label">Product</label>
            <select name="products[${index}][product]" id="product_${index}" class="form-control">
                <option value="" disabled>--Pilih Product--</option>
                @foreach ($productList as $p)
                    <option value="{{ $p->name }}">{{ $p->name }}</option>
                @endforeach
            </select>
            <label for="qty_${index}" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="products[${index}][qty]" required>
            <button type="button" class="btn btn-danger remove-product" onclick="removeProduct(${index})">Remove</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newProductField);
});


    // Remove product field
    function removeProduct(index) {
        let productField = document.querySelector(`.product-field[data-index="${index}"]`);
        productField.remove();
        updateProductSelection();
    }

    // Update the product options to disable already selected ones
    function updateProductSelection() {
        // Get all the select elements
        let selects = document.querySelectorAll('.product-select');
        
        // Disable already selected products
        selects.forEach(select => {
            let selectedProduct = select.value;
            selectedProducts.push(selectedProduct);
            select.querySelectorAll('option').forEach(option => {
                if (selectedProducts.includes(option.value)) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    // Initialize the product selection state when the page loads
    updateProductSelection();
</script>
@endsection
