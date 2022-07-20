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
    $usernameQuery = "SELECT * FROM student WHERE username = ? OR email = ?";
    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $usernameQuery)) {
        header('Location: index.php?error=SQLError');
        exit();
    } else {
        mysqli_stmt_bind_param($statement, "ss", $username, $email);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $fetchedUsers = array();
        //to store all the fetched rows
        while ($user = mysqli_fetch_assoc($result)) {
            $fetchedUsers[] = $user['username'];
            $fetchedUsers[] = $user['email'];
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
    <div class="bg-white w-3/4 h-4/5 md:h-fit flex rounded-lg border-amber-300 border-x-2 shadow-md">
        <!-- left side -->
        <div class="lg:w-2/3 w-full flex flex-col lg:mr-4 mr-0">
            <p class="text-xs text-right pt-6 pr-6">Already have an account? <span class="text-blue-600 hover:underline"><a href="signin.php">Sign
                        in</a></span></p>
            <p class="text-center pt-3 capitalize font-medium text-xl mb-4">create student account</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
                <!-- first name -->
                <div class="flex w-1/2">
                    <div class="w-full ">
                        <label for="fName" class="block capitalize font-semibold">first name</label>
                        <input type="text" name="firstName" id="fName" placeholder="Salma" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-blue-50 placeholder-gray-400 text-blue-800" value="<?php if (isset($fName)) echo htmlspecialchars($fName) ?>">
                    </div>
                </div>
                <!-- last name -->
                <div class="flex w-1/2">
                    <div class="w-full ml-2">
                        <label for="lName" class="block capitalize font-semibold">last name</label>
                        <input type="text" name="lastName" id="lName" placeholder="Bader" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-blue-50 placeholder-gray-400 text-blue-800" value="<?php if (isset($lName)) echo htmlspecialchars($lName) ?>">
                    </div>
                </div>
                <!-- username -->
                <div class="w-1/2 mt-3">
                    <label for="usename" class="block capitalize font-semibold">username</label>
                    <input type="text" name="username" maxlength="15" id="signup_usename" placeholder="_salma" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-blue-50 placeholder-gray-400 text-blue-800" value="<?php if (isset($username)) echo htmlspecialchars($username) ?>">
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
                                <svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400 hover:text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="signup_password" placeholder="••••••••" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-blue-50 placeholder-gray-400 text-blue-800" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
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
                    <input type="email" name="email" id="email" placeholder="example@email.com" class="w-full mt-1 bg-amber-100 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-blue-50 placeholder-gray-400 text-blue-800" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
                    <div class="text-red-500 text-sm mt-2">
                        <p class="flex items-center" id="emailError"><?php if (isset($emailError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $emailError ?></p>
                    </div>
                </div>
                <!-- intrests -->
                <div class="w-full mt-3">
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
                    <p class="text-xs mt-4">OR <span class=" text-blue-600 hover:underline"><a href="applyAsInstructor.php">apply as instructor</a></span></p>
                </div>
            </form>
        </div>

        <!-- right side -->
        <div class="w-1/3 lg:block hidden rounded-r-lg rightBg h-full">
            <!-- logo -->
            <div class="flex flex-col justify-between h-full">
                <div class="flex justify-end p-5">
                    <a href="index.php">
                        <svg class="h-10" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1075.7 353.7" enable-background="new 0 0 1075.7 353.7" xml:space="preserve">
                            <line display="none" fill="none" stroke="#000000" stroke-width="3" stroke-miterlimit="10" x1="758.5" y1="378.5" x2="788.5" y2="351.5" />
                            <path display="none" fill="none" stroke="#000000" stroke-width="3" stroke-miterlimit="10" d="M758.5,378.5l30-23.3
	c0-101.8,0-203.5,0-305.3" />
                            <polyline display="none" fill="none" stroke="#000000" stroke-width="3" stroke-miterlimit="10" points="574,440 760,379 789,353 
	" />
                            <g display="none">
                                <path display="inline" d="M-336.7-279.4c-1.7-0.5-1.8-2.8-0.1-3.4c10.5-3.8,20.3-7,29.8-11.2c32.9-13.9,67.7-26.1,101.3-39.6
		c3.9-1.6,7.2-1.5,11.1,0c30.6,11.4,61.5,22.1,91.7,34.3c12.7,5.1,25.6,9.7,38.9,15.3c1.5,0.6,1.5,2.9-0.1,3.4c0,0,0,0,0,0
		C-76-277.1-76-277.1-76-265.1c0,10.6-0.1,21.1,0.1,31.7c0,3.2-0.5,4.8-4.3,4.8c-3.8-0.1-3.7-2.2-3.6-4.8c0-11.8-0.2-23.5,0.1-35.3
		c0.2-5.2-1.4-5.7-5.9-4.2c-10,3.4-20.1,6.5-30.2,9.3c-3.6,1-4.8,2.6-4.7,6.3c0.3,10.5,0.7,21.1,0.2,31.6
		c-1.7,31.1-17.8,52.2-45.5,65.8c-15.4,7.6-31.3,9.8-47,5c-34-10.4-60.5-34.4-59.3-79.2c0.2-8.1-0.1-16.2,0.2-24.3
		c0.2-3.9-1.4-5.2-4.9-6.1c-18-4.7-36-9.6-54-14.5C-335.5-279-336.1-279.2-336.7-279.4z" />
                                <path display="inline" d="M-132-169.7V136L-278,197v-367.8c13.3,20.2,31.9,33.6,52.9,41.8c19.5,7.6,39.3,4,58.3-8
		C-152.7-145.8-141-156.6-132-169.7C-132-169.7-132-169.7-132-169.7z" />
                                <path display="inline" d="M-102,111h-3v-309.4c-3,4.1-6.2,8.3-9.3,12.3c-7.3,9.3-15.1,18.4-23.1,27.1l-2.6-1
		c8-8.6,16.1-18.7,23.3-27.9c4.1-5.2,8.1-10.6,12-15.9l2.7-3.8V111z" />
                                <line display="inline" fill="none" stroke="#000000" stroke-miterlimit="10" x1="-126" y1="-175.8" x2="-126" y2="128.5" />
                                <line display="inline" fill="none" stroke="#000000" stroke-miterlimit="10" x1="-117.8" y1="-184.9" x2="-117.8" y2="122.4" />
                                <line display="inline" fill="none" stroke="#000000" stroke-miterlimit="10" x1="-109.5" y1="-194" x2="-109.5" y2="116.4" />
                                <g display="inline">
                                    <path d="M-52.1-47.6c-0.5-0.5-0.7-1-0.7-1.7v-5.6c0-0.7,0.2-1.3,0.7-1.8c0.5-0.5,1-0.7,1.7-0.7h6.5c0.7,0,1.3,0.2,1.8,0.7
			s0.7,1.1,0.7,1.8v5.6c0,0.7-0.2,1.3-0.7,1.7s-1.1,0.7-1.8,0.7h-6.5C-51.1-47-51.7-47.2-52.1-47.6z M-51.3,15.9
			c-0.5-0.4-0.7-1-0.7-1.7v-48.8c0-0.7,0.2-1.3,0.7-1.7c0.5-0.5,1-0.7,1.7-0.7h4.9c0.7,0,1.3,0.2,1.7,0.7c0.5,0.5,0.7,1,0.7,1.7
			v48.8c0,0.7-0.2,1.3-0.7,1.7c-0.5,0.4-1,0.7-1.7,0.7h-4.9C-50.3,16.6-50.8,16.4-51.3,15.9z" />
                                    <path d="M-25,15.9c-0.5-0.4-0.7-1-0.7-1.7V-53c0-0.8,0.2-1.4,0.7-1.8c0.5-0.5,1-0.7,1.7-0.7h5.1c1.1,0,2,0.5,2.7,1.7L6.3-12.3
			l21.9-41.6c0.1-0.4,0.4-0.8,0.9-1.1c0.5-0.3,1-0.5,1.7-0.5h5c0.8,0,1.3,0.2,1.8,0.7c0.5,0.5,0.7,1,0.7,1.8v67.3
			c0,0.7-0.2,1.3-0.7,1.7s-1.1,0.7-1.8,0.7h-5c-0.7,0-1.3-0.2-1.7-0.7c-0.5-0.4-0.7-1-0.7-1.7v-50.7L11.2-2.9
			c-0.7,1.4-1.8,2.2-3.3,2.2H4.7c-1.5,0-2.6-0.7-3.3-2.2l-17.3-33.6v50.7c0,0.7-0.2,1.3-0.7,1.7s-1,0.7-1.7,0.7h-5.1
			C-24,16.6-24.6,16.4-25,15.9z" />
                                    <path d="M60.3,15.6c-2.9-1.4-5.2-3.2-6.8-5.6S51,5,51,2.1c0-4.5,1.9-8.3,5.6-11.2c3.7-2.9,8.8-4.8,15.2-5.7L87.1-17v-3
			c0-7-4-10.5-12.1-10.5c-3,0-5.5,0.6-7.4,1.9c-1.9,1.3-3.4,2.8-4.3,4.5c-0.2,0.6-0.5,1.1-0.8,1.3c-0.3,0.3-0.7,0.4-1.3,0.4h-4.4
			c-0.6,0-1.2-0.2-1.6-0.7c-0.5-0.5-0.7-1-0.7-1.6c0.1-1.6,0.8-3.5,2.3-5.6s3.8-3.9,6.8-5.5S70.6-38,75.2-38
			c7.7,0,13.2,1.8,16.6,5.4s5.1,8.1,5.1,13.4v33.4c0,0.7-0.2,1.3-0.7,1.7s-1,0.7-1.7,0.7h-4.7c-0.7,0-1.3-0.2-1.7-0.7
			c-0.4-0.4-0.7-1-0.7-1.7V9.8c-1.5,2.2-3.7,4.1-6.6,5.6c-2.9,1.5-6.6,2.3-11,2.3C66.3,17.6,63.2,16.9,60.3,15.6z M82.8,5.5
			c2.8-2.9,4.3-7.1,4.3-12.6V-10L75.2-8.2c-4.9,0.7-8.6,1.8-11,3.4s-3.7,3.7-3.7,6.1c0,2.8,1.1,4.9,3.4,6.3c2.3,1.5,4.9,2.2,8,2.2
			C76.3,9.9,80,8.4,82.8,5.5z" />
                                    <path d="M118.1,15.3c-3.3-1.5-5.7-3.3-7.3-5.3s-2.4-3.6-2.4-4.9c0-0.7,0.3-1.2,0.8-1.6c0.5-0.4,1.1-0.6,1.6-0.6h4.6
			c0.7,0,1.3,0.3,1.8,1c1.7,1.9,3.4,3.4,5.4,4.5c1.9,1.1,4.5,1.6,7.7,1.6c3.6,0,6.5-0.7,8.7-2.1s3.4-3.3,3.4-5.8
			c0-1.6-0.5-3-1.4-4.1c-0.9-1.1-2.5-2-4.7-2.8c-2.2-0.8-5.6-1.7-9.9-2.6c-6-1.3-10.2-3.2-12.7-5.7s-3.8-5.7-3.8-9.6
			c0-2.6,0.8-5.1,2.3-7.5s3.8-4.3,6.8-5.8c3-1.5,6.6-2.2,10.8-2.2c4.4,0,8.1,0.7,11.2,2.2s5.4,3.1,6.9,5.1s2.3,3.6,2.3,4.9
			c0,0.6-0.2,1.1-0.7,1.5s-1,0.6-1.6,0.6h-4.3c-0.8,0-1.5-0.3-2.1-1c-1.1-1.3-2-2.3-2.8-3c-0.8-0.7-1.9-1.4-3.4-1.9
			c-1.5-0.5-3.4-0.8-5.6-0.8c-3.3,0-5.8,0.7-7.6,2.1c-1.8,1.4-2.7,3.3-2.7,5.5c0,1.4,0.4,2.7,1.1,3.7s2.2,1.9,4.4,2.7
			c2.2,0.8,5.3,1.7,9.4,2.6c6.5,1.4,11.1,3.4,13.9,5.9c2.7,2.6,4.1,5.8,4.1,9.8c0,2.9-0.9,5.6-2.6,8s-4.2,4.3-7.6,5.7
			c-3.3,1.4-7.3,2.1-11.9,2.1C125.3,17.6,121.3,16.9,118.1,15.3z" />
                                    <path d="M168.8-1.5v-27.2h-8c-0.7,0-1.3-0.2-1.7-0.7s-0.7-1-0.7-1.7v-3.5c0-0.7,0.2-1.3,0.7-1.7s1-0.7,1.7-0.7h8v-17.2
			c0-0.7,0.2-1.3,0.7-1.7s1-0.7,1.7-0.7h4.8c0.7,0,1.3,0.2,1.7,0.7c0.4,0.5,0.7,1,0.7,1.7V-37h12.8c0.7,0,1.3,0.2,1.7,0.7
			c0.4,0.5,0.7,1,0.7,1.7v3.5c0,0.7-0.2,1.3-0.7,1.7s-1,0.7-1.7,0.7h-12.8v26.5c0,3.4,0.6,6,1.8,7.8s3.1,2.6,5.8,2.6h6.3
			c0.7,0,1.3,0.2,1.7,0.7s0.7,1,0.7,1.7v3.7c0,0.7-0.2,1.3-0.7,1.7s-1,0.7-1.7,0.7H185C174.2,16.6,168.8,10.6,168.8-1.5z" />
                                    <path d="M208.9,11.1c-4.2-4.4-6.5-10.3-6.9-17.9l-0.1-3.5l0.1-3.4c0.5-7.4,2.8-13.3,7.1-17.7c4.2-4.4,9.8-6.6,16.7-6.6
			c7.6,0,13.5,2.4,17.7,7.3s6.3,11.4,6.3,19.6v1.8c0,0.7-0.2,1.3-0.7,1.7s-1,0.7-1.7,0.7h-35.6v0.9c0.2,4.5,1.6,8.3,4.1,11.4
			c2.5,3.1,5.8,4.7,9.9,4.7c3.2,0,5.8-0.6,7.8-1.9c2-1.3,3.5-2.6,4.5-4c0.6-0.8,1.1-1.3,1.4-1.5c0.3-0.2,0.9-0.3,1.7-0.3h5.1
			c0.6,0,1.1,0.2,1.5,0.5c0.4,0.3,0.6,0.8,0.6,1.4c0,1.5-0.9,3.3-2.8,5.5s-4.5,4-7.9,5.5s-7.3,2.3-11.7,2.3
			C218.8,17.6,213.1,15.4,208.9,11.1z M239.9-14.1v-0.3c0-4.7-1.3-8.6-3.9-11.6s-6-4.5-10.4-4.5c-4.3,0-7.7,1.5-10.3,4.5
			s-3.8,6.9-3.8,11.6v0.3C211.7-14.1,239.9-14.1,239.9-14.1z" />
                                    <path d="M262.8,15.9c-0.5-0.4-0.7-1-0.7-1.7v-48.7c0-0.7,0.2-1.3,0.7-1.8s1-0.7,1.7-0.7h4.7c0.7,0,1.3,0.2,1.8,0.7
			s0.7,1.1,0.7,1.8v4.5c2.8-4.7,7.6-7,14.4-7h4c0.7,0,1.3,0.2,1.7,0.7c0.5,0.5,0.7,1,0.7,1.7v4.2c0,0.7-0.2,1.2-0.7,1.6
			s-1,0.6-1.7,0.6h-6.2c-3.7,0-6.6,1.1-8.8,3.3c-2.1,2.2-3.2,5.1-3.2,8.8v30.3c0,0.7-0.2,1.3-0.7,1.7s-1.1,0.7-1.8,0.7h-5
			C263.8,16.6,263.2,16.4,262.8,15.9z" />
                                </g>
                                <polygon display="inline" points="-132,136 -133.5,134.4 -104,108.9 -102,110 	" />
                            </g>
                            <path fill="#FFFFFF" d="M264.2,216.7c7.4,3,20.5-22.3,43.8-31.7c22-8.9,37.7,3.7,72,9c17.5,2.7,53.1,5.4,86.1-5
	c-16.2-54.6-24.2-92.2-19.1-115c1.8-7.8,6.4-25.4-2-33c-7.5-6.8-18.4,0.5-36,1c-33.9,0.9-38.5-25.1-74-28c-2.7-0.2-41-3.5-62.1,21.2
	c-6.2,7.2-5.8,16.7-7.5,22c7.6,60.5-0.4,84.7-4,113.1C260.6,175.7,257.6,214.1,264.2,216.7z" />
                            <path fill="#FFFFFF" d="M258.4,218.7c-7.4,3-15.7-22.5-39-32c-22-8.9-37.7,3.7-72,9c-17.5,2.7-59.8,15.2-92.8,4.9
	C70.8,146,85.5,98.5,80.4,75.7c-1.8-7.8-7.3-28.3,1.1-35.9c7.5-6.8,19.3,3.4,36.9,3.9c33.9,0.9,39.2-26.7,74.7-29.7
	c2.7-0.2,38.2-1,59.3,23.7c6.2,7.2,9.3,14.7,11,20c-7.6,60.5-5.6,102.6-2,131C262.1,194.2,265,216.1,258.4,218.7z" />
                            <g>
                                <path fill="#FBBF24" d="M403,241.9c-33,0-66,0.1-98.9-0.1c-3.7,0-5.6,0.9-7.4,4.4c-11.9,23.4-50,26.7-66.1,5.9
		c-0.6-0.7-1.3-1.4-1.5-2.3c-1.7-8.8-8-8.1-14.8-8.1c-63.4,0.1-126.8,0.1-190.2,0.1c-7,0-7,0-5.6-6.6
		c12.4-59.4,24.9-118.8,37.5-178.2c0.4-2,0-4.8,3.6-5.2c5.5-0.6,6.8,0.3,5.8,6.3C61.6,80.8,58,103.4,54.1,126
		c-5.3,30.6-11.1,61.2-15.6,91.9c-0.2,1.4-0.1,2.9-0.3,4.4c-0.5,3.3,0.8,4.3,4.1,4.6c22,1.9,43.5,0.1,65-5.2
		c18.9-4.6,36.4-12.6,53.9-20.7c36.5-16.9,73.2-0.9,93.9,24.6c6.9,8.5,6.6,8.3,13.1-0.2c18.8-24.7,44.1-33.8,74.5-30.1
		c16.3,2,30.3,10,45,16.2c30.1,12.6,61.2,18.4,93.8,15.5c3.6-0.3,4.7-1.1,4.2-5.1c-3.4-27.8-8.4-55.4-13-83c-4.3-26-8.9-52-13.3-78
		c-0.2-1.3-0.4-2.5-0.3-3.8c0.1-2-1.5-5.1,2.6-5.2c3.2-0.1,5.6-0.3,6.5,4.3c8.4,40.4,17.1,80.7,25.8,121.1
		c4.2,19.6,8.2,39.1,12.6,58.6c1,4.6,0.2,5.9-4.7,5.9c-33-0.2-65.9-0.1-98.9-0.1C403,241.8,403,241.9,403,241.9z" />
                                <path fill="#BFDBFE" d="M236.5,191.5c-12.7-10.6-27-17.2-44.1-17.7c-15.5-0.5-30.3,2.5-45.1,6.3c-15.4,4-30.8,6.4-46.8,3.8
		c-8.5-1.4-15.4-6.3-23.2-9.3c-2-0.8-3.2-1.7-3.7-2.9c-1-0.5-1.7-1.6-1.8-3c-0.6-6.4,1.1-12.6,2-18.8c0.9-6.4,1-12.9,1.8-19.3
		c0.7-5.7,1.6-11.4,2.4-17.1c0.7-5.5,1.7-10.8,4.1-15.9c0.1-0.3,0.3-0.5,0.4-0.7c0.2-1.6,0.5-3.3,0.8-4.9c0.1-0.3,0.2-0.6,0.3-0.9
		c-0.1-0.4-0.1-0.8,0-1.3c1-4.9,0.8-9.8,3.1-14.2c0.1-3.1,0-6.2,0-9.4c0.1-6.9,0.8-16.4,8.6-18.8c1.4-0.4,2.6,0,3.3,0.8
		c8.1,0,16.2-0.2,24.4-0.8c1.8-0.2,3.7-0.3,5.5-0.6c0.3-1,1.1-1.8,2.4-2.2c12.2-3.1,23.9-7.7,35.6-12.4c5.4-2.2,10.5-5.2,16.1-7
		c5.2-1.7,10.7-2.2,16.1-2.2c0.7,0,1.2,0.1,1.7,0.4c9.3-0.6,18.7,1.5,28.4,5.3c7.5,3,14.8,6.6,22,10.8c-8.5-18.3-29.9-26.4-49-27.9
		c-1.9-0.1-3.1-1.5-3.3-3.1c-5.6,0.4-11.3,1.5-17.2,3.3c-9.2,2.7-17.7,7.5-26.6,11.2c-12.9,5.3-26.5,7.6-40.3,8.5
		c-10.5,0.7-21.2,0.6-31.6-0.3c-7.3-0.6-7.7-1.1-8.5,6.2c-1.1,9.9-2.5,19.7-3.9,29.6c-2.6,17.7-5.4,35.4-8,53.1
		c-2.8,18.2-5.5,36.5-8.2,54.7c-1.7,11.1-3.3,22.2-5,33.3c-0.5,3.7,0.9,5.8,4.8,6.3c7.9,1,15.7,1.8,23.7,1.1
		c16.3-1.4,32.3-4.3,47.9-9.3c16.6-5.4,32.2-13.4,49.5-16.6c27.7-5,52.2,0.8,72.5,21.3c3.7,3.7,6.2,8.6,11.5,11.9
		C254.3,209.7,246.3,199.8,236.5,191.5z" />
                                <path fill="#BFDBFE" d="M475.6,204.5c-1.3-7.5-2.3-15-3.5-22.5c-2.8-18.4-5.6-36.8-8.3-55.3c-2.7-18.1-5.4-36.1-8.1-54.2
		c-1.9-12.7-3.7-25.4-5.5-38.1c-0.5-3.8-2.4-5.1-6-3.5c-2.6,1.1-5.3,1.2-8,1.1c-10.5-0.5-21,0.3-31.6-1
		c-14.9-1.8-29.3-5.1-42.8-11.6C349,13.2,336.1,8.5,321.3,8.6c-2.8,0-5.5,0.2-8.1,0.6c-0.1,1.3-0.8,2.6-2.5,3.1
		c-4.7,1.4-8.9,3.1-13.1,5.5c-3.7,2.2-8.8,3.5-11.6,6.9c-2.6,3.1-4.6,6.2-7.5,9.1c-2.1,2-3.7,4-4.8,6.4c9.7-5.9,19.8-10.8,30.7-14
		c15.1-4.4,29.6-4.5,43.3,4.6c4.8,3.2,10.3,5.5,15.7,7.7c19.8,8.2,40.7,10.1,61.9,9.9c8.8-0.1,8.8,0,9.8,8.5
		c0.3,2.7,0.7,5.4,1.1,8.1c5,32.5,10.1,65.1,15.1,97.6c1.4,9,1.4,9-6.9,13.6c-0.5,0.3-0.9,0.6-1.4,0.9c-14.3,7.9-29.6,9.4-45.5,7.3
		c-13.3-1.8-26.1-6.2-39.3-8.6c-11.8-2.2-23.8-2.8-35.7-0.7c-19.5,3.4-34.1,14.7-46.2,29.5c-4.1,5-7.5,10.5-8.6,17.5
		c1.8-1,2.7-2.9,4.1-4.3c7.4-7.5,14.3-15.5,23.9-20.5c21.6-11.1,43.8-11.4,66.6-4.3c19.2,6,37.3,15.2,57.4,18.9
		c15.7,2.9,31.3,5.5,47.4,3.8C475.4,214.7,477,212.6,475.6,204.5z" />
                            </g>
                            <path fill="#1E3A8A" d="M460.4,216.5C455.4,184,441,97.4,436,64.9c-0.4-2.7-0.8-5.4-1.1-8.1c-1-8.5-1-8.6-9.6-8.5
	c-20.9,0.2-41.5-1.7-61.1-9.9c-5.3-2.2-10.7-4.5-15.5-7.7c-13.6-9.2-27.9-9.1-42.8-4.6c-11.5,3.4-22,8.7-32.1,15.1
	c-1.1,0.7-2.1,2-4,1.7c-0.2-4.1,1.7-7.5,4.2-10.3c12.9-14.7,28.1-23.9,48.6-24.1c14.7-0.1,27.4,4.6,40,10.8
	c13.4,6.5,27.5,9.8,42.3,11.6c10.4,1.3,20.8,0.5,31.2,1c2.7,0.1,5.4,0,7.9-1.1c3.6-1.6,5.4-0.2,6,3.5c1.8,12.7,3.5,25.4,5.4,38.1
	c0.1,0.8,2.6,18.6,8,54.2c3.1,20.5,7.6,49.9,13.8,87.7c-2.6,0.5-5.1,0.9-7.7,1.4" />
                            <path fill="#1E3A8A" d="M63.9,216.5c5-32.5,19.5-119.1,24.5-151.7c0.4-2.7,0.8-5.4,1.1-8.1c1-8.5,1-8.6,9.7-8.5
	c21,0.2,41.6-1.7,61.3-9.9c5.3-2.2,10.8-4.5,15.5-7.7c13.6-9.2,27.9-9.1,42.9-4.6c11.5,3.4,22.1,8.7,32.2,15.1c1.1,0.7,2.1,2,4,1.7
	c0.2-4.1-1.7-7.5-4.2-10.3c-12.9-14.7-28.2-23.9-48.7-24.1c-14.7-0.1-27.5,4.6-40.2,10.8c-13.4,6.5-27.6,9.8-42.4,11.6
	c-10.5,1.3-20.9,0.5-31.3,1c-2.7,0.1-5.4,0-7.9-1.1c-3.6-1.6-5.4-0.2-6,3.5c-1.8,12.7-3.6,25.4-5.4,38.1c-0.1,0.8-2.6,18.6-8,54.2
	c-3.1,20.5-7.7,49.9-13.9,87.7c2.6,0.5,5.1,0.9,7.7,1.4" />
                            <path fill="#1E3A8A" d="M262.3,288h0.3c3.6,0,6.6-2.9,6.6-6.6V47.6c0-3.6-2.9-6.6-6.6-6.6h-0.3c-3.6,0-6.6,2.9-6.6,6.6v233.8
	C255.7,285.1,258.6,288,262.3,288z" />
                            <circle fill="#1E3A8A" cx="262.4" cy="24.3" r="10.4" />
                            <path fill="#1E3A8A" d="M269.1,247.7c-0.2,10.6,0.7,22.6,1.1,32.9c0.8,0.6,5.5,5.9,5.3,13.8c-0.1,5.7-2.2,9.2-3.2,10.3
	c0.3,1,5,16.7,7.1,25.5c0.2,0.7,0.5,2,0,3.5c-1.3,4.3-7.6,5.8-9.9,6.4c-1,0.2-15.7,3.6-20.5-4.3c-1.4-2.3-1.5-4.9-1.4-6.4
	c1.4-8,3.9-15.7,5.3-23.7V305c-0.9-2-3.5-7-3.5-10.6c0-8.5,4.6-12,6-13.8c0.5-11.6,0.4-23.7,0.4-35" />
                            <g>
                                <path fill="#1E3A8A" d="M559.2,97.2c-2.5,2.5-5.7,3.8-9.7,3.8s-7.2-1.3-9.7-3.8s-3.8-5.7-3.8-9.5c0-3.8,1.3-7.1,3.8-9.6
		c2.5-2.6,5.7-3.8,9.7-3.8s7.2,1.3,9.7,3.8c2.5,2.6,3.8,5.8,3.8,9.6S561.7,94.7,559.2,97.2z M538.4,193.5v-81.9h22.2v81.9H538.4z" />
                                <path fill="#1E3A8A" d="M603.4,82.5l32.5,43l32.5-43h21v111h-21.9v-75.7L636.3,158h-0.6l-31.3-40.2v75.7h-21.9v-111H603.4z" />
                                <path fill="#1E3A8A" d="M735.9,195.4c-9.2,0-16.3-2.3-21.3-6.9c-5-4.6-7.5-10.7-7.5-18.3c0-7.2,2.6-12.9,7.8-17.1
		c5.2-4.3,13.2-7.2,24-8.9l21.9-3.4v-0.8c0-8-4.9-12-14.7-12c-9.2,0-14.2,3.3-15.2,10H709c0.7-8,4.1-14.8,10-20.2s14.9-8.1,26.9-8.1
		c11.9,0,20.8,2.7,26.9,8c6,5.3,9.1,12.8,9.1,22.5v38.6c0,6.1,0.8,11.1,2.3,14.7h-21.4c-0.1,0-0.2-0.4-0.3-1.1
		c-0.1-0.7-0.2-1.9-0.4-3.4c-0.2-1.5-0.2-3.1-0.2-4.6C756.7,191.8,748,195.4,735.9,195.4z M760.7,156.8l-19.7,3.3
		c-8.4,1.4-12.5,4.6-12.5,9.6c0,5.7,4.1,8.5,12.3,8.5c6.4,0,11.3-1.6,14.7-5c3.4-3.3,5.2-7.7,5.2-13.2L760.7,156.8L760.7,156.8z" />
                                <path fill="#1E3A8A" d="M830.8,195.4c-22.3,0-34.1-9.5-35.5-28.5h22.5c0.2,3,1.4,5.6,3.7,7.6s5.5,3.1,9.9,3.1c4.2,0,7.3-0.7,9.5-2
		s3.3-3.2,3.3-5.5c0-2.5-1.6-4.4-4.7-5.6s-6.9-2.2-11.3-2.9c-4.4-0.7-8.9-1.7-13.4-3s-8.3-3.7-11.4-7.4c-3.1-3.6-4.7-8.5-4.7-14.5
		c0-7.6,3-14,9.1-19.2c6-5.2,14-7.8,23.8-7.8c11.2,0,19.4,2.8,24.9,8.4c5.4,5.6,8.3,12,8.8,19.2h-21.4c-0.2-2.8-1.4-5.2-3.5-7
		c-2.1-1.9-5.1-2.8-8.8-2.8c-3.5,0-6.3,0.8-8.3,2.3c-2,1.5-3,3.4-3,5.7c0,2.5,1.6,4.3,4.7,5.5c3.1,1.1,6.9,2.1,11.3,2.7
		c4.4,0.7,8.9,1.6,13.3,2.9s8.2,3.8,11.3,7.5s4.7,8.8,4.7,15c0,7.6-3.1,13.9-9.3,18.8C850,192.9,841.5,195.4,830.8,195.4z" />
                                <path fill="#1E3A8A" d="M918.5,173.8v19.2c-2.5,0.6-6,0.9-10.5,0.9c-16.8,0-25.2-8.3-25.2-25v-39.9h-11.1v-17.5h11.1V91.3H905v20.3
		h13.6v17.5H905v37.5c0,5.3,2.8,8,8.3,8L918.5,173.8z" />
                                <path fill="#1E3A8A" d="M1008.5,159h-59.4c0.7,5.6,2.8,9.9,6.3,12.9c3.4,3,8,4.5,13.6,4.5c3.5,0,6.8-0.8,9.6-2.3
		c2.9-1.5,4.9-3.7,6.2-6.6h22.4c-2.4,8.3-7.1,15.1-14.2,20.3c-7,5.2-15.2,7.7-24.6,7.7c-12.1,0-22-4-29.7-12
		c-7.7-8-11.6-18.3-11.6-31c0-12.2,3.9-22.4,11.6-30.5s17.6-12.2,29.5-12.2c12,0,21.8,4,29.3,12.1s11.3,18.3,11.3,30.6L1008.5,159z
		 M968,127.6c-5,0-9.1,1.4-12.3,4.1s-5.3,6.5-6.3,11.3h37.2c-0.8-4.7-2.9-8.4-6.1-11.3C977.3,129,973.1,127.6,968,127.6z" />
                                <path fill="#1E3A8A" d="M1070.1,111v20.8c-1.6-0.3-3-0.5-4.4-0.5c-6.6,0-11.5,1.7-14.8,5.2c-3.3,3.4-4.9,8.9-4.9,16.3v40.8h-22.2
		v-81.9h20.5v10.6c4.7-7.6,12.4-11.4,23.1-11.4L1070.1,111z" />
                            </g>
                            <path display="none" fill="#CDDDEA" d="M145.8-3.5c-0.3-5.8,2.4-10.5,6-14.5c18.5-20.8,40.2-33.8,69.5-34c21-0.1,39.2,6.5,57.3,15.3
	c19.2,9.3,39.4,13.9,60.5,16.4c14.9,1.8,29.8,0.7,44.6,1.4c3.9,0.2,7.7,0,11.3-1.6c5.1-2.2,7.8-0.3,8.5,5c2.5,18,5.1,35.9,7.7,53.9
	c3.8,25.5,7.6,51.1,11.4,76.6c3.9,26,7.8,52.1,11.8,78.1c1.6,10.6,3.1,21.3,4.9,31.9c1.9,11.4-0.4,14.4-12.1,15.6
	c-22.7,2.4-44.8-1.3-67-5.4c-28.3-5.2-53.9-18.2-81-26.7c-32.2-10.1-63.6-9.6-94.1,6c-13.6,7-23.4,18.3-33.8,28.9
	c-1.9,2-3.1,4.6-5.7,6.1c1.6-9.8,6.5-17.7,12.2-24.7c17.1-21,37.8-36.9,65.3-41.7c16.8-2.9,33.8-2,50.5,1
	c18.6,3.4,36.7,9.7,55.5,12.2c22.4,3,44,0.9,64.2-10.3c0.7-0.4,1.3-0.9,1.9-1.3c11.7-6.6,11.7-6.6,9.7-19.2
	c-7.1-46-14.2-91.9-21.4-137.9c-0.6-3.8-1.1-7.6-1.6-11.4c-1.4-12.1-1.4-12.1-13.8-12c-30,0.3-59.4-2.5-87.5-14
	c-7.6-3.1-15.4-6.3-22.1-10.8c-19.4-13-39.9-12.9-61.2-6.6c-16.4,4.8-31.6,12.2-46,21.4C149.9-4.9,148.5-3.1,145.8-3.5z" />
                            <path display="none" fill="#CDDDEA" d="M20.9-3.5c-0.3-5.8,2.4-10.5,6-14.5c18.5-20.8,40.2-33.8,69.5-34c21-0.1,39.2,6.5,57.3,15.3
	c19.2,9.3,39.4,13.9,60.5,16.4c14.9,1.8,29.8,0.7,44.7,1.4c3.9,0.2,7.7,0,11.3-1.6c5.1-2.2,7.8-0.3,8.5,5c2.5,18,5.1,35.9,7.7,53.9
	c3.8,25.5,7.6,51.1,11.4,76.6c3.9,26,7.8,52.1,11.8,78.1c1.6,10.6,3.1,21.3,4.9,31.9c1.9,11.4-0.4,14.4-12.1,15.6
	c-22.7,2.4-44.8-1.3-67-5.4c-28.3-5.2-53.9-18.2-81.1-26.7c-32.2-10.1-63.6-9.6-94.2,6c-13.6,7-23.4,18.3-33.8,28.9
	c-1.9,2-3.1,4.6-5.7,6.1c1.6-9.8,6.5-17.7,12.2-24.7c17.1-21,37.8-36.9,65.3-41.7c16.8-2.9,33.8-2,50.5,1
	c18.6,3.4,36.7,9.7,55.5,12.2c22.4,3,44.1,0.9,64.2-10.3c0.7-0.4,1.3-0.9,1.9-1.3c11.7-6.6,11.7-6.6,9.7-19.2
	c-7.1-46-14.2-91.9-21.4-137.9c-0.6-3.8-1.1-7.6-1.6-11.4c-1.4-12.1-1.4-12.1-13.8-12c-30,0.3-59.4-2.5-87.5-14
	c-7.6-3.1-15.4-6.3-22.1-10.8c-19.4-13-39.9-12.9-61.2-6.6C56.2-22.4,41-15,26.6-5.9C25-4.9,23.6-3.1,20.9-3.5z" />
                            <g display="none">
                                <path display="inline" fill="#1F4690" d="M557.3,209.9c2.3,0,4.1-0.4,5.5-1.4s2-2.2,2-3.9c0-1.2-0.3-2.1-0.9-2.9
		c-0.6-0.8-1.4-1.3-2.4-1.6s-2-0.6-3.2-0.9c-1.2-0.2-2.3-0.5-3.5-0.8c-1.2-0.3-2.3-0.7-3.2-1.1s-1.8-1.2-2.4-2.2s-0.9-2.3-0.9-3.8
		c0-2.1,0.8-4,2.5-5.5c1.7-1.5,4-2.3,7-2.3c3,0,5.3,0.8,7,2.5s2.5,3.8,2.6,6.5h-2.8c0-1.9-0.7-3.5-1.9-4.6s-2.8-1.8-4.9-1.8
		c-2.1,0-3.7,0.5-4.9,1.4s-1.8,2.2-1.8,3.7c0,1.1,0.3,2,0.9,2.7c0.6,0.7,1.4,1.2,2.4,1.5s2,0.6,3.2,0.8s2.3,0.5,3.5,0.8
		s2.2,0.7,3.2,1.2c1,0.5,1.8,1.3,2.4,2.3c0.6,1,0.9,2.3,0.9,3.8c0,2.4-1,4.3-2.9,5.8c-1.9,1.5-4.4,2.2-7.5,2.2
		c-3.4,0-5.9-0.8-7.6-2.5s-2.6-3.8-2.7-6.4h2.8c0.2,2.1,0.9,3.6,2.3,4.7C553.3,209.4,555.1,209.9,557.3,209.9z" />
                                <path display="inline" fill="#1F4690" d="M581.6,209.3v2.5c-0.5,0.1-1.2,0.2-2.1,0.2c-3.4,0-5.2-1.8-5.2-5.4v-12.2h-3.8V192h3.8
		v-5.7h2.8v5.7h4.6v2.4h-4.6v12c0,2.1,0.9,3.1,2.7,3.1L581.6,209.3z" />
                                <path display="inline" fill="#1F4690" d="M599.7,203.8v-11.8h2.8V212h-2.7v-2.9c-0.4,0.8-1.2,1.6-2.3,2.3s-2.5,1.1-4.2,1.1
		c-2.4,0-4.2-0.7-5.5-2.1c-1.3-1.4-1.9-3.2-1.9-5.5v-12.8h2.8v12.2c0,3.9,1.7,5.8,5.1,5.8c1.7,0,3.1-0.5,4.2-1.6
		C599.1,207.4,599.7,205.8,599.7,203.8z" />
                                <path display="inline" fill="#1F4690" d="M624.6,195.6v-13h2.8V212h-2.7v-3.7c-1.5,2.8-4,4.1-7.5,4.1c-2.9,0-5.2-1-6.9-3
		s-2.5-4.5-2.5-7.4c0-2.9,0.8-5.4,2.5-7.4s4-3,6.9-3C620.6,191.6,623.1,192.9,624.6,195.6z M624.7,202c0-2.3-0.6-4.2-1.9-5.7
		s-3-2.3-5.1-2.3s-3.9,0.8-5.2,2.3c-1.3,1.5-1.9,3.4-1.9,5.7c0,2.2,0.6,4.1,1.9,5.6c1.3,1.5,3,2.3,5.2,2.3s3.9-0.8,5.1-2.3
		S624.7,204.3,624.7,202z" />
                                <path display="inline" fill="#1F4690" d="M652.1,202.8h-16.5c0.1,2.1,0.8,3.8,2.1,5.1c1.3,1.3,2.9,2,5,2c1.5,0,2.8-0.4,3.9-1.1
		c1.1-0.8,1.9-1.8,2.3-3h2.9c-0.6,2-1.7,3.6-3.3,4.8c-1.6,1.2-3.6,1.9-5.9,1.9c-3,0-5.4-1-7.2-3s-2.6-4.5-2.6-7.4
		c0-2.9,0.9-5.3,2.7-7.4s4.2-3.1,7.1-3.1s5.2,1,7,2.9s2.6,4.4,2.6,7.3L652.1,202.8z M642.5,194.1c-1.9,0-3.4,0.6-4.7,1.8
		s-2,2.8-2.2,4.6h13.7c-0.2-2-0.9-3.5-2.1-4.7C646,194.7,644.5,194.1,642.5,194.1z" />
                                <path display="inline" fill="#1F4690" d="M660.1,192.1v3.1c0.5-0.9,1.3-1.7,2.3-2.4c1.1-0.7,2.5-1.1,4.2-1.1c2.4,0,4.3,0.7,5.6,2.1
		c1.3,1.4,2,3.3,2,5.6V212h-2.8v-12.2c0-1.9-0.4-3.3-1.3-4.3s-2.2-1.5-3.9-1.5s-3.2,0.5-4.3,1.6c-1.1,1.1-1.7,2.6-1.7,4.5V212h-2.8
		V192L660.1,192.1L660.1,192.1z" />
                                <path display="inline" fill="#1F4690" d="M688.9,209.3v2.5c-0.5,0.1-1.2,0.2-2.1,0.2c-3.4,0-5.2-1.8-5.2-5.4v-12.2h-3.8V192h3.8
		v-5.7h2.8v5.7h4.6v2.4h-4.6v12c0,2.1,0.9,3.1,2.7,3.1L688.9,209.3z" />
                                <path display="inline" fill="#1F4690" d="M725.1,212h-3.4l-6.5-12.1H707V212h-2.8v-27.8h11.4c3,0,5.2,0.7,6.7,2.2
		c1.5,1.4,2.2,3.3,2.2,5.6c0,2-0.5,3.6-1.6,5c-1.1,1.4-2.7,2.2-4.8,2.6L725.1,212z M721.5,192c0-1.6-0.5-2.8-1.5-3.7
		c-1-0.9-2.4-1.4-4.4-1.4H707v10.2h8.7c1.9,0,3.4-0.4,4.4-1.4S721.5,193.6,721.5,192z" />
                                <path display="inline" fill="#1F4690" d="M747.7,202.8h-16.5c0.1,2.1,0.8,3.8,2.1,5.1c1.3,1.3,2.9,2,5,2c1.5,0,2.8-0.4,3.9-1.1
		c1.1-0.8,1.9-1.8,2.3-3h2.9c-0.6,2-1.7,3.6-3.3,4.8c-1.6,1.2-3.6,1.9-5.9,1.9c-3,0-5.4-1-7.2-3s-2.6-4.5-2.6-7.4
		c0-2.9,0.9-5.3,2.7-7.4s4.2-3.1,7.1-3.1s5.2,1,7,2.9s2.6,4.4,2.6,7.3L747.7,202.8z M738.2,194.1c-1.9,0-3.4,0.6-4.7,1.8
		s-2,2.8-2.2,4.6H745c-0.2-2-0.9-3.5-2.1-4.7C741.7,194.7,740.1,194.1,738.2,194.1z" />
                                <path display="inline" fill="#1F4690" d="M768.5,195.7v-3.6h2.7V211c0,2.8-0.8,5.1-2.4,6.9c-1.6,1.8-3.9,2.7-6.9,2.7
		c-2.6,0-4.7-0.6-6.2-1.9s-2.5-2.7-2.9-4.5h2.8c0.4,1.2,1.1,2.1,2.3,2.8c1.1,0.7,2.5,1,4,1c2,0,3.6-0.6,4.7-1.8
		c1.2-1.2,1.7-2.7,1.7-4.6v-3.7c-1.5,2.7-4,4-7.4,4c-2.9,0-5.2-1-6.8-3c-1.7-2-2.5-4.4-2.5-7.2s0.8-5.2,2.5-7.2c1.7-2,4-3,6.8-3
		C764.5,191.6,767,192.9,768.5,195.7z M766.6,207.3c1.3-1.5,1.9-3.3,1.9-5.5c0-2.2-0.6-4.1-1.9-5.5c-1.3-1.4-3-2.2-5.1-2.2
		c-2.1,0-3.8,0.7-5.1,2.2c-1.3,1.5-1.9,3.3-1.9,5.5c0,2.2,0.6,4,1.9,5.5c1.3,1.5,3,2.2,5.1,2.2C763.6,209.4,765.3,208.7,766.6,207.3
		z" />
                                <path display="inline" fill="#1F4690" d="M779.2,187.1c-0.6,0-1.1-0.2-1.5-0.5s-0.5-0.8-0.5-1.4s0.2-1.1,0.5-1.4
		c0.4-0.4,0.8-0.6,1.5-0.6c0.6,0,1,0.2,1.4,0.6s0.6,0.9,0.6,1.4s-0.2,1-0.6,1.4C780.3,186.9,779.8,187.1,779.2,187.1z M777.8,212
		v-19.9h2.8V212H777.8z" />
                                <path display="inline" fill="#1F4690" d="M793.8,212.4c-2.7,0-4.7-0.6-6-1.9c-1.3-1.3-2-2.9-2.2-4.8h2.8c0.1,1.3,0.6,2.4,1.5,3.1
		c0.9,0.8,2.2,1.1,3.8,1.1c1.6,0,2.9-0.3,3.8-0.9c0.9-0.6,1.4-1.4,1.4-2.5c0-1.1-0.4-1.8-1.3-2.3c-0.8-0.5-1.9-0.9-3.1-1
		s-2.4-0.4-3.6-0.6c-1.2-0.3-2.3-0.8-3.1-1.6c-0.8-0.8-1.3-2-1.3-3.5c0-1.6,0.7-3,2-4.1c1.3-1.1,3.1-1.7,5.4-1.7
		c2.5,0,4.3,0.6,5.5,1.9s1.9,2.7,2,4.4h-2.8c-0.1-1.1-0.6-2.1-1.4-2.8s-2-1.1-3.5-1.1c-1.5,0-2.6,0.3-3.4,0.9
		c-0.8,0.6-1.2,1.4-1.2,2.3c0,0.8,0.3,1.5,0.9,2s1.4,0.8,2.3,1c0.9,0.2,1.9,0.4,2.9,0.7s2.1,0.5,3,0.7s1.7,0.8,2.3,1.6
		c0.6,0.9,0.9,2,0.9,3.3c0,1.6-0.7,3-2,4.1C798.3,211.9,796.3,212.4,793.8,212.4z" />
                                <path display="inline" fill="#1F4690" d="M815.2,209.3v2.5c-0.5,0.1-1.2,0.2-2.1,0.2c-3.4,0-5.2-1.8-5.2-5.4v-12.2h-3.8V192h3.8
		v-5.7h2.8v5.7h4.6v2.4h-4.6v12c0,2.1,0.9,3.1,2.7,3.1L815.2,209.3z" />
                                <path display="inline" fill="#1F4690" d="M829.5,191.9v2.6c-0.3,0-0.6,0-1,0c-1.8,0-3.2,0.5-4.3,1.6c-1.1,1.1-1.6,2.6-1.6,4.6V212
		h-2.8v-19.9h2.7v3.1c0.5-0.9,1.2-1.6,2.3-2.3s2.4-1,4.1-1L829.5,191.9z" />
                                <path display="inline" fill="#1F4690" d="M839.2,212.4c-2.3,0-4.1-0.5-5.3-1.6c-1.2-1.1-1.8-2.5-1.8-4.4c0-3.3,2.5-5.3,7.5-6l7-0.9
		V199c0-3.4-1.9-5-5.6-5c-3.2,0-5,1.3-5.5,3.9h-2.8c0.3-1.9,1.1-3.5,2.5-4.6s3.4-1.7,6-1.7c2.8,0,4.8,0.7,6.2,2s2.1,3.2,2.1,5.5v8.7
		c0,2,0.2,3.4,0.6,4.2h-2.7c-0.3-0.8-0.4-1.9-0.4-3.4C845.3,211.1,842.7,212.4,839.2,212.4z M846.6,201.8l-6.6,0.9
		c-1.8,0.2-3.1,0.7-3.9,1.3c-0.8,0.6-1.2,1.5-1.2,2.5c0,1.3,0.4,2.2,1.3,2.8s2,0.8,3.3,0.8c2.2,0,4-0.6,5.2-1.9s1.9-2.6,1.9-4.2
		L846.6,201.8L846.6,201.8z" />
                                <path display="inline" fill="#1F4690" d="M864.1,209.3v2.5c-0.5,0.1-1.2,0.2-2.1,0.2c-3.4,0-5.2-1.8-5.2-5.4v-12.2H853V192h3.8
		v-5.7h2.8v5.7h4.6v2.4h-4.6v12c0,2.1,0.9,3.1,2.7,3.1L864.1,209.3z" />
                                <path display="inline" fill="#1F4690" d="M870,187.1c-0.6,0-1.1-0.2-1.5-0.5s-0.5-0.8-0.5-1.4s0.2-1.1,0.5-1.4
		c0.4-0.4,0.8-0.6,1.5-0.6c0.6,0,1,0.2,1.4,0.6s0.6,0.9,0.6,1.4s-0.2,1-0.6,1.4C871.1,186.9,870.6,187.1,870,187.1z M868.6,212
		v-19.9h2.8V212H868.6z" />
                                <path display="inline" fill="#1F4690" d="M886.9,212.4c-3,0-5.5-1-7.3-3.1s-2.8-4.5-2.8-7.3c0-2.9,0.9-5.3,2.8-7.4s4.3-3.1,7.3-3.1
		c3,0,5.5,1,7.4,3.1s2.8,4.5,2.8,7.4c0,2.8-0.9,5.3-2.8,7.3C892.4,211.4,890,212.4,886.9,212.4z M879.6,202c0,2.3,0.7,4.1,2,5.6
		c1.4,1.5,3.1,2.3,5.3,2.3c2.2,0,4-0.8,5.3-2.3s2-3.4,2-5.6c0-2.3-0.7-4.2-2-5.7s-3.1-2.3-5.3-2.3s-4,0.8-5.3,2.3
		S879.6,199.7,879.6,202z" />
                                <path display="inline" fill="#1F4690" d="M905,192.1v3.1c0.5-0.9,1.3-1.7,2.3-2.4c1.1-0.7,2.5-1.1,4.2-1.1c2.4,0,4.3,0.7,5.6,2.1
		c1.3,1.4,2,3.3,2,5.6V212h-2.8v-12.2c0-1.9-0.4-3.3-1.3-4.3s-2.2-1.5-3.9-1.5s-3.2,0.5-4.3,1.6c-1.1,1.1-1.7,2.6-1.7,4.5V212h-2.8
		V192L905,192.1L905,192.1z" />
                                <path display="inline" fill="#1F4690" d="M944.5,209.9c2.3,0,4.1-0.4,5.5-1.4s2-2.2,2-3.9c0-1.2-0.3-2.1-0.9-2.9
		c-0.6-0.8-1.4-1.3-2.4-1.6s-2-0.6-3.2-0.9c-1.2-0.2-2.3-0.5-3.5-0.8c-1.2-0.3-2.3-0.7-3.2-1.1s-1.8-1.2-2.4-2.2s-0.9-2.3-0.9-3.8
		c0-2.1,0.8-4,2.5-5.5c1.7-1.5,4-2.3,7-2.3c3,0,5.3,0.8,7,2.5s2.5,3.8,2.6,6.5h-2.8c0-1.9-0.7-3.5-1.9-4.6c-1.2-1.2-2.8-1.8-4.9-1.8
		c-2.1,0-3.7,0.5-4.9,1.4s-1.8,2.2-1.8,3.7c0,1.1,0.3,2,0.9,2.7c0.6,0.7,1.4,1.2,2.4,1.5c1,0.3,2,0.6,3.2,0.8
		c1.2,0.2,2.3,0.5,3.5,0.8c1.2,0.3,2.2,0.7,3.2,1.2c1,0.5,1.8,1.3,2.4,2.3c0.6,1,0.9,2.3,0.9,3.8c0,2.4-1,4.3-2.9,5.8
		c-1.9,1.5-4.4,2.2-7.5,2.2c-3.4,0-5.9-0.8-7.6-2.5s-2.6-3.8-2.7-6.4h2.8c0.2,2.1,0.9,3.6,2.3,4.7
		C940.5,209.4,942.3,209.9,944.5,209.9z" />
                                <path display="inline" fill="#1F4690" d="M962.8,220l3.4-8.1l-8.3-19.9h3l6.7,16.5l6.9-16.5h2.9l-11.8,28L962.8,220z" />
                                <path display="inline" fill="#1F4690" d="M987.9,212.4c-2.7,0-4.7-0.6-6-1.9c-1.3-1.3-2-2.9-2.2-4.8h2.8c0.1,1.3,0.6,2.4,1.5,3.1
		c0.9,0.8,2.2,1.1,3.8,1.1c1.6,0,2.9-0.3,3.8-0.9c0.9-0.6,1.4-1.4,1.4-2.5c0-1.1-0.4-1.8-1.3-2.3c-0.8-0.5-1.9-0.9-3.1-1
		s-2.4-0.4-3.6-0.6c-1.2-0.3-2.3-0.8-3.1-1.6c-0.8-0.8-1.3-2-1.3-3.5c0-1.6,0.7-3,2-4.1c1.3-1.1,3.1-1.7,5.4-1.7
		c2.5,0,4.3,0.6,5.5,1.9s1.9,2.7,2,4.4H993c-0.1-1.1-0.6-2.1-1.4-2.8s-2-1.1-3.5-1.1c-1.5,0-2.6,0.3-3.4,0.9
		c-0.8,0.6-1.2,1.4-1.2,2.3c0,0.8,0.3,1.5,0.9,2s1.4,0.8,2.3,1c0.9,0.2,1.9,0.4,2.9,0.7s2.1,0.5,3,0.7s1.7,0.8,2.3,1.6
		c0.6,0.9,0.9,2,0.9,3.3c0,1.6-0.7,3-2,4.1C992.4,211.9,990.4,212.4,987.9,212.4z" />
                                <path display="inline" fill="#1F4690" d="M1009.3,209.3v2.5c-0.5,0.1-1.2,0.2-2.1,0.2c-3.4,0-5.2-1.8-5.2-5.4v-12.2h-3.8V192h3.8
		v-5.7h2.8v5.7h4.6v2.4h-4.6v12c0,2.1,0.9,3.1,2.7,3.1L1009.3,209.3z" />
                                <path display="inline" fill="#1F4690" d="M1031.7,202.8h-16.5c0.1,2.1,0.8,3.8,2.1,5.1c1.3,1.3,2.9,2,5,2c1.5,0,2.8-0.4,3.9-1.1
		c1.1-0.8,1.9-1.8,2.3-3h2.9c-0.6,2-1.7,3.6-3.3,4.8c-1.6,1.2-3.6,1.9-5.9,1.9c-3,0-5.4-1-7.2-3s-2.6-4.5-2.6-7.4
		c0-2.9,0.9-5.3,2.7-7.4s4.2-3.1,7.1-3.1s5.2,1,7,2.9s2.6,4.4,2.6,7.3L1031.7,202.8z M1022.1,194.1c-1.9,0-3.4,0.6-4.7,1.8
		s-2,2.8-2.2,4.6h13.7c-0.2-2-0.9-3.5-2.1-4.7C1025.6,194.7,1024.1,194.1,1022.1,194.1z" />
                                <path display="inline" fill="#1F4690" d="M1053.3,200.3V212h-2.8v-12.2c0-1.8-0.4-3.2-1.2-4.2s-2.1-1.5-3.8-1.5
		c-1.7,0-3,0.6-4.1,1.6s-1.6,2.6-1.6,4.5V212h-2.8v-19.9h2.7v3.1c1.3-2.4,3.4-3.5,6.3-3.5c3.2,0,5.3,1.3,6.5,3.8
		c0.6-1.1,1.5-2,2.7-2.7s2.6-1.1,4.3-1.1c2.3,0,4.1,0.7,5.4,2.2c1.3,1.4,1.9,3.3,1.9,5.5V212h-2.8v-12.2c0-1.8-0.4-3.2-1.2-4.2
		s-2.1-1.6-3.7-1.6c-1.6,0-3,0.6-4.1,1.6C1053.8,196.7,1053.3,198.3,1053.3,200.3z" />
                            </g>
                        </svg>
                    </a>
                </div>
                <img src="images/signup.png" class="rounded-br-lg">
            </div>
        </div>
    </div>
    <footer class="mt-4">
        <p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
    </footer>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="js/student_createAccount.js"></script>
</body>

</html>