@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Role All</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Data Tables</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('role.permissions.create') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i class="fas fa-plus-circle"></i> Assign Role Permission</a> <br/><br/>

                            <h4 class="card-title">Supplier All Data</h4>

                            <table id="datatable" class="table table-bordered dt-responsive wrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Role Name</th>
                                        <th>Permission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @foreach($roles as $key => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap align-items-center">

                                            @php

                                                $permissions = Spatie\Permission\Models\Permission::select('name')->join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->where('role_has_permissions.role_id',$item->id)->get();

                                            @endphp

                                            @foreach($permissions as $permission)

                                                <span class="badge bg-info fs-6 p-1 m-1">{{ $permission->name }}</span>

                                            @endforeach

                                                    {{-- {{ $item->permissions != null ? $item->permissions->pluck('name')->implode(', ') : 'Not Given'  }} --}}

                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('role.permissions.edit',$item->id) }}" class="btn btn-info btn-sm mb-2" title="Edit Data"> <i class="fas fa-edit"></i></a>

                                            <a href="{{ route('roles.delete',$item->id) }}" class="btn btn-danger btn-sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
    </div>
@endsection
