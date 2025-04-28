@extends('layout.produksi.main')
@section('title')
    Kelola Material || {{ Auth::user()->name }}
@endsection
@section('pages')
Kelola Material
@endsection
@section('content')
<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
  <i class="material-icons text-white">add</i> Add Material
</a>
<div class="container-fluid py-2">
    <div class="row">
      <div class="card">
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Stok</th>
                    <th>Unit Price</th>
                    <th>Buying Price</th>
                    <th>Supplier</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $d)
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; {{ $loop->iteration }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->name }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->stok }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->unit_price }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->buying_price }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->supplier }}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;
                      <div style="margin-top: -25px" class="d-flex justify-content-center">
                        <!-- Edit Button Trigger -->
                        <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $d->id }}">
                            <i class="material-icons text-warning">edit</i>
                        </a>
                        <!-- Delete Button Trigger -->
                        <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $d->id }}">
                            <i class="material-icons text-danger">delete</i>
                        </a>
                      </div>
                    </td>
                  </tr>

                  <!-- Edit Modal -->
                  <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Edit Material</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ route('produksi.kmaterial.update', $d->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                              <label for="name" class="form-label">Description</label>
                              <input type="text" class="form-control" id="name" name="name" value="{{ $d->name }}">
                            </div>
                            <div class="mb-3">
                              <label for="stok" class="form-label">Stok</label>
                              <input type="number" class="form-control" id="stok" name="stok" value="{{ $d->stok }}">
                            </div>
                            <div class="mb-3">
                              <label for="unit_price" class="form-label">Unit Price</label>
                              <input type="text" class="form-control" id="unit_price" name="unit_price" value="{{ $d->unit_price }}">
                            </div>
                            <div class="mb-3">
                              <label for="buying_price" class="form-label">Buying Price</label>
                              <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ $d->buying_price }}">
                            </div>
                            <div class="mb-3">
                              <label for="supplier" class="form-label">Supplier</label>
                              <input type="text" class="form-control" id="supplier" name="supplier" value="{{ $d->supplier }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this material?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <form action="{{ route('produksi.kmaterial.destroy', $d->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>    
    </div>
</div>
<!-- Add Material Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Add New Material</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('produksi.kmaterial.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                      <label for="name" class="form-label">Description</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                  <div class="mb-3">
                      <label for="stok" class="form-label">Stock</label>
                      <input type="number" class="form-control" id="stok" name="stok" required>
                  </div>
                  <div class="mb-3">
                      <label for="unit_price" class="form-label">Unit Price</label>
                      <input type="text" class="form-control" id="unit_price" name="unit_price" required>
                  </div>
                  <div class="mb-3">
                      <label for="buying_price" class="form-label">Buying Price</label>
                      <input type="text" class="form-control" id="buying_price" name="buying_price" required>
                  </div>
                  <div class="mb-3">
                      <label for="supplier" class="form-label">Supplier</label>
                      <input type="text" class="form-control" id="supplier" name="supplier" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Add Material</button>
              </form>
          </div>
      </div>
  </div>
</div>

@endsection
