<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/cea-logo.jpg" type="image/x-icon">

	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="css/main.css">

	<title>Semicolon | Update Adviser</title>
</head>

<body class="bg-gray-100">
	<div class="container mx-auto">
		<div class="grid place-items-center min-h-screen">
			<?php
			include 'config.php';

			$id = $_GET['id'];
			$faculty = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM faculty WHERE id=$id"));

			if ($faculty) {
				echo '<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 px-5 pb-5 pt-1 rounded shadow-md">';
				echo '<button id="back-btn" class="py-2 font-bold text-[#124d5d] hover:text-[#ffc412] hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button"><i class="bx bx-arrow-back"></i> Back</button>';
				echo '<hr>';
				echo '<form method="POST" action="updateFaculty.php?id=' . $faculty['id'] . '" enctype="multipart/form-data" class="space-y-2 pt-2">';
				echo '<input type="hidden" name="id" value="' . $faculty['id'] . '">';
				echo '<h1 class="text-xl pb-3">Update Faculty: <span class="font-bold">' . $faculty['full_name'] . '</span></h1>';
				echo '<div class="flex items-center gap-1">';
				echo '<label for="full_name">Name:</label>';
				echo '<input type="text" name="full_name" id="full_name" value="' . $faculty['full_name'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
				echo '</div>';
				echo '<div class="flex items-center gap-1">';
				echo '<label>Program:</label>';
				echo '<select name="category" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
				echo '<option hidden>Select Program</option>';
				echo '<option value="College Dean">College Dean</option>';
				echo '<option value="BS Architecture">BS Architecture</option>';
				echo '<option value="BS Civil Engineering">BS Civil Engineering</option>';
				echo '<option value="BS Computer Engineering">BS Computer Engineering</option>';
				echo '<option value="BS Electrical Engineering">BS Electrical Engineering</option>';
				echo '<option value="BS Electronics Engineering">BS Electronics Engineering</option>';
				echo '<option value="BS Mechanical Engineering">BS Mechanical Engineering</option>';
				echo '<option value="General Education">BS Mechanical Engineering</option>';
				echo '</select>';
				echo '</div>';
				echo '<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">';
				echo '<label for="faculty_img" class="cursor-pointer font-bold">Choose or Drag & Drop Adviser\'s Picture Here</label>';
				echo '<input type="file" id="faculty_img" name="faculty_img" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
				echo '</div>';
				echo '<div class="text-center pt-2">';
				echo '<input type="submit" name="update" value="Update" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out">';
				echo '</div>';
				echo '</form>';
				echo '</div>';

				if (isset($_POST["update"])) {
					$id = $_GET["id"];
					$full_name = $_POST["full_name"];
					$category = $_POST["category"];
					$faculty_img = $_FILES["faculty_img"];

					$target_dir = "faculty/";
					$target_file = $target_dir . basename($faculty_img["name"]);
					$faculty_imgType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
					if (move_uploaded_file($faculty_img["tmp_name"], $target_file)) {
						$sql = "UPDATE faculty SET faculty_img=?, full_name=?, category=? WHERE id=?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param("sssi", $target_file, $full_name, $category, $id);
						if ($stmt->execute()) {
							echo "<script>alert('Faculty record updated successfully.');</script>";
							echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
							exit();
						} else {
							echo "<script>alert('Error updating faculty record: " . $stmt->error . "');</script>";
						}
					} else {
						echo "<script>alert('Error uploading faculty image.');</script>";
					}
				}
			} else {
				echo '<h3 class="text-2xl font-medium">Faculty not found</h3>';
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