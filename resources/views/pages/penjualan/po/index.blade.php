@extends('layout.produksi.main')

@section('title', 'Kelola PO || Penjualan')

@section('pages', 'Kelola PO')

@section('content')
<div class="container-fluid py-4">
    <div class="container ml-2">
        <!-- Add Button -->
<button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
    Add Purchase Order
</button>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor PO</th>
                                <th>Tanggal Terima PO</th>
                                <th>Nama Customer</th>
                                <th>Product</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $order)
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $index + 1 }}</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->nomor_po }}</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($order->tanggal_terima_po)->format('d M Y') }}</td>

                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->nama_customer }}</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;
                                        @foreach (json_decode($order->product, true) as $p)
                                            {{$p['product']}} => qty {{$p['qty']}} <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endforeach

                                    </td>
                                    <td>
                                        <a href="{{route('penjualan.po.edit',$order->id)}}" class="btn btn-primary">Edit</a>
                                        <!-- Delete Button that triggers the Modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Do you really want to delete the PO with number <strong>{{ $order->nomor_po }}</strong>?<br> This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <!-- The form is submitted when the user confirms the deletion -->
                                                        <form action="{{ route('penjualan.po.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Purchase Order Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('penjualan.po.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Purchase Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomor_po" class="form-label">Nomor PO</label>
                        <input type="text" style="border: 1px solid #000; outline: none;" value="{{$newPoNumber}}" class="form-control" name="nomor_po" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_penawaran" class="form-label">Tanggal Penawaran</label>
                        <input type="date" class="form-control" style="border: 1px solid #000; outline: none;" name="tanggal_penawaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_customer" class="form-label">Nama Customer</label>
                        <input type="text" style="border: 1px solid #000; outline: none;" class="form-control" name="nama_customer" required>
                    </div>
                    <div class="mb-3">
                        <label for="product" class="form-label">Product</label>
                        <div id="product-container">
                            <div class="input-group mb-3 product-row">
                                <select name="product[]" class="form-control">
                                    <option value="" disabled selected>--Pilih Product--</option>
                                    @foreach ($productList as $p)
                                        <option value="{{ $p->name }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="qty[]" class="form-control" placeholder="Quantity" min="1">
                                <button type="button" class="btn btn-danger remove-product">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
                    </div>
                    
                    <div class="mb-3">
                        <label for="no_penawaran" class="form-label">No Penawaran</label>
                        <input type="text" style="border: 1px solid #000; outline: none;" value="{{$newPenawaranNumber}}" class="form-control" name="no_penawaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="status_penawaran" class="form-label">Status Penawaran</label>
                        <input type="text" style="border: 1px solid #000; outline: none;" class="form-control" name="status_penawaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                        <input type="date" style="border: 1px solid #000; outline: none;" class="form-control" name="tanggal_permintaan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_terima_po" class="form-label">Tanggal Terima PO</label>
                        <input type="date" style="border: 1px solid #000; outline: none;" class="form-control" name="tanggal_terima_po" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_ditawarkan" class="form-label">Harga Ditawarkan</label>
                        <input type="number" style="border: 1px solid #000; outline: none;" class="form-control" name="harga_ditawarkan" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_disetujui" class="form-label">Harga Disetujui</label>
                        <input type="number" style="border: 1px solid #000; outline: none;" class="form-control" name="harga_disetujui" required>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" style="border: 1px solid #000; outline: none;" name="catatan" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Pass the product data to JavaScript
    const products = @json($productList);

    // Event listener for adding a new product row
    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('product-container');
        const productRow = document.createElement('div');
        productRow.classList.add('input-group', 'mb-3', 'product-row');
        
        // Create product dropdown
        const productSelect = document.createElement('select');
        productSelect.name = 'product[]';
        productSelect.classList.add('form-control');
        
        // Get the current selected products from all existing rows
        const selectedProducts = Array.from(document.querySelectorAll('select[name="product[]"]'))
                                      .map(select => select.value);

        // Add product options to the dropdown, excluding selected products
        products.forEach(product => {
            if (!selectedProducts.includes(product.name)) {
                const option = document.createElement('option');
                option.value = product.name;
                option.textContent = product.name;
                productSelect.appendChild(option);
            }
        });
        
        // Create quantity input
        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.name = 'qty[]';
        qtyInput.classList.add('form-control');
        qtyInput.placeholder = 'Quantity';
        qtyInput.min = '1';
        
        // Create remove button
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-danger', 'remove-product');
        removeButton.textContent = 'Remove';
        
        // Append elements to the row
        productRow.appendChild(productSelect);
        productRow.appendChild(qtyInput);
        productRow.appendChild(removeButton);
        
        // Append row to the container
        container.appendChild(productRow);
        
        // Add event listener to the remove button
        removeButton.addEventListener('click', function() {
            container.removeChild(productRow);
        });
    });
</script>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Product List</h4>
            <button class="btn btn-primary btn-sm" id="addRowBtn">+ Tambah Baris</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="editableTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Name</th>
                            <th style="width: 150px;">Status</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listProduct as $p)
                        <tr data-id="{{ $p->id }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><input type="text" class="form-control form-control-sm edit-name" value="{{ $p->name }}"></td>
                            <td>
                                <select class="form-select form-select-sm edit-status">
                                    <option value="0" {{ $p->status == 0 ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ $p->status == 1 ? 'selected' : '' }}>NonActive</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteRowBtn">&times;</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function sendUpdate(row) {
        var id = row.data('id');
        var name = row.find('.edit-name').val();
        var status = row.find('.edit-status').val();

        $.ajax({
            url: '/update-product',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                name: name,
                status: status
            },
            success: function(response) {
                console.log('Updated!');
            },
            error: function(xhr) {
                alert('Gagal update!');
            }
        });
    }

    // Update otomatis saat blur atau change
    $('#editableTable').on('blur change', '.edit-name, .edit-status', function() {
        var row = $(this).closest('tr');
        sendUpdate(row);
    });

    // Tambah baris baru
    $('#addRowBtn').click(function() {
        $.ajax({
            url: '/add-product', // route tambah produk
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // Buat baris baru
                var newRow = `
                    <tr data-id="${response.id}">
                        <td class="text-center">New</td>
                        <td><input type="text" class="form-control form-control-sm edit-name" value=""></td>
                        <td>
                            <select class="form-select form-select-sm edit-status">
                                <option value="0" selected>Active</option>
                                <option value="1">NonActive</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm deleteRowBtn">&times;</button>
                        </td>
                    </tr>
                `;
                $('#editableTable tbody').append(newRow);
            },
            error: function(xhr) {
                alert('Gagal tambah data!');
            }
        });
    });

    // Hapus baris
    $('#editableTable').on('click', '.deleteRowBtn', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');

        if (confirm('Yakin mau hapus?')) {
            $.ajax({
                url: '/delete-product',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    row.remove();
                    console.log('Deleted!');
                },
                error: function(xhr) {
                    alert('Gagal hapus!');
                }
            });
        }
    });

});
</script>


@endsection
