// validate.js — client-side validation

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("studentForm");
    if (!form) return; // safety check

    form.addEventListener("submit", function (e) {
        let hasErrors = false;

        // Grab form values
        const name   = form.name.value.trim();
        const email  = form.email.value.trim();
        const regNo  = form.reg_no.value.trim();
        const password = form.password.value.trim();
        const gender = form.gender.value;
        const course = form.course.value;

        // Clear previous error messages
        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        // Validation
        if (name === "") {
            form.name.nextElementSibling.textContent = "Full Name is required (client-side)";
            hasErrors = true;
        }

        if (email === "") {
            form.email.nextElementSibling.textContent = "Email is required (client-side)";
            hasErrors = true;
        }

        if (regNo === "") {
            form.reg_no.nextElementSibling.textContent = "Registration Number is required (client-side)";
            hasErrors = true;
        }

        if (password === "") {
            form.password.nextElementSibling.textContent = "Password is required (client-side)";
            hasErrors = true;
        }

        if (gender === "") {
            form.gender.nextElementSibling.textContent = "Gender is required (client-side)";
            hasErrors = true;
        }

        if (course === "") {
            form.course.nextElementSibling.textContent = "Course is required (client-side)";
            hasErrors = true;
        }

        if (hasErrors) {
            e.preventDefault(); // stop form submission if there are errors
        }
    });
});
