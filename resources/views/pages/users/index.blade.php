@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-button">
                    <a href="{{ route('user.create') }}"
                        class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">All Users</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Users</h2>
                <p class="section-lead">
                    You can manage all Users, such as editing, deleting and more.
                </p>

                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                            href="#">All <span class="badge badge-white">5</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="#">Draft <span class="badge badge-primary">1</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="#">Pending <span class="badge badge-primary">1</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="#">Trash <span class="badge badge-primary">0</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Users</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <select class="form-control selectric">
                                        <option>Action For Selected</option>
                                        <option>Move to Draft</option>
                                        <option>Move to Pending</option>
                                        <option>Delete Pemanently</option>
                                    </select>
                                </div>
                                <div class="float-right">
                                    <form method="GET", action="{{ route('user.index')}}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search"
                                                name='name'>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($users as $user )
                                        <tr>

                                            <td>
                                                {{$user->name}}
                                            <td>
                                                {{$user->email}}
                                            <td>
                                                {{$user->phone}}

                                            </td>
                                            <td>
                                                {{$user->created_at}}
                                            </td>
                                            <td>
                                                <div class="d-flex" justify-content-center>
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                    </a>

                                                    <form action="{{ route('user.destroy', $user->id) }}"
                                                        method="POST"
                                                        class="ml-2"
                                                        >
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button
                                                        class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                        {{-- onclick="confirmation(event)" --}}
                                                        >
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>


                                        </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $users->withQueryString()->links() }}
                                    {{-- <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link"
                                                    href="#"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link"
                                                    href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="#"
                                                    aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-Users.js') }}"></script>

    {{-- <script type="text/javascript">
        // function confirmation(ev){
        //     ev.preventDefault();
        //     // var urlToRedirect = ev.currentTarget.getAttribute('');
        //     var urlToRedirect = document.getElementById('deleteForm').submit();

        //     swal({
        //         title:"Are you sure to delete this ?",
        //         text: "You wont be able to revert this delete",
        //         icon : "warning",
        //         buttons : true,
        //         dangerMode : true,
        //     })

        //     .then((willCancel){
        //         if(willCancel){
        //           urlToRedirect();
        //         }
        //     });
        // }
        function confirmation(ev) {
            ev.preventDefault();
            // var urlToRedirect = ev.currentTarget.getAttribute('href');
            var urlToRedirect = document.getElementById('deleteForm').submit();
            console.log(urlToRedirect);
            swal({
                title: "Are you sure to Delete this post",
                text: "You will not be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willCancel) => {
                if (willCancel) {
                    urlToRedirect();
                }
            });
            }
    </script> --}}
@endpush
