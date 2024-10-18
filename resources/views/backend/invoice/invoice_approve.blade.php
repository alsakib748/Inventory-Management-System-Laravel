@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Invoice Approve</h4>

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

    @php
        $payment = App\Models\Payment::where('invoice_id',$invoice->id)->first();
    @endphp

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4>Invoice No: #{{ $invoice->invoice_no }} - {{ date('m-d-Y',strtotime($invoice->date)) }}</h4>

                            <a href="{{ route('invoice.pending.list') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-list"></i> Pending Invoice List</a> <br/><br/>

                            <table class="table table-dark" width="100%">
                                <tbody>
                                    <tr>
                                        <td><p>Customer Info</p></td>
                                        <td><p>Name: <strong>{{ optional($payment)->customer->name }}</strong></p></td>
                                        <td><p>Mobile No: <strong>{{ optional($payment)->customer->mobile_no }}</strong></p></td>
                                        <td><p>Email: <strong>{{ optional($payment)->customer->email }}</strong></p></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><p>Description: {{ $invoice->description }}</p></td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="{{ route('approval.store',$invoice->id) }}" method="POST">
                            @csrf
                                <table border="1" class="table table-dark" width="100%">

                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center" style="background-color: #8B008B;">Current Stock</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $total_price = 0;
                                    @endphp
                                    @foreach ($invoice->invoice_details as $key => $item )
                                        <tr>

                                            <input type="hidden" name="category_id[]" value="{{ $item->category_id }}" />

                                            <input type="hidden" name="product_id[]" value="{{ $item->product_id }}" />

                                            <input type="hidden" name="selling_qty[{{ $item->id }}]" value="{{ $item->selling_qty }}" />

                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $item->category->name }}</td>
                                            <td class="text-center">{{ $item->product->name }}</td>
                                            <td class="text-center" style="background-color: #8B008B;">{{ $item->product->quantity }}</td>
                                            <td class="text-center">{{ $item->selling_qty }}</td>
                                            <td class="text-center">{{ $item->unit_price }}</td>
                                            <td class="text-center">{{ $item->selling_price }}</td>
                                        </tr>
                                        @php
                                            $total_price += $item->selling_price;
                                        @endphp
                                    @endforeach
                                        <tr>
                                            <td colspan="6"> Sub Total </td>
                                            <td>{{ $total_price }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="6"> Discount </td>
                                            <td>{{ $payment->discount_amount }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="6"> Paid Amount </td>
                                            <td>{{ $payment->paid_amount }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="6"> Due Amount </td>
                                            <td>{{ $payment->due_amount }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="6"> Grand Total </td>
                                            <td>{{ $payment->total_amount }}</td>
                                        </tr>

                                    </tbody>

                                </table>

                                <button type="submit" class="btn btn-info">Invoice Approve</button>

                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
    </div>
@endsection
