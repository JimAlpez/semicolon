<?php
include_once('config.php');

$sql = 'SELECT * FROM faculty';
$result = $conn->query($sql);

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

    <div class="px-1 py-5">
        <div class="container mx-auto space-y-6">
            <h1 class="text-4xl font-bold italic uppercase text-center p-1 text-[#ffc412] drop-shadow-md">Faculty and Staff</h1>
            <?php
            if ($result->num_rows > 0) {
                echo '<section class="space-y-3">';
                $categories = array();
                $imageRows = array();

                while ($row = $result->fetch_assoc()) {
                    $category = $row['category'];
                    $imageHTML = '<div class="col-span-1"><a href="/' . $row['faculty_img'] . '" target="_blank"><img src=/' . $row['faculty_img'] . ' alt="' . $row['full_name'] . '" width="300"></a></div>';

                    if (!isset($categories[$category])) {
                        $categories[$category] = true;
                        $imageRows[$category] = '';
                    }

                    $imageRows[$category] .= $imageHTML;
                }

                $combinedImageRow = '';
                foreach ($categories as $category => $value) {
                    $combinedImageRow .= '<h2 class="text-3xl font-bold italic uppercase pt-6 text-[#ffc412] drop-shadow-md">' . $category . '</h2>';
                    $combinedImageRow .= '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">' . $imageRows[$category] . '</div>';
                }

                echo $combinedImageRow;
                echo '</section>';
            } else {
                echo '<h3 class="text-2xl font-medium">No results found</h3>';
            }

            ?>
        </div>
    </div>

    <footer-component></footer-component>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="components/header.js"></script>
    <script src="components/footer.js"></script>
    <script type="module" src="components/slider.js"></script>
</body>
</html>