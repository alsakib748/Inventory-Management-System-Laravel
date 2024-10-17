@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Purchase Pending</h4>

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

                            <a href="{{ route('purchase.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i class="fas fa-plus-circle"></i> Add Purchase</a> <br/><br/>

                            <h4 class="card-title">Purchase All Pending Data</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Purchase No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                        <th>Product Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @foreach($purchases as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->purchase_no }}</td>
                                        <td>{{ date('d-m-Y',strtotime($item->date )) }}</td>
                                        <td>{{ optional($item->supplier)->name }}</td>
                                        <td>{{ optional($item->category)->name }}</td>
                                        <td>{{ $item->buying_qty }}</td>
                                        <td>{{ optional($item->product)->name }}</td>
                                        <td>
                                            @if($item->status == 0)
                                                {{-- <span class="badge bg-danger">Pending</span> --}}
                                                <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                            @elseif($item->status == 1)
                                                {{-- <span class="badge bg-info">Approved</span> --}}
                                                <button type="button" class="btn btn-info btn-sm">Approved</button>
                                            @endif
                                        </td>
                                        <td>

                                        @if($item->status == 0)

                                            <a href="{{ route('purchase.approve',$item->id) }}" class="btn btn-success btn-sm" title="Approved" id="ApprovedBtn"> <i class="fas fa-check-circle"></i></a>

                                        @endif

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
