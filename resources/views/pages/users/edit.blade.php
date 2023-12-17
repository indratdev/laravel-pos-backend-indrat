@extends('layouts.app')

@include('sweetalert::alert')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Advanced Forms</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit User Form</h2>
                {{-- <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p> --}}

                <div class="row">
                    <div class="col-12 ">
                        {{-- <form action="{{ route('user.update ', $user)}}" method="POST"> --}}
                        <form action="{{ route('user.update', $user)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input id="fullname"
                                        type="text"
                                        class="form-control @error('name')
                                            is-invalid
                                        @enderror "
                                        name="name"
                                        value="{{ $user->name }}"
                                        autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email"
                                        type="email"
                                        class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                        name="email"
                                        value="{{ $user->email }}"
                                        >
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="password"
                                        class="d-block">Password</label>
                                    <input id="password"
                                        type="password"
                                        class="form-control pwstrength @error('password')
                                            is-invalid
                                        @enderror"
                                        data-indicator="pwindicator"
                                        name="password"
                                        >
                                    @error('password')
                                        <div>
                                            {{$message}}
                                        </div>
                                    @enderror
                                    <div id="pwindicator"
                                        class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" name="phone"
                                        value="{{ $user->phone }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Roles</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio"
                                                name="roles"
                                                value="ADMIN"
                                                class="selectgroup-input"
                                                @if ($user->roles == "ADMIN")
                                                    checked
                                                @endif
                                                >
                                            <span class="selectgroup-button">ADMIN</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio"
                                                name="roles"
                                                value="MANAGER"
                                                class="selectgroup-input"
                                                @if ($user->roles == "MANAGER")
                                                    checked
                                                @endif
                                                >
                                            <span class="selectgroup-button">MANAGER</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio"
                                                name="roles"
                                                value="STAFF"
                                                class="selectgroup-input"
                                                @if ($user->roles == "STAFF")
                                                    checked
                                                @endif
                                                >
                                            <span class="selectgroup-button">STAFF</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
