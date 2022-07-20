<?php
session_start();
require('database/db_connection.php');
$con = OpenCon();
if (isset($_POST['createAccountBtn'])) {
    $isValidEmail = true;
    $isValidUsername = true;
    $fName = filter_input(INPUT_POST, 'firstName');
    $lName = filter_input(INPUT_POST, 'lastName');
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    $interests = $_POST['interests'];
    $existanceQuery1 = "SELECT * FROM student WHERE username = ? OR email = ?";
    $existanceQuery2 = "SELECT * FROM instructors WHERE username = ? OR email = ?";
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
            $insertQuery = "INSERT INTO student (username,FName,LName,email,password) VALUES (?,?,?,?,?)";
            $statement = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($statement, $insertQuery)) {
                header('Location: index.php?error=InsertionError');
                exit();
            } else {
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($statement, "sssss", $username, $fName, $lName, $email, $hashedPass);
                mysqli_stmt_execute($statement);
                foreach ($interests as $item) {
                    $insertInterests = "INSERT INTO student_interests (interests,student_username) VALUES('$item','$username')";
                    mysqli_query($con, $insertInterests);
                }
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
    <title>Create a student account</title>
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
            background-image: linear-gradient(45deg, rgba(253, 230, 138, 0.51) 0%, transparent 36%), repeating-linear-gradient(135deg, rgba(197, 197, 197, 0.1) 0px, rgba(197, 197, 197, 0.1) 1px, transparent 1px, transparent 11px), repeating-linear-gradient(45deg, rgba(197, 197, 197, 0.1) 0px, rgba(197, 197, 197, 0.1) 1px, transparent 1px, transparent 11px), linear-gradient(0deg, rgba(253, 230, 138, 0.51), rgba(253, 230, 138, 0.51));
        }
    </style>
    <!-- prevent resubmission when refresh the page -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body class="bg-amber-50 flex flex-col items-center justify-center w-full h-screen overflow-x-hidden text-gray-700 scrollbar">
    <img src="images/logo.svg" class="lg:hidden block h-14 mb-2">
    <div class="bg-white w-3/4 h-5/6  flex rounded-lg border-amber-300 border-x-2 shadow-md">
        <!-- left side -->
        <div class="lg:w-2/3 w-full flex flex-col lg:mr-4 mr-0">
            <p class="text-xs text-right pt-6 pr-6">Already have an account? <span class="text-amber-600 hover:underline"><a href="signin.php">Sign
                        in</a></span></p>
            <p class="text-center pt-3 capitalize font-medium text-xl">create student account</p>
            <p class="text-center p-1 text-xs mb-4 text-blue-600">please fill in all information to be able to submit the form</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 xl:overflow-y-hidden overflow-y-auto scrollbar">
                <!-- first name -->
                <div class="flex w-1/2">
                    <div class="w-full ">
                        <label for="fName" class="block capitalize font-semibold">first name</label>
                        <input type="text" name="firstName" id="fName" placeholder="Salma" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white focus:border-amber-400 focus:ring-amber-400 placeholder-gray-400 text-blue-800" value="<?php if (isset($fName)) echo htmlspecialchars($fName) ?>">
                    </div>
                </div>
                <!-- last name -->
                <div class="flex w-1/2">
                    <div class="w-full ml-2">
                        <label for="lName" class="block capitalize font-semibold">last name</label>
                        <input type="text" name="lastName" id="lName" placeholder="Bader" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white focus:border-amber-400 focus:ring-amber-400 placeholder-gray-400 text-blue-800" value="<?php if (isset($lName)) echo htmlspecialchars($lName) ?>">
                    </div>
                </div>
                <!-- username -->
                <div class="w-1/2 mt-2">
                    <label for="usename" class="block capitalize font-semibold">username</label>
                    <input type="text" name="username" maxlength="10" id="signup_usename" placeholder="_salma" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white focus:border-amber-400 focus:ring-amber-400 placeholder-gray-400 text-blue-800" value="<?php if (isset($username)) echo htmlspecialchars($username) ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="usernameError"><?php if (isset($usernameError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $usernameError ?></p>
                    </div>
                </div>
                <!-- password -->
                <div class="flex w-1/2">
                    <div class="w-full ml-2 mt-2">
                        <label for="password" class="block capitalize font-semibold">password</label>
                        <div class="relative">
                            <div id="eyeIcon" class="eyeIcon flex absolute inset-y-0 right-0 items-center pr-3 cursor-pointer">
                                <svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400 hover:text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="signup_password" placeholder="••••••••" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white focus:border-amber-400 focus:ring-amber-400 placeholder-gray-400 text-blue-800" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
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
                <div class="w-full">
                    <label for="email" class="block capitalize font-semibold">email</label>
                    <input type="email" name="email" id="email" placeholder="example@email.com" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white focus:border-amber-400 focus:ring-amber-400 placeholder-gray-400 text-blue-800" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="emailError"><?php if (isset($emailError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $emailError ?></p>
                    </div>
                </div>
                <!-- intrests -->
                <div class="w-full">
                    <label class="block capitalize font-semibold">intrests</label>
                    <p id="hint" class="block text-xs text-gray-500 bg-gray-200 w-fit rounded-r-full px-2">please choose at least one</p>
                    <div class="flex flex-wrap flex-col lg:flex-row mt-1">
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="programming" value="programming" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300  focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="programming" class="capitalize"> programming</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="mathematics" value="mathematics" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300  focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="mathematics" class="capitalize"> mathematics</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="design" value="design" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300 focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="design" class="capitalize"> design</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="marketing" value="marketing" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300 focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="marketing" class="capitalize"> marketing</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="software" value="IT & Software" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300 focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="software" class="capitalize"> IT & Software</label>
                        </div>
                        <div class="lg:w-1/3">
                            <input type="checkbox" name="interests[]" id="business" value="business" class="form-check-input appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-amber-300 checked:border-amber-300  focus:outline-none focus:ring-amber-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"><label for="business" class="capitalize"> business</label>
                        </div>
                    </div>
                </div>
                <!-- button -->
                <div class="flex flex-col items-center">
                    <button type="submit" name="createAccountBtn" id="signupBtn" class="mt-10 bg-amber-400 text-amber-900 px-14 py-3 rounded-full shadow-md font-semibold hover:text-white hover:bg-amber-500 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Create
                        account</button>
                    <p class="text-xs mt-3">OR <span class=" text-amber-600 hover:underline"><a href="applyAsInstructor.php">apply as instructor</a></span></p>
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
                <img src="images/student_signup.png" class="rounded-br-lg">
            </div>
        </div>
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/student_createAccount.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>