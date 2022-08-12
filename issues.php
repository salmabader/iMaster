<?php
session_start();
require 'database/db_connection.php';
require 'mailConfig.php';

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
if (isset($_POST['acceptDelete'])) {
    $query = "SELECT FName,LName,email FROM instructor WHERE username ='" . $_POST['instructorUsername'] . "'";
    $result = mysqli_query($con, $query);
    $instructor = mysqli_fetch_assoc($result);
    $fullName = $instructor['FName'] . ' ' . $instructor['LName'];
    $mail->addAddress($instructor['email'], $fullName);     //Add a recipient

    $queryCouse = "SELECT title FROM course WHERE courseID ='" . $_POST['courseId'] . "'";
    $resultCourse = mysqli_query($con, $queryCouse);
    $courseTitle = mysqli_fetch_assoc($resultCourse);

    //Content
    $mail->Subject = 'Deleting course is done';
    $mail->Body    = 'Hello ' . ucfirst($instructor['FName']) . ',<br>
    The course: <b>' . $courseTitle['title'] . '</b> has been deleted based on your request.<br><br>
    Regards,<br>' . $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . '<br><br>iMaster';
    if ($mail->send()) {
        $feedback = "The course: " . $courseTitle['title'] . " was deleted";
    }
    $delete = "DELETE FROM course WHERE courseID ='" . $_POST['courseId'] . "'";
    mysqli_query($con, $delete);
}
if (isset($_POST['sendBtn'])) {
    $updateQuery = "UPDATE requests SET status = 'commented', admin_username = '" . $_SESSION['username'] . "' WHERE type = 'others' AND status = 'waiting' AND instructor_username ='" . $_POST['username'] . "'";
    mysqli_query($con, $updateQuery);

    $query = "SELECT FName,LName,email FROM instructor WHERE username ='" . $_POST['username'] . "'";
    $result = mysqli_query($con, $query);
    $instructor = mysqli_fetch_assoc($result);
    $fullName = $instructor['FName'] . ' ' . $instructor['LName'];
    $mail->addAddress($instructor['email'], $fullName);     //Add a recipient

    //Content
    $mail->Subject = 'Reply from iMaster';
    $mail->Body    = $_POST['reply'] . '<br><br>' . $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . '<br>iMaster';
    if ($mail->send()) {
        $feedback = "Your reply is sent";
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Issues</title>
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
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="requests.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg><span class="toHide">Requests</span></a>
                        </div>
                        <div class="text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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
                                    <span id="newNotification" class="hidden">
                                        <div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 right-1 "></div>
                                        <div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 animate-ping right-1 "></div>
                                    </span>
                                </div>
                            </div>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNotification" class="hidden z-20 w-full max-w-sm bg-white rounded divide-y divide-gray-100 shadow-md" aria-labelledby="dropdownNotificationBtn">
                            <div class="block py-2 px-4 font-medium text-center text-gray-700 bg-gray-50">
                                Notifications
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto max-h-96 scrollbar" id="notify">
                                <?php
                                $query = "SELECT * FROM requests,instructor WHERE status = 'waiting' AND instructor_username = username ORDER BY requestID DESC";
                                $result = mysqli_query($con, $query);
                                $firstIteration = false;
                                if (mysqli_num_rows($result) > 0) {
                                    $firstIteration = true;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row['type'] == 'application') { ?>
                                            <a onclick="$('#instructor-tab').click()" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                                <div class="flex-shrink-0 text-blue-600 bg-blue-200 rounded-full p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <div class="pl-3 w-full flex justify-between">
                                                    <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?> sent an application</div>
                                                    <?php if ($firstIteration) { ?>
                                                        <span new-indecator class=" bg-pink-400 text-white text-xs font-semibold px-2 py-1 rounded-md flex items-center">New</span>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                        <?php } elseif ($row['type'] == 'course') {
                                            $courseQuery = "SELECT title FROM course WHERE courseID = '" . $row['course_id'] . "'";
                                            $result2 = mysqli_query($con, $courseQuery);
                                            $course = mysqli_fetch_assoc($result2);
                                        ?>
                                            <a onclick="$('#course-tab').click()" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                                <div class="flex-shrink-0 text-amber-600 bg-amber-200 rounded-full p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div class="pl-3 w-full flex justify-between">
                                                    <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">"<?php echo ucfirst($course['title']) ?>" course needs your review</div>
                                                    <?php if ($firstIteration) { ?>
                                                        <span new-indecator class=" bg-pink-400 text-white text-xs font-semibold px-2 py-1 rounded-md flex items-center">New</span>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                <?php }
                                        $firstIteration = false;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- col 2: content -->
                <div class="w-full h-[85%]">
                    <div class="md:ml-5 mt-5 mb-3">
                        <!-- Title -->
                        <p class="text-xl font-semibold capitalize w-full tracking-wide text-gray-700">All problems sent by instructors</p>
                    </div>

                    <!-- tabs content -->
                    <div id="myTabContent" class="relative">
                        <!-- instructor content -->
                        <div class="p-4 bg-gray-50 rounded-lg" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                            <div class="overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">

                                <!-- get instructor requests -->
                                <?php
                                $query = "SELECT * FROM requests,instructor WHERE status = 'waiting' AND instructor_username = username ORDER BY requestID DESC";
                                $result = mysqli_query($con, $query);
                                if (mysqli_num_rows($result) > 0) { ?>
                                    <div class="overflow-y-auto overflow-x-hidden scrollbar max-h-96">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <tbody>
                                                <?php
                                                $q = "SELECT * FROM requests WHERE status='waiting' AND (type ='DeleteCourse' OR type = 'others')";
                                                $r = mysqli_query($con, $q);
                                                if (mysqli_num_rows($r) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['type'] == "DeleteCourse" || $row['type'] == "others") {
                                                            if ($row['type'] == "DeleteCourse") {
                                                                $courseQuery = "SELECT * FROM course WHERE courseID = '" . $row['course_id'] . "'";
                                                                $result2 = mysqli_query($con, $courseQuery);
                                                                $course = mysqli_fetch_assoc($result2);
                                                            }
                                                ?>
                                                            <tr class="bg-white border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                    <?php
                                                                    if ($row['type'] == "DeleteCourse") {
                                                                        echo "Delete course";
                                                                    } elseif ($row['type'] == "others") {
                                                                        echo "Problem";
                                                                    } ?>
                                                                </td>
                                                                <?php if ($row['type'] == "DeleteCourse") { ?>
                                                                    <td class="py-4 px-6" inst-field>
                                                                        <?php echo ucfirst($course['category']) ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="py-4 px-6">From:
                                                                        <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?>
                                                                    </td>
                                                                <?php } ?>
                                                                <td class="py-4 px-6">
                                                                    <?php $date = explode("-", $row['date']);
                                                                    echo 'Submitted on <span>' . $date[2] . '/' . $date[1] . '/' . $date[0] . '</span>' ?>
                                                                </td>
                                                                <td class="py-4 px-6 flex justify-end gap-4 items-center">
                                                                    <button data-modal-toggle="<?php echo $row['type'] . '_' . $row['requestID'] ?>" class="flex items-center text-blue-600 p-1 hover:bg-blue-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                        </svg><span>Details</span></button>
                                                                    <p>|</p>
                                                                    <!-- Main modal -->
                                                                    <div id="<?php echo $row['type'] . '_' . $row['requestID'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                                                            <!-- Modal content -->
                                                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                                <!-- Modal header -->
                                                                                <div class="flex justify-between items-start p-4 pb-1 rounded-t border-b dark:border-gray-600">
                                                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                        <?php
                                                                                        if ($row['type'] == "DeleteCourse") {
                                                                                            echo "Delete course request";
                                                                                        } elseif ($row['type'] == "others") {
                                                                                            echo "Problem details";
                                                                                        } ?>
                                                                                    </h3>
                                                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="<?php echo $row['type'] . '_' . $row['requestID'] ?>">
                                                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                                        </svg>
                                                                                        <span class="sr-only">Close modal</span>
                                                                                    </button>
                                                                                </div>
                                                                                <!-- Modal body -->
                                                                                <div class="p-6 pt-3 space-y-6">
                                                                                    <div class="text-base leading-relaxed text-gray-800 flex flex-col">
                                                                                        <?php
                                                                                        if ($row['type'] == "DeleteCourse") { ?>
                                                                                            <p class="w-full font-bold text-xl border-b border-gray-300 text-blue-800 pb-2"><?php echo ucfirst($course['title']) ?></p>
                                                                                            <div class="flex justify-between w-full mt-3">
                                                                                                <p><?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?></p>
                                                                                                <p><?php echo ucfirst($course['category']) ?></p>
                                                                                            </div>
                                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">- Details:</div>
                                                                                            <div class="w-full ml-5"><?php echo ucfirst($row['reason']) ?></div>
                                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">
                                                                                                - Contact:
                                                                                            </div>
                                                                                            <div class="w-full ml-5">
                                                                                                <a class="text-blue-700" href="mailto:<?php echo $row['email'] ?>">Email</a>
                                                                                            </div>
                                                                                        <?php } else { ?>
                                                                                            <p class="w-full font-bold text-xl border-b border-gray-300 text-blue-800 pb-2">From <?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?></p>
                                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">- Details:</div>
                                                                                            <div class="w-full ml-5"><?php echo ucfirst($row['reason']) ?></div>
                                                                                            <div class="w-full mt-5 text-gray-800 font-semibold">
                                                                                                - Contact:
                                                                                            </div>
                                                                                            <div class="w-full ml-5">
                                                                                                <a class="text-blue-700" href="mailto:<?php echo $row['email'] ?>">Email</a>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($row['type'] == "DeleteCourse") { ?>
                                                                        <form action="issues.php" method="POST" class="flex justify-between items-center gap-4">
                                                                            <input name="courseId" value="<?php echo $row['course_id'] ?>" class="hidden">
                                                                            <input name="instructorUsername" value="<?php echo $row['username'] ?>" class="hidden">
                                                                            <button name="acceptDelete" class="flex items-center text-green-600 p-1 hover:bg-green-100 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline mr-[2px]" viewBox="0 0 20 20" fill="currentColor">
                                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                                </svg><span>Accept</span></button>
                                                                        </form>
                                                                    <?php } else { ?>
                                                                        <button data-modal-toggle="<?php echo $row['requestID'] . '_' . $row['instructor_username'] ?>" class="flex items-center text-yellow-700 p-1 hover:bg-amber-200 rounded-md">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[17px] mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                                            </svg>
                                                                            <span>Reply</span></button>
                                                                        <!-- Main modal -->
                                                                        <div id="<?php echo $row['requestID'] . '_' . $row['instructor_username'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                                                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                                                                <!-- Modal content -->
                                                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                                                    <!-- Modal header -->
                                                                                    <div class="flex justify-between items-start p-4 pb-1 rounded-t border-b dark:border-gray-600">
                                                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                            Send a reply
                                                                                        </h3>
                                                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="<?php echo $row['requestID'] . '_' . $row['instructor_username'] ?>">
                                                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                                            </svg>
                                                                                            <span class="sr-only">Close modal</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <!-- Modal body -->
                                                                                    <div class="p-6 pt-3 space-y-6">
                                                                                        <div class="text-base leading-relaxed text-gray-800 flex flex-col">
                                                                                            <form action="issues.php" method="POST" class="flex flex-col">
                                                                                                <input name="username" value="<?php echo $row['username'] ?>" class="hidden">
                                                                                                <label for="adminComment">Your reply</label>
                                                                                                <textarea type="text" id="adminComment" name="reply" class="rounded-md border border-gray-400 mt-1"></textarea>
                                                                                                <div class="w-full flex justify-center">
                                                                                                    <button name="sendBtn" class="rounded-full bg-blue-700 text-white px-4 py-2 mt-4 w-1/2 ">Send</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    }
                                                } else { ?>
                                                    <p class="p-3">There is no any issues</p>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <p class="p-3">There is no any issues</p>
                                <?php } ?>
                            </div>
                        </div>
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

    <!-- toast msg -->
    <div id="action-feedback" class="opacity-0 flex fixed bottom-5 right-9 items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow border border-green-600" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-600 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg aria-hidden="true" class="h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal" id="feedbackMsg"><?php if (isset($feedback)) echo $feedback ?></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#action-feedback" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <script src="js/request.js"></script>
    <script src="js/analytics.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        const indecator = document.getElementById("newNotification")
        const notificationBtn = document.getElementById("dropdownNotificationBtn")

        var pusher = new Pusher('b2e65e119e246c55827a', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            indecator.classList.remove("hidden")
            indecator.classList.add("block")
            $.ajax({
                url: "notification.php",
                success: function(result) {
                    $("#notify").html(result);
                }
            });
        });
        notificationBtn.addEventListener('click', function() {
            const newIndecator = document.querySelectorAll("[new-indecator]")
            if (indecator.className == "block") {
                indecator.classList.remove("block")
                indecator.classList.add("hidden")
            } else {
                newIndecator.forEach(element => {
                    element.classList.add("hidden")
                });
            }
        })

        // ---------- to show toast msg ----------
        const toast = document.getElementById("action-feedback")
        const msg = document.getElementById("feedbackMsg")
        window.addEventListener('load', function() {
            if (msg.innerHTML.length > 0) {
                toast.classList.remove("opacity-0")
                toast.classList.add("opacity-100")
            }
        })
    </script>
</body>

</html>