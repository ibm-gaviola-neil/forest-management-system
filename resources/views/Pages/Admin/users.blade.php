@extends('components.Layout.main-content')

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>Users</h1>
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Oculux</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav> --}}
            </div>
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="/users/register" class="btn btn-sm btn-primary" title="">Register User</a>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="bg-white p-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <div class="input-group mb-0">
                                <select name="" id="" class="form-control">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-magnifier"></i></span>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
                        <thead>
                            <tr>
                                <th class="w60">Name</th>
                                <th>Role</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th class="w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr id="user-{{ $user->id }}">
                                    <td>
                                        <h6 class="mb-0" style="text-transform: capitalize">{{ $user->last_name. ' ' .$user->first_name  }}</h6>
                                        <span>{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        @if ($user->role == 'staff')
                                            <span class="badge badge-success">{{ $user->role }}</span>
                                        @endif

                                        @if ($user->role == 'donor')
                                            <span class="badge badge-warning">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('m-d-Y') }}</td>
                                    <td>
                                        @if ($user->status == 'deactivated')
                                            <span class="badge badge-danger">{{ $user->status }}</span>
                                        @endif

                                        @if ($user->status == 'active')
                                            <span class="badge badge-success">{{ $user->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" value="{{ $user->id }}" data-status="{{ $user->status }}" class="btn block-user btn-sm btn-default" title="Edit"><i
                                                class="fa fa-power-off"></i></button>
                                        <a href="/users/edit/{{ $user->id }}" class="btn btn-sm btn-default" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <button value="{{ $user->id }}" type="button" class="btn btn-sm btn-default js-sweetalert delete-user" title="Delete"
                                            data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Data</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('assets/js/users.js') }}"></script>
@endpush
@endsection
