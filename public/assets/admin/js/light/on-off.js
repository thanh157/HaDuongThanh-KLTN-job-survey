document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("toggleTheme");
    const body = document.body;

    if (localStorage.getItem("theme") === "light") {
        body.classList.add("light-mode");
        toggle.checked = true;
    }

    toggle.addEventListener("change", function () {
        if (this.checked) {
            body.classList.add("light-mode");
            localStorage.setItem("theme", "light");
        } else {
            body.classList.remove("light-mode");
            localStorage.setItem("theme", "dark");
        }
    });
});



