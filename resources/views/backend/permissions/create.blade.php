@extends('layouts.backend.app')
@section('title')
    Buat Permission Baru
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                    <h4 class="page-title">@yield('title')</h4>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Permissions</li>
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
                        <form action="{{ route('admin.permission.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Permission Name</label>
                                <div class="col-10">
                                    <input type="text" name="name" class="form-control" placeholder="Permission Name"
                                        id="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-2 col-form-label">Permission Guard Name</label>
                                <div class="col-10">
                                    <select name="guard_name" class="form-control" id="">
                                        <option value="">-- Pilih Guard Name --</option>
                                        <option value="web">WEB</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                            </div>
                            <a href="{{ route('admin.permission') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
