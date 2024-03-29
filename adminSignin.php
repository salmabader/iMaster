<?php
session_start();
require('database/db_connection.php');
if (isset($_SESSION['type'])) {
    $privilage = $_SESSION['type'];
    if (isset($_SESSION['username']) && $privilage == "student") {
        header('Location: studentDashboard.php');
        exit();
    } elseif (isset($_SESSION['username']) && $privilage == "instructor") {
        header('Location: instructorHome.php');
        exit();
    } else {
        header('Location: analytics.php');
        exit();
    }
}
$con = OpenCon();
if (isset($_POST['signinBtn'])) {
    $isValidUsername = false;
    $wrongInfo = false;
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $existanceQuery1 = "SELECT * FROM admin WHERE username = ? ";
    $statement1 = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement1, $existanceQuery1)) {
        header('Location: index.php?error=SQLError');
        exit();
    } else {
        mysqli_stmt_bind_param($statement1, "s", $username);
        mysqli_stmt_execute($statement1);
        $result1 = mysqli_stmt_get_result($statement1);
        $admin = mysqli_fetch_assoc($result1);
        if (isset($admin)) {
            $isValidPass = password_verify($password, $admin['password']);
            if (!$isValidPass) {
                $wrongInfo = true;
            } else {
                $wrongInfo = false;
            }
        } else {
            $wrongInfo = true;
        }
        if ($wrongInfo) {
            $feedback = "Username or password is incorrect";
        } else {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $admin['email'];
            $_SESSION['firstName'] = $admin['FName'];
            $_SESSION['lastName'] = $admin['LName'];
            $_SESSION['type'] = "admin";
            header('Location: analytics.php');
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
    <title>Sign in for admin</title>
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

<body class="bg-blue-50 flex flex-col items-center justify-center w-full h-screen overflow-x-hidden text-gray-700 scrollbar">
    <a href="index.php">
        <img src="images/logo.svg" class="h-14 mb-2">
    </a>
    <div class="bg-white md:w-1/2 w-3/4 flex rounded-lg border-blue-400 border-x-2 shadow-md">
        <!-- left side -->
        <div class="w-full flex flex-col lg:mr-4 mr-0">
            <p class="text-center pt-10 font-medium text-xl">Sign in to Your Admin Account</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
                <!-- username -->
                <div class="w-full mt-3">
                    <label for="usename" class="block capitalize font-semibold">username</label>
                    <input type="text" name="username" maxlength="10" id="signup_usename" placeholder="_salma" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" value="<?php if (isset($username)) echo htmlspecialchars($username)  ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="usernameError"><?php if (isset($usernameError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $usernameError ?></p>
                    </div>
                </div>
                <!-- password -->
                <div class="flex w-full">
                    <div class="w-full mt-3">
                        <label for="password" class="block capitalize font-semibold">password</label>
                        <div class="relative">
                            <div id="eyeIcon" class="eyeIcon flex absolute inset-y-0 right-0 items-center pr-3 cursor-pointer">
                                <svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">blue
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
                        </div>
                        <div class="text-red-500 text-sm mt-2">
                            <p id="signInError" class="flex items-center"><?php if (isset($feedback)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $feedback ?></p>
                        </div>
                    </div>
                </div>

                <!-- button -->
                <div class="flex flex-col items-center">
                    <button type="submit" name="signinBtn" id="signinBtn" class="mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Sign in</button>
                </div>
            </form>
        </div>
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700 ">
                <div class="p-6 text-center flex flex-col items-center">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-24" fill="none">
                        <style>
                            @keyframes check {
                                to {
                                    stroke-dashoffset: 0;
                                }
                            }
                        </style>
                        <circle cx="12" cy="12" r="8" stroke="#4C4C4C" stroke-width="1" />
                        <path stroke="#087D04" stroke-linecap="round" stroke-width="1.5" d="M9.215 12.052l1.822 1.805 3.748-3.714" style="animation:check 2s infinite cubic-bezier(.99,-.1,.01,1.02)" stroke-dashoffset="100" stroke-dasharray="100" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Your password has been successfully reset<br>you can sign in now</h3>
                    <button id="okBtn" data-modal-toggle="popup-modal" type="button" class="text-white bg-green-600 hover:bg-green-800 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-8 py-2 text-center mr-2">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="js/adminSignin.js"></script>
</body>

</html>