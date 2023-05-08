@include('layouts.header')
@extends('layouts.header')
@section('section')

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="#" method="POST" id="addEmployee" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body p-4 bg-light">
                            <div class="row">
                                <div class="col-lg">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                           placeholder="First Name">
                                </div>
                                <div class="col-lg">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                           placeholder="Last Name">
                                </div>
                            </div>
                            <div class="my-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="Email">
                            </div>
                            <div class="my-2">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                       placeholder="Phone">
                            </div>
                            <div class="my-2">
                                <label for="post">Post</label>
                                <input type="text" name="post" class="form-control" placeholder="Post">
                            </div>
                            <div class="my-2">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="addEmpBtn" value="submit" name="submit" class="btn btn-primary">Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editformModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="editEmployee" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="emp_id" id="empId">
                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                    <div class="modal-body">
                        <div class="modal-body p-4 bg-light">
                            <div class="row">
                                <div class="col-lg">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="firstname"
                                           placeholder="First Name">
                                </div>
                                <div class="col-lg">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="lastname"
                                           placeholder="Last Name">
                                </div>
                            </div>
                            <div class="my-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Email">
                            </div>
                            <div class="my-2">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                       placeholder="Phone">
                            </div>
                            <div class="my-2">
                                <label for="post">Post</label>
                                <input type="text" name="post" class="form-control" id="post" placeholder="Post">
                            </div>
                            <div class="my-2">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control">
                                <div id="image" class="mt-2">

                                </div>
                                {{--                                <img src="{{asset('storage/images/' . $employees->images)}}"--}}
                                {{--                                     @if($employees->images != NULL) height="100px" width="100px" @endif alt="No Image"--}}
                                {{--                                     class="m-2">--}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="editEmpBtn" value="submit" name="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // $(document).ready(function () {
        //     $('#datatables').DataTable({
        //         responsive: true,
        //         "order": [[0, "asc"]],
        //         "pageLength": 5,
        //     });
        // });

        //To get the data
        var page = '';

        function getEmployees() {
            $.ajax({
                url: '{{route('employee.index')}}',
                method: 'GET',
                data: page,
                success: function (response) {
                    $('#allEmp').html(response);
                }
            });
        }


        //To store the data
        $('#addEmployee').submit(function (e) {
            e.preventDefault();
            const data = new FormData(this);
            $('#addEmpBtn').text('Adding..');
            $.ajax({
                url: '{{route('employee.store')}}',
                method: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Added!',
                            'New Employee Added Successfully!',
                            'success'
                        )
                    }
                    $('#addEmpBtn').text('Add');
                    $('#addEmployee')[0].reset();
                    $('#formModal').modal('hide');
                    $('.modal-backdrop').remove();
                    getEmployees();
                }
            });
        });

        //edit
        $(document).on('click', '.editIcon', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var url = 'employee/' + id + '/edit';
            $.ajax({
                url: url,
                method: 'GET',
                data: {'id': id, '_token': '{{csrf_token()}}'},
                success: function (res) {
                    $('#firstname').val(res.first_name);
                    $('#lastname').val(res.last_name);
                    $('#email').val(res.email);
                    $('#phone').val(res.phone);
                    $('#post').val(res.post);
                    if (res.images !== null) {
                        $('#image').html(`<img src="${window.location.origin}/storage/images/${res.images}" width="100px" height="100px" ass="img-fluid img-thumbnail">`);
                    }
                    $('#empId').val(id);
                    $('#emp_avatar').val(res.images);
                }
            });
        });

        //delete
        $(document).on('click', '.deleteIcon', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'employee/' + id,
                        method: 'DELETE',
                        data: {'id': id, '_token': '{{csrf_token()}}'},
                        success: function (res) {
                            if (res.status === 200) {
                                Swal.fire(
                                    'Deleted!',
                                    'Employee Deleted Successfully!',
                                    'success'
                                )
                            }
                            getEmployees();
                        }
                    });
                }
            });
        });


        //    To update the data
        $('#editEmployee').submit(function (e) {
            e.preventDefault();
            const Data = new FormData(this);
            var id = $('#empId').attr('value');
            $('#editEmpBtn').text('Updating..');
            debugger
            $.ajax({
                url: 'employee/' + id,
                method: 'POST',
                data: Data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (Res) {
                    if (Res.status === 200) {
                        Swal.fire(
                            'Updated!',
                            'Employee Updated Successfully!',
                            'success'
                        )
                    }
                    $('#editEmpBtn').text('Add');
                    $('#editEmployee')[0].reset();
                    $('#editformModal').modal('hide');
                    $('.modal-backdrop').remove();
                    getEmployees();
                }
            });
        });
    </script>
@endsection
