@include('layouts.header')
@extends('layouts.header')
@include('index')

{{--    <div class="container">--}}
{{--        <div class="col-lg-3 mt-5">--}}
{{--            <label for="search">Search</label>--}}
{{--            <input type="text" name="search" class="form-control" id="search" placeholder="Search Data">--}}
{{--        </div>--}}
{{--        <div class="col-lg-3 mt-3">--}}
{{--            <label for="posts">Post</label>--}}
{{--            <select name="post" class="form-control" id="posts">--}}
{{--                <option value="">Select Post</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

<div class="container mt-5">
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand text-white" href="">Employees</a>
            {{--                                <div class="card-body" id="allEmp">--}}
            {{--                                    <h1 class="text-center text-secondary my-5">Loading...</h1>--}}
            {{--                                </div>--}}
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#formModal"
                    data-bs-toggle="button">Add Employee
            </button>
        </div>
    </nav>
    @if(isset($employee) && count($employee) > 0)
        <table id="datatables" class="table table-striped table-sm text-center align-middle">
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Post</th>
                <th>Action</th>
            </tr>
            @foreach($employee as $key => $employees)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    @if($employees->images != NULL)
                        <td><img src="{{asset('storage/images/'.$employees->images)}}" height="100px" width="100px">
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td>{{$employees->first_name . " " . $employees->last_name}}</td>
                    <td>{{$employees->email}}</td>
                    <td>{{$employees->phone}}</td>
                    <td>{{$employees->post}}</td>
                    <td>
                        <a href="#" id="{{$employees->id}}" class="text-success mx-1 editIcon"
                           data-bs-toggle="modal" data-bs-target="#editformModal"><i
                                class="bi-pencil-square h4"></i></a>
                        <a href="#" id="{{$employees->id}}" class="text-danger mx-1 deleteIcon"><i
                                class="bi-trash h4"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h3 class="text-center text-secondary my-5">No records found.</h3>
    @endif
</div>

