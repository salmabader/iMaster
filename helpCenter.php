<?php
session_start();
if (isset($_SESSION['type'])) {
	$privilage = $_SESSION['type'];
	if (isset($_SESSION['username']) && $privilage == "student") {
		header('Location: studentDashboard.php');
		exit();
	} elseif (isset($_SESSION['username']) && $privilage == "admin") {
		header('Location: analytics.php');
		// header('Location: helpCenter.php');
		exit();
	}
}
require('database/db_connection.php');
$con = OpenCon();
if (isset($_POST['createAccountBtn'])) {

	$description = filter_input(INPUT_POST, 'description');
	$Reason = filter_input(INPUT_POST, 'Reason');
	$courseID = filter_input(INPUT_POST, 'title');
	$option = filter_input(INPUT_POST, 'option');
	$status = "waiting";

	$instUsername = $_SESSION['username'];
	//  for option 1:
	if ($option == "DeleteCourse") {
		$insertQuery = "INSERT INTO requests (type,status,instructor_username,reason,course_id,date) VALUES (?,?,?,?,?,?)";
		$statement = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($statement, $insertQuery)) {
			header('Location: index.php?error=InsertionError');
			exit();
		} else {
			date_default_timezone_set('Asia/Riyadh');
			$date = date("Y-m-d");
			mysqli_stmt_bind_param($statement, "ssssss", $option, $status, $instUsername, $Reason, $courseID, $date);
			mysqli_stmt_execute($statement);
			$feedback = "Your Request has been sent!";
		}
	}
	//  for option 2:
	if ($option == "others") {
		$insertQuery = "INSERT INTO requests (type,status,instructor_username,reason,date) VALUES (?,?,?,?,?)";
		$statement = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($statement, $insertQuery)) {
			header('Location: index.php?error=InsertionError');
			exit();
		} else {
			date_default_timezone_set('Asia/Riyadh');
			$date = date("Y-m-d");
			mysqli_stmt_bind_param($statement, "sssss", $option, $status, $instUsername, $description, $date);
			mysqli_stmt_execute($statement);
			$feedback = "Your Request has been sent!";
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
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2/dist/chart.min.js"></script>
	<title>Help center</title>
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
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="instructorDashboard.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
								</svg><span class="toHide">Dashboard</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="createCourse.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
								</svg><span class="toHide">New Course</span></a>
						</div>
						<div class="text-blue-800 duration-100 ease-in-out mb-5">
							<a href="helpCenter.php" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
								</svg><span class="toHide">Help Center</span></a>
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
				</div>
				<!-- col 2: content -->
				<div class="w-full flex justify-center items-center h-[85%] overflow-y-auto overflow-x-hidden scrollbar">
					<div class="bg-gray-100 mt-10 rounded-lg flex flex-col items-center mx-2 w-[98%] h-full mb-5 relative overflow-hidden">
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-col w-3/4 gap-5 absolute top-14 transition-all duration-500">

							<div class="w-full h-full border-2 border-gray-100 mt-3">

								<!-- options -->

								<div class="flex w-1/2 ">
									<div class="w-full mr-2">
										<label for="option" class="block capitalize font-semibold my-2">What kind of help do you need ?</label>
										<select id="option" onclick="Validate()" name="option" class="bg-blue-50 px-6 py-2.5 border-2 border-blue-200 focus:bg-white text-sm rounded-lg block w-full">
											<option selected value="0">Choose your help option</option>
											<option value="DeleteCourse">Delete course</option>
											<option value="others">Others</option>
										</select>
									</div>
								</div>
								<!-- Delete course option -->
								<div class="flex flex-col w-1/2 " id="Deletecourses">
									<!-- title list -->
									<div class="w-full mr-2">
										<label for="title" class="block capitalize font-semibold my-2">course title</label>
										<select id="title" onclick="Validate()" name="title" class="bg-blue-50 px-6 py-2.5 border-2 border-blue-200 focus:bg-white text-sm rounded-lg block w-full">
											<option selected value="0">Choose course title</option>
											<?php
											$query = "SELECT * FROM course WHERE instructor_usename = '" . $_SESSION['username'] . "'";
											$result = mysqli_query($con, $query);
											if (mysqli_num_rows($result) > 0) { ?>
												<?php while ($course = mysqli_fetch_assoc($result)) {
												?>
													<option value="<?php echo ucfirst($course['courseID']) ?>"><?php echo ucfirst($course['title']) ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<!-- title list -->

									<!-- Reason -->
									<label for="Reason" class="block capitalize font-semibold my-2">reason</label>
									<textarea name="Reason" id="Reason" placeholder="Please write your reason here.." class=" bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 w-full"></textarea>
								</div>
								<!-- other option -->
								<div class="flex flex-col w-1/2 " id="Other">
									<label for="description" class="block capitalize font-semibold my-2">problem description</label>
									<textarea name="description" id="description" placeholder="Please write a brief description here.. " class=" bg-blue-50 px-6 py-2 rounded-lg border-2 border-blue-200 focus:bg-white placeholder-gray-400 text-blue-800 w-full"></textarea>
								</div>
							</div>

							<!-- button -->
							<div class="flex flex-col w-1/2 items-end">
								<button type="submit" name="createAccountBtn" id="signupBtn" class="mt-10 bg-blue-500 text-white px-14 py-3 rounded-full shadow-md font-semibold hover:bg-blue-600 duration-100 ease-in-out disabled:opacity-60 disabled:pointer-events-none" disabled>Send</button>

							</div>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- end of right side-->
	</main>
	<!-- toast messages  -->
	<div id="toast" class="opacity-0 flex fixed bottom-5 right-8 items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 border-2 border-green-600" role="alert">
		<div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-600 rounded-lg dark:bg-green-800 dark:text-green-200">
			<svg aria-hidden="true" class="h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
			</svg>
			<span class="sr-only">Check icon</span>
		</div>
		<div class="ml-3 text-sm font-normal" id="feedback"><?php if (isset($feedback)) echo $feedback ?></div>
		<button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast" aria-label="Close">
			<span class="sr-only">Close</span>
			<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
			</svg>
		</button>
	</div>
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
							<label for="bio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Bio</label>
							<textarea name="bio" id="bio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"><?php echo $user['bio'] ?></textarea>
						</div>
						<div>
							<label for=" username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
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

	<script src="js/helpCenter.js"></script>
	<script src="js/analytics.js"></script>
	<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>