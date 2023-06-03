function setFormMessage(formElement, type, message) {
    const messageElement = formElement.querySelector(".form__message");

    messageElement.textContent = message;
    messageElement.classList.remove("text-green-500", "text-red-500");
    messageElement.classList.add(`text-${type}-500`)
}

function setInputError(inputElement, message) {
    inputElement.classList.add("text-red-500", "border-red-500");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
};

function clearInputError(inputElement) {
    inputElement.classList.remove("text-red-500", "border-red-500");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
};

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccount = document.querySelector("#createAccount");

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("hidden");
        createAccount.classList.remove("hidden");
        document.title = "Semicolon | Create Account";
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("hidden");
        createAccount.classList.add("hidden");
        document.title = "Semicolon | Login";
    });

    loginForm.addEventListener("submit", e => {
        e.preventDefault();

        setFormMessage(loginForm, "red", "Invalid username/password combination");
    });

    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("blur", e => {
            if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 10) {
                setInputError(inputElement, "Username must be at least 10 characters in length");
            }
        })

        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        })
    })
});