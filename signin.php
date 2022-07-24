<?php
session_start();
require('database/db_connection.php');
$con = OpenCon();
if (isset($_POST['signinBtn'])) {

	$isValidUsername = false;
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$existanceQuery1 = "SELECT * FROM student WHERE username = ? ";
	$existanceQuery2 = "SELECT * FROM instructors WHERE username = ?";
	$statement1 = mysqli_stmt_init($con);
	$statement2 = mysqli_stmt_init($con);
	if (!mysqli_stmt_prepare($statement1, $existanceQuery1) || !mysqli_stmt_prepare($statement2, $existanceQuery2)) {
		header('Location: index.php?error=SQLError');
		exit();
	} else {
		mysqli_stmt_bind_param($statement1, "s", $username);
		mysqli_stmt_execute($statement1);
		$result1 = mysqli_stmt_get_result($statement1);
		mysqli_stmt_bind_param($statement2, "s", $username);
		mysqli_stmt_execute($statement2);
		$result2 = mysqli_stmt_get_result($statement2);
		$fetchedStu = array();
		$fetchedInstruc = array();
		//to store all the fetched rows
		$stu = mysqli_fetch_assoc($result1);
		$inst = mysqli_fetch_assoc($result2);


		if (isset($inst)) {
			$isValidInstPass = password_verify($password, $inst['password']);
			if (!$isValidInstPass) {
				$passError = "Invalid password.";
			}
		}
		if (isset($stu)) {
			$isValidstuPass = password_verify($password, $stu['password']);
			if (!$isValidstuPass) {
				$passError = "Invalid password.";
			}
		}
		if (!isset($inst) && !isset($stu)) {

			$usernameError = "Invalid username.";
		}
		if (isset($stu) && $isValidstuPass) {
			header('Location: student_home.html');
		} elseif (isset($inst) && $isValidInstPass) {
			header('Location: instructor_home.html');
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
	<title>Sign in</title>
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
	<img src="images/logo.svg" class="lg:hidden block h-14 mb-2">
	<div class="bg-white w-2/3 flex rounded-lg border-amber-400 border-x-2 shadow-md">
		<!-- left side -->
		<div class="lg:w-2/3 w-full flex flex-col lg:mr-4 mr-0">
			<p class="text-center pt-10 font-medium text-xl">Sign in to Your Account</p>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-wrap justify-center px-12 pb-12 overflow-y-auto scrollbar">
				<!-- username -->
				<div class="w-full mt-3">
					<label for="usename" class="block capitalize font-semibold">username</label>
					<input type="text" name="username" maxlength="10" id="signup_usename" placeholder="_salma" class="w-full mt-1  bg-amber-50 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-amber-400 focus:ring-amber-400" value="<?php if (isset($username)) echo htmlspecialchars($username)  ?>">
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
								<svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400 hover:text-amber-500" viewBox="0 0 20 20" fill="currentColor">
									<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
									<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
								</svg>
							</div>
							<input type="password" name="password" id="password" placeholder="••••••••" class="w-full mt-1  bg-amber-50 px-6 py-2 rounded-lg border-2 border-amber-200 focus:bg-white placeholder-gray-400 text-blue-800 focus:border-amber-400 focus:ring-amber-400" data-tooltip-target="tooltip-click" data-tooltip-trigger="click" data-tooltip-placement="right" value="<?php if (isset($password)) echo htmlspecialchars($password) ?>">
							<div class="text-red-500 text-sm mt-2">
								<p class="flex items-center" id="usernameError"><?php if (isset($passError)) echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>' . $passError ?></p>
							</div>
						</div>
						<div class="text-red-500 text-sm mt-2">
							<p id="signInError" class="flex items-center"></p>
						</div>
						<div class="text-amber-500 text-xs flex justify-end mr-2">
							<a href="resetPassword.php" class="hover:underline">Forget password?</a>
						</div>
					</div>
				</div>

				<!-- button -->
				<div class="flex flex-col items-center">
					<button type="submit" name="signinBtn" id="signinBtn" class="mt-10 bg-amber-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-amber-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Sign in</button>
					<p class="text-xs mt-4">New user? <span class=" text-amber-600 hover:underline"><a href="createStudentAccount.php">create account</a></span></p>
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
				<img src="images/signin_users.png" class="rounded-br-lg">
			</div>
		</div>
	</div>
	<footer class="mt-4">
		<p class="text-sm text-gray-600 text-center">Copyright © 2022 iMaster</p>
	</footer>
	<script src="js/signin.js"></script>
	<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>