const popupTemplate = `
    <div class="popup-content bg-slate-100 border-4 border-solid border-[#ffc412] p-1 max-w-[90%] max-h-[90%]">
        <button id="close-button" class="close-button text-4xl absolute top-0 right-0 hover:text-[#ffc412] transition duration-300 ease-in-out"><i class='bx bx-x'></i></button>
        <div class="grid sm:grid-cols-2">
            <div id="popup-image-container" class="col-span-1 grid place-items-center text-center mx-auto w-1/2 sm:w-full"></div>
            <ul class="col-span-1 space-y-1 font-medium bg-white px-6 py-3">
                <li id="popup-name" class="text-[#124d5d] text-xl font-bold text-center"></li>
                <hr>
                <div class="pt-1"></div>
                <li>Student ID: <span id="popup-studentID" class="text-[#124d5d] font-bold"></span></li>
                <li>Birthday: <span id="popup-birthday" class="text-[#124d5d] font-bold"></span></li>
                <li>Address: <span id="popup-address" class="text-[#124d5d] font-bold"></span></li>
                <li>Award/s Received: <span id="popup-award" class="text-[#124d5d] font-bold"></span></li>
                <li>Email: <span id="popup-email" class="text-[#124d5d] font-bold"></span></li>
                <li>Ambition: <span id="popup-ambition" class="text-[#124d5d] font-bold"></span></li>
                <li class="italic text-[#124d5d] font-bold text-center py-3">"<span id="popup-motto"></span>"</li>
                <li id="popup-program" class="hidden"></li>
                <li id="popup-year" class="hidden"></li>
            </ul>
        </div>
    </div>
`;

const popupContainer = document.createElement('div');
popupContainer.innerHTML = popupTemplate;
popupContainer.classList.add("popup-container");
document.body.appendChild(popupContainer);

const popupContent = popupContainer.querySelector('.popup-content');
const popupName = popupContainer.querySelector('#popup-name');
const popupStudentID = popupContainer.querySelector('#popup-studentID');
const popupBirthday = popupContainer.querySelector('#popup-birthday');
const popupAddress = popupContainer.querySelector('#popup-address');
const popupEmail = popupContainer.querySelector('#popup-email');
const popupAward = popupContainer.querySelector('#popup-award');
const popupAmbition = popupContainer.querySelector('#popup-ambition');
const popupMotto = popupContainer.querySelector('#popup-motto');
const popupProgram = popupContainer.querySelector('#popup-program');
const popupYear = popupContainer.querySelector('#popup-year');
const popupImageContainer = popupContainer.querySelector('#popup-image-container');
const closeButton = popupContainer.querySelector('#close-button');

const triggers = document.querySelectorAll('.popup-trigger');

triggers.forEach((trigger) => {
    if (trigger.querySelector('.font-medium') && trigger.querySelector('img')) {
        trigger.addEventListener('click', () => {
            if (!trigger.classList.contains('disable-popup')) {
                if (popupName) popupName.textContent = trigger.querySelector('.font-medium')?.textContent;
                if (popupBirthday) popupBirthday.textContent = trigger.getAttribute('data-birthday');
                if (popupStudentID) popupStudentID.textContent = trigger.getAttribute('data-studentID');
                if (popupAddress) popupAddress.textContent = trigger.getAttribute('data-address');
                if (popupEmail) popupEmail.textContent = trigger.getAttribute('data-email');
                if (popupAward) popupAward.textContent = trigger.getAttribute('data-award');
                if (popupAmbition) popupAmbition.textContent = trigger.getAttribute('data-ambition');
                if (popupMotto) popupMotto.textContent = trigger.getAttribute('data-motto');
                if (popupProgram) popupProgram.textContent = trigger.getAttribute('data-program');
                if (popupYear) popupYear.textContent = trigger.getAttribute('data-year');
                const imageSrc = trigger.querySelector('img')?.getAttribute('src');
                if (popupImageContainer) popupImageContainer.innerHTML = `<img src="${imageSrc}" alt="Popup Image">`;
                if (popupContainer) {
                    popupContainer.classList.add('show');
                    popupContent.classList.add('show');
                }
            }
        });
    }
});


if (closeButton) {
    closeButton.addEventListener('click', () => {
        if (popupContainer) {
            popupContainer.classList.remove('show');
            popupContent.classList.remove('show');
        }
    });
}

window.addEventListener('click', (event) => {
    if (popupContainer && event.target === popupContainer) {
        popupContainer.classList.remove('show');
        popupContent.classList.remove('show');
    }
});



// ----------------------------------------------------------------
const yearSelect = document.getElementById('year-select');
const popupYearSelect = document.getElementById('popup-year');
const programSelect = document.getElementById('program-select');
const popupProgramSelect = document.getElementById('popup-program');
const popupTriggers = document.querySelectorAll('.popup-trigger');

function showSelectedTriggers(selectedYear, selectedProgram) {
    popupTriggers.forEach((trigger) => {
        const triggerYear = trigger.dataset.year;
        const triggerProgram = trigger.dataset.program;
        if (triggerYear === selectedYear && triggerProgram === selectedProgram) {
            trigger.classList.remove('hidden');
        } else {
            trigger.classList.add('hidden');
        }
    });
}

const initialYear = '2023';
const initialProgram = 'BS Computer Engineering';
yearSelect.value = initialYear;
programSelect.value = initialProgram;
popupYearSelect.textContent = initialYear;
popupProgramSelect.textContent = initialProgram;
showSelectedTriggers(initialYear, initialProgram);

yearSelect.addEventListener('change', () => {
    const selectedYear = yearSelect.value;
    popupYearSelect.textContent = selectedYear;
    const selectedProgram = programSelect.value;
    showSelectedTriggers(selectedYear, selectedProgram);
});

programSelect.addEventListener('change', () => {
    const selectedProgram = programSelect.value;
    popupProgramSelect.textContent = selectedProgram;
    const selectedYear = yearSelect.value;
    showSelectedTriggers(selectedYear, selectedProgram);
});
