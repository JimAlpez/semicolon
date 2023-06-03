class Header extends HTMLElement {
	constructor() {
	  super();
	}
  
	connectedCallback() {
	  const currentPage = window.location.pathname;
  
	  if (currentPage === "/books.php") {
		document.title = "Semicolon | Books";
	  } else if (currentPage === "/faculty.php") {
		document.title = "Semicolon | Faculty";
	  } else if (currentPage === "/yearbook.php") {
		document.title = "Semicolon | Yearbook";
	  } else {
		document.title = "Semicolon";
	  }
  
	  const links = this.querySelectorAll("a");
	  links.forEach((link) => {
		if (link.href === window.location.href) {
		  link.classList.add("active");
		}
	  });
  
	  this.innerHTML = `
		<style>
		  a.active {
			color: #ffc412;
		  }
  
		  .sticky {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			z-index: 999;
			animation-duration: 0.5s;
			animation-name: slide-down;
		  }
		  .sticky a {
			font-size: 14px;
		  }
		  .sticky img {
			width: 40px;
		  }
  
		  @keyframes slide-down {
			0% {
			  transform: translateY(-100%);
			}
			100% {
			  transform: translateY(0%);
			}
		  }
		</style>
		<header class="text-white bg-black px-2 py-4">
		  <div class="container mx-auto">
			<div class="grid sm:grid-cols-3 space-y-4 sm:space-y-0">
			  <div class="col-span-1 flex items-center sm:justify-start justify-center space-x-3">
				<a href="/"><img src="img/cea-logo.jpg" width=60" alt="Logo"></a>
				<a href="/"><img src="img/icpep.png" width=60" alt="Logo"></a>
				<a href="/"><img src="img/ce-logo.png" width=60" alt="Logo"></a>
				<a href="/"><img src="img/ece-logo.png" width=60" alt="Logo"></a>
				<a href="/"><img src="img/ee-logo.png" width=60" alt="Logo"></a>
				<a href="/"><img src="img/me-logo.png" width=60" alt="Logo"></a>
			  </div>
			  <div class="col-span-1 place-self-center">
				<ul class="flex gap-2">
				  <li><a class="p-2 ${currentPage === "/books.php" ? "active" : ""}" href="books.php">Books</a></li>
				  <li><a class="p-2 ${currentPage === "/yearbook.php" ? "active" : ""}" href="yearbook.php">Yearbook</a></li>
				  <li><a class="p-2 ${currentPage === "/faculty.php" ? "active" : ""}" href="faculty.php">Faculty</a></li>
				</ul>
			  </div>
			  <div class="col-span-1 flex items-center sm:justify-end justify-center">
				<form method="post" class="h-full" id="logout-form">
					<button type="submit" name="logout" id="logout-btn" class="h-full flex gap-1 items-center text-red-600 overflow-x-hidden">
						<i class='bx bx-left-arrow-alt text-xl'></i>
						<span class="text-sm font-medium">Logout</span>
					</button>
				</form>
				<a id="login-link" class="p-2" href="login.html">Login &#129122;</a>
			</div>
			</div>
		  </div>
		</header>
	  `;
  
	  const header = this.querySelector("header");
	  const stickyClass = "sticky";
  
	  function toggleSticky() {
		if (window.pageYOffset > header.offsetTop) {
		  header.classList.add(stickyClass);
		} else {
		  header.classList.remove(stickyClass);
		}
	  }

	  window.addEventListener("scroll", toggleSticky);
	}
  }
  
  customElements.define("header-component", Header);
  