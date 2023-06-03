<?php
    include_once('config.php');

    $sql = 'SELECT * FROM books';
    $result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/cea-logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <title>Semicolon</title>
</head>

<body class="bg-gray-100">
    <header-component></header-component>

    <swiper-slider pagination="true" slides-per-view="1">
        <div class="swiper-slide"><img src="/img/books/cover1.png" alt="Cover 1"></div>
        <div class="swiper-slide"><img src="/img/books/cover2.png" alt="Cover 1"></div>
        <div class="swiper-slide"><img src="/img/books/cover3.png" alt="Cover 1"></div>
    </swiper-slider>

    <div class="container mx-auto">
        <div class="p-4">
            <div class="bg-gray-100 border border-solid border-gray-300 rounded shadow-lg p-7 space-y-4">
                <div class="flex items-center justify-between flex-col gap-2 sm:flex-row">
                    <h2 class="text-3xl font-bold italic uppercase p-1 text-[#ffc412] drop-shadow-md">Books</h2>
                    <form class="flex items-center shadow-md rounded-full overflow-hidden bg-white pl-3 border border-solid border-gray-300">
                        <label for="book_input" class="cursor-pointer h-full text-gray-500"><i class='bx bx-search'></i></label>
                        <input id="book_input" name="search" class="min-w-[300px] w-full outline-0 p-2" type="search" placeholder="Search books here...">
                    </form>
                </div>
                <hr>
                <?php
                $search_query = isset($_GET['search']) ? $_GET['search'] : '';
                $sql = "SELECT * FROM books WHERE title LIKE '%$search_query%' OR description LIKE '%$search_query%'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<div id="book_container" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">';
                    while ($row = $result->fetch_assoc()) {
                        $title = $row['title'];
                        $description = $row['description'];

                        if (!empty($search_query)) {
                            $title = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="bg-yellow-200">$1</span>', $title);
                            $description = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="bg-yellow-200">$1</span>', $description);
                        }

                        echo '<div title="' . $row['title'] . '" class="border border-solid border-gray-300 col-span-1 bg-white p-4 grid grid-cols-3 gap-2 rounded shadow-lg">';
                        echo '<div class="col-span-1"><img src=/' . $row['image'] . ' alt="' . $row['title'] . '"></div>';
                        echo '<div class="col-span-2 gap-3 flex flex-col justify-between px-2">';
                        echo '<div class="space-y-2">';
                        echo '<h3 class="text-lg font-bold line-clamp-2 leading-6">' . $title . '</h3>';
                        echo '<p class="text-sm text-gray-500 line-clamp-3 leading-5">' . $description . '</p>';
                        echo '</div>';
                        echo '<div class="flex items-center justify-between">';
                        echo '<a href="' . $row['bookFile'] . '" target="_blank" title="Read More" class="px-4 py-1 rounded-full bg-gray-100 hover:bg-[#ffc412] hover:text-white text-sm font-medium shadow-md transition duration-300 ease-in-out">Read More</a>';
                        echo '<a href="javascript:void(0);" title="Share" class="text-gray-500" onclick="copyLink(\'/' . $row['bookFile'] . '\')"><i class="bx bxs-share-alt"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<h3 class="text-2xl font-medium">No results found</h3>';
                }
                ?>
            </div>
        </div>
    </div>

    <footer-component></footer-component>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="components/header.js"></script>
    <script src="components/footer.js"></script>
    <script type="module" src="components/slider.js"></script>
    <script src="js/share-link.js"></script>
</body>

</html>