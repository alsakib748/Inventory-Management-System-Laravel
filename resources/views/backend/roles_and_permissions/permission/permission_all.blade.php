@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Supplier All</h4>

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

                            <a href="{{ route('permissions.create') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i class="fas fa-plus-circle"></i> Add Permission</a> <br/><br/>

                            <h4 class="card-title">Supplier All Data</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Group Name</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @foreach($permissions as $key => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->group_name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit',$item->id) }}" class="btn btn-info btn-sm" title="Edit Data"> <i class="fas fa-edit"></i></a>

                                            <a href="{{ route('permissions.delete',$item->id) }}" class="btn btn-danger btn-sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i></a>

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
