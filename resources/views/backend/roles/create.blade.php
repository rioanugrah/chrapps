@extends('layouts.backend.app')
@section('title')
    Buat Role Baru
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                    <h4 class="page-title">Roles</h4>
                    <ol class="breadcrumb mb-0">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a>
                        </li> --}}
                        <li class="breadcrumb-item">Roles</li>
                        <li class="breadcrumb-item active">Buat Baru</li>
                    </ol>
                </div>
            </div>
        </div>
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.roles.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Role Name</label>
                                <div class="col-10">
                                    <input type="text" name="name" class="form-control" placeholder="Role Name"
                                        id="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Permission</label>
                                <div class="col-10">
                                    <div class="row">
                                        @foreach ($custom_permission as $key => $group)
                                            <div class="mb-2" style="font-weight: bold">{{ ucfirst($key) }}</div>
                                            @forelse($group as $permission)
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        {{ Form::checkbox('permission[]', $permission->name, false, ['class' => 'form-check-input']) }}
                                                        {{ $permission->name }}
                                                    </div>
                                                </div>
                                            @empty
                                                {{ __('No permission in this group !') }}
                                            @endforelse
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.roles') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
