@extends('layouts.backend.app')
@section('title')
    Edit IP Address
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('updateIpAddresses', ['id' => $response[0]['.id']]) }}" method="post">
            @csrf
            <div class="card-body">
                <h4 class="card-title mb-4">Edit IP Pool</h4>
                <div class="mb-3">
                    <label for="">Comment</label>
                    <input type="text" name="comment" class="form-control" placeholder="Comment" id="">
                </div>
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $response[0]['name'] }}" id="">
                </div>
                <div class="mb-3">
                    <label for="">Ranges</label>
                    <input type="text" name="ranges" class="form-control" placeholder="Address" value="{{ $response[0]['ranges'] }}" id="">
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
