document.addEventListener("click", (e) => {
    const panel = document.querySelector(".side-panel");
    const overlay = document.getElementById("overlay");

    if (!panel || !overlay) return; // Evita errores si no existen

    if (e.target.matches(".btn-edit")) {
        panel.classList.add("active");
        overlay.classList.add("active");
    }

    if (e.target.matches("#btn-cerrar-panel, #overlay")) {
        panel.classList.remove("active");
        overlay.classList.remove("active");
    }
});
