@extends('layouts.backend.app')
@section('title')
    Edit User
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                    <h4 class="page-title">Users</h4>
                    <ol class="breadcrumb mb-0">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a>
                        </li> --}}
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update',['generate' => $user->generate]) }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Name</label>
                                <div class="col-10">
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        id="" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Email</label>
                                <div class="col-10">
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        id="" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Password</label>
                                <div class="col-10">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        id="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Konfirmasi Password</label>
                                <div class="col-10">
                                    <input type="password" name="confirm-password" class="form-control" placeholder="Konfirmasi Password"
                                        id="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Roles</label>
                                <div class="col-10">
                                    {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </div>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
