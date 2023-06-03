<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/cea-logo.jpg" type="image/x-icon">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css">

    <title>Semicolon | Update Book</title>
</head>
<body class="bg-gray-100">
	<div class="container mx-auto">
		<div class="grid place-items-center min-h-screen">
			<?php
				include 'config.php';

				$id = $_GET['id'];
				$book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$id"));

				if ($book) {
					echo '<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 px-5 pb-5 pt-1 rounded shadow-md">';
						echo '<button id="back-btn" class="py-2 font-bold text-[#124d5d] hover:text-[#ffc412] hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button"><i class="bx bx-arrow-back"></i> Back</button>';
						echo '<hr>';
						echo '<form method="POST" action="updateBooks.php?id=' . $book['id'] . '" enctype="multipart/form-data" class="space-y-2 pt-2">';
							echo '<input type="hidden" name="id" value="' . $book['id'] . '">';
							echo '<h1 class="text-xl pb-3">Update Book: <span class="font-bold">' . $book['title'] . '</span></h1>';
							echo '<div class="flex items-center gap-1">';
								echo '<label for="title">Title:</label>';
								echo '<input type="text" name="title" id="title" value="' . $book['title'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
							echo '</div>';
							echo '<div class="space-y-1">';
								echo '<label for="description">Description:</label><br>';
								echo '<textarea name="description" id="description" required rows="4" class="p-1.5 light-background w-full outline-none border border-solid border-gray-300">' . $book['description'] . '</textarea>';
							echo '</div>';
							echo '<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">';
								echo '<label for="image" class="cursor-pointer font-bold">Choose or Drag & Drop Image File Here</label>';
								echo '<input type="file" id="image" name="image" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
							echo '</div>';
							echo '<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">';
								echo '<label for="bookFile" class="cursor-pointer font-bold">Choose or Drag & Drop PDF Files Here</label>';
								echo '<input type="file" id="bookFile" name="bookFile" accept=".pdf" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
							echo '</div>';
							echo '<div class="text-center pt-2">';
								echo '<input type="submit" name="update" value="Update" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out">';
							echo '</div>';
						echo '</form>';
					echo '</div>';

					if (isset($_POST["update"])) {
						$id = $_GET["id"];
						$title = $_POST["title"];
						$description = $_POST["description"];
						$target_dir_file = "books/";
						$target_dir_cover = "books/cover/";
						$target_file = $target_dir_cover . basename($_FILES["image"]["name"]);
						$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
						if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
							$sql = "UPDATE books SET title=?, description=?, image=? WHERE id=?";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("sssi", $title, $description, $target_file, $id);
							if ($stmt->execute()) {
								$target_file = $target_dir_file . basename($_FILES["bookFile"]["name"]);
								$bookFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
								if (move_uploaded_file($_FILES["bookFile"]["tmp_name"], $target_file)) {
									$sql = "UPDATE books SET bookFile=? WHERE id=?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("si", $target_file, $id);
									if ($stmt->execute()) {
										echo "<script>alert('Book record updated successfully.');</script>";
										echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
										exit();
									} else {
										echo "<script>alert('Error updating book record.');</script>: " . $stmt->error;
									}
								} else {
									echo "<script>alert('Error uploading book file.');</script>";
								}
							} else {
								echo "<script>alert('Error updating book record.');</script>: " . $stmt->error;
							}
						} else {
							echo "<script>alert('Error uploading image file.');</script>";
						}
					}
				} else {
					echo '<h3 class="text-2xl font-medium">Book not found</h3>';
				}
			?>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		const backButton = document.getElementById("back-btn");
		backButton.addEventListener("click", function() {
		window.history.back();
		});
	</script>
</body>
</html>