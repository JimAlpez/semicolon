<?php
include_once 'config.php';

// Books View All // ------------------------------------------------------------------------------
$sql = 'SELECT * FROM books ORDER BY id DESC';
$result = $conn->query($sql);
// Books Recent Added // --------------------------------------------------------------------------
$sql_books_recent = 'SELECT * FROM books ORDER BY id DESC LIMIT 3';
$result_books_recent = $conn->query($sql_books_recent);
// Books Count // ---------------------------------------------------------------------------------
$sql_books_count = "SELECT COUNT(*) AS row_count FROM books";
$result_books_count = $conn->query($sql_books_count);
// ------------------------------------------------------------------------------------------------
// Advisers View All // ---------------------------------------------------------------------------
$sql_advisers = "SELECT * FROM advisers";
$result_advisers = $conn->query($sql_advisers);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_ar = "SELECT * FROM advisers WHERE program = 'BS Architecture'";
$result_advisers_ar = $conn->query($sql_advisers_ar);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_ce = "SELECT * FROM advisers WHERE program = 'BS Civil Engineering'";
$result_advisers_ce = $conn->query($sql_advisers_ce);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_cpe = "SELECT * FROM advisers WHERE program = 'BS Computer Engineering'";
$result_advisers_cpe = $conn->query($sql_advisers_cpe);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_ee = "SELECT * FROM advisers WHERE program = 'BS Electrical Engineering'";
$result_advisers_ee = $conn->query($sql_advisers_ee);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_ece = "SELECT * FROM advisers WHERE program = 'BS Electronics Engineering'";
$result_advisers_ece = $conn->query($sql_advisers_ece);
// Advisers Architecture // -----------------------------------------------------------------------
$sql_advisers_me = "SELECT * FROM advisers WHERE program = 'BS Mechanical Engineering'";
$result_advisers_me = $conn->query($sql_advisers_me);
// ------------------------------------------------------------------------------------------------
// Students View All // ---------------------------------------------------------------------------
$sql_students = "SELECT * FROM students";
$result_students = $conn->query($sql_students);
// Students Recent Added // ------------------------------------------------------------------------------
$sql_students_recent = 'SELECT * FROM students ORDER BY id DESC LIMIT 3';
$result_students_recent = $conn->query($sql_students_recent);
// Students Count // ------------------------------------------------------------------------------
$sql_students_count = "SELECT COUNT(*) AS row_count FROM students";
$result_students_count = $conn->query($sql_students_count);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_ar = "SELECT * FROM students WHERE program = 'BS Architecture'";
$result_students_ar = $conn->query($sql_students_ar);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_ce = "SELECT * FROM students WHERE program = 'BS Civil Engineering'";
$result_students_ce = $conn->query($sql_students_ce);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_cpe = "SELECT * FROM students WHERE program = 'BS Computer Engineering'";
$result_students_cpe = $conn->query($sql_students_cpe);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_ee = "SELECT * FROM students WHERE program = 'BS Electrical Engineering'";
$result_students_ee = $conn->query($sql_students_ee);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_ece = "SELECT * FROM students WHERE program = 'BS Electronics Engineering'";
$result_students_ece = $conn->query($sql_students_ece);
// Students Architecture // -----------------------------------------------------------------------
$sql_students_me = "SELECT * FROM students WHERE program = 'BS Mechanical Engineering'";
$result_students_me = $conn->query($sql_students_me);
// ------------------------------------------------------------------------------------------------
// Faculty View All // ----------------------------------------------------------------------------
$sql_faculty = 'SELECT * FROM faculty';
$result_faculty = $conn->query($sql_faculty);
// Faculty Count // -------------------------------------------------------------------------------
$sql_faculty_count = "SELECT COUNT(*) AS row_count FROM faculty";
$result_faculty_count = $conn->query($sql_faculty_count);
// ------------------------------------------------------------------------------------------------
// Books Upload // --------------------------------------------------------------------------------
if (isset($_POST["books_upload"])) {
	$title = $_POST["title"];
	$description = $_POST["description"];

	$check_sql = "SELECT id FROM books WHERE title=?";
	$check_stmt = $conn->prepare($check_sql);
	$check_stmt->bind_param("s", $title);
	$check_stmt->execute();
	$check_result = $check_stmt->get_result();

	if ($check_result->num_rows > 0) {
		echo "<script>alert('A book with the same title already exists. Please choose a different title.');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
		exit();
	}

	$target_dir_file = "file/books/";
	$target_dir_cover = "img/books/";
	$target_file = $target_dir_cover . basename($_FILES["image"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		$sql = "INSERT INTO books (title, description, image) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $title, $description, $target_file);

		if ($stmt->execute()) {
			$book_id = $stmt->insert_id;
			$target_file = $target_dir_file . basename($_FILES["bookFile"]["name"]);
			$bookFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			if (move_uploaded_file($_FILES["bookFile"]["tmp_name"], $target_file)) {
				$sql = "UPDATE books SET bookFile=? WHERE id=?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("si", $target_file, $book_id);

				if ($stmt->execute()) {
					echo "<script>alert('File uploaded successfully.');</script>";
					echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
					exit();
				} else {
					echo "<script>alert('Error updating book record: " . $stmt->error . "');</script>";
					echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
					exit();
				}
			} else {
				echo "<script>alert('Error uploading book file.');</script>";
				echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
				exit();
			}
		} else {
			echo "<script>alert('Error inserting book record: " . $stmt->error . "');</script>";
			echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
			exit();
		}
	} else {
		echo "<script>alert('Error uploading image file.');</script>";
		echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
		exit();
	}
}

// ------------------------------------------------------------------------------------------------
// Students Upload // -----------------------------------------------------------------------------
if (isset($_POST["students_upload"])) {
	$student_id = $_POST["student_id"];
	$full_name = $_POST["full_name"];
	$birthday = $_POST["birthday"];
	$address = $_POST["address"];
	$email = $_POST["email"];
	$awards_received = $_POST["awards_received"];
	$ambition = $_POST["ambition"];
	$motto = $_POST["motto"];
	$program = $_POST["program"];
	$year = $_POST["year"];
	$student_img = $_FILES["student_img"];

	// Check if student with the same student ID already exists
	$check_sql = "SELECT id FROM students WHERE student_id=?";
	$check_stmt = $conn->prepare($check_sql);
	$check_stmt->bind_param("s", $student_id);
	$check_stmt->execute();
	$check_result = $check_stmt->get_result();

	if ($check_result->num_rows > 0) {
		echo "<script>alert('A student with the same ID already exists. Please choose a different student ID.');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
		exit();
	}

	$target_dir = "img/students/";
	$target_file = $target_dir . basename($student_img["name"]);
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	if (move_uploaded_file($student_img["tmp_name"], $target_file)) {
		$sql = "INSERT INTO students (student_id, student_img, full_name, birthday, address, email, awards_received, ambition, motto, program, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssssssss", $student_id, $target_file, $full_name, $birthday, $address, $email, $awards_received, $ambition, $motto, $program, $year);
		if ($stmt->execute()) {
			echo "<script>alert('Student uploaded successfully.');</script>";
			echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
			exit();
		} else {
			echo "<script>alert('Error inserting student record');</script>: " . $stmt->error;
			echo "<meta http-equiv='refresh' content='0'>";
			exit();
		}
	} else {
		echo "<script>alert('Error uploading student image.');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
		exit();
	}
}
// ------------------------------------------------------------------------------------------------
// Advisers Upload // -----------------------------------------------------------------------------
if (isset($_POST["advisers_upload"])) {
	$full_name = $_POST["full_name"];
	$program = $_POST["program"];
	$year = $_POST["year"];
	$adviser_img = $_FILES["adviser_img"];

	$target_dir = "img/advisers/";
	$target_file = $target_dir . basename($adviser_img["name"]);
	$adviser_imgType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	if (move_uploaded_file($adviser_img["tmp_name"], $target_file)) {
		$sql = "INSERT INTO advisers (adviser_img, full_name, program, year) VALUES (?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssi", $target_file, $full_name, $program, $year);
		if ($stmt->execute()) {
			echo "<script>alert('Adviser uploaded successfully.');</script>";
			echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
			exit();
		} else {
			echo "<script>alert('Error inserting adviser record: " . $stmt->error . "');</script>";
			echo "<meta http-equiv='refresh' content='0'>";
			exit();
		}
	} else {
		echo "<script>alert('Error uploading adviser image.');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
		exit();
	}
}
// ------------------------------------------------------------------------------------------------
// Faculty Upload // ------------------------------------------------------------------------------
if (isset($_POST["faculty_upload"])) {
	$full_name = $_POST["full_name"];
	$category = $_POST["category"];
	$faculty_img = $_FILES["faculty_img"];

	$target_dir = "img/faculty/";
	$target_file = $target_dir . basename($faculty_img["name"]);
	$faculty_imgType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if (move_uploaded_file($faculty_img["tmp_name"], $target_file)) {
		$sql = "INSERT INTO faculty (faculty_img, full_name, category) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $target_file, $full_name, $category);

		if ($stmt->execute()) {
			echo "<script>alert('Faculty uploaded successfully.');</script>";
			echo "<meta http-equiv='refresh' content='0; url=dashboard.php'>";
			exit();
		} else {
			echo "<script>alert('Error inserting faculty record: " . $stmt->error . "');</script>";
			echo "<meta http-equiv='refresh' content='0'>";
			exit();
		}
	} else {
		echo "<script>alert('Error uploading faculty image.');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
		exit();
	}
}
// ------------------------------------------------------------------------------------------------
$conn->close();
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

	<title>Semicolon | Dashboard</title>
	<script>
		if (!isLoggedIn()) {
			window.location.href = "login.html";
		}

		function isLoggedIn() {
			return sessionStorage.getItem("isLoggedIn") === "true";
		}

		document.addEventListener("DOMContentLoaded", function() {
			var logoutForm = document.getElementById("logout-form");
			if (logoutForm) {
				logoutForm.addEventListener("submit", function(event) {
					event.preventDefault();
					logout();
				});
			}
		});

		function logout() {
			sessionStorage.removeItem("isLoggedIn");
			window.location.href = "login.html";
		}
	</script>
