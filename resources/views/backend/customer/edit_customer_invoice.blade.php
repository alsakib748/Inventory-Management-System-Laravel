@extends('admin.admin_master')

@section('admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer Invoice</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active">Customer Invoice</li>
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

                            <a href="{{ route('credit.customer') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                    class="fas fa-list"></i> Back</a> <br />

                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="p-2">
                                            <h3 class="font-size-16"><strong>Customer Invoice (Invoice No: #
                                                    {{ optional($payment->invoice)->invoice_no }}) </strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>

                                                            <td><strong>Customer Name</strong></td>
                                                            <td class="text-center"><strong>Customer Mobile</strong></td>
                                                            <td class="text-center"><strong>Address</strong>
                                                            </td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td>{{ $payment->customer->name }}</td>
                                                            <td class="text-center">{{ $payment->customer->mobile_no }}</td>
                                                            <td class="text-center">{{ $payment->customer->email }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('customer.update.invoice', $payment->invoice_id) }}"
                                        method="POST">
                                        @csrf
                                        <div>
                                            <div class="p-2">

                                            </div>
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td><strong>Sl</strong></td>
                                                                <td class="text-center"><strong>Category</strong></td>
                                                                <td class="text-center"><strong>Product Name</strong></td>
                                                                <td class="text-center"><strong>Current Stock</strong></td>
                                                                <td class="text-center"><strong>Quantity</strong></td>
                                                                <td class="text-center"><strong>Unit Price</strong></td>
                                                                <td class="text-center"><strong>Total Price</strong></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php

                                                                $total_price = 0;

                                                                $invoice_details = App\Models\InvoiceDetail::where(
                                                                    'invoice_id',
                                                                    $payment->invoice_id,
                                                                )->get();

                                                            @endphp
                                                            @foreach ($invoice_details as $key => $item)
                                                                <tr>
                                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                                    <td class="text-center">{{ $item->category->name }}</td>
                                                                    <td class="text-center">{{ $item->product->name }}</td>
                                                                    <td class="text-center">
                                                                        {{ $item->product->quantity }}</td>
                                                                    <td class="text-center">{{ $item->selling_qty }}</td>
                                                                    <td class="text-center">{{ $item->unit_price }}</td>
                                                                    <td class="text-center">{{ $item->selling_price }}</td>
                                                                </tr>
                                                                @php
                                                                    $total_price += $item->selling_price;
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line"></td>
                                                                <td class="thick-line text-center">
                                                                    <strong>Subtotal</strong>
                                                                </td>
                                                                <td class="thick-line text-end">{{ $total_price }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>Discount Amount</strong>
                                                                </td>
                                                                <td class="no-line text-end">
                                                                    {{ $payment->discount_amount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>Paid Amount</strong>
                                                                </td>
                                                                <td class="no-line text-end">{{ $payment->paid_amount }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>Due Amount</strong>
                                                                    <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}" />
                                                                </td>
                                                                <td class="no-line text-end">{{ $payment->due_amount }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>Grand Amount</strong>
                                                                </td>
                                                                <td class="no-line text-end">
                                                                    <h4 class="m-0">{{ $payment->total_amount }}</h4>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label for="">Paid Status</label>
                                                        <select name="paid_status" id="paid_status" class="form-select">

                                                            <option selected value="">Select Status</option>
                                                            <option value="full_paid">Full Paid</option>
                                                            <option value="partial_paid">Partial Paid</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 partial_amount" id="partial_amount"
                                                        style="display:none;">
                                                        <div class="md-3">
                                                            <label for="">Partial Paid Amount</label>
                                                            <input type="text" name="partial_paid_amount"
                                                                id="partial_paid_amount" class="form-control"
                                                                placeholder="Enter Paid Amount" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="example-date-input" class="form-label">Date</label>
                                                        <input type="date" name="date"
                                                            class="form-control example-date-input" id="date"
                                                            placeholder="YYYY-MM-DD">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="md-3" style="padding-top: 30px;">
                                                            <label for=""></label>
                                                            <button type="submit" class="btn btn-info">Invoice
                                                                Update</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>

    <script>
        $(document).on('change', '#paid_status', function() {
            var paid_status = $(this).val();
            // console.log(paid_status);
            if (paid_status == "partial_paid") {
                $("#partial_amount").show();
            } else {
                $("#partial_amount").hide();
            }
        });
    </script>
@endsection
