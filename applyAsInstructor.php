<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
if (isset($_SESSION['type'])) {
    $privilage = $_SESSION['type'];
    if (isset($_SESSION['username']) && $privilage == "student") {
        header('Location: student_home.html');
        exit();
    } elseif (isset($_SESSION['username']) && $privilage == "instructor") {
        header('Location: instructor_home.html');
        exit();
    } else {
        header('Location: analytics.php');
        exit();
    }
}
require('database/db_connection.php');
$con = OpenCon();
if (isset($_POST['createAccountBtn'])) {
    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        'b2e65e119e246c55827a',
        '956e3a00348571b20a5c',
        '1457323',
        $options
    );
    $isValidEmail = true;
    $isValidUsername = true;
    $fName = filter_input(INPUT_POST, 'firstName');
    $lName = filter_input(INPUT_POST, 'lastName');
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    $courseLink = filter_input(INPUT_POST, 'courseLink');
    $bio = filter_input(INPUT_POST, 'bio');
    $degree = filter_input(INPUT_POST, 'degree');
    $field = filter_input(INPUT_POST, 'field');
    $year = filter_input(INPUT_POST, 'year');
    $existanceQuery1 = "SELECT * FROM student WHERE username = ? OR email = ?";
    $existanceQuery2 = "SELECT * FROM instructor WHERE username = ? OR email = ?";
    $statement1 = mysqli_stmt_init($con);
    $statement2 = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement1, $existanceQuery1) || !mysqli_stmt_prepare($statement2, $existanceQuery2)) {
        header('Location: index.php?error=SQLError');
        exit();
    } else {
        mysqli_stmt_bind_param($statement1, "ss", $username, $email);
        mysqli_stmt_execute($statement1);
        $result1 = mysqli_stmt_get_result($statement1);
        mysqli_stmt_bind_param($statement2, "ss", $username, $email);
        mysqli_stmt_execute($statement2);
        $result2 = mysqli_stmt_get_result($statement2);
        $fetchedUsers = array();
        //to store all the fetched rows
        while ($stu = mysqli_fetch_assoc($result1)) {
            $fetchedUsers[] = $stu['username'];
            $fetchedUsers[] = $stu['email'];
        }
        while ($inst = mysqli_fetch_assoc($result2)) {
            $fetchedUsers[] = $inst['username'];
            $fetchedUsers[] = $inst['email'];
        }
        if (count($fetchedUsers) > 0) {
            if (in_array($username, $fetchedUsers)) {
                $usernameError = "Usename is taken";
                $isValidUsername = false;
            }
            if (in_array($email, $fetchedUsers)) {
                $emailError = "Email is already registered";
                $isValidEmail = false;
            }
        }
        if ($isValidUsername && $isValidEmail) {
            $insertQuery = "INSERT INTO instructor (username,FName,LName,email,password,field,previous_course,degree,experience,bio) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $statement = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($statement, $insertQuery)) {
                header('Location: index.php?error=InsertionError');
                exit();
            } else {
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($statement, "ssssssssss", $username, $fName, $lName, $email, $hashedPass, $field, $courseLink, $degree, $year, $bio);
                mysqli_stmt_execute($statement);
                date_default_timezone_set('Asia/Riyadh');
                $date = date("Y-m-d");
                $insertQuery = "INSERT INTO requests (type,status,instructor_username,date) VALUES ('application','waiting','$username','$date')";
                mysqli_query($con, $insertQuery);
                $data['message'] = $fName;
                $pusher->trigger('my-channel', 'my-event', $data);
            }
        }
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
    <title>Apply as instructor</title>
    <style>
        .scrollbar::-webkit-scrollbar {
            width: 10px;
        }

        .scrollbar::-webkit-scrollbar-track {
            border-radius: 100vh;
            background: none;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #eeeeee;
            border-radius: 100vh;
            border: 3px solid white;
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: #DFDFDF;
        }

        .rightBg {
            background-image: linear-gradient(90deg, rgb(219, 234, 254) 0%, transparent 40%), repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.18) 0px, rgba(255, 255, 255, 0.18) 1px, transparent 1px, transparent 13px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.18) 0px, rgba(255, 255, 255, 0.18) 1px, transparent 1px, transparent 13px), linear-gradient(0deg, rgb(219, 234, 254), rgb(219, 234, 254));
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
    <!-- prevent resubmission when refresh the page -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center w-full h-screen overflow-x-hidden text-gray-700 scrollbar">
    <a href="index.php">
        <img src="images/logo.svg" class="lg:hidden block h-14 mb-2">
    </a>
    <div class="bg-white lg:w-3/4 w-4/5 flex rounded-lg border-blue-500 border-x-2 shadow-md h-4/5">
        <!-- left side -->
        <div class="lg:w-2/3 w-full flex flex-col lg:mr-4 mr-0">
            <p class="text-xs text-right pt-6 pr-6">Already have an account? <span class="text-blue-600 hover:underline"><a href="signin.php">Sign
                        in</a></span></p>
            <p class="text-center pt-3 font-medium text-xl">Apply as Instructor</p>
            <p class="text-center p-1 text-xs mb-4 text-amber-600">please fill in all information to be able to submit the form</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
                <!-- first name -->
                <div class="flex w-1/2">
                    <div class="w-full ">
                        <label for="fName" class="block capitalize font-semibold">first name</label>
                        <input type="text" name="firstName" id="fName" placeholder="Salma" class="w-full mt-1 bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" value="<?php if (isset($fName)) echo htmlspecialchars($fName) ?>">
                    </div>
                </div>
                <!-- last name -->
                <div class="flex w-1/2">
                    <div class="w-full ml-2">
                        <label for="lName" class="block capitalize font-semibold">last name</label>
                        <input type="text" name="lastName" id="lName" placeholder="Bader" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" value="<?php if (isset($lName)) echo htmlspecialchars($lName) ?>">
                    </div>
                </div>
                <!-- username -->
                <div class="w-1/2 mt-3">
                    <label for="usename" class="block capitalize font-semibold">username</label>
                    <input type="text" name="username" maxlength="10" id="signup_usename" placeholder="_salma" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" value="<?php if (isset($username)) echo htmlspecialchars($username) ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="usernameError"><?php if (isset($usernameError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $usernameError ?></p>
                    </div>
                </div>
                <!-- password -->
                <div class="flex w-1/2">
                    <div class="w-full ml-2 mt-3">
                        <label for="password" class="block capitalize font-semibold">password</label>
                        <div class="relative">
                            <div id="eyeIcon" class="eyeIcon flex absolute inset-y-0 right-0 items-center pr-3 cursor-pointer">
                                <svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
                        </div>
                        <div class="text-red-500 text-sm mt-2">
                            <p id="passwordError" class="flex items-center"></p>
                        </div>
                    </div>
                </div>

                <!-- tooltip -->
                <div id="tooltip-click" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm opacity-0 tooltip transition-opacity duration-200">
                    <ul>Password must be:
                        <li><span id="passLength"></span>at least 8 characters</li>
                        <li><span id="passCL"></span>contains at least one capital letter</li>
                        <li><span id="passSL"></span>contains at least one small letter</li>
                        <li><span id="passSC"></span>contains at least one special character</li>
                    </ul>
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <!-- email -->
                <div class="w-full mt-2">
                    <label for="email" class="block capitalize font-semibold">email</label>
                    <input type="email" name="email" id="email" placeholder="example@email.com" class="w-full mt-1 bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="emailError"><?php if (isset($emailError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $emailError ?></p>
                    </div>
                </div>
                <!-- form part2 -->
                <div class="w-full border-t-2 border-gray-100 mt-3">
                    <!-- degree -->
                    <label for="degree" class="block capitalize font-semibold my-2">Your degree</label>
                    <select id="degree" name="degree" class="bg-blue-50 px-6 py-2.5 border-2 border-blue-200 focus:bg-white text-sm rounded-lg block w-full">
                        <option selected value="0">Choose your degree</option>
                        <option value="ungraduate">Ungraduate</option>
                        <option value="bachelor">Bachelor</option>
                        <option value="master">Master</option>
                        <option value="PhD">PhD</option>
                    </select>
                    <!-- field -->
                    <div class="flex">
                        <div class="flex w-1/2">
                            <div class="w-full mr-2">
                                <label for="field" class="block capitalize font-semibold my-2">Your field</label>
                                <select id="field" name="field" class="bg-blue-50 px-6 py-2.5 border-2 border-blue-200 focus:bg-white text-sm rounded-lg block w-full">
                                    <option selected value="0">Choose your field</option>
                                    <option value="programming">Programming</option>
                                    <option value="mathematics">Mathematics</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="IT & Software">IT & Software</option>
                                    <option value="business">Business</option>
                                </select>
                            </div>
                        </div>
                        <!-- experience -->
                        <div class="flex w-1/2">
                            <div class="w-full">
                                <label for="year" class="block capitalize font-semibold my-2">your experience</label>
                                <input type="number" id="year" name="year" placeholder="##" class="appearance-none w-full bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800" value="<?php if (isset($year)) echo htmlspecialchars($year) ?>">
                            </div>
                        </div>
                    </div>
                    <label class="block font-semibold my-2">Have you introduced previous courses?</label>
                    <div class="flex flex-wrap flex-col lg:flex-row mt-1">
                        <div class="lg:w-1/3">
                            <input type="radio" name="radioBtns[]" value="yes" id="yes" class="h-4 w-4 border border-gray-400 bg-white checked:bg-blue-400 checked:border-blue-300  focus:outline-none focus:ring-blue-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="yes" class="capitalize"> yes</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="radio" name="radioBtns[]" value="no" id="no" class="h-4 w-4 border border-gray-400 bg-white checked:bg-blue-400 checked:border-blue-300  focus:outline-none focus:ring-blue-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="no" class="capitalize"> no</label>
                        </div>
                        <div class="block w-full">
                            <input type="url" name="courseLink" id="courseLink" class="hidden mt-2 w-full rounded-lg focus:bg-blue-50 placeholder-gray-400 text-blue-800" value="<?php if (isset($courseLink)) echo htmlspecialchars($courseLink) ?>" placeholder="please paste the course link">
                        </div>
                    </div>
                    <label for="bio" class="block capitalize font-semibold my-2">about you</label>
                    <textarea name="bio" id="bio" placeholder="Please write a brief about you" class=" bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 w-full"><?php if (isset($bio)) echo htmlspecialchars($bio) ?></textarea>
                </div>

                <!-- button -->
                <div class="flex flex-col items-center">
                    <button type="submit" name="createAccountBtn" id="signupBtn" class="mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Create
                        account</button>
                    <p class="text-xs mt-4">OR <span class=" text-blue-600 hover:underline"><a href="createStudentAccount.php">create account as student</a></span></p>
                </div>
            </form>
        </div>

        <!-- right side -->
        <div class="w-1/3 lg:block hidden rounded-r-lg rightBg h-full">
            <!-- logo -->
            <div class="flex flex-col justify-between h-full">
                <div class="flex justify-end p-5">
                    <a href="index.php">
                        <img src="images/logo.svg" class="h-10">
                    </a>
                </div>
                <img src="images/instructor_signup.png" class="rounded-br-lg">
            </div>
        </div>
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/instructor_createAccount.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>