@extends('layouts.backend.app')
@section('title')
    Roles
@endsection
@section('css')
<!-- DataTables -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                    <h4 class="page-title">Roles</h4>
                    <div class="">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Roles</h4>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.roles.create') }}" class="btn bt btn-primary">
                                    <i class="fas fa-plus fs-5 me-1"></i> Buat Baru
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Role Name</th>
                                        <th class="text-center">Role Guard</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $key => $role)
                                        <tr>
                                            <td class="text-center">{{ $key+1 }}</td>
                                            <td class="text-center">{{ $role->name }}</td>
                                            <td class="text-center">{{ $role->guard_name }}</td>
                                            <td class="text-center">
                                                <div class="flex-wrap gap-2">
                                                    <a href="{{ route('admin.roles.detail',['id' => $role->id]) }}" class="btn btn-success"><i class="fas fa-eye"></i> View</a>
                                                    @can('role-edit')
                                                    <a href="{{ route('admin.roles.edit',['id' => $role->id]) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    @endcan
                                                    @can('role-delete')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                    {!! Form::close() !!}
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Required datatable js -->
        <script src="{{ url('/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/jszip/jszip.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="{{ url('/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{ url('/') }}/assets/js/pages/datatables.init.js"></script>
@endsection
