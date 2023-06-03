<?php
include_once 'config.php';

$sql_advisers = 'SELECT * FROM advisers';
$result_advisers = $conn->query($sql_advisers);

$sql_students = 'SELECT * FROM students';
$result_students = $conn->query($sql_students);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/cea-logo.jpg" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css">

    <title>Semicolon</title>
</head>
<body class="bg-gray-100">
    <header-component></header-component>

    <div class="container mx-auto p-2">
        <div class="space-y-3 sm:space-y-6 text-center px-3 py-4 sm:py-8">
            <select id="program-select" name="program" class="cursor-pointer drop-shadow-md outline-none text-[#124d5d] text-lg sm:text-2xl md:text-3xl text-center font-bold px-2 max-w-fit w-full appearance-none bg-transparent">
                <option value="BS Architecture" class="text-lg">BS Architecture</option>
                <option value="BS Civil Engineering" class="text-lg">BS Civil Engineering</option>
                <option selected value="BS Computer Engineering" class="text-lg">BS Computer Engineering</option>
                <option value="BS Electrical Engineering" class="text-lg">BS Electrical Engineering</option>
                <option value="BS Electronics Engineering" class="text-lg">BS Electronics Engineering</option>
                <option value="BS Mechanical Engineering" class="text-lg">BS Mechanical Engineering</option>
            </select>
            <br>
            <select id="year-select" name="year" class="cursor-pointer uppercase drop-shadow-md outline-none text-[#ffc412] text-2xl sm:text-4xl md:text-6xl text-center font-bold px-2 max-w-fit w-full appearance-none bg-transparent">
                <option value="2023" selected class="text-lg">Class of 2023</option>
                <option value="2022" class="text-lg">Class of 2022</option>
                <option value="2021" class="text-lg">Class of 2021</option>
                <option value="2020" class="text-lg">Class of 2020</option>
                <option value="2019" class="text-lg">Class of 2019</option>
            </select>
        </div>
        <div class="space-y-6">
            <div class="space-y-2">
                <h2 class="text-lg sm:text-3xl font-bold italic uppercase p-1 text-[#ffc412] drop-shadow-md">Class Adviser</h2>
                <?php if ($result_advisers->num_rows > 0) {
                    echo '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">'; ?>
                    <?php while ($row = $result_advisers->fetch_assoc()) {
                        echo '<div class="popup-trigger disable-popup col-span-1 shadow-lg bg-white shadow-[0_0_0_1px_#000]" data-program="' . $row['program'] . '" data-year="' . $row['year'] . '">';
                            echo '<img class="border-8 border border-solid border-[#124d5d]" src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] .'">';
                            echo '<h3 class="text-center px-3 pb-2 bg-[#124d5d] text-white font-medium">' . $row['full_name'] . '</h3>';
                        echo '</div>';
                    }
                    echo '</div>';
                    } else {
                    echo '<h3 class="text-2xl font-medium">No results found</h3>';
                } ?>
            </div>
            <div class="space-y-2">
                <h2 class="text-3xl font-bold italic uppercase p-1 text-[#ffc412] drop-shadow-md">Students</h2>
                <?php if ($result_students->num_rows > 0) {
                    echo '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">'; ?>
                    <?php while ($row = $result_students->fetch_assoc()) {
                        echo '<div class="popup-trigger cursor-pointer col-span-1 shadow-lg bg-white shadow-[0_0_0_1px_#000]" data-studentID="' . $row['student_id'] . '" data-birthday="' . $row['birthday'] . '" data-address="' . $row['address'] . '" data-email="' . $row['email'] . '" data-award="' . $row['awards_received'] . '" data-ambition="' . $row['ambition'] . '" data-motto="' . $row['motto'] . '" data-program="' . $row['program'] . '" data-year="' . $row['year'] . '">';
                            echo '<img class="border-8 border border-solid border-[#124d5d]" src="' . $row['student_img'] . '" alt="' . $row['full_name'] .'">';
                            echo '<h3 class="text-center px-3 pb-2 bg-[#124d5d] text-white font-medium">' . $row['full_name'] . '</h3>';
                        echo '</div>';
                    }
                    echo '</div>';
                    } else {
                    echo '<h3 class="text-2xl font-medium">No results found</h3>';
                } ?>
            </div>
        </div>
    </div>
    
    <footer-component></footer-component>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="components/header.js"></script>
    <script src="components/footer.js"></script>
    <script src="js/popup.js"></script>
    <script>
        
    </script>

</body>
</html>