<?php
session_start();
require 'database/db_connection.php';
$con = OpenCon();
if (isset($_POST['done'])) {
	$courseTitle = filter_input(INPUT_POST, 'courseTitle');
	$field = filter_input(INPUT_POST, 'category');
	$objective = filter_input(INPUT_POST, 'objectives');
	$requirement = filter_input(INPUT_POST, 'requirement');
	$level = filter_input(INPUT_POST, 'level');

	$chapterTitles =  $_POST['chapterTitle'];
	$lessonsTitles =  $_POST['lessonTitle'];

	$contentVideo =  $_POST['contentVideo'];
	$contentDescription =  $_POST['contentDescription'];

	$courseDescription = filter_input(INPUT_POST, 'description');
	$courseImg = filter_input(INPUT_POST, 'image');
	$coUsername = filter_input(INPUT_POST, 'coUsername');
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
	<title>Create new course</title>
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

		#progress::after {
			content: "";
			height: 100%;
			width: 0;
			border-top: 18px solid transparent;
			border-bottom: 18px solid transparent;
			position: absolute;
			right: -20px;
			top: 0;
			border-left: 20px solid #3b82f6;
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
						<div class="text-blue-800 duration-100 ease-in-out mb-5">
							<a href="createCourse.php" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
								</svg><span class="toHide">New Course</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="helpCenter.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
					<!-- notifications -->
					<div class="w-1/3 mr-5 flex items-center justify-end text-gray-500">
						<!-- notification icon -->
						<button id="dropdownNotificationBtn" data-dropdown-toggle="dropdownNotification">
							<div class="bg-gray-200 shadow rounded-md p-2 hover:bg-gray-300">
								<div class="relative">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
									</svg>
									<div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 right-1 "></div>
									<div class="absolute bg-blue-500 h-2 w-2 rounded-full top-1.5 animate-ping right-1 "></div>
								</div>
							</div>
						</button>
						<!-- Dropdown menu -->
						<div id="dropdownNotification" class="hidden z-20 w-full max-w-sm bg-white rounded divide-y divide-gray-100 shadow-md" aria-labelledby="dropdownNotificationBtn">
							<div class="block py-2 px-4 font-medium text-center text-gray-700 bg-gray-50">
								Notifications
							</div>
							<div class="divide-y divide-gray-100 dark:divide-gray-700">
								<a href="#" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
									<div class="flex-shrink-0 text-blue-600 bg-blue-200 rounded-full p-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
										</svg>
									</div>
									<div class="pl-3 w-full">
										<div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">Muhammad sent an application</div>
										<div class="text-xs text-gray-600">a few minutes ago</div>
									</div>
								</a>

								<a href="#" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
									<div class="flex-shrink-0 text-amber-600 bg-amber-200 rounded-full p-2">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
										</svg>
									</div>
									<div class="pl-3 w-full">
										<div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">Math course needs your review</div>
										<div class="text-xs text-gray-600">a few minutes ago</div>
									</div>
								</a>
							</div>
							<a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
								<div class="inline-flex items-center ">
									<svg class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
										<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
									</svg>
									View all
								</div>
							</a>
						</div>
					</div>
				</div>
				<!-- col 2: content -->
				<div class="w-full h-[85%] overflow-y-auto overflow-x-hidden scrollbar">
					<!-- steps -->
					<div class="bg-gray-100 mt-3 rounded-lg flex flex-col items-center mx-2 w-[98%] pb-5 mb-5 relative overflow-hidden">
						<div class="flex justify-between w-full text-sm font-medium py-2 bg-blue-50 shadow-sm border-b border-gray-300 relative">
							<div id="progress" class="w-1/5 h-full absolute bg-gradient-to-r from-cyan-500 to-blue-500 top-0 left-0 transition-all duration-1000"></div>
							<div class="relative text-white pl-5">Step 1<span class="text-xs font-normal sm:inline hidden">: Main info</span></div>
							<div class="relative transition-all duration-1000" id="step2">Step 2<span class="text-xs font-normal sm:inline hidden">: Course outlines</span></div>
							<div class="relative transition-all duration-1000" id="step3">Step 3<span class="text-xs font-normal sm:inline hidden">: Lesson contents</span></div>
							<div class="relative transition-all duration-1000 pr-5" id="step4">Step 4<span class="text-xs font-normal sm:inline hidden">: Finilizing</span></div>
						</div>
						<form method="POST" action="createCourse.php">
							<!-- step1 -->
							<div id="form1" class="flex flex-col xl:w-[900px] md:w-[700px] sm:w-[500px] w-[400px] gap-3 transition-all duration-500 mt-5">
								<div class="flex">
									<div class="flex flex-col mr-4 w-1/2">
										<label for="courseTitle" class="text-md font-semibold text-gray-800 mb-2">Course title</label>
										<input type="text" name="courseTitle" id="courseTitle" class="rounded-md border border-gray-300">
									</div>
									<div class="flex flex-col w-1/2">
										<label for="category" class="text-md font-semibold text-gray-800 mb-2">Category</label>
										<select id="category" name="category" class="rounded-md border border-gray-300 pl-2 h-full">
											<option selected value="0">Course category</option>
											<option value="programming">Programming</option>
											<option value="mathematics">Mathematics</option>
											<option value="marketing">Marketing</option>
											<option value="IT & Software">IT & Software</option>
											<option value="business">Business</option>
										</select>
									</div>
								</div>
								<div class="flex flex-col w-full">
									<label for="objectives" class="text-md font-semibold text-gray-800 mb-2">Course objectives</label>
									<textarea name="objectives" id="objectives" class="rounded-md border border-gray-300 p-3"></textarea>
								</div>
								<div class="flex flex-col w-full">
									<label for="requirement" class="text-md font-semibold text-gray-800 mb-2">Course requirement</label>
									<textarea name="requirement" id="requirement" class="rounded-md border border-gray-300 p-3"></textarea>
								</div>
								<div class="flex flex-col w-full">
									<label for="level" class="text-md font-semibold text-gray-800 mb-2">Level</label>
									<select id="level" name="level" class="rounded-md border border-gray-300 pl-2 h-full py-2">
										<option selected value="0">Course level</option>
										<option value="0">Beginner</option>
										<option value="1">Intermediate</option>
										<option value="2">Advanced</option>
									</select>
								</div>
								<!-- buttons -->
								<div class="flex justify-end">
									<button disabled type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300 disabled:pointer-events-none disabled:bg-gray-400" id="next1">
										<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
										<span>Next</span>
										<svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
										</svg>
									</button>
								</div>
							</div>

							<!-- form2: step2 -->
							<div id="form2" class="hidden flex flex-col xl:w-[900px] md:w-[700px] w-[400px] gap-3 transition-all duration-500 mt-5">
								<div class="flex flex-col w-full" id="chapterSection">
									<div class="flex lg:flex-row flex-col w-full">
										<div class="chapterN text-lg font-bold flex items-center justify-center bg-amber-300 text-gray-800 px-2 lg:rounded-l-md lg:rounded-tr-none rounded-t-md">1</div>
										<div class="bg-blue-100 p-5 lg:rounded-r-md lg:rounded-bl-none rounded-b-md w-full">
											<div class="flex lg:flex-row flex-col">
												<div class="flex flex-col mr-4 lg:w-1/2 w-full">
													<label class="text-md font-semibold text-gray-800 mb-2">Chapter title</label>
													<input type="text" name="chapterTitle[]" onkeyup="checkValue()" class="rounded-md border border-gray-300">
												</div>
												<div class="flex flex-col lg:w-1/2 w-full">
													<div id="lessonSection" class="flex flex-col">
														<label class="text-md font-semibold text-gray-800 mb-2">Lesson titles</label>
														<input type="text" name="lessonTitle[]" onkeyup="checkValue()" class="lessonTitle rounded-md border border-gray-300 w-full">
													</div>
													<div class="flex justify-end mt-1">
														<button type="button" onclick="addLesson(this)" class="hover:bg-blue-300 px-2 rounded-md text-xs font-medium flex items-center duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline" viewBox="0 0 20 20" fill="currentColor">
																<path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
															</svg><span>Add more lesson</span></button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="mt-1">
									<button onclick="addChapter()" type="button" id="moreChapter" class="hover:bg-gray-300 px-2 rounded-md text-xs font-medium flex items-center duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
										</svg><span>Add more chapter</span></button>
								</div>
								<!-- buttons -->
								<div class="flex justify-between mt-5">
									<button type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300" id="back1">
										<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
										<svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
										</svg>
										<span>Back</span>
									</button>
									<button disabled type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300 disabled:pointer-events-none disabled:bg-gray-400" id="next2">
										<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
										<span>Next</span>
										<svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
										</svg>
									</button>
								</div>
							</div>

							<!-- form3: step3 -->
							<div id="form3" class="hidden flex flex-col xl:w-[900px] md:w-[700px] w-[400px] gap-3 transition-all duration-500 mt-5">
								<div class="flex flex-col w-full">
									<div id="items" class="w-full flex flex-col">
									</div>
									<!-- buttons -->
									<div class="flex justify-between">
										<button type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300" id="back2">
											<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
											<svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
											</svg>
											<span>Back</span>
										</button>
										<button disabled type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300 disabled:pointer-events-none disabled:bg-gray-400" id="next3">
											<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
											<span>Next</span>
											<svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
											</svg>
										</button>
									</div>
								</div>
							</div>

							<!-- step4 -->
							<div id="form4" class="hidden flex flex-col xl:w-[900px] md:w-[700px] w-[400px] gap-3 transition-all duration-500 mt-5">
								<div class="flex flex-col w-full gap-2">
									<div class="flex flex-col w-full">
										<label for="description" class="text-md font-semibold text-gray-800 mb-2">Course description</label>
										<textarea name="description" id="description" class="rounded-md border border-gray-300 p-3"></textarea>
									</div>
									<div class="flex flex-col w-full">
										<label for="image" class="text-md font-semibold text-gray-800 mb-2">Course image</label>
										<input id="image" name="image" class="block mb-5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
									</div>
									<div class="flex flex-col w-full">
										<div class="flex gap-5">
											<label class="block text-md font-semibold text-gray-800 mb-2">Is there a collaborator?</label>
											<div>
												<input type="radio" name="radioBtns" value="yes" id="yes" class="h-4 w-4 border border-gray-400 bg-white checked:bg-blue-400 checked:border-blue-300  focus:outline-none focus:ring-blue-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-1 cursor-pointer"><label for="yes" class="capitalize"> yes</label>
											</div>
											<div>
												<input type="radio" name="radioBtns" value="no" id="no" class="h-4 w-4 border border-gray-400 bg-white checked:bg-blue-400 checked:border-blue-300  focus:outline-none focus:ring-blue-400 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-1 cursor-pointer"><label for="no" class="capitalize"> no</label>
											</div>
										</div>
										<div class="hidden w-full" id="collaborator">
											<div class="flex">
												<span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-l-md border border-r-0 border-gray-300">
													@
												</span>
												<input type="text" id="coUsername" name="coUsername" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 " placeholder="please enter the collaborator's username">
											</div>
										</div>
									</div>
									<!-- buttons -->
									<div class="flex justify-between mt-3">
										<button type="button" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300" id="back3">
											<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
											<svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
											</svg>
											<span>Back</span>
										</button>
										<button disabled name="done" type="submit" class="flex items-center relative rounded-full px-5 py-2.5 overflow-hidden group bg-blue-500 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 text-white transition-all ease-out duration-300 disabled:pointer-events-none disabled:bg-gray-400" id="done">
											<span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
											<span>Done</span>
											<svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 inline" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
											</svg>
										</button>
									</div>
								</div>
							</div>
						</form>
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
	<script src="js/createCourse.js"></script>
	<script src="js/analytics.js"></script>
	<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>