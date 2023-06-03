class Footer extends HTMLElement {
	constructor() {
		super();
	}

	connectedCallback() {
		this.innerHTML = `
            <footer class="bg-black">
                <div class="container mx-auto">
                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-y-6 text-white sm:py-5 p-1">
                        <div class="sm:col-span-1 space-y-3 p-2">
                            <h3 class="text-xl font-medium">Contact Us</h3>
                            <ul class="text-sm space-y-2">
                                <li><a class="flex flex-row gap-3 items-center max-w-max hover:text-[#ffc412]" target="_blank" href="https://www.google.com/maps/place/Northwest+Samar+State+University/@12.0710138,124.5974386,17.25z/data=!4m5!3m4!1s0x3309d9557a63c83b:0x192ccf3a4bccfbe6!8m2!3d12.0711409!4d124.5968099">
                                    <i class='bx bxs-map text-2xl'></i>
                                    <span>Rueda Street, 6710 <br>Calbayog City</span>
                                </a></li>
                                <li><a class="flex flex-row gap-3 items-center max-w-max hover:text-[#ffc412]" target="_blank" href="#">
                                    <i class='bx bxs-phone-call text-2xl'></i>
                                    <span>+1 555 123456</span>
                                </a></li>
                                <li><a class="flex flex-row gap-3 items-center max-w-max hover:text-[#ffc412]" target="_blank" href="#">
                                    <i class='bx bxs-envelope text-2xl'></i>
                                    <span>semicolon@gmail.com</span>
                                </a></li>
                            </ul>
                            <div class="flex flex-row gap-3">
                                <a href="#" class="border-2 w-9 h-9 grid place-content-center hover:text-[#ffc412] hover:border-[#ffc412]">
                                    <i class='bx bxl-facebook text-2xl' ></i>
                                </a>
                                <a href="#" class="border-2 w-9 h-9 grid place-content-center hover:text-[#ffc412] hover:border-[#ffc412]">
                                    <i class='bx bxl-twitter text-2xl' ></i>
                                </a>
                                <a href="#" class="border-2 w-9 h-9 grid place-content-center hover:text-[#ffc412] hover:border-[#ffc412]">
                                    <i class='bx bxl-instagram text-2xl' ></i>
                                </a>
                                <a href="#" class="border-2 w-9 h-9 grid place-content-center hover:text-[#ffc412] hover:border-[#ffc412]">
                                    <i class='bx bxl-google-plus text-2xl' ></i>
                                </a>
                            </div>
                        </div>
                        <div class="sm:col-span-1 space-y-3 p-2 lg:mr-9">
                            <h3 class="text-xl font-medium">About Us</h3>
                            <p class="text-sm">
                                The Computer Engineering interns which called as semi-colon is a software team tasked to create an online website for College of Engineering and Architecture teachers and student. The Online Database System is a user-friendly website created for College of Engineering and Architecture Students.
                            </p>
                            <p class="text-sm">
                                ©Copyright. All rights reserved.
                            </p>
                        </div>
                        <div class="sm:col-span-2 space-y-5 p-2 bg-[url('img/programmer.png')] bg-cover bg-no-repeat bg-center">
                            <div class="text-center w-48 mx-auto">
                                <a href="/"><img class="w-full" src="img/logo.png" height="auto" alt="Logo"></a>
                            </div>
                            <div class="grid grid-cols-2 sm:w-[80%] mx-auto">
                                <ul class="sm:col-span-1 p-2">
                                    <li>Alpez, Jim C.</li>
                                    <li>Bruza, Maria Jessa D.</li>
                                    <li>Basbas, Richelle L.</li>
                                    <li>Catalan, John Lester C.</li>
                                    <li>Dote, Erika Jean M.</li>
                                </ul>
                                <ul class="sm:col-span-1 p-2">
                                    <li>Glinogo, Ralph Lauren G.</li>
                                    <li>Limpiado, Ma. Jessadel T.</li>
                                    <li>Lucero, Rez Emmanuel T.</li>
                                    <li>Uy, Jennielyn D.</li>
                                    <li>Yaon, Jae A.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        `;
	}
}

customElements.define("footer-component", Footer);
