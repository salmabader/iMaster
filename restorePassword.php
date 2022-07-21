<?php
session_start();
require('database/db_connection.php');
$con = OpenCon();
if (isset($_POST['signinBtn'])) {
    $isValidEmail = true;
    $isValidUsername = true;
    $username = filter_input(INPUT_POST, 'username');
    $email = filter_input(INPUT_POST, 'email_restore');
    $studentQuery = "SELECT * FROM student WHERE username = ? AND email = ?";
    $instructorQuery = "SELECT * FROM instructors WHERE username = ? AND email = ?";
    $statement1 = mysqli_stmt_init($con);
    $statement2 = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement1, $studentQuery) || !mysqli_stmt_prepare($statement2, $instructorQuery)) {
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
        if (count($fetchedUsers) == 0) {
            $restoreError = "Sorry you have enter a wrong information, check it again!";
        } else {
            // send email
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
            background-image: repeating-linear-gradient(45deg, hsla(207, 0%, 63%, 0.05) 0px, hsla(207, 0%, 63%, 0.05) 1px, transparent 1px, transparent 11px, hsla(207, 0%, 63%, 0.05) 11px, hsla(207, 0%, 63%, 0.05) 12px, transparent 12px, transparent 32px), repeating-linear-gradient(0deg, hsla(207, 0%, 63%, 0.05) 0px, hsla(207, 0%, 63%, 0.05) 1px, transparent 1px, transparent 11px, hsla(207, 0%, 63%, 0.05) 11px, hsla(207, 0%, 63%, 0.05) 12px, transparent 12px, transparent 32px), repeating-linear-gradient(135deg, hsla(207, 0%, 63%, 0.05) 0px, hsla(207, 0%, 63%, 0.05) 1px, transparent 1px, transparent 11px, hsla(207, 0%, 63%, 0.05) 11px, hsla(207, 0%, 63%, 0.05) 12px, transparent 12px, transparent 32px), repeating-linear-gradient(90deg, hsla(207, 0%, 63%, 0.05) 0px, hsla(207, 0%, 63%, 0.05) 1px, transparent 1px, transparent 11px, hsla(207, 0%, 63%, 0.05) 11px, hsla(207, 0%, 63%, 0.05) 12px, transparent 12px, transparent 32px), linear-gradient(90deg, rgb(253, 230, 138), rgb(254, 243, 199));
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

<body class="bg-amber-50 flex flex-col items-center justify-center w-full h-screen overflow-x-hidden text-gray-700 scrollbar">
    <a href="index.php">
        <img src="images/logo.svg" class="h-14 my-2">
    </a>
    <div class="bg-white lg:w-[40%] md:mx-0 mx-3 max-w-3xl flex rounded-lg border-blue-400 border-x-2 shadow-md">
        <!-- left side -->
        <div class="w-full flex flex-col lg:mr-4 mr-0">
            <p class="text-center pt-10 font-medium text-xl">Sign in to Your Account</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
                <!-- username -->
                <div class="w-full mt-3">
                    <label for="usename" class="block capitalize font-semibold">username</label>
                    <input type="text" name="username" maxlength="10" id="signup_usename" placeholder="_salma" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" value="<?php if (isset($username)) echo htmlspecialchars($username) ?>">
                </div>
                <!-- email -->
                <div class="flex w-full">
                    <div class="w-full mt-3">
                        <label for="password" class="block capitalize font-semibold">email</label>
                        <input type="email" name="email" id="email_restore" placeholder="example@email.com" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
                        <div class="text-red-500 text-sm mt-2">
                            <p id="restoreError" class="flex items-center"><?php if (isset($restoreError)) echo htmlspecialchars($restoreError) ?></p>
                        </div>
                    </div>
                </div>

                <!-- button -->
                <div class="flex flex-col items-center">
                    <button type="submit" name="signinBtn" id="signinBtn" class="mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Send a code</button>
                    <p class="text-xs mt-4">New user? <span class=" text-blue-600 hover:underline"><a href="createStudentAccount.php">create account</a></span></p>
                </div>
            </form>
        </div>

        <!-- right side -->
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="js/signin.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>