<!DOCTYPE html>
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
                    <a class="text-decoration-none" href="#">Dashboard</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-bars pe-4"></i>
                    <a class="text-decoration-none" href="#">Idea Lists</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-graduation-cap pe-4"></i>
                    <a class="text-decoration-none" href="#">Academic Years</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="#">Categories</a>
                </div>
                <div class="hover-div d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                    <i class=" fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="#">Account Management</a>
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

            <div style="background-color: #e9f1fa; height: 100vh">
                content here
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

</html>