<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .bg-nav {
            background-color: #1e98d7;
        }

        .bg-nav-title {
            background-color: #00abe4;
        }

        .bg-top {
            background-color: #ffffff;
        }

        .bg-leaf {
            background-color: #6aac5b;
        }

        .text-tag {
            color: #f59a23;
        }

        .search-logo {
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
        }

        .br-10 {
            border-radius: 10px;
        }

        .gap-6 {
            gap: 55px;
        }

        .w-6 {
            width: 6%;
        }

        .w-44 {
            width: 44%;
        }

        .nav-height {
            height: calc(100% - 90px);
        }

        .hover-div a,
        .hover-div i {
            color: whitesmoke;
            flex-wrap: nowrap;
        }

        .hover-div a {
            white-space: nowrap;
        }

        .hover-div {
            cursor: pointer;
        }

        .hover-div:hover a {
            color: #1e98d7;
        }

        .hover-div:hover {
            background-color: whitesmoke;
        }

        .hover-div:hover i {
            color: #1e98d7;
        }

        .navigation,
        .navi-back {
            transition: 0.5s;
        }

        table tr,
        th,
        td {
            padding: 1rem;
        }

        table .btn {

            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .navigation {
                display: none;
            }

            .full-content {
                width: 100%;
                background-color: #f59a23;
            }

            .search {
                display: none;
            }

        }

        .no-wrap {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="d-flex w-100" style="height: 100vh">
        <div class="navigation bg-nav text-white position-fixed" style="width: 17% ; height: 100vh">
            <div class="bg-nav-title d-flex justify-content-center align-items-center" style="height: 90px">
                <h2 class="m-0">
                    Greenwich
                </h2>
            </div>

            <div class="navbar d-flex flex-column justify-content-start align-items-center fs-5 nav-height">
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-home pe-4"></i>
                    <a class="text-decoration-none text-nowrap" href="#">Dashboard</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-bars pe-4"></i>
                    <a class="text-decoration-none text-nowrap" href="#">Idea Lists</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-graduation-cap pe-4"></i>
                    <a class="text-decoration-none text-nowrap" href="#">Academic Years</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none text-nowrap" href="#">Categories</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none text-nowrap" href="#">Account Management</a>
                </div>

                <div class="d-flex flex-column mt-auto w-100">
                    <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                        style="height: 95px;">
                        <i class="fa-solid fa-gear pe-4"></i>
                        <a class="text-decoration-none" href="#">Setting</a>
                    </div>
                    <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                        style="height: 95px;">
                        <i class="fa-solid fa-arrow-right-from-bracket pe-4"></i>
                        <a class="text-decoration-none" href="#">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="navi-back" style="width: 17%;">

        </div>

        <div class="full-content" style="width: 83%">

            <div class="d-flex justify-content-between align-items-center" style="height: 90px">

                <div class="d-flex justify-content-center align-items-center fs-5 w-6">
                    <i class="fa-solid fa-bars menu-bars"></i>
                </div>

                <div class="d-flex justify-content-start align-items-center px-1 fs-5 gap-4 w-44">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRalke-Kf6_TB5yrnMuUYP158MBQd4bezQIxw&s"
                        style="width: 80px; height: 80px;">
                    <h1>Admin Dashboard</h1>
                </div>

                <div class="search d-flex justify-content-evenly align-items-center px-5 w-50">
                    <div class="position-relative d-flex align-items-center fs-5 w-25">
                        <i class="search-logo fa-solid fa-search position-absolute "></i>
                        <input class="ps-5 py-1 br-10" type="text" class="form-control" placeholder="Search Here" />
                    </div>

                    <div class="d-flex justify-content-end align-items-center fs-2 gap-6 w-75 pe-3">
                        <i class="fa-solid fa-bell"></i>
                        <img src="https://media.istockphoto.com/id/639454418/photo/close-up-of-beagle-against-gray-background.jpg?s=612x612&w=0&k=20&c=dlac4lCaSPRkVwD2wLB7J1y1DCb9rKcjY6eBSxYyOEM="
                            class="border rounded-circle" style="width: 50px; height: 50px;">
                    </div>
                </div>
            </div>

            <div class="p-5" style="background-color: #e9f1fa; height: 100vh">

                <div class="container">
                    <div class="card">
                        <div class="d-flex align-items-start p-5" style=" height: 300px;">
                            <img src="
                            https://cdn1.hammers.news/uploads/25/2023/08/GettyImages-1342442688-1024x693.jpg"
                                class="h-100 rounded-circle me-4" style="aspect-ratio: 1/1;">
                            <div class=" position-relative d-flex justify-content-start align-items-center h-100">
                                <div
                                    class="d-flex flex-column justify-content-between align-items-start h-100 px-5 fs-5">
                                    <h4 class="m-0">Name :</h4>
                                    <h5 class="m-0">Email :</h5>
                                    <h5 class="m-0">Phone Number :</h5>
                                    <h5 class="m-0">Department :</h5>
                                    <h5 class="m-0">Position :</h5>
                                </div>
                                <div class="d-flex flex-column justify-content-between h-100 pe-5">
                                    <h4 class="m-0">Harry Maguire</h4>
                                    <h5 class="m-0">harry006@gmail.com</h5>
                                    <h5 class="m-0">+1 356 897 656</h5>
                                    <h5 class="m-0">Football Department</h5>
                                    <h5 class="m-0">QA Manager</h5>
                                </div>
                                <div class="postion-absolute">
                                    <p class="text-success">🟢 A C T I V E </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="bg-white border border-dark-subtle">
                        <div class="bg-nav-title text-white d-flex justify-content-center align-items-center p-4">
                            <h3 class="m-0 fs-3">Staff Management System</h3>
                        </div>
                        <div>

                            <div class="p-4">
                                <h4 class="pb-2">Staff List</h4>
                                <button class="btn bg-leaf text-white">Add New Account</button>
                            </div>

                            <table class="w-100 table-borderless text-center border px-3">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td>Harry Maguire</td>
                                    <td>Harry@example.com</td>
                                    <td>QA Manager</td>
                                    <td>School Management</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ruben Amorim</td>
                                    <td>Amorim@example.com</td>
                                    <td>QA Coordinator</td>
                                    <td>School Management</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bruno Fernandes</td>
                                    <td>bruno@example.com</td>
                                    <td>QA Coordinator</td>
                                    <td>School Management</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">View</button>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <script>

        const menu = document.querySelector('.menu-bars');
        const navigation = document.querySelector('.navigation');
        const naviBack = document.querySelector('.navi-back');
        const fullContent = document.querySelector('.full-content');
        const h2 = document.querySelector('.navigation h2');

        menu.addEventListener('click', () => {
            if (navigation.style.display === 'none' || navigation.style.width === '0%') {
                navigation.style.display = 'block';
                naviBack.style.display = 'block';
                setTimeout(() => {
                    navigation.style.width = '17%';
                    naviBack.style.width = '17%';
                    fullContent.style.transition = '0.5s';
                    fullContent.style.width = '83%';
                    h2.style.display = 'block';
                }, 100);


            } else {
                fullContent.style.width = '100%';
                navigation.style.width = '0%';
                naviBack.style.width = '0%';
                h2.style.display = 'none';
                setTimeout(() => {
                    navigation.style.display = 'none';
                    naviBack.style.display = 'none';
                }, 350);

            }
        });

    </script>
</body>
</html> -->






@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
             @session('success')
                        <div class="alert alert-success">
                                    {{$value}}
                        </div>
                        @endsession
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                @can ('user-create')
                    <a href="{{route('users.create')}}" class="btn btn-success mb-3">Create User</a>
                @endcan
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->getRoleNames() as $role)
                                    <button class="btn btn-success btn-sm">{{$role}}</button>
                                    @endforeach
                                </td>
                               <td>
                               <form action="{{route('users.destroy',$user->id)}}" method="POST">
                        @csrf
                        @method ('DELETE')
                        @can ('user-list')
                                  <a href="{{route('users.show',$user->id)}}" class="btn btn-sm btn-info">Details</a>
                        @endcan
                        @can ('user-edit')
                                  <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-info">Edit</a>
                                @endcan
                                @can ('user-delete')
                               <button class="btn btn-danger btn-sm">Delete</button>
                               @endcan
                               </form>
                            </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                      
                    </table>

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
