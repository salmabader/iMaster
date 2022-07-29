<?php

session_start();
require 'database/db_connection.php';
// if there is a session but user is not student
if (isset($_SESSION['type'])) {
    $privilage = $_SESSION['type'];
    if ($privilage != "student") {
        header('Location: index.php');
    }
} else { // if there is no session
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
    <link rel="icon" href="images/icon.svg" type="image/x-icon">
    <title>student_home</title>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .scrollbar::-webkit-scrollbar {
            width: 10px;
        }

        .scrollbar::-webkit-scrollbar-track {
            border-radius: 100vh;
            background: none;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: rgb(147 197 253);
            border-radius: 100vh;
            border: 3px solid #d8f0fc;
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgb(147 197 253);
        }
    </style>

</head>

<body class="overflow-x-hidden h-screen w-screen">
    <main class="flex w-full h-full">
        <!-- left side -->
        <div id="leftSide" class="flex flex-col lg:w-1/5 lg:block hidden h-full mr-4 transition-all duration-500">
            <!-- container of left side -->
            <div class="bg-amber-50 border-r-[1px] border-amber-200 border-dashed flex flex-col justify-between items-center w-full h-full relative">

                <!-- logo -->
                <div class="h-1/4">
                    <img id="logo" src="images/logo.svg" class="h-12 mt-5 mb-10">
                </div>
                <!-- options -->
                <div id="optionsDiv" class="mt-10 w-full max-w-1/2 h-1/2  flex flex-col justify-between items-center text-amber-400 font-semibold text-lg  ">
                    <div class="flex items-center justify-center  py-3 text-blue-800 duration-100 ease-in-out mb-5 bg-amber-200 border-b-[1px] border-t-[1px]  border-amber-400 border-dashed shadow-md rounded-xl w-60 ">
                        <a href="student_home_page.php" class="  duration-100 ease-in-out  flex items-center "><svg class="h-5 inline mr-4 optionIcons" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg><span class="toHide">Home</span></a>
                    </div>
                    <div class="flex items-center justify-center  py-3 mt-10 hover:text-blue-800 hover:bg-amber-200 hover:border-b-[1px] hover:border-t-[1px] hover:border-amber-400 hover:border-dashed hover:shadow-md duration-100 ease-in-out mb-5 rounded-xl w-60">
                        <a href="student_course_page.html" class=" duration-100 ease-in-out  flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg><span class="toHide">Courses</span></a>
                    </div>
                    <div class="flex  items-center justify-center  py-3 mt-10 hover:text-blue-800 duration-100 ease-in-out hover:bg-amber-200 hover:border-b-[1px] hover:border-t-[1px] hover:border-amber-400 hover:border-dashed hover:shadow-md mb-5 rounded-xl w-60">
                        <a href="student_favoreite_page.html" class=" duration-100 ease-in-out flex items-center">
                            <svg class="h-5 inline mr-4 optionIcons" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg><span class="toHide">Favoreite</span></a>
                    </div>

                </div>

                <!-- log out -->
                <div class="flex  justify-center items-center h-1/2 ">
                    <button onclick="window.location.href='database/destroy_session.php'" id="signoutBtn" class="text-xs md:text-sm bg-amber-100 mt-32 px-6 py-1  rounded-xl shadow-md border-amber-200 border-2 hover:bg-amber-200 duration-300 ease-in-out"><span id="signOutTtitle" class="toHide  text-blue-800">log
                            out </span><svg xmlns="http://www.w3.org/2000/svg" class=" h-3 w-3 md:h-6 md:w-6 inline text-blue-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></button>
                </div>

                <div id="minimizeBtn" class="absolute -right-4 bottom-1/4 flex items-center bg-white hover:bg-amber-200  hover:text-blue-800 hover:cursor-pointer duration-150 ease-in-out rounded-full border-amber-200 border-2 p-1 text-amber-400 minimizeBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                    </svg>
                </div>
            </div>
        </div> <!-- end of left side-->
        <!-- right side -->
        <div id="rightSide" class="lg:w-4/5 lg:mx-0 lg:mr-4 mx-5 w-full h-full transition-all duration-500">
            <div class="flex flex-col h-full w-full">
                <!-- col 1: header -->
                <div class="w-full h-[15%] flex justify-between mt-3 border-b-[1px]  border-amber-100 border-dashed">
                    <!-- profile -->
                    <div class="w-2/3 flex items-center mb-2">
                        <!-- personal photo -->
                        <div class="md:w-1/6 sm:w-1/4 h-full flex md:justify-end sm:justify-start justify-center w-1/2">
                            <a href="#profile">
                                <img src="images/avatar2.png" class="h-full rounded-full ml-2 border-[3px] border-amber-200">
                            </a>
                        </div>
                        <!-- greeting -->
                        <div class="md:w-5/6 flex flex-col h-full justify-center sm:ml-3 sm:w-3/4 w-1/2  mb-5">
                            <div class="w-full md:text-xl text-lg font-semibold text-gray-800">Welcome, <span class="capitalize"><?php if (isset($_SESSION['firstName'])) echo $_SESSION['firstName']; ?></span></div>
                            <div class="w-full text-sm text-gray-600 capitalize"><?php if (isset($_SESSION['type'])) echo $_SESSION['type']; ?></div>
                        </div>

                    </div>
                    <!-- notifications -->
                    <div class="w-1/3 mr-5 flex items-center justify-end text-gray-500">
                        <!-- notification icon -->
                        <button>
                            <div class="bg-amber-50 shadow rounded-md p-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <div class="absolute bg-amber-500 h-2 w-2 rounded-full top-1.5 right-1 "></div>
                                    <div class="absolute bg-amber-500 h-2 w-2 rounded-full top-1.5 animate-ping right-1 "></div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
                <!-- col 2: content -->
                <div class="w-1/6 h-[5%] flex justify-between mt-3  text-blue-800  font-bold ">
                    Recommended For You
                </div>
                <!-- container of Recommended card -->


                <!-- card -->



                <!--end Recommended card-->
                <div class="w-1/6 h-[5%] flex justify-between mt-6  text-blue-800  font-bold ">
                    All Courses
                </div>
                <!--allcourses card-->

                <!--end allcourses card-->
                <footer class=" flex w-full  items-center justify-center text-blue-200">
                    Copyright © 2022 iMaster
                </footer>
            </div>
        </div> <!-- end of right side-->
    </main>
    <script src="student_home.js"></script>
</body>

</html>