<?php
session_start();
require 'database/db_connection.php';
// if there is a session but user is not student
if (isset($_SESSION['type'])) {
	$privilage = $_SESSION['type'];
	if ($privilage != "student") {
		header('Location: index.php');
	}
} else { // if there is no session
	header('Location: index.php');
	exit();
}
$con = OpenCon();

if (isset($_POST['addBut'])) {

	$courseID = filter_input(INPUT_POST, 'courseID');
	$stu_username = $_SESSION['username'];
	$insertQuery = "INSERT INTO student_course (stu_username,coID) VALUES (?,?)";
	$statement = mysqli_stmt_init($con);
	if (!mysqli_stmt_prepare($statement, $insertQuery)) {
		header('Location: index.php?error=InsertionError');
		exit();
	} else {

		mysqli_stmt_bind_param($statement, "ss", $stu_username, $courseID);
		mysqli_stmt_execute($statement);
	}
}
if (isset($_POST['FavBut'])) {

	$courseID = filter_input(INPUT_POST, 'courseID');
	$stu_username = $_SESSION['username'];
	$query = "SELECT * FROM student_favorite WHERE stu_username = '" . $stu_username . "' AND  course_id='" . $courseID . "'";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) > 0) {
		$deleteQuery = "DELETE FROM student_favorite WHERE stu_username= '" .  $stu_username . "' AND course_id='" . $courseID . "'";
		$statement = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($statement, $deleteQuery)) {
			header('Location: index.php?error=InsertionError');
			exit();
		} else {

			mysqli_stmt_execute($statement);
		}
	} else {
		$insertQuery = "INSERT INTO student_favorite (stu_username,course_id) VALUES (?,?)";
		$statement = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($statement, $insertQuery)) {
			header('Location: index.php?error=InsertionError');
			exit();
		} else {
			mysqli_stmt_bind_param($statement, "ss", $stu_username, $courseID);
			mysqli_stmt_execute($statement);
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
	<title>Courses</title>
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
							<a href="analytics.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
								</svg><span class="toHide">Dashboard</span></a>
						</div>
						<div class="text-blue-800 duration-100 ease-in-out mb-5">
							<a href="studentCourse.php" class="pl-2 border-l-[3px] duration-100 ease-in-out border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
								</svg><span class="toHide">Courses</span></a>
						</div>
						<div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
							<a href="favorite.php" class="pl-2 hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
								</svg><span class="toHide">Favorite</span></a>
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
				<div class="w-full h-[85%] overflow-y-auto overflow-x-hidden scrollbar">
					<!-- recomended for you -->
					<div id="myCoursesSection" class="md:ml-5 mt-5">
						<p class="text-xl font-bold capitalize w-full tracking-wide text-gray-700 mb-3">Recommended for you</p>
						<section class=" items-center flex flex-nowrap overflow-x-auto snap-x snap-mandatory gap-5 px-1  h-[70%] w-[full]  scrollbar">
							<!-- get student's courses -->
							<?php
							$query = "SELECT * FROM course,student_interests,requests WHERE courseID NOT IN ( SELECT coID FROM student_course WHERE stu_username ='" . $_SESSION['username'] . "' ) AND category=interests AND student_username ='" . $_SESSION['username'] . "' AND courseID=course_id AND status='accepted';";

							$result = mysqli_query($con, $query);
							if (mysqli_num_rows($result) > 0) { ?>

								<?php while ($course = mysqli_fetch_assoc($result)) {
								?>
									<!-- card -->
									<div class="flex-none snap-always snap-center w-full md:w-1/5 bg-gray-50 rounded-md shadow-sm border border-gray-300 relative" role="button">
										<!-- Image -->
										<img class="h-40 object-cover rounded-t-md w-full " data-modal-toggle="#show<?php echo ucfirst($course['courseID']) ?>" src="upload/<?php echo $course['image'] ?>">
										<p class="absolute top-1 right-1
                                    <?php if ($course['level'] == 0) echo "bg-yellow-100 text-yellow-800";
									elseif ($course['level'] == 1) echo "bg-green-100 text-green-800";
									else echo "bg-red-100 text-red-800";
									?> 
                                    text-[10px] font-medium px-2.5 py-0.5 rounded">
											<?php if ($course['level'] == 0) echo "Beginners";
											elseif ($course['level'] == 1) echo "Intermediate";
											else echo "Advanced"; ?>
										</p>
										<div class="p-2">
											<!-- title -->
											<p class="text-[10px] font-semibold pt-0 text-blue-700"><?php echo ucfirst($course['category']) ?></p>
											<h2 class="font-bold text-lg mb-1 border-b border-gray-200 truncate"><?php echo ucfirst($course['title']) ?></h2>
											<!-- instructor -->
											<?php
											// $sql = "SELECT * FROM course, instructor WHERE instructor_usename = username;";
											$query = "SELECT * FROM instructor, course WHERE username = '" . $course['instructor_usename'] . "'";
											$result2 = mysqli_query($con, $query);
											$instructor = mysqli_fetch_assoc($result2);
											?>
											<p class="text-sm text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
													<path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />
												</svg><?php echo ucfirst($instructor['FName']) . " " . ucfirst($instructor['LName']) ?></p>
										</div>
										<div class="flex justify-end m-3">
											<form action="studentCourse.php" method="POST" class="flex justify-between items-center ">
												<input name="courseID" value="<?php echo $course['courseID'] ?>" class="hidden">
												<!-- row 1: FavButton -->
												<button id="FavBut1" name="FavBut" onclick="hideFAV1()" class="inline-flex items-center py-1 px-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
													<?php

													$query = "SELECT * FROM student_favorite WHERE stu_username = '" . $_SESSION['username'] . "' AND  course_id='" . $course['courseID'] . "'";
													$result3 = mysqli_query($con, $query);
													if (mysqli_num_rows($result3) <= 0) { ?>
														<svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
															<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
														</svg>
													<?php } else { ?><svg xmlns="http://www.w3.org/2000/svg" class="h-5 text-white" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
															<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
														</svg><?php }
																?>

												</button>
												<!-- row 2:AddButton -->
												<button id="addBut1" name="addBut" class="inline-flex ml-2  items-center py-1 px-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

													<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
														<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
													</svg>
												</button>
											</form>
										</div>

									</div>
									<!-- end of card -->
									<!-- card model -->

									<!-- Main modal -->
									<div id="#show<?php echo ucfirst($course['courseID']) ?>" aria-hidden="true" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
										<div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
											<!-- Modal content -->
											<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
												<!-- Modal header -->
												<div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
													<h3 class="text-xl font-semibold  text-blue-700 dark:text-white">
														<?php echo ucfirst($course['title']) ?>
													</h3>
													<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="#show<?php echo ucfirst($course['courseID']) ?>">
														<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
														</svg>
														<span class="sr-only">Close modal</span>
													</button>
												</div>
												<!-- Modal body -->
												<div class="p-6 space-y-6 flex flex-col">
													<div class="h-[20%] flex justify-between text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
														<div><?php echo ucfirst($instructor['FName']) . " " . ucfirst($instructor['LName']);
																if ($course['collaborator'] != NULL) echo ", " . $course['collaborator'] ?></div>
														<div><?php echo ucfirst($course['category']) ?></div>
														<div class=" <?php if ($course['level'] == 0) echo " text-yellow-800";
																		elseif ($course['level'] == 1) echo " text-green-800";
																		else echo " text-red-800";
																		?> 
                                                            "><?php if ($course['level'] == 0) echo "Beginners";
																elseif ($course['level'] == 1) echo "Intermediate";
																else echo "Advanced"; ?></div>
													</div>
													<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
														Description:
													</div>
													<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
														<?php echo ucfirst($course['description']) ?>
													</div>
													<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
														Objectives:
													</div>
													<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
														<?php echo ucfirst($course['objectives']) ?>
													</div>
													<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
														Requirements:
													</div>
													<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
														<?php echo ucfirst($course['requirements']) ?>
													</div>
												</div>

											</div>
										</div>
									</div>

									<!-- end of card model -->

							<?php }
							} ?>



						</section>
					</div>
					<!-- All Courses -->
					<div id="myCoursesSection" class="md:ml-5 mt-5 flex md:flex-wrap gap-3 md:flex-row flex-col">
						<p class="text-xl font-bold capitalize w-full tracking-wide text-gray-700 mb-3">All Courses</p>

						<!-- get student's courses -->
						<?php
						$query = "SELECT * FROM course,requests WHERE courseID NOT IN ( SELECT coID FROM student_course WHERE stu_username ='" . $_SESSION['username'] . "' ) AND courseID=course_id AND status=\"accepted\";";

						$result = mysqli_query($con, $query);
						if (mysqli_num_rows($result) > 0) { ?>

							<?php while ($course = mysqli_fetch_assoc($result)) {
							?>
								<!-- card -->
								<div class=" w-full md:w-1/5 bg-gray-50 rounded-md shadow-sm border border-gray-300 relative" role="button">
									<!-- Image -->
									<img class="h-40 object-cover rounded-t-md w-full" src="upload/<?php echo $course['image'] ?>" data-modal-toggle="#show<?php echo ucfirst($course['courseID']) ?>">
									<p class="absolute top-1 right-1
                                    <?php if ($course['level'] == 0) echo "bg-yellow-100 text-yellow-800";
									elseif ($course['level'] == 1) echo "bg-green-100 text-green-800";
									else echo "bg-red-100 text-red-800";
									?> 
                                    text-[10px] font-medium px-2.5 py-0.5 rounded">
										<?php if ($course['level'] == 0) echo "Beginners";
										elseif ($course['level'] == 1) echo "Intermediate";
										else echo "Advanced"; ?>
									</p>
									<div class="p-2">
										<!-- title -->
										<p class="text-[10px] font-semibold pt-0 text-blue-700"><?php echo ucfirst($course['category']) ?></p>
										<h2 class="font-bold text-lg mb-1 border-b border-gray-200 truncate"><?php echo ucfirst($course['title']) ?></h2>
										<!-- instructor -->
										<?php
										// $sql = "SELECT * FROM course, instructor WHERE instructor_usename = username;";
										$query = "SELECT * FROM instructor, course WHERE username = '" . $course['instructor_usename'] . "'";
										$result2 = mysqli_query($con, $query);
										$instructor = mysqli_fetch_assoc($result2);
										?>
										<p class="text-sm text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />
											</svg><?php echo ucfirst($instructor['FName']) . " " . ucfirst($instructor['LName']) ?></p>
									</div>
									<div class="flex justify-end m-3">
										<form action="studentCourse.php" method="POST" class="flex justify-between items-center ">
											<input name="courseID" value="<?php echo $course['courseID'] ?>" class="hidden">
											<!-- row 1: FavButton -->
											<button id="FavBut2" name="FavBut" onclick="hideFAV2()" class="inline-flex items-center py-1 px-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

												<?php

												$query3 = "SELECT * FROM student_favorite WHERE stu_username = '" . $_SESSION['username'] . "'";
												$result3 = mysqli_query($con, $query3);

												if (mysqli_num_rows($result3) <= 0) { ?>
													<svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
														<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
													</svg>
												<?php } else { ?><svg xmlns="http://www.w3.org/2000/svg" class="h-5 text-white" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
														<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
													</svg><?php }
															?>
											</button>
											<!-- row 2: AddButton -->
											<button id="addBut2" name="addBut" class="inline-flex ml-2  items-center py-1 px-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
													<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
												</svg>
											</button>
										</form>
									</div>

								</div>
								<!-- end of card -->
								<!-- card model -->

								<!-- Main modal -->
								<div id="#show<?php echo ucfirst($course['courseID']) ?>" aria-hidden="true" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
									<div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
										<!-- Modal content -->
										<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
											<!-- Modal header -->
											<div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
												<h3 class="text-xl font-semibold  text-blue-700 dark:text-white">
													<?php echo ucfirst($course['title']) ?>
												</h3>
												<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="#show<?php echo ucfirst($course['courseID']) ?>">
													<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
													</svg>
													<span class="sr-only">Close modal</span>
												</button>
											</div>
											<!-- Modal body -->
											<div class="p-6 space-y-6 flex flex-col">
												<div class="h-[20%] flex justify-between text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
													<div><?php echo ucfirst($instructor['FName']) . " " . ucfirst($instructor['LName']);
															if ($course['collaborator'] != NULL) echo ", " . $course['collaborator'] ?></div>
													<div><?php echo ucfirst($course['category']) ?></div>
													<div class=" <?php if ($course['level'] == 0) echo " text-yellow-800";
																	elseif ($course['level'] == 1) echo " text-green-800";
																	else echo " text-red-800";
																	?> 
                                                            "><?php if ($course['level'] == 0) echo "Beginners";
																elseif ($course['level'] == 1) echo "Intermediate";
																else echo "Advanced"; ?></div>
												</div>
												<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
													Description:
												</div>
												<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
													<?php echo ucfirst($course['description']) ?>
												</div>
												<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
													Objectives:
												</div>
												<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
													<?php echo ucfirst($course['objectives']) ?>
												</div>
												<div class="text-base font-bold leading-relaxed text-gray-500 dark:text-gray-400">
													Requirements:
												</div>
												<div class="text-base leading-relaxed  text-gray-500 dark:text-gray-400">
													<?php echo ucfirst($course['requirements']) ?>
												</div>
											</div>

										</div>
									</div>
								</div>

								<!-- end of card model -->

						<?php }
						} ?>

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
							<label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
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

	<script src="js/analytics.js"></script>
	<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>
