@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Invoice All</h4>

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

                            <a href="{{ route('invoice.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"></i> Add Invoice</a> <br/><br/>

                            <h4 class="card-title">Purchase All Data</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Customer Name</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($invoices as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ optional($item->payment)->customer->name }}</td>
                                            <td># {{ $item->invoice_no }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ optional($item->payment)->total_amount }}</td>
                                            <td>
                                                @if($item->status == 0)
                                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                                @elseif($item->status == 1)
                                                    {{-- <span class="badge bg-info">Approved</span> --}}
                                                    <button type="button" class="btn btn-info btn-sm">Approved</button>
                                                @endif
                                            </td>
                                            <td>

                                            @if($item->status == 0)

                                                <a href="{{ route('invoice.approve',$item->id) }}" class="btn btn-success btn-sm" title="Approve Data"> <i class="fas fa-check-circle"></i></a>

                                                <a href="{{ route('invoice.delete',$item->id) }}" class="btn btn-danger btn-sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i></a>

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
