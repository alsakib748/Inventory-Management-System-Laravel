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

                        <div class="card-body">

                            <h4 class="card-title">Daily Invoice Report</h4>
                            <form action="{{ route('daily.invoice.pdf') }}" target="_blank" method="GET" id="myForm">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-date-input" class="form-label">Start Date</label>
                                            <input type="date" name="start_date" class="form-control example-date-input"
                                                id="start_date" placeholder="YY-MM-DD">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="md-3 form-group">
                                            <label for="example-date-input" class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control example-date-input"
                                                id="end_date" placeholder="YY-MM-DD">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="md-3 form-group">
                                            <label for="" class="form-label" style="margin-top:45px;"></label>
                                            <button type="submit" class="btn btn-info">Search</button>
                                        </div>
                                    </div>

                                </div>
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
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },

                },
                messages: {
                    start_date: {
                        'required': 'Please Select Start Date'
                    },
                    end_date: {
                        'required': 'Please Select End Date'
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
@endsection
