<?php
session_start();
require('database/db_connection.php');
require('mailConfig.php');
$con = OpenCon();
if (isset($_POST['sendCode'])) {
    $isValidEmail = true;
    $isValidUsername = true;
    $email = filter_input(INPUT_POST, 'email');
    $newPass = filter_input(INPUT_POST, 'password');
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
            $restoreError = "You have entered the wrong information, please recheck it!";
        } else {
            // send the code to email
            //Recipients
            $mail->setFrom('SalmaBader.CS@gmail.com', 'iMaster');
            // $mail->addAddress($email, 'Joe User');     //Add a recipient
            $mail->addAddress($email);

            //Content
            $content = substr(str_shuffle("0123456789"), 0, 6);
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Restore password code';
            $mail->Body    = 'Your restore code: <b>' . $content . '</b>';

            if ($mail->send()) {
                // echo 'CODE SENT';
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
    <title>Restore password</title>
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
    <div id="toast-danger" class="opacity-0 flex fixed bottom-5 right-8 duration-100 ease-in items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white border-2 border-red-500 rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-red-500 dark:bg-red-800 dark:text-red-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ml-3 text-sm font-normal" id="errorMsg"><?php if (isset($restoreError)) echo htmlspecialchars($restoreError) ?></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <a href="index.php">
        <img src="images/logo.svg" class="h-14 my-2">
    </a>
    <div class="bg-white lg:w-[40%] md:mx-0 mx-3 max-w-3xl flex rounded-lg border-blue-400 border-x-2 shadow-md">
        <!-- left side -->
        <div class="w-full flex flex-col lg:mr-4 mr-0 items-center">
            <p class="text-center pt-10 font-medium text-xl">Sign in to Your Account</p>
            <div class="flex items-center text-white text-sm w-1/2 mt-2">
                <div class="bg-blue-500 rounded-md px-3 py-1">1</div>
                <div class="w-full bg-gray-200 h-2" id="bar"></div>
                <div class="bg-gray-200 rounded-md px-3 py-1" id="secondStep">2</div>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
                <!-- email -->
                <div class="flex w-full">
                    <div class="w-full mt-3">
                        <label for="email" class="block capitalize font-semibold">email</label>
                        <input type="text" name="email" id="email" placeholder="example@email.com" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
                        <div class="text-red-500 text-sm mt-2">
                            <p class="flex items-center" id="emailError"></p>
                        </div>
                        <!-- <div class="text-red-500 text-sm mt-2">
                            <p id="restoreError" class="flex items-center"><?php if (isset($restoreError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . htmlspecialchars($restoreError) ?></p>
                        </div> -->
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
                        <input type="password" name="password" id="password" placeholder="••••••••" class="w-full mt-1  bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-blue-400 focus:ring-blue-400" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
                    </div>
                    <div class="text-red-500 text-sm mt-2">
                        <p id="passwordError" class="flex items-center"></p>
                    </div>
                </div>
                <!-- button -->
                <div class="flex flex-col items-center">
                    <button type="submit" name="sendCode" id="sendCode" class="mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" data-tooltip-target="tooltip-click" data-tooltip-trigger="hover" data-tooltip-placement="top" disabled>Send a code</button>

                    <p class="text-xs mt-4">New user? <span class=" text-blue-600 hover:underline"><a href="createStudentAccount.php">create account</a></span></p>
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
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/restorePassword.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>