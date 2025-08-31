document.addEventListener("DOMContentLoaded", () => {
    // hamburger menu
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");

    hamburger.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });

    // registrationForm
    const registrationForm = document.getElementById("registration-form");
    const firstname = document.getElementById("registration_form_firstname");
    const lastname = document.getElementById("registration_form_lastname");
    const email = document.getElementById("registration_form_email");
    const password = document.getElementById("registration_form_plainPassword_first");
    const confirmPassword = document.getElementById("registration_form_plainPassword_second");
    const cgu = document.getElementById("registration_form_isAcceptedCGU");

    const errors = {
        firstname: document.getElementById("firstname-error"),
        lastname: document.getElementById("lastname-error"),
        email: document.getElementById("email-error"),
        password: document.getElementById("password-error"),
        confirmPassword: document.getElementById("confirm-password-error"),
        cgu: document.getElementById("cgu-error"),
    };

    function clearError(field) {
        if (errors[field]) {
            errors[field].textContent = "";
        }
    }

    function validateField(field) {
        let value = field.value.trim();
        let isValid = true;
       
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
                const emailPattern =
                    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
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
                    errors.password.textContent =
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
                    errors.cgu.textContent = "Veuillez accepter nos conditions générales.";
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

    registrationForm.addEventListener("submit", (event) => {
        if (!validateRegistrationForm()) {
            event.preventDefault();
        }
    });
});
