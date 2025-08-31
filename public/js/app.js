document.addEventListener("DOMContentLoaded", () => {
    // hamburger menu
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");

    hamburger.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });

    // loginForm
    const loginForm = document.getElementById("login-form");
    const username = document.getElementById("username");
    const passwordInLoginForm = document.getElementById("password");

    // registrationForm
    const registrationForm = document.getElementById("registration-form");
    const firstname = document.getElementById("registration_form_firstname");
    const lastname = document.getElementById("registration_form_lastname");
    const email = document.getElementById("registration_form_email");
    const password = document.getElementById(
        "registration_form_plainPassword_first"
    );
    const confirmPassword = document.getElementById(
        "registration_form_plainPassword_second"
    );
    const cgu = document.getElementById("registration_form_isAcceptedCGU");

    const errors = {
        firstname: document.getElementById("firstname-error"),
        lastname: document.getElementById("lastname-error"),
        email: document.getElementById("email-error"),
        registrationPassword: document.getElementById("password-error"),
        confirmPassword: document.getElementById("confirm-password-error"),
        cgu: document.getElementById("cgu-error"),
        username: document.getElementById("username-error"),
        passwordInLoginForm: document.getElementById("password-login-error"),
    };

    function clearError(field) {
        switch (field.id) {
            case "registration_form_firstname":
                errors.firstname.textContent = "";
                break;
            case "registration_form_lastname":
                errors.lastname.textContent = "";
                break;
            case "registration_form_email":
                errors.email.textContent = "";
                break;
            case "registration_form_plainPassword_first":
                errors.registrationPassword.textContent = "";
                break;
            case "registration_form_plainPassword_second":
                errors.confirmPassword.textContent = "";
                break;
            case "registration_form_isAcceptedCGU":
                errors.cgu.textContent = "";
                break;
            case "username":
                errors.username.textContent = "";
                break;
            case "password":
                errors.passwordInLoginForm.textContent = "";
                break;
        }
    }

    function validateField(field) {
        let value = field.value.trim();
        let isValid = true;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        switch (field.id) {
            case "registration_form_firstname":
                if (value.length < 2) {
                    errors.firstname.textContent =
                        "Le prénom doit avoir au moins 2 caractères.";
                    isValid = false;
                } else if (value.length > 255) {
                    errors.firstname.textContent =
                        "Le prénom ne peut pas dépasser 255 caractères.";
                    isValid = false;
                }
                break;

            case "registration_form_lastname":
                const lastnamePattern = /^[A-Z][a-zA-Z'-]+$/;
                if (value.length < 2) {
                    errors.lastname.textContent =
                        "Le nom doit avoir au moins 2 caractères.";
                    isValid = false;
                } else if (value.length > 255) {
                    errors.lastname.textContent =
                        "Le nom ne peut pas dépasser 255 caractères.";
                    isValid = false;
                } else if (!lastnamePattern.test(value)) {
                    errors.lastname.textContent =
                        "Le nom doit commencer par une majuscule et ne contenir que des lettres.";
                    isValid = false;
                }
                break;

            case "registration_form_email":
                if (!value) {
                    errors.email.textContent = "L'email est obligatoire.";
                    isValid = false;
                } else if (!emailPattern.test(value)) {
                    errors.email.textContent = "Votre email est invalide.";
                    isValid = false;
                } else if (value.length > 255) {
                    errors.email.textContent =
                        "L'email ne peut pas dépasser 255 caractères.";
                    isValid = false;
                }
                break;

            case "registration_form_plainPassword_first":
                if (value.length < 8) {
                    errors.registrationPassword.textContent =
                        "Le mot de passe doit contenir au moins 8 caractères.";
                    isValid = false;
                }
                break;

            case "registration_form_plainPassword_second":
                if (password.value != confirmPassword.value) {
                    errors.confirmPassword.textContent =
                        "Les mots de passe ne correspondent pas.";
                    isValid = false;
                }
                break;

            case "registration_form_isAcceptedCGU":
                if (!cgu.checked) {
                    errors.cgu.textContent =
                        "Veuillez accepter nos conditions générales.";
                    isValid = false;
                }
                break;

            case "username":
                if (!value) {
                    errors.username.textContent = "L'email est obligatoire.";
                    isValid = false;
                } else if (!emailPattern.test(value)) {
                    errors.username.textContent = "Votre email est invalide.";
                    isValid = false;
                } else if (value.length > 255) {
                    errors.username.textContent =
                        "L'email ne peut pas dépasser 255 caractères.";
                    isValid = false;
                }
                break;

            case "password":
                if (value.length < 8) {
                    errors.passwordInLoginForm.textContent =
                        "Le mot de passe doit contenir au moins 8 caractères.";
                    isValid = false;
                }
                break;

            default:
                break;
        }

        return isValid;
    }

    function validateRegistrationForm() {
        let isValid = true;

        [firstname, lastname, email, password, confirmPassword, cgu].forEach(
            (field) => {
                clearError(field.id);

                if (!validateField(field)) {
                    isValid = false;
                }
            }
        );
        return isValid;
    }

    function validateLoginForm() {
        let isValid = true;

        [username, passwordInLoginForm].forEach((field) => {
            clearError(field.id);
            if (!validateField(field)) {
                isValid = false;
            }
        });
        return isValid;
    }

    if (registrationForm) {
        registrationForm.addEventListener("submit", (event) => {
            if (!validateRegistrationForm()) {
                event.preventDefault();
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", (event) => {
            if (!validateLoginForm()) {
                event.preventDefault();
            }
        });
    }
});
