<?php
session_start();
require('database/db_connection.php');
require('mailConfig.php');
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
$isStudent = false;
if (isset($_POST['sendCode'])) {
    $isValidEmail = true;
    $isValidUsername = true;
    $email = filter_input(INPUT_POST, 'email');
    $newPass = filter_input(INPUT_POST, 'password');
    $_SESSION['resetEmail'] = $email;
    $_SESSION['newPass'] = $newPass;
    $studentQuery = "SELECT * FROM student WHERE email = ?";
    $instructorQuery = "SELECT * FROM instructor WHERE email = ?";
    $statement1 = mysqli_stmt_init($con);
    $statement2 = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement1, $studentQuery) || !mysqli_stmt_prepare($statement2, $instructorQuery)) {
        header('Location: index.php?error=SQLError');
        exit();
    } else {
        mysqli_stmt_bind_param($statement1, "s", $email);
        mysqli_stmt_execute($statement1);
        $result1 = mysqli_stmt_get_result($statement1);
        mysqli_stmt_bind_param($statement2, "s", $email);
        mysqli_stmt_execute($statement2);
        $result2 = mysqli_stmt_get_result($statement2);
        $fetchedStu = array();
        $fetchedInst = array();
        //to store all the fetched rows
        while ($stu = mysqli_fetch_assoc($result1)) {
            $fetchedStu[] = $stu['email'];
        }
        while ($inst = mysqli_fetch_assoc($result2)) {
            $fetchedInst[] = $inst['email'];
        }
        if (count($fetchedStu) == 0 && count($fetchedInst) == 0) {
            $wrongInfo = "Sorry, this email in not registred!";
        } else {
            // send the code to email
            $_SESSION['code'] = substr(str_shuffle("0123456789"), 0, 6);
            // to get full name
            if ($fetchedStu) {
                $getFullName = "SELECT FName, LName FROM student WHERE email = '$email'";
                $isStudent = true;
            } else {
                $getFullName = "SELECT FName, LName FROM instructor WHERE email = '$email'";
                $isStudent = false;
            }
            $result = mysqli_query($con, $getFullName);
            $row = mysqli_fetch_assoc($result);
            $fullName = $row['FName'] . ' ' . $row['LName'];
            $mail->addAddress($email, $fullName);     //Add a recipient

            //Content
            $content = $_SESSION['code'];
            $mail->Subject = 'Restore password code';
            $mail->Body    = 'Your restore code: <b>' . $content . '</b>';

            $_SESSION['privilage'] = $isStudent;
            if ($mail->send()) {
                $feedback = "Code sent to: " . $email;
            }
        }
    }
}
if (isset($_POST['verify'])) {
    $enteredCode = filter_input(INPUT_POST, 'code');
    if ($enteredCode == $_SESSION['code']) {
        //update db
        $hashedPass = password_hash($_SESSION['newPass'], PASSWORD_DEFAULT);
        if ($_SESSION['privilage']) {
            $updateQuery = "UPDATE student SET password = '$hashedPass' WHERE email ='" . $_SESSION['resetEmail'] . "'";
        } else {
            $updateQuery = "UPDATE instructor SET password = '$hashedPass' WHERE  email ='" . $_SESSION['resetEmail'] . "'";
        }
        $result = mysqli_query($con, $updateQuery);
        if ($result) {
            $_SESSION = array(); //clear session
            header('Location: signin.php?success=password-is-updated');
        }
    } else {
        $wrongCode = "You have entered a wrong code, try again";
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
    <title>Reset password</title>
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
    <div class="bg-white sm:w-1/2 w-4/5 md:mx-0 mx-3 max-w-xl flex rounded-lg border-blue-400 border-x-2 shadow-md">
        <div class="w-full flex flex-col lg:mr-4 mr-0 items-center">
            <p class="text-center pt-10 font-medium text-xl">Reset your password</p>
            <div class="flex items-center text-white text-sm w-1/2 mt-2">
                <div class="bg-blue-500 rounded-md px-3 py-1 flex flex-col">1</div>
                <div class="w-full bg-gray-200 h-2" id="bar"></div>
                <div class="bg-gray-200 rounded-md px-3 py-1" id="secondStep">2</div>
            </div>
            <div class="flex items-center justify-between text-[10px] text-gray-400 w-1/2 mt-1">
                <div class="">Enter password</div>
                <div class="">Confirm</div>
            </div>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar w-full">
                <div class="block w-full" id="enterInfo">
                    <!-- enter information to send email -->
                    <!-- email -->
                    <div class="flex w-full">
                        <div class="w-full mt-3">
                            <label for="email" class="block capitalize font-semibold">email</label>
                            <input type="text" name="email" id="email" placeholder="example@email.com" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
                            <div class="text-red-500 text-sm mt-2">
                                <p class="flex items-center" id="emailError"></p>
                            </div>
                        </div>
                    </div>
                    <!-- new password -->
                    <div class="w-full mt-2">
                        <label for="password" class="block capitalize font-semibold">new password</label>
                        <div class="relative">
                            <div id="eyeIcon" class="eyeIcon flex absolute inset-y-0 right-0 items-center pr-3 cursor-pointer">
                                <svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($newPass)) echo htmlspecialchars($newPass) ?>">
                        </div>
                        <div class="text-red-500 text-sm mt-2">
                            <p id="passwordError" class="flex items-center"></p>
                        </div>
                    </div>
                    <!-- button -->
                    <div class="flex flex-col items-center">
                        <button type="submit" name="sendCode" id="sendCode" class="flex justify-center items-center mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" data-tooltip-target="tooltip-hover" data-tooltip-trigger="hover" data-tooltip-placement="top" disabled>Send a code</button>

                        <p class="text-xs mt-4">New user? <span class=" text-blue-600 hover:underline"><a href="createStudentAccount.php">create account</a></span></p>
                    </div>
                </div>
                <div id="verifyCode" class="hidden w-full flex flex-col items-center">
                    <div class="flex w-full">
                        <!-- code -->
                        <div class="w-full mt-3">
                            <label for="code" class="block capitalize font-semibold">Code</label>
                            <input type="text" name="code" id="code" maxlength="6" class="w-full mt-1  bg-blue-50 pl-2 pr-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400">
                        </div>
                    </div>
                    <button type="submit" name="verify" id="verify" class="flex justify-center items-center mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>verify</button>
                </div>
            </form>
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

    <!-- toast messages  -->
    <!-- toast 1 -->
    <div id="toast-danger1" class="opacity-0 flex fixed bottom-5 right-8 items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white border-2 border-red-500 rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 dark:bg-red-800 dark:text-red-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ml-3 text-sm font-normal" id="errorMsg"><?php if (isset($wrongInfo)) echo htmlspecialchars($wrongInfo) ?></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <!-- toast 2 -->
    <div id="toast-danger2" class="opacity-0 flex fixed bottom-5 right-8 items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white border-2 border-red-500 rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 dark:bg-red-800 dark:text-red-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ml-3 text-sm font-normal" id="wrongCode"><?php if (isset($wrongCode)) echo htmlspecialchars($wrongCode) ?></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <!-- toast3 -->
    <div id="toast-success" class="opacity-0 flex fixed bottom-5 right-8 items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 border-2 border-green-600" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-600 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg aria-hidden="true" class="h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ml-3 text-sm font-normal" id="feedback"><?php if (isset($feedback)) echo htmlspecialchars($feedback) ?></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <!-- tooltip -->
    <div id="tooltip-hover" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-xs text-white bg-gray-800 rounded-lg shadow-sm opacity-0 tooltip transition-opacity duration-200">
        <p>Send code to confirm the password changes</p>
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/restorePassword.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>