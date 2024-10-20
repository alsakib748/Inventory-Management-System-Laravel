@extends('admin.admin_master')

@section("admin")

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('supplier.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Suppliers</p>
                                    <h4 class="mb-2">{{ $suppliers }}</h4>
                                    {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="fas fa-truck-moving font-size-24"></i>
                                    </span>
                                </div>
                        </div>
                    </a>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('customer.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Customer</p>
                                <h4 class="mb-2">{{ $customers }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-user-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('unit.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Unit</p>
                                <h4 class="mb-2">{{ $units }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-balance-scale font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                    </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('category.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Category</p>
                                <h4 class="mb-2">{{ $categories }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-tags font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('product.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Product</p>
                                <h4 class="mb-2">{{ $products }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-shopping-cart font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('purchase.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Purchase</p>
                                <h4 class="mb-2">{{ $purchases }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-shopping-bag font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <a href="{{ route('invoice.all') }}" class="text-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Invoice</p>
                                <h4 class="mb-2">{{ $invoices }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-file-invoice-dollar font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </a>
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Monthly Purchase Amount</p>
                                <h4 class="mb-2">{{ number_format($purchase_amount,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-dollar-sign font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Purchase Amount</p>
                                <h4 class="mb-2">{{ number_format($total_purchase_amount,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-secure-payment-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Monthly Payment</p>
                                <h4 class="mb-2">{{ number_format($monthly_payment,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-dollar-sign font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Payment</p>
                                <h4 class="mb-2">{{ number_format($total_payment,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-secure-payment-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Monthly Due Amount</p>
                                <h4 class="mb-2">{{ number_format($monthly_due,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-dollar-sign font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Due Amount</p>
                                <h4 class="mb-2">{{ number_format($total_due,0) }}</h4>
                                {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> --}}
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-secure-payment-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            {{-- <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                                <h4 class="mb-2">1452</h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">New Orders</p>
                                <h4 class="mb-2">938</h4>
                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col --> --}}

        </div><!-- end row -->


        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">

                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>

                        </div>

                        <h4 class="card-title mb-4">Latest Transactions</h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Customer Name</th>
                                        <th>Mobile</th>
                                        <th>Amount</th>
                                        {{-- <th style="width: 120px;">Salary</th> --}}
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @foreach ($latest_payment as $key => $item)
                                    @php
                                        $customer_id = App\Models\Payment::where('invoice_id',$item->invoice_id)->first()->customer_id;
                                        $customer = App\Models\Customer::where('id',$customer_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ date('d-m-Y',strtotime($item->date)) }}</td>
                                        <td>{{ optional($item->invoice)->invoice_no }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->mobile_no }}</td>
                                        <td>{{ $item->current_paid_amount }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </div>

</div>

@endsection