</head>

<body class="overflow-x-hidden">
	<section id="sidebar" class="sidebar z-20 w-[200px] md:w-[280px] h-full fixed top-0 left-0 overflow-x-hidden">
		<div class="py-5 px-8">
			<a href="/" target="_blank">
				<img src="img/logo1.png" class="w-full" alt="Logo">
			</a>
		</div>
		<ul class="w-full mt-12">
			<li class="active">
				<a href="/dashboard.php" id="linkDashboard" class="side_menu w-full h-full flex items-center rounded-[48px] overflow-x-hidden">
					<i class='bx bxs-dashboard min-w-[40px] grid place-items-center'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="/dashboard.php" id="linkBooks" class="side_menu w-full h-full flex items-center rounded-[48px] overflow-x-hidden">
					<i class='bx bxs-book min-w-[40px] grid place-items-center'></i>
					<span class="text">Books</span>
				</a>
			</li>
			<li>
				<a href="/dashboard.php" id="linkYearbook" class="side_menu w-full h-full flex items-center rounded-[48px] overflow-x-hidden">
					<i class='bx bxs-graduation min-w-[40px] grid place-items-center'></i>
					<span class="text">Yearbook</span>
				</a>
			</li>
			<li>
				<a href="/dashboard.php" id="linkFaculty" class="side_menu w-full h-full flex items-center rounded-[48px] overflow-x-hidden">
					<i class='bx bxs-user-account min-w-[40px] grid place-items-center'></i>
					<span class="text">Faculty</span>
				</a>
			</li>
		</ul>
	</section>

	<div class="content relative z-10 left-[200px] md:left-[280px]">
		<nav class="dashboard_navbar h-14 px-6 flex items-center gap-6 sticky top-0 left-0 z-10">
			<i id="menuBar" class='bx bx-menu cursor-pointer'></i>
			<a href="/dashboard.php" id="linkProgram" class="side_menu hover:text-blue-500">Program</a>
			<div class="w-full"></div>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode cursor-pointer relative block h-[25px] min-w-[50px] rounded-[25px]"></label>
			<form method="post" class="h-full" id="logout-form">
				<button type="submit" name="logout" id="logout-btn" class="h-full flex gap-1 items-center text-red-600 overflow-x-hidden">
					<i class='bx bx-left-arrow-alt text-xl'></i>
					<span class="text-sm font-medium">Logout</span>
				</button>
			</form>
		</nav>
		<section id="dashboard" class="content_dashboard space-y-3">
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
				<div class="col-span-1 light-background shadow-lg rounded-2xl p-5 flex items-center gap-6">
					<div class="bg-blue-100 text-blue-500 shadow-md text-3xl rounded-lg h-20 w-20 grid place-content-center">
						<i class="bx bxs-book drop-shadow-md"></i>
					</div>
					<div class="flex flex-col justify-center h-full">
						<h2 class="font-bold text-3xl drop-shadow">
							<?php if ($result_books_count) {
								$row = $result_books_count->fetch_assoc();
								$count = $row['row_count'];
								echo $count;
							} else {
								echo "Error executing the query: " . $conn->error;
							} ?>
						</h2>
						<h4 class="font-medium text-lg drop-shadow">Books</h4>
					</div>
				</div>
				<div class="col-span-1 light-background shadow-lg rounded-2xl p-5 flex items-center gap-6">
					<div class="bg-yellow-100 text-yellow-500 shadow-md text-3xl rounded-lg h-20 w-20 grid place-content-center">
						<i class='bx bxs-user drop-shadow-md'></i>
					</div>
					<div class="flex flex-col justify-center h-full">
						<h2 class="font-bold text-3xl drop-shadow">
							<?php if ($result_students_count) {
								$row = $result_students_count->fetch_assoc();
								$count = $row['row_count'];
								echo $count;
							} else {
								echo "Error executing the query: " . $conn->error;
							} ?>
						</h2>
						<h4 class="font-medium text-lg drop-shadow">Students</h4>
					</div>
				</div>
				<div class="col-span-1 light-background shadow-lg rounded-2xl p-5 flex items-center gap-6">
					<div class="bg-red-100 text-red-500 shadow-md text-3xl rounded-lg h-20 w-20 grid place-content-center">
						<i class='bx bxs-user-account drop-shadow-md'></i>
					</div>
					<div class="flex flex-col justify-center h-full">
						<h2 class="font-bold text-3xl drop-shadow">
							<?php if ($result_faculty_count) {
								$row = $result_faculty_count->fetch_assoc();
								$count = $row['row_count'];
								echo $count;
							} else {
								echo "Error executing the query: " . $conn->error;
							} ?>
						</h2>
						<h4 class="font-medium text-lg drop-shadow">Faculty</h4>
					</div>
				</div>
			</div>
			<div class="grid lg:grid-cols-2 gap-3">
				<div class="lg:col-span-1 space-y-2 light-background shadow-lg rounded-2xl p-5">
					<h2 class="text-2xl font-medium drop-shadow">Recent Books</h2>
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Cover</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Title</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Description</th>
							</tr>
						</thead>
						<?php
						if ($result_books_recent && $result_books_recent->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							while ($row = $result_books_recent->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['image'] . '" alt="' . $row['title'] . '" width="80"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-3">' . $row['title'] . '</span></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-3">' . $row['description'] . '</span></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						}
						?>
					</table>
				</div>
				<div class="lg:col-span-1 space-y-2 light-background shadow-lg rounded-2xl p-5">
					<h2 class="text-2xl font-medium drop-shadow">Recent Students</h2>
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Program</th>
							</tr>
						</thead>
						<?php
						if ($result_students_recent && $result_students_recent->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							while ($row = $result_students_recent->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-2">' . $row['full_name'] . '</span></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-2">' . $row['program'] . '</span></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						}
						?>
					</table>
				</div>
			</div>
		</section>
		<section id="books" class="content_dashboard hidden">
			<div class="light-background space-y-4 shadow-lg rounded-2xl px-4 pb-4 pt-3">
				<div class="flex items-center justify-between">
					<ul class="flex gap-3 items-center">
						<li data-scroll-id="AllBooks" class="button-toggle-slide active button-nav cursor-pointer text-sm sm:text-base font-medium p-2">Books</li>
					</ul>
					<button data-scroll-id="UploadBooks" class="button-toggle-slide rounded-full px-4 py-1.5 bg-[#ffc412d5] text-sm sm:text-base hover:bg-[#ffc412] text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button">Add Book</button>
				</div>
				<div id="AllBooks">
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Cover</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Title</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Description</th>
							</tr>
						</thead>
						<?php
						if ($result && $result->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							while ($row = $result->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['image'] . '" alt="' . $row['title'] . '" width="80"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-3">' . $row['title'] . '</span></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium"><span class="line-clamp-3">' . $row['description'] . '</span></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><a href="/updateBooks.php?id=' . $row['id'] . '" title="Update" class="light-background px-2 sm:px-4 py-1 rounded-full hover:bg-[#ffc412] hover:text-white text-xs sm:text-sm font-medium shadow-md transition duration-300 ease-in-out">Update</a></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						}
						?>
					</table>
				</div>
				<div id="UploadBooks" style="display: none;">
					<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 p-5 rounded shadow-md">
						<form method="POST" enctype="multipart/form-data" class="space-y-2">
							<div class="flex items-center gap-1">
								<label for="title">Title:</label>
								<input type="text" name="title" id="title" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="space-y-1">
								<label for="description">Description:</label><br>
								<textarea name="description" id="description" required rows="4" class="p-1.5 light-background w-full outline-none border border-solid border-gray-300"></textarea>
							</div>
							<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">
								<label for="image" class="cursor-pointer font-bold">Choose or Drag & Drop Image File Here</label>
								<input type="file" id="image" name="image" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							</div>
							<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">
								<label for="bookFile" class="cursor-pointer font-bold">Choose or Drag & Drop PDF Files Here</label>
								<input type="file" id="bookFile" name="bookFile" accept=".pdf" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							</div>
							<div class="text-center pt-2">
								<input type="submit" name="books_upload" value="Upload" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] transition duration-300 ease-in-out">
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<section id="yearbook" class="content_dashboard hidden">
			<div class="light-background space-y-4 shadow-lg rounded-2xl px-4 pb-4 pt-3">
				<div class="flex flex-col-reverse sm:flex-row items-center justify-between">
					<ul class="flex gap-3 items-center">
						<li data-scroll-id="AllAdvisers" class="button-toggle-slide active button-nav cursor-pointer text-sm sm:text-base font-medium p-2">Advisers</li>
						<li data-scroll-id="AllStudents" class="button-toggle-slide button-nav cursor-pointer text-sm sm:text-base font-medium p-2">Students</li>
					</ul>
					<div class="flex items-center gap-2">
						<button data-scroll-id="UploadAdviser" class="button-toggle-slide rounded-full px-4 py-1.5 bg-[#ffc412d5] text-sm sm:text-base hover:bg-[#ffc412] text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button">Add Adviser</button>
						<button data-scroll-id="UploadStudents" class="button-toggle-slide rounded-full px-4 py-1.5 bg-[#ffc412d5] text-sm sm:text-base hover:bg-[#ffc412] text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button">Add Student</button>
					</div>
				</div>
				<div id="AllAdvisers">
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Program</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
							</tr>
						</thead>
						<?php if ($result_advisers && $result_advisers->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							while ($row = $result_advisers->fetch_assoc()) {
								// Display the results of the second query
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="60"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['program'] . '</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><a href="/updateAdviser.php?id=' . $row['id'] . '" title="Update" class="light-background px-2 sm:px-4 py-1 rounded-full hover:bg-[#ffc412] hover:text-white text-xs sm:text-sm font-medium shadow-md transition duration-300 ease-in-out">Update</a></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						} ?>
					</table>
				</div>
				<div id="AllStudents" style="display: none;">
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Details</th>
							</tr>
						</thead>
						<?php if ($result_students->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">'; ?>
						<?php while ($row = $result_students->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="100"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-sm whitespace-no-wrap font-medium">
											Name: <span class="font-bold text-[#124d5d]">' . $row['full_name'] . '</span> <br>
											Student ID: <span class="font-bold text-[#124d5d]">' . $row['student_id'] . '</span> <br>
											Birthday: <span class="font-bold text-[#124d5d]">' . $row['birthday'] . '</span> <br>
											Address: <span class="font-bold text-[#124d5d]">' . $row['address'] . '</span> <br>
											Email: <span class="font-bold text-[#124d5d]">' . $row['email'] . '</span> <br>
											Award/s Received: <span class="font-bold text-[#124d5d]">' . $row['awards_received'] . '</span> <br>
											Ambition: <span class="font-bold text-[#124d5d]">' . $row['ambition'] . '</span> <br>
											Motto: <span class="font-bold text-[#124d5d]">' . $row['motto'] . '</span> <br>
											Program: <span class="font-bold text-[#124d5d]">' . $row['program'] . '</span> <br>
											Year: <span class="font-bold text-[#124d5d]">' . $row['year'] . '</span>
										</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><a href="/updateStudent.php?id=' . $row['id'] . '" title="Update" class="light-background px-2 sm:px-4 py-1 rounded-full hover:bg-[#ffc412] hover:text-white text-xs sm:text-sm font-medium shadow-md transition duration-300 ease-in-out">Update</a></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						} ?>
					</table>
				</div>
				<div id="UploadAdviser" style="display: none;">
					<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 p-5 rounded shadow-md">
						<form method="POST" enctype="multipart/form-data" class="space-y-2">
							<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">
								<label for="adviser_img" class="cursor-pointer font-bold">Choose or Drag & Drop Adviser's Picture Here</label>
								<input type="file" id="adviser_img" name="adviser_img" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							</div>
							<div class="flex items-center gap-1">
								<label for="adviser_name" class="whitespace-nowrap">Full Name:</label>
								<input type="text" name="full_name" id="adviser_name" required placeholder="e.g: Juan D. Cruz" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label>Program:</label>
								<select name="program" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
									<option hidden>Select Program</option>
									<option value="BS Architecture">BS Architecture</option>
									<option value="BS Civil Engineering">BS Civil Engineering</option>
									<option value="BS Computer Engineering">BS Computer Engineering</option>
									<option value="BS Electrical Engineering">BS Electrical Engineering</option>
									<option value="BS Electronics Engineering">BS Electronics Engineering</option>
									<option value="BS Mechanical Engineering">BS Mechanical Engineering</option>
								</select>
							</div>
							<div class="flex items-center gap-1">
								<label class="whitespace-nowrap">Class Year:</label>
								<select name="year" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
									<option hidden>Select Class Year</option>
									<option value="2023">2023</option>
									<option value="2022">2022</option>
									<option value="2021">2021</option>
									<option value="2020">2020</option>
									<option value="2019">2019</option>
									<option value="2018">2018</option>
								</select>
							</div>
							<div class="text-center pt-2">
								<input type="submit" name="advisers_upload" value="Upload" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] transition duration-300 ease-in-out">
							</div>
						</form>
					</div>
				</div>
				<div id="UploadStudents" style="display: none;">
					<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 p-5 rounded shadow-md">
						<form method="POST" enctype="multipart/form-data" class="space-y-2">
							<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">
								<label for="student_img" class="cursor-pointer font-bold">Choose or Drag & Drop Student's Picture Here</label>
								<input type="file" id="student_img" name="student_img" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							</div>
							<div class="flex items-center gap-1">
								<label for="student_name" class="whitespace-nowrap">Full Name:</label>
								<input type="text" name="full_name" id="student_name" required placeholder="e.g: Juan D. Cruz" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="student_id" class="whitespace-nowrap">Student ID:</label>
								<input type="text" name="student_id" id="student_id" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="birthday">Birthday:</label>
								<input type="text" name="birthday" id="birthday" required placeholder="e.g: January 1, 2001" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="address">Address:</label>
								<input type="text" name="address" id="address" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="email">Email:</label>
								<input type="email" name="email" id="email" required placeholder="e.g: example@gmail.com" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="awards_received" class="whitespace-nowrap">Award/s Received:</label>
								<input type="text" name="awards_received" id="awards_received" required placeholder="e.g: Cum Laude" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="ambition">Ambition:</label>
								<input type="text" name="ambition" id="ambition" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label for="motto">Motto:</label>
								<input type="text" name="motto" id="motto" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label>Program:</label>
								<select name="program" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
									<option hidden>Select Program</option>
									<option value="BS Architecture">BS Architecture</option>
									<option value="BS Civil Engineering">BS Civil Engineering</option>
									<option value="BS Computer Engineering">BS Computer Engineering</option>
									<option value="BS Electrical Engineering">BS Electrical Engineering</option>
									<option value="BS Electronics Engineering">BS Electronics Engineering</option>
									<option value="BS Mechanical Engineering">BS Mechanical Engineering</option>
								</select>
							</div>
							<div class="flex items-center gap-1">
								<label class="whitespace-nowrap">Class Year:</label>
								<select name="year" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
									<option hidden>Select Class Year</option>
									<option value="2023">2023</option>
									<option value="2022">2022</option>
									<option value="2021">2021</option>
									<option value="2020">2020</option>
									<option value="2019">2019</option>
									<option value="2018">2018</option>
								</select>
							</div>
							<div class="text-center pt-2">
								<input type="submit" name="students_upload" value="Upload" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] transition duration-300 ease-in-out">
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<section id="faculty" class="content_dashboard hidden">
			<div class="light-background space-y-4 shadow-lg rounded-2xl px-4 pb-4 pt-3">
				<div class="flex items-center justify-between">
					<ul class="flex gap-3 items-center">
						<li data-scroll-id="AllFaculty" class="button-toggle-slide active button-nav cursor-pointer text-sm sm:text-base font-medium p-2">Faculty</li>
					</ul>
					<button data-scroll-id="UploadFaculty" class="button-toggle-slide rounded-full px-4 py-1.5 bg-[#ffc412d5] text-sm sm:text-base hover:bg-[#ffc412] text-white font-medium shadow-md hover:shadow-lg hover:scale-[1.1] focus:scale-[1] transition duration-300 ease-in-out" type="button">Add Faculty</button>
				</div>
				<div id="AllFaculty">
					<table class="min-w-full border border-collapse border-slate-300">
						<thead>
							<tr>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
								<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Program</th>
							</tr>
						</thead>
						<?php if ($result_faculty->num_rows > 0) {
							echo '<tbody class="dark-background divide-y divide-gray-300">'; ?>
						<?php while ($row = $result_faculty->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['faculty_img'] . '" alt="' . $row['full_name'] . '" width="60"></td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['category'] . '</td>';
								echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><a href="/updateFaculty.php?id=' . $row['id'] . '" title="Update" class="light-background px-2 sm:px-4 py-1 rounded-full hover:bg-[#ffc412] hover:text-white text-xs sm:text-sm font-medium shadow-md transition duration-300 ease-in-out">Update</a></td>';
								echo '</tr>';
							}
							echo '</tbody>';
						} else {
							echo '<tbody class="dark-background divide-y divide-gray-300">';
							echo '<tr>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
							echo '</tr>';
							echo '</tbody>';
						} ?>
					</table>
				</div>
				<div id="UploadFaculty" style="display: none;">
					<div class="dark-background max-w-screen-sm font-medium border border-solid border-gray-300 p-5 rounded shadow-md">
						<form method="POST" enctype="multipart/form-data" class="space-y-2">
							<div class="flex items-center gap-1">
								<label for="faculty_name" class="whitespace-nowrap">Full Name:</label>
								<input type="text" name="full_name" id="faculty_name" required placeholder="e.g: Juan D. Cruz" class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
							</div>
							<div class="flex items-center gap-1">
								<label>Program:</label>
								<select name="category" required class="w-full px-1.5 py-1 outline-none border border-solid border-gray-300 light-background">
									<option hidden>Select Program</option>
									<option value="College Dean">College Dean</option>
									<option value="BS Architecture">BS Architecture</option>
									<option value="BS Civil Engineering">BS Civil Engineering</option>
									<option value="BS Computer Engineering">BS Computer Engineering</option>
									<option value="BS Electrical Engineering">BS Electrical Engineering</option>
									<option value="BS Mechanical Engineering">BS Mechanical Engineering</option>
									<option value="BS Electronics Engineering">BS Electronics Engineering</option>
									<option value="General Education">BS Mechanical Engineering</option>
								</select>
							</div>
							<div class="space-y-2 p-4 border border-solid border-gray-300 light-background">
								<label for="faculty_img" class="cursor-pointer font-bold">Choose or Drag & Drop Faculty's Picture Here</label>
								<input type="file" id="faculty_img" name="faculty_img" accept="image/*" required class="cursor-pointer appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							</div>
							<div class="text-center pt-2">
								<input type="submit" name="faculty_upload" value="Upload" class="uppercase text-sm font font-medium text-white bg-[#ffc412d5] hover:bg-[#ffc412] p-2 w-32 cursor-pointer rounded-full shadow-md hover:shadow-lg hover:scale-[1.1] transition duration-300 ease-in-out">
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<section id="program" class="content_dashboard hidden">
			<div class="light-background space-y-4 shadow-lg rounded-2xl px-4 pb-4 pt-3 overflow-hidden">
				<ul class="flex gap-3 items-center">
					<li data-scroll-id="All_Ar" class="button-toggle-slide active button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">Ar</span> <span class="hidden sm:block">Architecture</span></li>
					<li data-scroll-id="All_CE" class="button-toggle-slide button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">CE</span> <span class="hidden sm:block">Civil</span></li>
					<li data-scroll-id="All_CpE" class="button-toggle-slide button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">CpE</span> <span class="hidden sm:block">Computer</span></li>
					<li data-scroll-id="All_EE" class="button-toggle-slide button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">EE</span> <span class="hidden sm:block">Electrical</span></li>
					<li data-scroll-id="All_ECE" class="button-toggle-slide button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">ECE</span> <span class="hidden sm:block">Electronics</span></li>
					<li data-scroll-id="All_ME" class="button-toggle-slide button-nav cursor-pointer text-sm font-medium p-2"><span class="sm:hidden">ME</span> <span class="hidden sm:block">Mechanical</span></li>
				</ul>
				<div id="All_Ar" class="space-y-6">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_ar && $result_advisers_ar->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_ar->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_ar && $result_students_ar->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_ar->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<div id="All_CE" class="space-y-6" style="display: none;">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_ce && $result_advisers_ce->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_ce->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_ce && $result_students_ce->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_ce->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<div id="All_CpE" class="space-y-6" style="display: none;">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_cpe && $result_advisers_cpe->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_cpe->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_cpe && $result_students_cpe->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_cpe->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<div id="All_EE" class="space-y-6" style="display: none;">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_ee && $result_advisers_ee->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_ee->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_ee && $result_students_ee->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_ee->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<div id="All_ECE" class="space-y-6" style="display: none;">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_ece && $result_advisers_ece->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_ece->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_ece && $result_students_ece->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_ece->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<div id="All_ME" class="space-y-6" style="display: none;">
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Advisers</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_advisers_me && $result_advisers_me->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_advisers_me->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['adviser_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
					<div class="grid sm:grid-cols-4">
						<div class="sm:col-span-3 space-y-2">
							<h2 class="text-sm sm:text-base font-bold">Students</h2>
							<table class="min-w-full border border-collapse border-slate-300">
								<thead>
									<tr>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Picture</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Name</th>
										<th class="border border-slate-300 p-2 sm:px-4 sm:py-3 light-background text-left text-xs sm:text-sm leading-4 font-bold uppercase tracking-wider">Year</th>
									</tr>
								</thead>
								<?php
								if ($result_students_me && $result_students_me->num_rows > 0) {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									while ($row = $result_students_me->fetch_assoc()) {
										echo '<tr>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap"><img src="' . $row['student_img'] . '" alt="' . $row['full_name'] . '" width="80"></td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['full_name'] . '</td>';
										echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 text-xs sm:text-base whitespace-no-wrap font-medium">' . $row['year'] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								} else {
									echo '<tbody class="dark-background divide-y divide-gray-300">';
									echo '<tr>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium">No results found</td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '<td class="border border-slate-300 p-2 sm:px-4 sm:py-2 whitespace-no-wrap font-medium"></td>';
									echo '</tr>';
									echo '</tbody>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/dashboard.js"></script>
	<script src="js/button.js"></script>
	


</body>

</html>