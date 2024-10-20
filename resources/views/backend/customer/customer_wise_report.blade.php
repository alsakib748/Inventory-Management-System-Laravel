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
                        <h4 class="mb-sm-0">Customer Wise Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Customer</a></li>
                                <li class="breadcrumb-item active">Customer Wise Report</li>
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

                            <div class="row">
                                <div class="col-md-12 text-center">

                                    <input type="radio" name="customer_wise_report" value="customer_wise_credit"
                                        class="search_value" id="customer_credit" >
                                    <label for="customer_credit" class="form-label">Customer Wise Credit Report</label>

                                        &nbsp;&nbsp;&nbsp;

                                    <input type="radio" name="customer_wise_report" value="customer_wise_paid"
                                    class="search_value" id="customer_paid" >
                                    <label for="customer_paid" class="form-label">Customer Wise Paid Report</label>

                                </div>
                            </div> {{-- end row --}}

                            <br/>

                            {{-- Customer Credit Wise --}}
                            <div class="show_credit" style="display:none">
                                <form action="{{ route('customer.wise.credit.report') }}" method="GET" id="myForm" target="_blank">
                                    <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label for="supplier_id" class="form-label">Customer Name</label>
                                            <select name="customer_id" id="supplier_id" class="form-select select2">
                                                <option selected value="">Select a Customer</option>
                                                @foreach ($customers as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4" style="padding-top: 28px;">
                                            <label for=""></label>
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            {{-- Cusermer Paid Wise --}}
                            <div class="show_paid" style="display:none">
                                <form action="{{ route('customer.wise.paid.report') }}" method="GET" id="myForm" target="_blank">
                                    <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label for="supplier_id" class="form-label">Customer Name</label>
                                            <select name="customer_id" id="supplier_id" class="form-select select2">
                                                <option selected value="">Select a Customer</option>
                                                @foreach ($customers as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4" style="padding-top: 28px;">
                                            <label for=""></label>
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {

            $("#myForm").validate({
                rules: {
                    category_id: {
                        required: true,
                    },
                    product_id: {
                        required: true,
                    },
                },
                messages: {
                    category_id: {
                        'required': 'Please Select Category'
                    },
                    product_id: {
                        'required': 'Please Select Product'
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>

    <script>
        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();

            if (search_value == "customer_wise_credit") {
                $(".show_credit").show();
            } else {
                $(".show_credit").hide();
            }

        });
    </script>

<script>
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();

        if (search_value == "customer_wise_paid") {
            $(".show_paid").show();
        } else {
            $(".show_paid").hide();
        }

    });
</script>



@endsection
