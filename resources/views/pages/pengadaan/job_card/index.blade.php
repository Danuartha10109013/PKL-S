@extends('layout.produksi.main')

@section('title')
    @if (Auth::user()->role == 0)
    Job Card || Pengadaan
    @elseif (Auth::user()->role == 1)
    Job Card || Produksi
    @endif
@endsection

@section('pages')
Job Card
@endsection

@section('content')
<div class="container-fluid mt-0">
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="d-flex justify-content-between mb-3">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJobCardModal">Add New Job Card</a>
            <form action="{{route('pengadaan.jobcard')}}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
          </div>
        
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Total Job Cards</h6>
                  <p class="text-sm mb-0">
                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                    <span class="font-weight-bold ms-1">{{$sumJobcard}} done</span> this month
                  </p>
                </div>
                <div class="col-lg-6 col-5 text-end">
                  <div class="dropdown">
                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-ellipsis-v text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownTable">
                      <li><a class="dropdown-item" href="javascript:;">Month</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Year</a></li>
                      <li><a class="dropdown-item" href="javascript:;">All</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table  mb-0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>JC Number</th>
                      <th>Date</th>
                      <th>Customer</th>
                      <th>Total Material</th>
                      {{-- <th>Selling Price</th> --}}
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody >
                    <!-- Loop through job cards -->
                  @foreach($jobCards as $jobCard)
                    <tr >
                      <td>&nbsp;&nbsp;&nbsp;&nbsp; {{ $loop->iteration }}</td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $jobCard->no_jobcard }}</td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($jobCard->date)->format('d M Y') }}</td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $jobCard->customer_name }}</td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;
                      @php
                        $total = \App\Models\JobcardDetailM::where('jobcard_id', $jobCard->id)->count();
                      @endphp
                      {{$total}}
                        &nbsp;&nbsp;  
                      <a href="{{route('pengadaan.jobcard.material',$jobCard->id)}}">
                        <i class="material-icons text-success">visibility</i>
                      </a>
                      </td>
                      {{-- <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $jobCard->totalbp }}</td> --}}
                      <td>&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div style="margin-top: -25px" class="d-flex justify-content-center">
                          <a href="{{route('pengadaan.jobcard.detail.add',$jobCard->id)}}" class="mx-2" >
                            <i class="material-icons text-success">add</i>
                        </a>

                          <!-- Edit Button -->
                          <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#editJobCardModal{{ $jobCard->id }}">
                            <i class="material-icons text-warning">edit</i>
                          </a>

                          <!-- Edit Modal -->
                          <div class="modal fade" id="editJobCardModal{{ $jobCard->id }}" tabindex="-1" aria-labelledby="editJobCardModalLabel{{ $jobCard->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editJobCardModalLabel{{ $jobCard->id }}">Edit Job Card</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('pengadaan.jobcard.update', $jobCard->id) }}">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                    <!-- Input Fields Here -->
                                    <div class="mb-3">
                                      <label for="no_jobcard{{ $jobCard->id }}" class="form-label">No Job Card</label>
                                      <input type="text" class="form-control" id="no_jobcard{{ $jobCard->id }}" name="no_jobcard" value="{{ $jobCard->no_jobcard }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $jobCard->date }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $jobCard->customer_name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_po" class="form-label">No PO</label>
                                        <input type="text" class="form-control" id="no_po" name="no_po" value="{{ $jobCard->no_po }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="po_date" class="form-label">PO Date</label>
                                        <input type="date" class="form-control" id="po_date" name="po_date" value="{{ $jobCard->po_date }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="po_received" class="form-label">PO Received</label>
                                        <input type="date" class="form-control" id="po_received" name="po_received" value="{{ $jobCard->po_received }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kurs" class="form-label">Kurs</label>
                                        <input type="number" class="form-control" id="kurs" name="kurs" value="{{ $jobCard->kurs }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalbop" class="form-label">Total BOP</label>
                                        <input type="number" class="form-control" id="totalbop" name="totalbop" value="{{ $jobCard->totalbop }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalsp" class="form-label">Total SP</label>
                                        <input type="number" class="form-control" id="totalsp" name="totalsp" value="{{ $jobCard->totalsp }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalbp" class="form-label">Total BP</label>
                                        <input type="number" class="form-control" id="totalbp" name="totalbp" value="{{ $jobCard->totalbp }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_form" class="form-label">No Form</label>
                                        <input type="text" class="form-control" id="no_form" name="no_form" value="{{ $jobCard->no_form }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="effective_date" class="form-label">Effective Date</label>
                                        <input type="date" class="form-control" id="effective_date" name="effective_date" value="{{ $jobCard->effective_date }}">
                                    </div>
                                    <div class="mb-3">
                                      @php
                                        $no_revisi_new = $jobCard->no_revisi + 1 ;
                                      @endphp
                                        <label for="no_revisi" class="form-label">No Revisi</label>
                                        <input type="number" class="form-control" id="no_revisi" name="no_revisi" value="{{$no_revisi_new}}">
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                          </div>

                          <!-- View Icon Trigger for Modal -->
                          <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#viewModal{{ $jobCard->id }}">
                            <i class="material-icons text-success">visibility</i>
                          </a>

                          <!-- View Job Card Modal -->
                          <div class="ml-4 modal fade" id="viewModal{{ $jobCard->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $jobCard->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header with Title -->
                                    <div class="modal-header bg-primary text-white">
                                      @php
                                        $job = \App\Models\JobCardM::find($jobCard->id);
                                      @endphp
                                        <h5 class="modal-title" id="viewModalLabel{{ $jobCard->id }}" style="color: white">Job Card Details - {{ $job->no_jobcard }}</h5> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{route('pengadaan.jobcard.print',$jobCard->id)}}" class="mt-2 btn btn-white"><i class="ml-3 material-icons text-black">print</i></a>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <!-- Modal Body with Professional Layout -->
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Job Card Summary Section -->
                                                <h6 class="text-muted mb-3"><center>Job Card</center></h6>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <strong>JC No : </strong> {{ $job->no_jobcard }} <br>
                                                        <strong>Date : </strong> {{ \Carbon\Carbon::parse($job->date)->format('d M Y') }} <br>
                                                        <strong>kurs : </strong> {{ $job->kurs }} <br>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <strong>Customer Name : </strong> {{ $job->customer_name }} <br>
                                                        <strong>PO No : </strong> {{ $job->customer_name }} <br>
                                                        <strong>PO Date : </strong> {{ \Carbon\Carbon::parse($job->po_date)->format('d M Y') }} <br>
                                                        <strong>PO Received : </strong> {{ $job->po_received }} <br>
                                                    </div>
                                                </div>

                                                <!-- Pricing Section -->
                                                <h6 class="text-muted mb-3">Detail</h6>
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
                                                              <th>Unit Price</th>
                                                              <th>Total</th>
                                                              <th>Unit Price</th>
                                                              <th>Total</th>
                                                              <th>Unit Price</th>
                                                              <th>Total</th>
                                                              <th>Supplier</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        @php
                                                          $data = \App\Models\JobCardDetailM::where('jobcard_id',$job->id)->get();
                                                          // dd($job->id);
                                                        @endphp
                                                        @foreach ($data as $d)
                                                          
                                                        
                                                          <tr>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}</td> <!-- NO -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$d->qty}}</td> <!-- Qty -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$d->description}}</td> <!-- Description -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->unit_bop}}</td> <!-- Bottom Price Unit Price -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->total_bop}}</td> <!-- Bottom Price Total -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->unit_sp}}</td> <!-- Selling Price Unit Price -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->total_sp}}</td> <!-- Selling Price Total -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->unit_bp}}</td> <!-- Buying Price Unit Price -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->total_bp}}</td> <!-- Buying Price Total -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$d->supplier}}</td> <!-- Buying Price Supplier -->
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$d->remarks}}</td> <!-- Remarks/Delivery Time -->
                                                          </tr>
                                                        @endforeach
                                                            <tr>
                                                              <td colspan="3" class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;Total In Rupiah</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;Rp</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$job->totalbop}}</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;Rp</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$job->totalsp}}</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;Rp</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$job->totalbp}}</td>
                                                            </tr>
                                                            <tr>
                                                              <td colspan="3" class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;Total In USD</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;$</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($job->totalbop / $job->kurs, 2, '.', ',') }}</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;$</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($job->totalsp/ $job->kurs, 2, '.', ',') }}</td>
                                                              <td class="text-end">&nbsp;&nbsp;&nbsp;&nbsp;$</td>
                                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($job->totalbp / $job->kurs, 2, '.', ',') }}</td>
                                                            </tr>
                                                            
                                                          <!-- Additional rows as needed -->
                                                      </tbody>
                                                  </table>
                                              </div>
                                              

                                                <!-- Supplier Information Section -->
                                                <div class="row mt-2">
                                                    <div class="col-md-12 text-end">
                                                        <strong>No Form:</strong> {{ $job->no_form }} <br>
                                                        <strong>Effective Date:</strong> {{ \Carbon\Carbon::parse($job->effective_date)->format('d M Y') }} <br>
                                                        <strong>No Revisi:</strong> {{ $job->no_revisi }} <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Footer with Close Button -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                          </div>

                                  
                            <!-- Delete Button with Modal Trigger -->
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteModal{{$jobCard->id}}">
                              <i class="material-icons text-danger">delete</i>
                            </a>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal{{$jobCard->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$jobCard->id}}" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="deleteModalLabel{{$jobCard->id}}">Confirm Delete</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          Are you sure you want to delete this job card?
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <form action="{{ route('pengadaan.jobcard.destroy', $jobCard->id) }}" method="POST">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-danger">Delete</button>
                                          </form>
                                      </div>
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

        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
              <div class="card-header pb-0">
                  <h6>Orders Overview</h6>
                  <p class="text-sm">
                      <i class="fa fa-arrow-up text-success"></i>
                      <span class="font-weight-bold">24%</span> this month
                  </p>
              </div>
              <div class="card-body p-3">
                  <!-- Canvas element for the chart -->
                  <canvas id="ordersChart"></canvas>
              </div>
          </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>
          // Get the canvas element
          var ctx = document.getElementById('ordersChart').getContext('2d');

          // Initialize the chart
          var ordersChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: @json($chartLabels), // Monthly labels (e.g., January, February, etc.)
                  datasets: [{
                      label: 'Orders Total (SP)', // Chart label
                      data: @json($chartData),   // Data for each month
                      borderColor: 'rgba(75, 192, 192, 1)', // Line color
                      backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true, // Make the chart responsive
                  scales: {
                      y: {
                          beginAtZero: true, // Start the Y axis at 0
                          ticks: {
                              callback: function(value) {
                                  return value; // Display value on Y-axis
                              }
                          }
                      }
                  },
                  plugins: {
                      legend: {
                          display: true, // Display the legend
                          position: 'top', // Position of the legend
                      },
                      tooltip: {
                          mode: 'index',
                          intersect: false
                      }
                  }
              }
          });
      </script>
      </div>
