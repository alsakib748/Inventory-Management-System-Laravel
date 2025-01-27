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
                            <h4 class="card-title">Update Role To Permissions Page</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('role.permissions.update') }}" method="post" id="myForm">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Roles Name</h6>
                                    </div>
                                    <div class="form-group col-sm-9 text-secondary">
                                        <select name="role_id" class="form-select mb-3" aria-label="Default select example">
                                            <option selected="">Open this select role</option>
                                            @foreach ($roles as $role)
                                                <option {{ $hasRole->id === $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="permission_all">
                                    <label class="form-check-label" for="permission_all">Permission All</label>
                                </div>


                                <hr>

                                @foreach ($permission_groups as $group)
                                    <div class="row"><!--  // Start row  -->
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input group-checkbox" type="checkbox" name="group[]" value="{{ $group->group_name }}"
                                                    id="group-{{ Str::slug($group->group_name) }}" >
                                                <label class="form-check-label"
                                                    for="group-{{ Str::slug($group->group_name) }}">{{ $group->group_name }}</label>
                                            </div>
                                        </div>

                                        <div class="col-9">

                                            @php
                                                $permissions = App\Models\User::getpermissionByGroupName(
                                                    $group->group_name,
                                                );
                                            @endphp

                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input {{ ($hasPermissions->contains($permission->name)) ? 'checked' : '' }} class="form-check-input permission-checkbox" name="permission[]" type="checkbox"
                                                        value="{{ $permission->name }}" id="permission-{{ $permission->id }}" data-group="group-{{ Str::slug($group->group_name) }}"   >
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                            <br>
                                        </div>

                                    </div><!--  // end row  -->
                                @endforeach


                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Update" />
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
                    role_name: {
                        required: true,
                    },
                    permission:{
                        required: true,
                    }

                },
                messages: {
                    role_name: {
                        'required': 'Please Enter Permission Group Name'
                    },
                    permission:{
                        'required': 'Please Select Permission'
                    }

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

        $(document).ready(function() {

            $("#permission_all").click(function() {

                if ($(this).is(':checked')) {
                    $('input[type=checkbox]').prop('checked', true);
                } else {
                    $('input[type=checkbox]').prop('checked', false);
                }

            });

        });

    $(document).ready(function() {
        // Handle group checkbox change
        $('.group-checkbox').change(function() {
            var groupId = $(this).attr('id');
            var isChecked = $(this).is(':checked');
            $('.permission-checkbox[data-group="' + groupId + '"]').prop('checked', isChecked);
        });

        // Handle "Permission All" checkbox change
        $('#permission_all').change(function() {
            var isChecked = $(this).is(':checked');
            $('.group-checkbox, .permission-checkbox').prop('checked', isChecked);
        });
    });

    </script>
@endsection
