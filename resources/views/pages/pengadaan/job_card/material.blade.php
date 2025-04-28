@extends('layout.produksi.main')

@section('title')
    {{ Auth::user()->role == 0 ? 'Job Card || Admin' : 'Job Card || Pegawai' }}
@endsection

@section('pages')
    Kelola Material || {{ $data->no_jobcard }}
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <style>
                            th.text-align-center {
                                text-align: center;
                                vertical-align: middle; /* Centers vertically */
                            }
                        </style>
                        <tr>
                            <th class="text-align-center" rowspan="2">NO</th>
                            <th class="text-align-center" rowspan="2">Qty</th>
                            <th class="text-align-center" rowspan="2">Description</th>
                            <th class="text-align-center" colspan="2">Bottom Price</th>
                            <th class="text-align-center" colspan="2">Selling Price</th>
                            <th class="text-align-center" colspan="3">Buying Price</th>
                            <th class="text-align-center" rowspan="2">Remarks <br> Delivery Time</th>
                        </tr>
                        <tr>
                            <th class="text-align-center">Unit Price</th>
                            <th class="text-align-center">Total</th>
                            <th class="text-align-center">Unit Price</th>
                            <th class="text-align-center">Total</th>
                            <th class="text-align-center">Unit Price</th>
                            <th class="text-align-center">Total</th>
                            <th class="text-align-center">Supplier</th>
                                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($detail as $d)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }} 
                                <!-- Trigger Link -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="{{ $d->id }}">
                                    <i class="material-icons text-danger">delete</i>
                                </a>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this item?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form id="deleteForm" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Set the form action dynamically using Bootstrap's modal events
                                    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
                                        const button = event.relatedTarget; // Button that triggered the modal
                                        const id = button.getAttribute('data-bs-id'); // Extract info from data-bs-* attribute
                                        const form = document.getElementById('deleteForm');
                                        form.action = `{{ route('pengadaan.jobcard.material.delete', '') }}/${id}`;
                                    });
                                </script>

                                
                                </td>
                                <td class="text-center">{{ $d->qty }} 
                                </td>
                                <td>{{ $d->description }}</td>
                                <td>Rp. {{ number_format($d->unit_bop, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($d->total_bop, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($d->unit_sp, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($d->total_sp, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($d->unit_bp, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($d->total_bp, 0, ',', '.') }}</td>
                                <td>{{ $d->supplier }}</td>
                                <td>{{ $d->remarks }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total In Rupiah</strong></td>
                            <td class="text-end">Rp</td>
                            <td>{{ number_format($data->totalbop, 0, ',', '.') }}</td>
                            <td class="text-end">Rp</td>
                            <td>{{ number_format($data->totalsp, 0, ',', '.') }}</td>
                            <td class="text-end">Rp</td>
                            <td>{{ number_format($data->totalbp, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total In USD</strong></td>
                            <td class="text-end">$</td>
                            <td>{{ number_format($data->totalbop / $data->kurs, 2, '.', ',') }}</td>
                            <td class="text-end">$</td>
                            <td>{{ number_format($data->totalsp / $data->kurs, 2, '.', ',') }}</td>
                            <td class="text-end">$</td>
                            <td>{{ number_format($data->totalbp / $data->kurs, 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
