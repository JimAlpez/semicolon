document.addEventListener("DOMContentLoaded", () => {
  const dashboard = document.querySelector("#dashboard");
  const books = document.querySelector("#books");
  const yearbook = document.querySelector("#yearbook");
  const faculty = document.querySelector("#faculty");
  const program = document.querySelector("#program");
  const sidebar = document.querySelector("#sidebar");
  const menuBar = document.querySelector('.dashboard_navbar .bx.bx-menu');
  const siblingElements = document.querySelectorAll(".content_dashboard");
  const allSideMenu = document.querySelectorAll(".side_menu");
  const switchMode = document.querySelector("#switch-mode");


  allSideMenu.forEach((item) => {
    const li = item.parentElement;

    item.addEventListener("click", function () {
      allSideMenu.forEach((i) => {
        i.parentElement.classList.remove("active");
      });
      li.classList.add("active");
    });
  });

  document.querySelector("#linkProgram").addEventListener("click", (e) => {
    e.preventDefault();
    siblingElements.forEach((sibling) => {
      sibling.classList.add("hidden");
    });
    program.classList.remove("hidden");
    document.title = "Semicolon | Dashboard | Program";
  });
  document.querySelector("#linkDashboard").addEventListener("click", (e) => {
    e.preventDefault();
    siblingElements.forEach((sibling) => {
      sibling.classList.add("hidden");
    });
    dashboard.classList.remove("hidden");
    document.title = "Semicolon | Dashboard";
  });
  document.querySelector("#linkBooks").addEventListener("click", (e) => {
    e.preventDefault();
    siblingElements.forEach((sibling) => {
      sibling.classList.add("hidden");
    });
    books.classList.remove("hidden");
    document.title = "Semicolon | Dashboard | Books";
  });
  document.querySelector("#linkYearbook").addEventListener("click", (e) => {
    e.preventDefault();
    siblingElements.forEach((sibling) => {
      sibling.classList.add("hidden");
    });
    yearbook.classList.remove("hidden");
    document.title = "Semicolon | Dashboard | Yearbook";
  });
  document.querySelector("#linkFaculty").addEventListener("click", (e) => {
    e.preventDefault();
    siblingElements.forEach((sibling) => {
      sibling.classList.add("hidden");
    });
    faculty.classList.remove("hidden");
    document.title = "Semicolon | Dashboard | Faculty";
  });

  switchMode.addEventListener("change", function () {
    if (this.checked) {
      document.body.classList.add("dark");
    } else {
      document.body.classList.remove("dark");
    }
  });


  
  menuBar.addEventListener("click", function () {
    sidebar.classList.toggle("hide");
  });

  if(window.innerWidth < 768) {
    sidebar.classList.add('hide');
  }
});
