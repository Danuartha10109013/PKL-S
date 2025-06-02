<div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('pages')</li>
      </ol>
      <h6 class="font-weight-bolder mt-2 mb-0">@yield('pages')</h6>
      
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          
          {{-- <div class="input-group input-group-outline">
            <label class="form-label">Type here...</label>
            <input type="text" class="form-control">
          </div> --}}
          
        </div>
        @php

    $user_id = Auth::user()->id;
    $role = Auth::user()->role;

    $notif = \App\Models\NotifM::where('status',0)
        ->join('material', 'notif.material_id', '=', 'material.id')
        ->select('notif.*', 'material.unit_price')
        ->get()
        ->map(function ($item) {
            $unitPriceWeight = 0.75;
            $jumlahPengadaanWeight = 0.25;
            
            $item->ahp_score = ($item->unit_price * $unitPriceWeight) + ($item->jumlah_pengadaan * $jumlahPengadaanWeight);
            return $item;
        })
        ->sortByDesc('ahp_score');

    $notifPengadaan = \App\Models\NotifPengadaanM::where('status', 0)->latest()->get();
@endphp

@if ($role == 1)
    {{-- ROLE 1 NOTIFICATION --}}
    <div class="dropdown">
        <button class="btn btn-secondary" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Notification
            <i class="mdi mdi-bell-alert"></i>
            <img src="{{ asset('bell-alert.svg') }}" width="5%" alt="">
            <small class="text text-danger">{{$notif->count()}}</small>
        </button>
        <ul class="dropdown-menu p-3" style="width: 600px;" aria-labelledby="notificationDropdown">
            @if (!$notif->isEmpty())
                <a href="{{ route('produksi.clear-notifikasi') }}" class="text text-danger mb-2">Delete All Notification</a>
                @foreach ($notif as $n)
                    <li class="dropdown-item">
                        <div class="row">
                            <div class="col-1">
                                <strong>{{ $loop->iteration }}</strong>
                            </div>
                            <div class="col-3 text-wrap text-break">
                                <strong>Name</strong>
                                <hr class="my-1">
                                {{ $n->judul }}
                            </div>
                            <div class="col-3 text-wrap text-break">
                                <strong>Jobcard</strong>
                                <hr class="my-1">
                                {{ $n->no_jobcard }}
                            </div>
                            <div class="col-2 text-wrap text-break">
                                <strong>Qty</strong>
                                <hr class="my-1">
                                {{ $n->jumlah_pengadaan }}
                            </div>
                            <div class="col-3 text-wrap text-break">
                                <strong>By</strong>
                                <hr class="my-1">
                                {{ \App\Models\User::find($n->user_id)->name }}
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="dropdown-item">Tidak ada notifikasi</li>
            @endif
        </ul>
    </div>

@elseif ($role == 0)
    {{-- ROLE 0 NOTIFICATION --}}
    <div class="dropdown">
        <button class="btn btn-secondary" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Notification
            <i class="mdi mdi-bell-alert"></i>
            <img src="{{ asset('bell-alert.svg') }}" width="5%" alt="">
            <small class="text text-danger">{{$notifPengadaan->count()}}</small>
        </button>
        <ul class="dropdown-menu p-3" style="width: 800px;" aria-labelledby="notificationDropdown">
            @if (!$notifPengadaan->isEmpty())
                <a href="{{ route('pengadaan.clear-notifikasi') }}" class="text text-danger mb-2">Delete All Notification</a>
                @foreach ($notifPengadaan as $n)
                {{-- <a href="{{route('pengadaan.po.detail', $n->po_id)}}"> --}}
                    <li class="dropdown-item">
                        <div class="row">
                            <div class="col-1">
                                <strong>{{ $loop->iteration }}</strong>
                            </div>
                            <div class="col-2 text-wrap text-break">
                                <strong>Name</strong>
                                <hr class="my-1">
                                {{ $n->title }}
                            </div>
                            <div class="col-3 text-wrap text-break">
                                <strong>Value</strong>
                                <hr class="my-1">
                                {{ $n->value }}
                            </div>
                            <div class="col-1 text-wrap text-break">
                                <strong>By</strong>
                                <hr class="my-1">
                                {{ \App\Models\User::find($n->pengirm_id)->name }}
                            </div>
                            <div class="col-3 text-wrap text-break">
                                <strong>Product</strong>
                                <hr class="my-1">
                                @php
                                    $produk = \App\Models\POM::find($n->po_id);
                                    $plist = $produk ? json_decode($produk->product) : [];
                                @endphp

                                @if (!empty($plist))
                                    @foreach ($plist as $p)
                                    {{ $p->product }} => {{ $p->qty }}<br>
                                
                                    @endforeach
                                @else
                                    <em>No Existint Product</em>
                                @endif

                            </div>
                            <div class="col-2 text-wrap text-break">
                                <strong>Notes</strong>
                                <hr class="my-1">
                                @if($produk)
                                {{$produk->catatan}}
                                @endif
                            </div>
                        </div>
                    </li>
                {{-- </a> --}}
                @endforeach
            @else
                <li class="dropdown-item">Tidak ada notifikasi</li>
            @endif
        </ul>
    </div>
@endif

        
        
      <ul class="navbar-nav ms-auto align-items-center">
        <!-- Profile Image -->
        <li class="nav-item d-flex align-items-center">
            <img src="{{ asset('storage/' . Auth::user()->profile) }}" width="40" height="40" class="rounded-circle me-2" alt="User Profile">
        </li>
        
        <!-- User Name with Edit Link -->
        <li class="nav-item d-flex align-items-center">
            <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="{{ route('edit', $user_id) }}">
                {{ Auth::user()->name }}
            </a>
        </li>
        
        <!-- Mobile Navbar Toggler -->
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </a>
        </li>
        
        <!-- Logout Button -->
        <li class="nav-item d-flex align-items-center">
            <a href="{{ route('logout') }}" class="nav-link text-body font-weight-bold px-0" id="logout-link">
                <i class="fa fa-sign-out me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign Out</span>
            </a>
            
            <!-- SweetAlert2 CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            
            <!-- Konfirmasi Logout -->
            <script>
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault();
            
                Swal.fire({
                    title: 'Yakin mau keluar?',
                    text: "Kamu akan logout dari sistem!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.href;
                    }
                });
            });
            </script>
            
        </li>
    </ul>
    
    </div>
  </div>