@extends('layout.produksi.main')

@section('title')
    @if (Auth::user()->role == 0)
    
    Dashboard || Admin
    @elseif (Auth::user()->role == 1)
    Dashboard || Pegawai
    @endif
@endsection
@section('pages')
Edit Profile
@endsection
@section('content')
<div class="container-fluid py-4">
    {{-- <div class="container">
        <div class="row min-vh-80">
            <div class="col-12 mx-auto">
                <form action="">
                    <div class="form-group mb-3">

                        <label for="">Nama</label>
                        <input type="text" value="{{$user->name}}">
                    </div>
                </form>
            </div>
        </div> --}}
    {{-- </div> --}}
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
          <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
          <div class="row gx-4 mb-2">
            <div class="col-auto">
              <div class="avatar avatar-xl position-relative">
                <img src="{{asset('storage/'.$user->profile)}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
              </div>
            </div>
            <div class="col-auto my-auto">
              <div class="h-100">
                <h5 class="mb-1">
                  {{$user->name}}
                </h5>
                <p class="mb-0 font-weight-normal text-sm">
                  {{$user->jabatan}}
                </p>
              </div>
            </div>
            
        </div>
        <h6 class="mb-0">Profile Information</h6>
        <form action="{{ route('update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain h-100">
                            <div class="card-body p-3">
                                <hr class="horizontal gray-light my-4">
                                <div class="col-auto">
                                    
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                        <strong for="avatar" class="text-dark"">Update Profile Picture</strong>
                                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                                        @error('avatar')
                                        <div class="text-danger text-sm">{{ $message }}</div>
                                        @enderror
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                        <strong class="text-dark">Username:</strong> 
                                        &nbsp;
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                        <strong class="text-dark">Username:</strong> 
                                        &nbsp;
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Full Name:</strong> 
                                        &nbsp;
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Email:</strong> 
                                        &nbsp;
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Role:</strong> 
                                        &nbsp;
                                        <input type="text" name="role" class="form-control" value="{{ $user->role == 0 ? 'Admin' : 'Pegawai' }}" readonly>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain h-100">
                            <div class="card-body p-3">
                                <hr class="horizontal gray-light my-4">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Role:</strong> 
                                        &nbsp;
                                        <input type="text" name="active" class="form-control" value="{{ $user->active == 0 ? 'Disabeled' : 'Active' }}" readonly>
                                    </li>
                                    
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Created At:</strong> 
                                        &nbsp; {{ $user->created_at }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Updated At:</strong> 
                                        &nbsp; {{ $user->updated_at }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Location:</strong> 
                                        &nbsp;
                                        <input type="text" name="location" class="form-control" value="Indonesia" readonly>
                                    </li>
                                    <li class="list-group-item border-3 text-sm">
                                        <strong class="text-dark">Change Password:</strong> 
                                        &nbsp;
                                        <input type="password" name="password" class="form-control" placeholder="new password here ...">
                                        @error('password')
                                            <div class="text-danger text-sm">{{ $message }}</div>
                                        @enderror
                                    </li>
                                    <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
        

      </div>
</div>
@endsection