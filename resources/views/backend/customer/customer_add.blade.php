@extends('admin.admin_master')

@section('admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Customer Page</h4>
                        </div>
                        <div class="card-body">


                            <form action="{{ route('customer.store') }}" method="post" id="myForm" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="mobile_no" class="col-sm-2 col-form-label">Customer Mobile</label>
                                    <div class="form-group col-sm-10">
                                        <input type="number" class="form-control" id="mobile_no" name="mobile_no">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Customer Email</label>
                                    <div class="form-group col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-sm-2 col-form-label">Customer Address</label>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="image" class="col-sm-2 col-form-label">Customer Image</label>
                                    <div class="form-group col-sm-10">
                                        <input type="file" class="form-control" id="image" name="customer_image">
                                    </div>
                                </div>

                                <center>

                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <img id="showImage"
                                                src="{{ url('upload/no_image.jpg') }}"
                                                class="rounded avatar-lg" alt="Card image cap">
                                        </div>
                                    </div>

                                </center>

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Customer">

                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#myForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    mobile_no: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    customer_image: {
                        required: true,
                    }

                },
                messages: {
                    name: {
                        'required': 'Please Enter Your Name'
                    },
                    mobile_no: {
                        'required': 'Please Enter Your Mobile Number'
                    },
                    email: {
                        'required': 'Please Enter Your Email'
                    },
                    address: {
                        'required': 'Please Enter Your Address'
                    },
                    customer_image: {
                        'required': 'Please Select One Image'
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
        $(document).ready(function() {

            $("#image").change(function(e) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#showImage").attr("src", e.target.result);
                }

                reader.readAsDataURL(e.target.files[0]);
            });

        });
    </script>
@endsection
