@extends('admin.admin_master')

@section('admin')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Profile Page</h4>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('store.profile') }}" method="post" enctype="multipart/form-data">
                    @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input value="{{ $editData->name }}" type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">User Email</label>
                            <div class="col-sm-10">
                                <input value="{{ $editData->email }}" type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">UserName</label>
                            <div class="col-sm-10">
                                <input value="{{ $editData->username }}" type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-sm-2 col-form-label">Profile Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="profile_image">
                            </div>
                        </div>

                    <center>

                        <div class="row mb-3">
                            <label for="profile_image" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <img id="showImage" src="{{ (!empty($editData->profile_image)) ? url('upload/admin_images/'.$editData->profile_image) : url('upload/no_image.jpg') }}"  class="rounded avatar-lg" alt="Card image cap">
                            </div>
                        </div>

                    </center>

                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Profile">

                    </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script>

    $(document).ready(function(){

        $("#image").change(function(e){
            var reader = new FileReader();

            reader.onload = function(e){
                $("#showImage").attr("src",e.target.result);
            }

            reader.readAsDataURL(e.target.files[0]);
        });

    });

</script>

@endsection