</div>

<!-- Add Job Card Modal -->
<div class="modal fade" id="addJobCardModal" tabindex="-1" role="dialog" aria-labelledby="addJobCardModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addJobCardModalLabel">Add New Job Card</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('pengadaan.jobcard.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="no_jobcard">Job Card Number</label>
            <input type="text" class="form-control" id="no_jobcard" style="outline: 1px solid #007bff;" value="{{$newJobCard}}" name="no_jobcard" required>
          </div>

          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" style="outline: 1px solid #007bff;" value="{{now()->format('Y-m-d')}}" name="date" required>
          </div>

          <div class="form-group">
            <label for="kurs">Kurs</label>
            <input type="number" class="form-control" id="kurs" style="outline: 1px solid #007bff;" name="kurs" required>
          </div>

          <!-- Nomor PO -->
          <div class="mb-3">
            <label for="nomor_po_modal" class="form-label">Nomor PO</label>
            <input type="text" class="form-control" id="nomor_po_modal" name="nomor_po" placeholder="Ketik Nomor PO..." autocomplete="off" required>
            <ul id="po-suggestions" class="list-group mt-1" style="position: absolute; z-index: 1000; width: 90%; display: none;"></ul>
          </div>

          <!-- Nama Customer -->
          <div class="mb-3">
            <label for="customer_name_modal" class="form-label">Nama Customer</label>
            <input type="text" class="form-control" id="customer_name_modal" name="customer_name" readonly style="background-color: #e9ecef;">
          </div>

          <!-- Tanggal Terima PO -->
          <div class="mb-3">
            <label for="tanggal_terima_po_modal" class="form-label">Tanggal Terima PO</label>
            <input type="text" class="form-control" id="tanggal_terima_po_modal" name="tanggal_terima_po" readonly style="background-color: #e9ecef;">
          </div>

          <!-- Tanggal Permintaan -->
          <div class="mb-3">
            <label for="tanggal_permintaan_modal" class="form-label">Tanggal Permintaan</label>
            <input type="text" class="form-control" id="tanggal_permintaan_modal" name="tanggal_permintaan" readonly style="background-color: #e9ecef;">
          </div>

          <div class="form-group">
            <label for="no_form">Form Number</label>
            <input type="text" class="form-control" id="no_form" style="outline: 1px solid #007bff;" name="no_form" required>
          </div>

          <div class="form-group">
            <label for="effective_date">Effective Date</label>
            <input type="date" class="form-control" id="effective_date" style="outline: 1px solid #007bff;" name="effective_date" required>
          </div>

          <div class="form-group">
            <label for="no_revisi">Revision Number</label>
            <input type="number" class="form-control" id="no_revisi" style="outline: 1px solid #007bff;" name="no_revisi" value="1" readonly>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Job Card</button>
        </div>

      </form>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#nomor_po_modal').on('input', function() {
        var query = $(this).val();
        if (query.length >= 1) {
            $.ajax({
                url: '/po/search', // ganti ini sesuai route search PO kamu
                method: 'GET',
                data: { q: query },
                success: function(data) {
                    $('#po-suggestions').empty().show();
                    if (data.length > 0) {
                        $.each(data, function(i, po) {
                            $('#po-suggestions').append(`
                                <li class="list-group-item list-group-item-action" style="cursor:pointer" 
                                  data-nomor_po="${po.nomor_po}" 
                                  data-nama_customer="${po.nama_customer}" 
                                  data-tanggal_terima_po="${po.tanggal_terima_po}" 
                                  data-tanggal_permintaan="${po.tanggal_permintaan}">
                                  ${po.nomor_po}
                                </li>
                            `);
                        });
                    } else {
                        $('#po-suggestions').append('<li class="list-group-item disabled">No PO ditemukan</li>');
                    }
                }
            });
        } else {
            $('#po-suggestions').hide();
        }
    });

    $(document).on('click', '#po-suggestions li', function() {
        var nomorPo = $(this).data('nomor_po');
        var namaCustomer = $(this).data('nama_customer');
        var tanggalTerimaPo = $(this).data('tanggal_terima_po');
        var tanggalPermintaan = $(this).data('tanggal_permintaan');

        $('#nomor_po_modal').val(nomorPo);
        $('#customer_name_modal').val(namaCustomer);
        $('#tanggal_terima_po_modal').val(tanggalTerimaPo);
        $('#tanggal_permintaan_modal').val(tanggalPermintaan);

        $('#po-suggestions').hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#nomor_po_modal, #po-suggestions').length) {
            $('#po-suggestions').hide();
        }
    });
});
</script>

@endsection
