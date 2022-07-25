<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
	<link rel="icon" href="images/icon.svg" type="image/x-icon">
	<title>iMaster</title>
	<style>
		html {
			scroll-behavior: smooth;
		}

		.scrollbar::-webkit-scrollbar {
			width: 10px;
		}

		.scrollbar::-webkit-scrollbar-track {
			border-radius: 100vh;
			background: none;
		}

		.scrollbar::-webkit-scrollbar-thumb {
			background: #d97706;
			border-radius: 100vh;
			border: 3px solid #f6f7ed;
		}

		.scrollbar::-webkit-scrollbar-thumb:hover {
			background: #b45309;
		}
	</style>
</head>

<body class="flex flex-col items-center scrollbar overflow-x-hidden">
	<!-- header content -->
	<header class="w-full py-4 px-4 flex justify-center bg-amber-50 pb-24 border-b-2 border-amber-300 border-dashed">
		<div class="mx-4 max-w-6xl w-full">
			<!-- navbar -->
			<div id="navbar" class="flex justify-between items-center">
				<!-- logo -->
				<div>
					<a href="index.php">
						<img src="images/logo.svg" class="h-14">
					</a>
				</div>
				<div class="md:block flex justify-between hidden">
					<!-- home -->
					<a class="capitalize text-sm text-gray-800 hover:text-blue-800 px-4 py-2 hover:border-b-2 hover:border-b-blue-800 duration-200 ease-in-out h-full" href="index.php">home</a>
					<!-- about us -->
					<a class="capitalize text-sm text-gray-800 duration-200 ease-in-out hover:text-blue-800 px-4 py-2 hover:border-b-2 hover:border-b-blue-800" href="#aboutUs">about
						us</a>
					<!-- features -->
					<a class="capitalize text-sm text-gray-800 duration-200 ease-in-out hover:text-blue-800 px-4 py-2 hover:border-b-2 hover:border-b-blue-800" href="#features">features</a>
					<!-- contact us -->
					<a class="capitalize text-sm text-gray-800 duration-200 ease-in-out hover:text-blue-800 px-4 py-2 hover:border-b-2 hover:border-b-blue-800" href="#contactUs">contact
						us</a>
				</div>
				<!-- sign in -->
				<div class="hidden md:block">
					<button class="font-medium bg-amber-400 text-white px-6 py-1 rounded-xl shadow-md border-amber-500 border-2 hover:bg-amber-500 duration-300 ease-in-out" onclick="window.location.href='signin.php'">Sign
						In</button>
				</div>
				<div class="md:hidden">
					<svg class="text-gray-700 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
					</svg>
				</div>
			</div>
			<!-- text -->
			<div class="mt-20 sm:-mx-6">
				<h1 class="text-2xl font-bold text-gray-700 rounded-lg border-l-8 border-amber-400 px-2 bg-amber-100 w-max sm:mx-6" data-aos="fade-right" data-aos-easing="ease-in-out" data-aos-delay="200">
					Expand your
					knowledge
				</h1>
				<div class="relative flex">
					<p class="mt-3 w-full md:w-3/5 md:pr-8 lg:pr-0 text-justify text-gray-600 sm:mx-6 leading-relaxed" data-aos="fade-right" data-aos-easing="ease-in-out" data-aos-delay="400">
						Lorem
						ipsum dolor
						sit amet
						consectetur
						adipisicing
						elit.
						Architecto
						doloremque
						reiciendis
						tenetur
						eaque soluta a, esse, doloribus ex dolorum eos quos, ab quisquam similique harum quae laudantium
						pariatur? Ratione, animi.</p>
					<div class="absolute right-0 bottom-20 flex justify-start h-full" data-aos="fade-left" data-aos-delay="0" data-aos-easing="ease-in-out">
						<img src="images/main_img_p1.svg" class="hidden md:h-80 md:block lg:h-96 absolute">
						<img src="images/main_img_p2.svg" class="hidden md:h-80 md:block lg:h-96 animate-pulse">
					</div>
				</div>
				<div class="max-h-5" data-aos="fade-right" data-aos-easing="ease-in-out" data-aos-delay="800">
					<button class="capitalize sm:mx-6 bg-blue-800 border-b-4 md:hover:border-b-8 md:hover:-translate-y-1 md:hover:shadow-lg border-amber-200 px-6 py-2 rounded-xl text-gray-100 shadow-md mt-6  duration-100 ease-in" onclick="window.location.href ='createStudentAccount.php'">join
						us
						now!</button>
				</div>
			</div>
		</div>
	</header>
	<!-- main content -->
	<main class="bg-[#FCFCFC] pt-10 flex flex-col items-center w-full">
		<!-- about us -->
		<h2 id="aboutUs" class="text-center font-bold text-2xl capitalize text-gray-800 before:content-[''] before:w-10 before:h-[3px] before:inline-block before:bg-amber-400 before:rounded-full after:content-[''] after:w-10 after:h-[3px] after:inline-block after:bg-amber-400 after:ml-2 after:rounded-full" data-aos="fade-right" data-aos-easing="ease-in-out" data-aos-delay="1000">
			about
			us</h2>
		<div class="max-w-6xl pb-10">
			<p class="pt-5 leading-relaxed mx-4 sm:-mx-4" data-aos="fade-left" data-aos-easing="ease-in-out" data-aos-delay="1200">iMaster is a student registration system
				that provides you with
				different courses in different fields that you need, to improve your skills and expand your knowledge.
			</p>
		</div>
		<!-- features -->
		<h2 id="features" class="text-center font-bold text-2xl capitalize text-gray-800 before:content-[''] before:w-10 before:h-[3px] before:inline-block before:bg-amber-400 before:rounded-full after:content-[''] after:w-10 after:h-[3px] after:inline-block after:bg-amber-400 after:ml-2 after:rounded-full" data-aos="fade-right" data-aos-easing="ease-in-out" data-aos-delay="1700">
			features</h2>
		<!-- container of four cards -->
		<div class="max-w-6xl pb-10 pt-3">
			<div class="flex flex-col sm:flex-row sm:-mx-4">
				<!-- CARD 1 -->
				<div data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="50">
					<div class="mx-3 bg-amber-50 p-8 border-b-4 shadow-md border-amber-300 rounded-lg flex flex-col items-center mt-4 sm:p-3 md:p-8 md:hover:-translate-y-1 md:hover:scale-110 md:hover:shadow-lg md:hover:cursor-default duration-300">
						<div class="flex justify-center items-center mb-3">
							<div class="bg-amber-200 p-2 rounded-full w-16">
								<svg class="h-12 fill-amber-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
									<path d="M18.9 19.7l-6.9 2-6.9-2L3.7 3h16.7c-.5 5.6-1 11.1-1.5 16.7zM19.4 4H4.8l1.3 14.9 5.9 1.7 5.9-1.7L19.4 4zM8.1 13.8h2V15l2 .7 2-.7.1-2.2H9.9l-.1-2h4.5l.1-2H7.7l-.1-2h9l-.2 3.9-.4 5.8-3.9 1.3-3.9-1.3-.1-2.7z" fill-rule="evenodd" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="text-lg font-bold text-center ml-3 text-gray-800">Title</div>
						</div>
						<div class="text-gray-500 text-center mt-2 text-sm">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam enim eos a repudiandae iure
							consequatur asperiores magni voluptate voluptatum architecto iste perferendis eveniet dolore
							cupiditate, voluptates, vero maiores perspiciatis ipsam.
						</div>
					</div>
				</div>
				<!-- CARD 2 -->
				<div data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="500">
					<div class="mx-3 bg-amber-50 p-8 border-b-4 shadow-md border-amber-300 rounded-lg flex flex-col items-center mt-4 sm:p-3 md:p-8 md:hover:-translate-y-1 md:hover:scale-110 md:hover:shadow-lg md:hover:cursor-default duration-300">
						<div class="flex justify-center items-center mb-3">
							<div class="bg-amber-200 p-2 rounded-full w-16">
								<svg class="h-12 fill-amber-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
									<path d="M18.9 19.7l-6.9 2-6.9-2L3.7 3h16.7c-.5 5.6-1 11.1-1.5 16.7zM19.4 4H4.8l1.3 14.9 5.9 1.7 5.9-1.7L19.4 4zM8.1 13.8h2V15l2 .7 2-.7.1-2.2H9.9l-.1-2h4.5l.1-2H7.7l-.1-2h9l-.2 3.9-.4 5.8-3.9 1.3-3.9-1.3-.1-2.7z" fill-rule="evenodd" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="text-lg font-bold text-center ml-3 text-gray-800">Title</div>
						</div>
						<div class="text-gray-500 text-center mt-2 text-sm">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit debitis ipsum consequuntur eaque
							recusandae molestiae deserunt accusamus sed tenetur blanditiis, eveniet inventore sapiente
							distinctio delectus libero atque, doloremque quae! Repudiandae.
						</div>
					</div>
				</div>
				<!-- CARD 3 -->
				<div data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="1000">
					<div class="mx-3 bg-amber-50 p-8 border-b-4 shadow-md border-amber-300 rounded-lg flex flex-col items-center mt-4 sm:p-3 md:p-8 md:hover:-translate-y-1 md:hover:scale-110 md:hover:shadow-lg md:hover:cursor-default duration-300">
						<div class="flex justify-center items-center mb-3">
							<div class="bg-amber-200 p-2 rounded-full w-16">
								<svg class="h-12 fill-amber-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
									<path d="M18.9 19.7l-6.9 2-6.9-2L3.7 3h16.7c-.5 5.6-1 11.1-1.5 16.7zM19.4 4H4.8l1.3 14.9 5.9 1.7 5.9-1.7L19.4 4zM8.1 13.8h2V15l2 .7 2-.7.1-2.2H9.9l-.1-2h4.5l.1-2H7.7l-.1-2h9l-.2 3.9-.4 5.8-3.9 1.3-3.9-1.3-.1-2.7z" fill-rule="evenodd" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="text-lg font-bold text-center ml-3 text-gray-800">Title</div>
						</div>
						<div class="text-gray-500 text-center mt-2 text-sm">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit debitis ipsum consequuntur eaque
							recusandae molestiae deserunt accusamus sed tenetur blanditiis, eveniet inventore sapiente
							distinctio delectus libero atque, doloremque quae! Repudiandae.
						</div>
					</div>
				</div>
				<div data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="1500">
					<!-- CARD 4 -->
					<div class="mx-3 bg-amber-50 p-8 border-b-4 shadow-md border-amber-300 rounded-lg flex flex-col items-center mt-4 sm:p-3 md:p-8 md:hover:-translate-y-1 md:hover:scale-110 md:hover:shadow-lg md:hover:cursor-default duration-300">
						<div class="flex justify-center items-center mb-3">
							<div class="bg-amber-200 p-2 rounded-full w-16">
								<svg class="h-12 fill-amber-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
									<path d="M18.9 19.7l-6.9 2-6.9-2L3.7 3h16.7c-.5 5.6-1 11.1-1.5 16.7zM19.4 4H4.8l1.3 14.9 5.9 1.7 5.9-1.7L19.4 4zM8.1 13.8h2V15l2 .7 2-.7.1-2.2H9.9l-.1-2h4.5l.1-2H7.7l-.1-2h9l-.2 3.9-.4 5.8-3.9 1.3-3.9-1.3-.1-2.7z" fill-rule="evenodd" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="text-lg font-bold text-center ml-3 text-gray-800">Title</div>
						</div>
						<div class="text-gray-500 text-center mt-2 text-sm">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit debitis ipsum consequuntur eaque
							recusandae molestiae deserunt accusamus sed tenetur blanditiis, eveniet inventore sapiente
							distinctio delectus libero atque, doloremque quae! Repudiandae.
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-blue-900 w-full flex justify-center pt-10">
			<div class="max-w-6xl flex md:flex-row flex-col justify-between items-center text-white w-full mx-4">
				<div class="md:w-1/4" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="10">
					<p><span class="text-3xl font-medium">iMaster</span><br><span class="tracking-widest">Master your
							skills.</span>
					</p>
					<p class="rounded-md text-blue-100 mt-3 flex items-center">
						<svg class="h-5 inline mr-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
							<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
							<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
						</svg>
						iMaster@info.com
					</p>
					<p class="rounded-md text-blue-100 mt-1">
						<svg class="h-5 inline mr-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
							<path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
						</svg>
						(+966) 59000000
					</p>
				</div>
				<div class="md:w-3/4 w-full">
					<h2 id="contactUs" class="text-center font-bold text-2xl capitalize text-gray-100 before:content-[''] before:w-10 before:h-[3px] before:inline-block before:bg-amber-400 before:rounded-full after:content-[''] after:w-10 after:h-[3px] after:inline-block after:bg-amber-400 after:ml-2 after:rounded-full mb-6" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="100">
						contact
						us</h2>
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="flex flex-col items-center">
						<input type="text" id="fullName" placeholder="Your name" class="bg-blue-100 px-6 py-2 rounded-md border-2 border-white shadow-md mb-3 placeholder-blue-900 text-blue-900 w-3/4 focus:bg-white duration-200 ease-in-out hover:bg-blue-50" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="100">
						<input type="email" id="email" placeholder="Your email" class="bg-blue-100 px-6 py-2 rounded-md border-2 border-white shadow-md mb-3 placeholder-blue-900 text-blue-900 w-3/4 focus:bg-white duration-200 ease-in-out hover:bg-blue-50" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="200">
						<input type="text" id="subject" placeholder="Email subject" class="bg-blue-100 px-6 py-2 rounded-md border-2 border-white shadow-md mb-3 placeholder-blue-900 text-blue-900 w-3/4 focus:bg-white duration-200 ease-in-out hover:bg-blue-50" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="300">
						<textarea placeholder="Message" id="msg" class="bg-blue-100 px-6 py-2 rounded-md border-2 border-white shadow-md mb-3 placeholder-blue-900 text-blue-900 w-3/4 focus:bg-white duration-200 ease-in-out hover:bg-blue-50" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="400"></textarea>
						<button type="submit" name="sendMsgBtn" id="sendMsgBtn" class="bg-blue-300 px-6 py-3 w-3/4 rounded-2xl md:hover:bg-blue-400 duration-200 ease-in-out font-medium text-blue-900 hover:text-blue-50" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="500">Send
							message</button>
					</form>
				</div>
			</div>
		</div>
		<button id="goUp" class="opacity-0 fixed bottom-5 right-8 duration-200 ease-in"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 text-amber-600 bg-white rounded-full hover:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
			</svg></button>
	</main>
	<footer class="bg-blue-900 pt-20 pb-10 text-gray-100 w-full flex flex-col ">
		<p class="text-sm text-gray-300 text-center">Copyright © 2022 iMaster</p>
	</footer>
	<script>
		//Get the button:
		let myButton = document.getElementById("goUp");
		// When the user clicks on the button, scroll to the top of the document
		myButton.addEventListener("click", function() {
			document.body.scrollTop = 0; // For Safari
			document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
		})
		// When the user scrolls down 20px from the top of the document, show the button
		window.onscroll = function() {
			scrollFunction()
		};

		function scrollFunction() {
			if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
				myButton.style.opacity = "100";
			} else {
				myButton.style.opacity = "0";
			}
		}
	</script>
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
	<script>
		AOS.init({
			duration: 1000,
			once: true,
		})
	</script>
</body>

</html>