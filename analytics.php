<?php
session_start();
require 'database/db_connection.php';
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
	// need to catch the photo
	// $photo = filter_input(INPUT_POST, 'photo');
	// $password = filter_input(INPUT_POST, 'password');
	$query = "UPDATE $privilage SET FName = ?, LName = ? WHERE username ='" . $_SESSION['username'] . "'";
	$statement = mysqli_stmt_init($con);
	mysqli_stmt_prepare($statement, $query);
	mysqli_stmt_bind_param($statement, "ss", $fName, $lName);
	mysqli_stmt_execute($statement);
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
	<title>Analytics</title>
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
						<div class="text-blue-800 duration-100 ease-in-out mb-5">
							<a href="analytics.php" class="border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
									<path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
								</svg><span class="toHide">Analytics</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
								</svg><span class="toHide">Requests</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
									<path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
								</svg><span class="toHide">Issues</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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
				<div class="w-full h-[15%] flex justify-between mt-3 border-b-[1px] border-gray-200">
					<!-- profile -->
					<div class="w-2/3 flex items-center mb-2">
						<!-- personal photo -->
						<div class="md:w-1/6 sm:w-1/4 h-full flex md:justify-end sm:justify-start justify-center w-1/2 ">
							<button data-modal-toggle="profile-modal" class="relative">
								<img src="images/default_user_img.jpg" class="h-full rounded-full ml-2 border-[1px] border-gray-400 hover:shadow-md hover:shadow-amber-300 shadow transition-all ease-in-out duration-200">
								<div class="absolute bottom-3 -right-1 bg-amber-200 p-[2px] rounded-full border-[1px] border-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 20 20" fill="currentColor">
										<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
									</svg>
								</div>
							</button>
						</div>
						<!-- greeting -->
						<div class="md:w-5/6 flex flex-col h-full justify-center sm:ml-3 sm:w-3/4 w-1/2">
							<div class="w-full md:text-xl text-lg font-semibold text-gray-800">Welcome back, <span class="capitalize"><?php if (isset($admin['FName'])) echo $admin['FName']; ?> 👋🏻</span></div>
							<div class="w-full text-sm text-gray-600 capitalize"><?php if (isset($_SESSION['type'])) echo $_SESSION['type']; ?></div>
						</div>
					</div>
					<!-- notifications -->
					<div class="w-1/3 mr-5 flex items-center justify-end text-gray-500">
						<!-- notification icon -->
						<button>
							<div class="bg-gray-200 shadow rounded-md p-2">
								<div class="relative">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
									</svg>
									<div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 right-1 "></div>
									<div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 animate-ping right-1 "></div>
								</div>
							</div>
						</button>
					</div>
				</div>
				<!-- col 2: content -->
				<div class="w-full h-[85%] overflow-y-auto overflow-x-hidden scrollbar">
					<div class="md:ml-5 mt-5">
						<!-- Title -->
						<p class="text-xl font-semibold capitalize w-full tracking-wide text-gray-700">Analytics dashboard</p>
						<!-- date -->
						<div class="text-sm tracking-wide text-gray-500 mt-1">
							<?php echo date('F', mktime(0, 0, 0, date("m"))) . ' ' . date("d") . ', ' . date("l"); ?>
						</div>
					</div>
					<!-- top cards -->
					<div class="flex flex-col md:ml-5">
						<!-- get numbers -->
						<?php
						$query = "SELECT username FROM student";
						$result = mysqli_query($con, $query);
						$numOfStudents = mysqli_num_rows($result);

						$query = "SELECT username FROM instructors";
						$result = mysqli_query($con, $query);
						$numOfInstructors = mysqli_num_rows($result);

						$query = "SELECT courseID FROM course";
						$result = mysqli_query($con, $query);
						$numOfCourses = mysqli_num_rows($result);

						$query = "SELECT requestID FROM requests WHERE status = 'waiting'";
						$result = mysqli_query($con, $query);
						$numOfRequests = mysqli_num_rows($result);
						?>
						<!-- four numbers -->
						<div id="fourCards" class="flex flex-col md:flex-row mt-4 mr-2 w-full">
							<div class="flex w-full">
								<!-- students -->
								<div class="mr-3 md:mb-0 mb-3 flex items-center w-full bg-amber-50 px-3 py-4 border border-gray-300 rounded-md">
									<div class="bg-amber-300 rounded-full p-3 text-gray-800 mr-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
											<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
										</svg>
									</div>
									<div>
										<h5 class="text-2xl font-semibold text-gray-800"><?php echo $numOfStudents ?></h5>
										<p class="text-gray-700 text-sm"><?php if ($numOfStudents > 1) echo "Registered students";
																			elseif ($numOfStudents == 0) echo "There is no regirstred students yet";
																			else echo "Registered student" ?></p>
									</div>
								</div>
								<!-- instructors -->
								<div class="mr-3 md:mb-0 mb-3 flex items-center w-full bg-amber-50 px-3 py-4 border border-gray-300 rounded-md">
									<div class="bg-amber-300 rounded-full p-3 text-gray-800 mr-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
											<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
										</svg>
									</div>
									<div>
										<h5 class="text-2xl font-semibold text-gray-800"><?php echo $numOfInstructors ?></h5>
										<p class="text-gray-700 text-sm"><?php if ($numOfInstructors > 1) echo "Registered instructors";
																			elseif ($numOfInstructors == 0) echo "There is no regirstred instructors yet";
																			else echo "Instructor" ?></p>
									</div>
								</div>
							</div>
							<div class="flex w-full">
								<!-- courses -->
								<div class="mr-3 md:mb-0 mb-3 flex items-center w-full bg-amber-50 px-3 py-4 border border-gray-300 rounded-md">
									<div class="bg-amber-300 rounded-full p-3 text-gray-800 mr-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
											<path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
										</svg>
									</div>
									<div>
										<h5 class="text-2xl font-semibold text-gray-800"><?php echo $numOfCourses ?></h5>
										<p class="text-gray-700 text-sm"><?php if ($numOfCourses > 1) echo "Published courses";
																			elseif ($numOfCourses == 0) echo "There is no published courses yet";
																			else echo "Published courses" ?></p>
									</div>
								</div>
								<!-- requests -->
								<div class="mr-3 md:mb-0 mb-3 flex items-center w-full bg-amber-50 px-3 py-4 border border-gray-300 rounded-md">
									<div class="bg-amber-300 rounded-full p-3 text-gray-800 mr-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 20 20" fill="currentColor">
											<path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
											<path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
										</svg>
									</div>
									<div>
										<h5 class="text-2xl font-semibold text-gray-800"><?php echo $numOfRequests ?></h5>
										<p class="text-gray-700 text-sm"><?php if ($numOfRequests > 1) echo "New requests";
																			elseif ($numOfRequests == 0) echo "You have been replied for all requests";
																			else echo "New request" ?></p>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- end of top cards -->
					<!-- another content -->
					<div class="">
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
						<div>
							<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">Photo</label>
							<div class="flex items-center">
								<img src="images/<?php echo $admin['photo'] ?>" class="w-1/4 rounded-full mr-2">
								<div class="w-3/4">
									<input class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none id=" file_input" name="photo" type="file">
								</div>
							</div>
						</div>
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
	<script src="js/analytics.js"></script>
	<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>