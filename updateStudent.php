<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/cea-logo.jpg" type="image/x-icon">

	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="css/main.css">

	<title>Semicolon | Update Student</title>
</head>

<body class="bg-gray-100">
	<div class="container mx-auto">
		<div class="grid place-items-center min-h-screen">
			<?php
			include 'config.php';

			$id = $_GET['id'];
			$students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id=$id"));

			if ($students) {
				echo '<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 px-5 pb-5 pt-1 rounded shadow-md">';
					echo '<button id="back-btn" class="py-2 font-bold text-[#124d5d] hover:text-[#ffc412] hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button"><i class="bx bx-arrow-back"></i> Back</button>';
					echo '<hr>';
					echo '<form method="POST" action="updateStudent.php?id=' . $students['id'] . '" enctype="multipart/form-data" class="space-y-2 pt-2">';
						echo '<input type="hidden" name="id" value="' . $students['id'] . '">';
						echo '<h1 class="text-xl pb-3">Update Student: <span class="font-bold">' . $students['full_name'] . '</span></h1>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="full_name" class="whitespace-nowrap">Name:</label>';
							echo '<input type="text" name="full_name" id="full_name" value="' . $students['full_name'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="student_id" class="whitespace-nowrap">Student ID:</label>';
							echo '<input type="text" name="student_id" id="student_id" value="' . $students['student_id'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="birthday" class="whitespace-nowrap">Birthday:</label>';
							echo '<input type="text" name="birthday" id="birthday" value="' . $students['birthday'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="address" class="whitespace-nowrap">Address:</label>';
							echo '<input type="text" name="address" id="address" value="' . $students['address'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="email" class="whitespace-nowrap">Email:</label>';
							echo '<input type="email" name="email" id="email" value="' . $students['email'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="awards_received" class="whitespace-nowrap">Award/s Received:</label>';
							echo '<input type="text" name="awards_received" id="awards_received" value="' . $students['awards_received'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="ambition" class="whitespace-nowrap">Ambition:</label>';
							echo '<input type="text" name="ambition" id="ambition" value="' . $students['ambition'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label for="motto" class="whitespace-nowrap">Motto:</label>';
							echo '<input type="text" name="motto" id="motto" value="' . $students['motto'] . '" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label>Program:</label>';
							echo '<select name="program" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
								echo '<option hidden>Select Program</option>';
								echo '<option value="BS Architecture">BS Architecture</option>';
								echo '<option value="BS Civil Engineering">BS Civil Engineering</option>';
								echo '<option value="BS Computer Engineering">BS Computer Engineering</option>';
								echo '<option value="BS Electrical Engineering">BS Electrical Engineering</option>';
								echo '<option value="BS Electronics Engineering">BS Electronics Engineering</option>';
								echo '<option value="BS Mechanical Engineering">BS Mechanical Engineering</option>';
							echo '</select>';
						echo '</div>';
						echo '<div class="flex items-center gap-1">';
							echo '<label class="whitespace-nowrap">Class Year:</label>';
							echo '<select name="year" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">';
								echo '<option hidden>Select Class Year</option>';
								echo '<option value="2023">2023</option>';
								echo '<option value="2022">2022</option>';
								echo '<option value="2021">2021</option>';
								echo '<option value="2020">2020</option>';
								echo '<option value="2019">2019</option>';
								echo '<option value="2018">2018</option>';
							echo '</select>';
						echo '</div>';
						echo '<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">';
							echo '<label for="student_img" class="cursor-pointer font-bold">Choose or Drag & Drop Student\'s Picture Here</label>';
							echo '<input type="file" id="student_img" name="student_img" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
						echo '</div>';
						echo '<div class="text-center pt-2">';
							echo '<input type="submit" name="update" value="Update" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out">';
						echo '</div>';
					echo '</form>';
				echo '</div>';

				if (isset($_POST["update"])) {
					$id = $_GET["id"];
					$full_name = $_POST["full_name"];
					$student_id = $_POST["student_id"];
					$birthday = $_POST["birthday"];
					$address = $_POST["address"];
					$email = $_POST["email"];
					$awards_received = $_POST["awards_received"];
					$ambition = $_POST["ambition"];
					$motto = $_POST["motto"];
					$program = $_POST["program"];
					$year = $_POST["year"];
					$student_img = $_FILES["student_img"];

					$target_dir_img = "students/";
					$target_file_img = $target_dir_img . basename($student_img["name"]);
					$imageFileType_img = strtolower(pathinfo($target_file_img, PATHINFO_EXTENSION));

					if (move_uploaded_file($student_img["tmp_name"], $target_file_img)) {
						$sql = "UPDATE students SET full_name=?, student_id=?, birthday=?, address=?, email=?, awards_received=?, ambition=?, motto=?, program=?, year=?, student_img=? WHERE id=?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param("sssssssssssi", $full_name, $student_id, $birthday, $address, $email, $awards_received, $ambition, $motto, $program, $year, $target_file_img, $id);
						if ($stmt->execute()) {
							echo "<script>alert('Student record updated successfully.');</script>";
							echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
							exit();
						} else {
							echo "<script>alert('Error updating student record.');</script>: " . $stmt->error;
						}
					} else {
						echo "<script>alert('Error uploading student image file.');</script>";
					}
				}
			} else {
				echo '<h3 class="text-2xl font-medium">Student not found</h3>';
			}
			?>"

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