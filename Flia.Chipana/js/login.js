const form = document.getElementById("login-form");
const errorMessage = document.getElementById("error-message");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const password = document.getElementById("password").value.trim();

    errorMessage.innerText = ""; // Limpiar error anterior

    try {
        const credentials = btoa(`${nombre}:${password}`);
        const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            headers: {
                "Authorization": `Basic ${credentials}`
            }
        });

        const data = await res.json().catch(() => null);

        if (res.ok && data?.token) {
            localStorage.setItem("token", data.token);
            localStorage.setItem("role", data.role); // guardar rol
            
            window.location.href = "main.html";
        } else {
            
            errorMessage.innerText = data?.error || "Credenciales incorrectas.";
        }

    } catch (err) {
        console.error(err);
        errorMessage.innerText = "No se pudo conectar con el servidor.";
    }
});
