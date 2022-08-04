<?php
session_start();
require 'database/db_connection.php';
$con = OpenCon();
// if there is a session but user is not admin
if (isset($_SESSION['type'])) {
    $privilage = $_SESSION['type'];
    if ($privilage != "admin") {
        header('Location: index.php');
    }
} else { // if there is no session
    header('Location: index.php');
    exit();
}
if (isset($_POST['saveChangesBtn'])) {
    $fName = filter_input(INPUT_POST, 'fname');
    $lName = filter_input(INPUT_POST, 'lname');
    $query = "UPDATE $privilage SET FName = ?, LName = ? WHERE username ='" . $_SESSION['username'] . "'";
    $statement = mysqli_stmt_init($con);
    mysqli_stmt_prepare($statement, $query);
    mysqli_stmt_bind_param($statement, "ss", $fName, $lName);
    mysqli_stmt_execute($statement);
}
if (isset($_POST['accept'])) {
    $updateQuery = "UPDATE instructor SET isAccepted = 1 WHERE username ='" . $_POST['username'] . "'";
    mysqli_query($con, $updateQuery);
    $updateQuery = "UPDATE requests SET status = 'accepted', admin_username = '" . $_SESSION['username'] . "' WHERE type = 'application' AND status = 'waiting' AND instructor_username ='" . $_POST['username'] . "'";
    mysqli_query($con, $updateQuery);
}
if (isset($_POST['reject'])) {
    $query = "DELETE FROM instructor WHERE username ='" . $_POST['username'] . "'";
    mysqli_query($con, $query);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2/dist/chart.min.js"></script>
    <title>Requests</title>
    <style>
        .scrollbar::-webkit-scrollbar {
            width: 10px;
        }

        .scrollbar::-webkit-scrollbar-track {
            border-radius: 100vh;
            background: none;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #dadada;
            border-radius: 100vh;
            border: 3px solid white;
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgb(193, 193, 193);
        }

        #dropdownNotification {
            left: -1rem !important;
        }

        #dropdownNotification::before {
            content: "";
            width: 13px;
            height: 13px;
            background: #f9fafb;
            position: absolute;
            top: -7px;
            right: 35px;
            transform: rotate(45deg);
            border-top: 1px solid #f3f4f6;
            border-left: 1px solid #f3f4f6;
        }
    </style>
    <!-- prevent resubmission when refresh the page -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body class="h-screen w-screen overflow-hidden">
    <?php
    // retreive admin info:
    $query = "SELECT * FROM admin WHERE username ='" . $_SESSION['username'] . "'";
    $result = mysqli_query($con, $query);
    $admin = mysqli_fetch_assoc($result);
    ?>
    <main class="flex w-full h-full">
        <!-- left side -->
        <div id="leftSide" class="flex flex-col lg:w-1/5 lg:block hidden h-full mr-4 transition-all duration-500">
            <!-- container of left side -->
            <div class="bg-gray-50 border-r-[1px] border-gray-200 flex flex-col justify-between items-center w-full h-full relative">
                <!-- container of logo and options -->
                <div class="flex flex-col">
                    <!-- logo -->
                    <div>
                        <img id="logo" src="images/logo.svg" class="h-12 mt-5 mb-10">
                    </div>
                    <!-- options -->
                    <div id="optionsDiv" class="max-w-1/2 flex flex-col text-gray-700 font-semibold text-lg">
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="analytics.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg><span class="toHide">Analytics</span></a>
                        </div>
                        <div class="text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg><span class="toHide">Requests</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="issues.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg><span class="toHide">Issues</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="adminCourses.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg><span class="toHide">Courses</span></a>
                        </div>
                    </div>
                </div>
                <!-- sign out button -->
                <div class="mb-10">
                    <button onclick="window.location.href='database/destroy_session.php'" id="signoutBtn" class="bg-blue-100 hover:bg-blue-200 duration-200 ease-in-out px-8 py-2 text-blue-800 rounded-xl"><span id="signOutTtitle" class="toHide">Sign
                            out</span> <svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg></button>
                </div>
                <div id="minimizeBtn" class="absolute -right-4 bottom-1/2 flex items-center bg-white hover:bg-amber-400 hover:text-white hover:cursor-pointer duration-150 ease-in-out rounded-full border-gray-200 border-2 p-1 text-gray-700 minimizeBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                    </svg>
                </div>
            </div>
        </div> <!-- end of left side-->
        <!-- right side -->
        <div id="rightSide" class="lg:w-4/5 lg:mx-0 lg:mr-4 mx-5 w-full h-full transition-all duration-500">
            <div class="flex flex-col h-full">
                <!-- col 1: header -->
                <div class="w-full h-[100px] flex justify-between mt-3 border-b-[1px] border-gray-200">
                    <!-- profile -->
                    <div class="w-2/3 flex items-center mb-2">
                        <!-- personal photo -->
                        <button data-modal-toggle="profile-modal" class="w-[95px] relative flex justify-center items-center bg-blue-200  rounded-full p-7 border border-blue-400 hover:shadow-md hover:shadow-amber-300 shadow transition-all ease-in-out duration-200 sm:mr-0 mr-3">
                            <span class="text-blue-800 text-3xl font-semibold">
                                <?php echo ucfirst(substr($admin['FName'], 0, 1)) . ucfirst(substr($admin['LName'], 0, 1)) ?>
                            </span>
                            <div class="absolute bottom-3 -right-1 bg-amber-200 p-[2px] rounded-full border-[1px] border-blue-400 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </div>
                        </button>
                        <!-- greeting -->
                        <div class="md:w-5/6 flex flex-col h-full justify-center sm:ml-3 sm:w-3/4 w-1/2">
                            <div class="w-full text-xl font-semibold text-gray-800">Welcome back, <span class="capitalize"><?php if (isset($admin['FName'])) echo $admin['FName']; ?> 👋🏻</span></div>
                            <div class="w-full text-sm text-gray-600 capitalize"><?php if (isset($_SESSION['type'])) echo $_SESSION['type']; ?></div>
                        </div>
                    </div>
                    <!-- notifications -->
                    <div class="w-1/3 mr-5 flex items-center justify-end text-gray-500">
                        <!-- notification icon -->
                        <button id="dropdownNotificationBtn" data-dropdown-toggle="dropdownNotification">
                            <div class="bg-gray-200 shadow rounded-md p-2 hover:bg-gray-300">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 right-1 "></div>
                                    <div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 animate-ping right-1 "></div>
                                </div>
                            </div>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNotification" class="hidden z-20 w-full max-w-sm bg-white rounded divide-y divide-gray-100 shadow-md" aria-labelledby="dropdownNotificationBtn">
                            <div class="block py-2 px-4 font-medium text-center text-gray-700 bg-gray-50">
                                Notifications
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                <a href="#" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex-shrink-0 text-blue-600 bg-blue-200 rounded-full p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="pl-3 w-full">
                                        <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">Muhammad sent an application</div>
                                        <div class="text-xs text-gray-600">a few minutes ago</div>
                                    </div>
                                </a>

                                <a href="#" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex-shrink-0 text-amber-600 bg-amber-200 rounded-full p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div class="pl-3 w-full">
                                        <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">Math course needs your review</div>
                                        <div class="text-xs text-gray-600">a few minutes ago</div>
                                    </div>
                                </a>
                            </div>
                            <a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                                <div class="inline-flex items-center ">
                                    <svg class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    View all
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- col 2: content -->
                <div class="w-full h-[85%] overflow-y-auto overflow-x-hidden scrollbar">
                    <div class="md:ml-5 mt-5">
                        <!-- Title -->
                        <p class="text-xl font-semibold capitalize w-full tracking-wide text-gray-700">New instructors and courses</p>
                    </div>
                    <!-- tabs -->
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-flex p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group" id="instructor-tab" data-tabs-target="#instructor" type="button" role="tab" aria-controls="instructor" aria-selected="true">
                                    <svg aria-hidden="true" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                    </svg>Instructor
                                </button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button type="button" class="inline-flex p-4 text-blue-600 rounded-t-lg border-b-2 border-blue-600 active dark:text-blue-500 dark:border-blue-500 group" id="course-tab" data-tabs-target="#course" type="button" role="tab" aria-controls="course" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="mr-2 w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>Course
                                </button>
                            </li>
                        </ul>
                    </div> <!-- end of tabs -->

                    <!-- tabs content -->
                    <div id="myTabContent" class="relative">
                        <!-- instructor content -->
                        <div class="p-4 bg-gray-50 rounded-lg" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                            <div class="overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
                                <div class="flex justify-between items-center pb-4">
                                    <div>
                                        <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="ml-3 mt-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                            </svg>
                                            Filter on fields
                                            <svg class="ml-2 w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="dropdownRadio" class="hidden z-10 w-48 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 46.4px, 0px);" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                                                <li>
                                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <input data-categories id="filter-radio-example-0" type="radio" value="All" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                        <label for="filter-radio-example-0" class="ml-2 w-full text-sm font-medium text-gray-900 rounded">All</label>
                                                    </div>
                                                </li>
                                                <?php
                                                $query = "SELECT DISTINCT field FROM instructor";
                                                $result = mysqli_query($con, $query);
                                                $i = 1;
                                                while ($cate = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <li>
                                                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            <input data-categories id="filter-radio-example-<?php echo $i ?>" type="radio" value="<?php echo ucfirst($cate['field']) ?>" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                            <label for="filter-radio-example-<?php echo $i ?>" class="ml-2 w-full text-sm font-medium text-gray-900 rounded"><?php echo ucfirst($cate['field']) ?></label>
                                                        </div>
                                                    </li>
                                                <?php $i += 1;
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative mr-3 mt-3">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input data-search type="text" id="table-search" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                                    </div>
                                </div>
                                <!-- get instructor requests -->
                                <?php
                                $query = "SELECT * FROM requests,instructor WHERE type = 'application' AND status ='waiting' AND instructor_username = username ORDER BY requestID DESC ";
                                $result = mysqli_query($con, $query);
                                if (mysqli_num_rows($result) > 0) { ?>
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr class="bg-white border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white" data-fullname>
                                                        <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?>
                                                    </th>
                                                    <td class="py-4 px-6" data-field>
                                                        <?php echo ucfirst($row['field']) ?>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <?php if ($row['experience'] > 1) echo $row['experience'] . ' years experience';
                                                        else echo '1 year experience'; ?>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <?php $date = explode("-", $row['date']);
                                                        echo 'Submitted on <span>' . $date[2] . '/' . $date[1] . '/' . $date[0] . '</span>' ?>
                                                    </td>
                                                    <td class="py-4 px-6 flex justify-end gap-4 items-center">
                                                        <button data-modal-toggle="<?php echo $row['username'] ?>" class="flex items-center text-blue-600 p-1 hover:bg-blue-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg><span>Details</span></button>
                                                        <p>|</p>
                                                        <!-- Main modal -->
                                                        <div id="<?php echo $row['username'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                                                <!-- Modal content -->
                                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                    <!-- Modal header -->
                                                                    <div class="flex justify-between items-start p-4 pb-1 rounded-t border-b dark:border-gray-600">
                                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                            New instructor
                                                                        </h3>
                                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="<?php echo $row['username'] ?>">
                                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            <span class="sr-only">Close modal</span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- Modal body -->
                                                                    <div class="p-6 pt-3 space-y-6">
                                                                        <div class="text-base leading-relaxed text-gray-800 flex flex-col">
                                                                            <p class="w-full font-bold text-xl border-b border-gray-300 text-blue-800 pb-2"><?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?></p>
                                                                            <div class="flex justify-between w-full mt-3">
                                                                                <p><?php echo ucfirst($row['field']) ?></p>
                                                                                <p><?php echo ucfirst($row['degree']) ?></p>
                                                                                <p><?php echo ucfirst($row['experience']) . ' years experience' ?></p>
                                                                            </div>
                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">- About <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?>:</div>
                                                                            <div class="w-full ml-5"><?php echo ucfirst($row['bio']) ?></div>
                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">- <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?>'s previous courses:</div>
                                                                            <div class="w-full ml-5">
                                                                                <?php if ($row['previous_course'] != "") echo '<a class="text-blue-700" href="' . $row['previous_course'] . '" target="_blank">Find it here</a>';
                                                                                else echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) . ' does not have previuos courses' ?>
                                                                            </div>
                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">
                                                                                - Contact:
                                                                            </div>
                                                                            <div class="w-full ml-5">
                                                                                <a class="text-blue-700" href="mailto:<?php echo $row['email'] ?>">Email</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form action="requests.php" method="POST" class="flex justify-between items-center gap-4">
                                                            <input name="username" value="<?php echo $row['username'] ?>" class="hidden">
                                                            <button name="accept" class="flex items-center text-green-600 p-1 hover:bg-green-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg><span>Accept</span></button>
                                                            <p>|</p>
                                                            <button name="reject" class="flex items-center text-red-600 p-1 hover:bg-red-100 rounded-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg><span>Reject</span></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        </div> <!-- end of instructor content -->

                        <!-- course content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="course" role="tabpanel" aria-labelledby="course-tab">
                            <div class="overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
                                <div class="flex justify-between items-center pb-4">
                                    <div>
                                        <button id="dropdownRadioButton2" data-dropdown-toggle="dropdownRadio2" class="ml-3 mt-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                            </svg>
                                            Filter on fields
                                            <svg class="ml-2 w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownRadio2" class="hidden z-10 w-48 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 46.4px, 0px);" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton2">
                                                <?php
                                                $query = "SELECT DISTINCT category FROM course";
                                                $result = mysqli_query($con, $query);
                                                while ($cate = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <li>
                                                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            <input id="filter-radio-example-<?php echo $i ?>" type="radio" value="<?php echo ucfirst($cate['category']) ?>" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                            <label for="filter-radio-example-<?php echo $i ?>" class="ml-2 w-full text-sm font-medium text-gray-900 rounded"><?php echo ucfirst($cate['category']) ?></label>
                                                        </div>
                                                    </li>
                                                <?php $i += 1;
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative mr-3 mt-3">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input type="text" id="table-search" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                                    </div>
                                </div>
                                <!-- get instructor requests -->
                                <?php
                                $query = "SELECT * FROM requests,instructor WHERE type = 'application' AND status ='waiting' AND instructor_username = username";
                                $result = mysqli_query($con, $query);
                                if (mysqli_num_rows($result) > 0) { ?>
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr class="bg-white border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?>
                                                    </th>
                                                    <td class="py-4 px-6">
                                                        <?php echo ucfirst($row['field']) ?>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <?php echo $row['experience'] . ' years experience' ?>
                                                    </td>
                                                    <td class="py-4 px-6 flex justify-end gap-4">
                                                        <button class="flex items-center text-blue-600 p-1 hover:bg-blue-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg><span>Details</span></button>
                                                        <p>|</p>
                                                        <button name="accept" class="flex items-center text-green-600 p-1 hover:bg-green-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg><span>Accept</span></button>
                                                        <p>|</p>
                                                        <button name="reject" class="flex items-center text-gray-700 p-1 hover:bg-gray-200 rounded-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                            </svg><span>Comment</span></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        </div> <!-- end of course content -->
                    </div>

                </div>
            </div>
        </div>
        </div> <!-- end of right side-->
    </main>

    <!-- profile modal -->
    <div id="profile-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="profile-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">My Profile</h3>
                    <form class="space-y-6" action="analytics.php" method="POST">
                        <div class="flex">
                            <div class="w-1/2 mr-2">
                                <label for="fname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">First name</label>
                                <input type="text" name="fname" id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $admin['FName'] ?>" required>
                            </div>
                            <div class="w-1/2">
                                <label for="lname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last name</label>
                                <input type="text" name="lname" id="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $admin['LName'] ?>" required>

                            </div>
                        </div>
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
                            <input type="text" disabled name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="<?php echo $admin['username'] ?>">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                            <input disabled type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="<?php echo $admin['email'] ?>">
                        </div>
                        <div class="relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                            <input disabled type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <a class="text-blue-500 font-semibold hover:underline text-sm absolute top-10 right-3 cursor-pointer">Change</a>
                        </div>
                        <button type="submit" name="saveChangesBtn" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/analytics.js"></script>
    <script src="js/request.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>