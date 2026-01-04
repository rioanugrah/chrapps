@extends('layouts.backend.app')
@section('title')
    Edit IP Address
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('updateIpAddresses',['id' => $response[0]['.id']]) }}" method="post">
            @csrf
            <div class="card-body">
                <h4 class="card-title mb-4">Edit IP Address</h4>
                <div class="mb-3">
                    <label for="">Enabled</label>
                    <select name="disabled" class="form-control" id="">
                        <option value="">-- Pilih --</option>
                        <option value="no" {{ $response[0]['disabled'] == true ? 'selected' : null }}>Yes</option>
                        <option value="yes" {{ $response[0]['disabled'] == false ? 'selected' : null }}>No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $response[0]['address'] }}" id="">
                </div>
                <div class="mb-3">
                    <label for="">Network</label>
                    <input type="text" name="network" class="form-control" value="{{ $response[0]['network'] }}" id="">
                </div>
                <div class="mb-3">
                    <label for="">Interface</label>
                    <select name="interface" class="form-control" id="">
                        <option value="">-- Pilih --</option>
                        @foreach ($getInterfaces as $item)
                            <option value="{{ $item['name'] }}" {{ $response[0]['interface'] == $item['name'] ? 'selected' : null }}>{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
