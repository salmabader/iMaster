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
$con = OpenCon();
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
    <title>Dashboard</title>
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
    $query = "SELECT * FROM " . $_SESSION['type'] . " WHERE username ='" . $_SESSION['username'] . "'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
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
                        <div class="text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="analytics.php" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg><span class="toHide">Dashboard</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="studentCourse.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg><span class="toHide">Courses</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="favorite.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg><span class="toHide">Favorite</span></a>
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
                                <?php echo ucfirst(substr($user['FName'], 0, 1)) . ucfirst(substr($user['LName'], 0, 1)) ?>
                            </span>
                            <div class="absolute bottom-3 -right-1 bg-amber-200 p-[2px] rounded-full border-[1px] border-blue-400 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </div>
                        </button>
                        <!-- greeting -->
                        <div class="md:w-5/6 flex flex-col h-full justify-center sm:ml-3 sm:w-3/4 w-1/2">
                            <div class="w-full text-xl text-md font-semibold text-gray-800">Welcome back, <span class="capitalize"><?php if (isset($user['FName'])) echo $user['FName']; ?> 👋🏻</span></div>
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
                <div class="w-full h-[85%] overflow-y-auto overflow-x-hidden scrollbar pb-5">
                    <!-- statistics -->
                    <div class="flex flex-col md:ml-5 mt-5">
                        <p class="text-xl font-bold capitalize w-full tracking-wide text-gray-700 mb-2">Statistics</p>
                        <div class="flex gap-5">
                            <!-- pie chart -->
                            <div class="w-1/2 lg:w-1/4 bg-gray-100 rounded-md px-3 py-4 border shadow-sm border-gray-300">
                                <canvas id="ChartPerCateg"></canvas>
                            </div>
                            <!-- another numbers -->
                            <div class="w-1/2 lg:w-3/4 flex flex-col">
                                <!-- total courses -->
                                <div class="w-1/2 lg:w-1/5 bg-gray-100 rounded-md px-3 py-4 border shadow-sm border-gray-300 flex flex-col">
                                    <p class="capitalize text-sm font-medium">registered courses</p>
                                    <!-- // get Total number of courses: -->
                                    <?php
                                    $query = "SELECT * FROM student_course, course WHERE stu_username = '" . $_SESSION['username'] . "' AND coID = courseID";
                                    $result = mysqli_query($con, $query);
                                    $Totalnumbers =  mysqli_num_rows($result);
                                    ?>
                                    <div class="flex items-center text-gray-800 gap-3">
                                        <p class="text-3xl font-bold w-1/2"><?php echo $Totalnumbers ?></p>
                                        <img src="images/courses.png" class="w-1/2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    // get # course in categories:
                    $query1 = "SELECT DISTINCT category FROM course";
                    $result1 = mysqli_query($con, $query1);
                    $categories = "";
                    $numbers = "";
                    $students = "";

                    while ($cate = mysqli_fetch_assoc($result1)) {
                        $categories .= '"' . ucfirst($cate['category']) . '",';
                        $query = "SELECT * FROM course WHERE category = '" . $cate['category'] . "'";
                        $result3 = mysqli_query($con, $query);
                        $numbers .=  mysqli_num_rows($result3) . ",";
                        $query = "SELECT * FROM student_course, course WHERE stu_username = '" . $_SESSION['username'] . "' AND coID = courseID";
                        $result = mysqli_query($con, $query);
                        $students .=  mysqli_num_rows($result3) . ",";
                    }

                    ?>


                    <!-- my courses -->
                    <div id="myCoursesSection" class="md:ml-5 mt-5 flex md:flex-wrap gap-3 md:flex-row flex-col">
                        <!-- get student's courses -->
                        <?php
                        $query = "SELECT * FROM student_course, course WHERE stu_username = '" . $_SESSION['username'] . "' AND coID = courseID";
                        $result = mysqli_query($con, $query);
                        if (mysqli_num_rows($result) > 0) { ?>
                            <p class="text-xl font-bold capitalize w-full tracking-wide text-gray-700">My courses</p>
                            <?php while ($course = mysqli_fetch_assoc($result)) {
                            ?>
                                <!-- card -->
                                <div class="w-full md:w-1/5 bg-gray-50 rounded-md shadow-sm border border-gray-300 relative" role="button">
                                    <!-- Image -->
                                    <img class="h-40 object-cover rounded-t-md w-full" src="upload/<?php echo $course['image'] ?>">
                                    <p class="absolute top-1 right-1
                                    <?php if ($course['level'] == 0) echo "bg-yellow-100 text-yellow-800";
                                    elseif ($course['level'] == 1) echo "bg-green-100 text-green-800";
                                    else echo "bg-red-100 text-red-800";
                                    ?> 
                                    text-[10px] font-medium px-2.5 py-0.5 rounded">
                                        <?php if ($course['level'] == 0) echo "Beginners";
                                        elseif ($course['level'] == 1) echo "Intermediate";
                                        else echo "Advanced"; ?>
                                    </p>
                                    <div class="p-2">
                                        <!-- title -->
                                        <p class="text-[10px] font-semibold pt-0 text-blue-700"><?php echo ucfirst($course['category']) ?></p>
                                        <h2 class="font-bold text-lg mb-1 border-b border-gray-200 truncate"><?php echo ucfirst($course['title']) ?></h2>
                                        <!-- instructor -->
                                        <?php
                                        // $sql = "SELECT * FROM course, instructor WHERE instructor_usename = username;";
                                        $query = "SELECT * FROM instructor, course WHERE username = '" . $course['instructor_usename'] . "'";
                                        $result2 = mysqli_query($con, $query);
                                        $instructor = mysqli_fetch_assoc($result2);
                                        ?>
                                        <p class="text-sm text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />
                                            </svg><?php echo ucfirst($instructor['FName']) . " " . ucfirst($instructor['LName']) ?></p>
                                    </div>
                                    <!-- btns -->
                                    <button class="py-1 bg-blue-200 rounded-b-md w-full flex justify-center text-md font-bold text-blue-700">View</button>
                                </div>
                                <!-- end of card -->
                        <?php }
                        } ?>
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
                    <form class="space-y-4" action="analytics.php" method="POST">
                        <div class="flex">
                            <div class="w-1/2 mr-2">
                                <label for="fname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">First name</label>
                                <input type="text" name="fname" id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $user['FName'] ?>" required>
                            </div>
                            <div class="w-1/2">
                                <label for="lname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last name</label>
                                <input type="text" name="lname" id="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo $user['LName'] ?>" required>

                            </div>
                        </div>
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
                            <input type="text" disabled name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="<?php echo $user['username'] ?>">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                            <input disabled type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="<?php echo $user['email'] ?>">
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
    <script>
        const ctx2 = document.getElementById('ChartPerCateg').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [<?= $categories ?>],
                datasets: [{
                    label: '# of courses: ',
                    data: [<?= $students ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 159, 64, 1)'
                    ]
                }]
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Pie Chart'
                }
            }
        });
    </script>
    <script src="js/analytics.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>