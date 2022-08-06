<?php
require 'database/db_connection.php';
$con = OpenCon();
$query = "SELECT * FROM requests,instructor WHERE status = 'waiting' AND instructor_username = username ORDER BY requestID DESC";
$result = mysqli_query($con, $query);
$firstIteration = false;
if (mysqli_num_rows($result) > 0) {
    $firstIteration = true;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['type'] == 'application') { ?>
            <a href="#" class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
                <div class="flex-shrink-0 text-blue-600 bg-blue-200 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="pl-3 w-full flex justify-between">
                    <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><?php echo ucfirst($row['FName']) . ' ' . ucfirst($row['LName']) ?> sent an application</div>
                    <?php if ($firstIteration) { ?>
                        <span new-indecator class=" bg-pink-400 text-white text-xs font-semibold px-2 py-1 rounded-md flex items-center">New</span>
                    <?php } ?>
                </div>
            </a>
        <?php } elseif ($row['type'] == 'course') {
            $courseQuery = "SELECT title FROM course WHERE courseID = '" . $row['course_id'] . "'";
            $result2 = mysqli_query($con, $courseQuery);
            $course = mysqli_fetch_assoc($result2);
        ?>
            <a class="flex items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">
                <div class="flex-shrink-0 text-amber-600 bg-amber-200 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="pl-3 w-full flex justify-between">
                    <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">"<?php echo ucfirst($course['title']) ?>" course needs your review</div>
                    <?php if ($firstIteration) { ?>
                        <span new-indecator class=" bg-pink-400 text-white text-xs font-semibold px-2 py-1 rounded-md flex items-center">New</span>
                    <?php } ?>
                </div>
            </a>
<?php }
        $firstIteration = false;
    }
}
