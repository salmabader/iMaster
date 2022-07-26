<?php
// create a session and check if the current session for the admin
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
    <title>student_home</title>
</head>

<body class="overflow-x-hidden h-screen w-screen">
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
                            <a href="student_home_page.php" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg class="h-5 inline mr-4 optionIcons" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg><span class="toHide">Home</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="student_course_page.html" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-4 optionIcons" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg><span class="toHide">Courses</span></a>
                        </div>
                        <div class="hover:text-blue-800 duration-100 ease-in-out mb-5">
                            <a href="student_favoreite_page.html" class="hover:border-l-[3px] duration-100 ease-in-out hover:border-l-amber-500 flex items-center">
                                <svg class="h-5 inline mr-4 optionIcons" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg><span class="toHide">Favoreite</span></a>
                        </div>

                    </div>
                </div>
                <!-- sign out button -->
                <div class="mb-10">
                    <button id="signoutBtn" class="bg-blue-100 hover:bg-blue-200 duration-200 ease-in-out px-8 py-2 text-blue-800 rounded-xl"><span id="signOutTtitle" class="toHide">Sign
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
        <div id="rightSide" class="lg:w-4/5 lg:mx-0 mx-5 w-full h-full transition-all duration-500">
            <div class="flex ">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae nobis eos asperiores earum aliquid. Aspernatur consequuntur harum ex deserunt fuga magnam ab iusto, tempore ipsa, necessitatibus explicabo inventore quis veritatis!
            </div>
            <div>

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="images/avatar.png" alt="">
                    </a>
                    <div class="p-5 flex flex-col">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Title</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">description</p>
                        <div class="flex justify-between">
                            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">instructors</div>
                            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">categ</div>
                            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">level</div>
                        </div>
                        <div class=" border-t-2 border-dashed border-zinc-300 mb-3 mt-3 "></div>
                        <div class="flex justify-end ">
                            <a href="#" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </a>
                            <a href="#" class="inline-flex ml-3  items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- end of right side-->
    </main>
    <script src="js/analytics.js"></script>
</body>

</html>