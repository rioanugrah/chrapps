@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-theme-white-2 mb-0">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{-- Please check the form below for errors --}}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
