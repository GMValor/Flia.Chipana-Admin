
//----------------------------------------------------------
//                  MOSTRAR UN CLIENTE
//----------------------------------------------------------

//esta funcion se usa cada ves se carga la pag o cuando necesitas actualizar la tabla

async function cargarProductos() {
    const tabla = document.getElementById("tabla-productos");

    try {
        const res = await fetchConToken(`${API_URL}/productos`);

        if (!res || !res.ok) throw new Error("Error al obtener productos");

        const productos = await res.json();
        tabla.innerHTML = "";
        productos.forEach(productos => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${productos.id_producto}</td>
                <td>${productos.descripcion}</td>
                <td>${productos.stock}</td>
                <td>${productos.id_proveedor}</td>
                <td>${productos.precio}</td>
                <td>${productos.costo}</td>
                <td>${productos.fecha_cad}</td>
                <td class="actions">
                    <button class="btn-edit" data-id="${productos.id_producto}"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn-delete" data-id="${productos.id_producto}"><i class="fa-solid fa-trash-can"></i></button>
                </td>`;
            tabla.appendChild(fila);
        });
    } catch (err) {
        console.error(err);
        tabla.innerHTML = "<tr><td colspan='8'>Error al cargar producto.</td></tr>";
    }
}


//----------------------------------------------------------
//                  AGREGAR UN CLIENTE
//----------------------------------------------------------

//funcion para mostrar el de agregado del cliente exitosamente 
function mostrarMensaje(mensaje) {
  const toast = document.getElementById("mensaje-toast");
  toast.textContent = mensaje;
  toast.style.display = "block";
  toast.style.opacity = "1";

  setTimeout(() => {
    toast.style.opacity = "0";
    setTimeout(() => {
      toast.style.display = "none";
    }, 300);
  }, 2500);
}

// funcion para agregar un cliente
function inicializarAgregarProducto() {
  const form = document.getElementById("form-agregar-producto");
  const panel = document.querySelector(".side-panel");
  const overlay = document.getElementById("overlay");

  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const botonAgregar = form.querySelector('button[type="submit"]');
    botonAgregar.disabled = true;
    botonAgregar.textContent = "Agregando...";

    const token = localStorage.getItem("token");
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    try {
      const res = await fetchConToken(`${API_URL}/productos`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });

      if (!res.ok) throw new Error("Error al agregar producto");

      mostrarMensaje("producto agregado exitosamente");
      form.reset();
      panel.classList.remove("active");
      overlay.classList.remove("active");
      cargarProductos(); // refresca la tabla
    } catch (err) {
      console.error(err);
      mostrarMensaje("Error al agregar producto");
    } finally {
      botonAgregar.disabled = false;
      botonAgregar.textContent = "Agregar";
    }
  });
}

  //panel agregar
document.addEventListener("click", (e) => {
  const panel = document.querySelector(".side-panel");
  const overlay = document.getElementById("overlay");
  const form = document.getElementById("form-agregar-productos");

  if (!panel || !overlay) return; // Evita errores si no existen

  if (e.target.matches(".btn-add-producto")) {
    panel.classList.add("active");
    overlay.classList.add("active");
    cargarProveedoresProductos();

  }

  if (e.target.matches("#btn-cerrar-panel, #overlay")) {
    panel.classList.remove("active");
    overlay.classList.remove("active");

    // Resetear formulario al cerrar panel
    if (form) form.reset();
  }
});






//----------------------------------------------------------
//                  EDITAR UN CLIENTE
//----------------------------------------------------------


function inicializarEditarProducto() {
  const panelEditar = document.getElementById("panel-editar");
  const overlay = document.getElementById("overlay");
  const formEditar = document.getElementById("form-editar-producto");
  const btnCerrarEditar = document.getElementById("btn-cerrar-panel-editar");

  //Cerrar panel editar
  btnCerrarEditar.addEventListener("click", () => {
    panelEditar.classList.remove("active");
    overlay.classList.remove("active");
    formEditar.reset();
  });

  overlay.addEventListener("click", () => {
    if (panelEditar.classList.contains("active")) {
      panelEditar.classList.remove("active");
      overlay.classList.remove("active");
      formEditar.reset();
    }
  });

  // Delegación para botón editar en la tabla
  document.getElementById("tabla-productos").addEventListener("click", async(e) => {
    if (e.target.closest(".btn-edit")) {
      const btnEditar = e.target.closest(".btn-edit");
      const fila = btnEditar.closest("tr");

      // Obtener datos de la fila
      const id_producto = btnEditar.getAttribute("data-id");
      const descripcion = fila.children[1].textContent;
      const stock = fila.children[2].textContent;
      const id_proveedor = fila.children[3].textContent;
      const precio = fila.children[4].textContent;
      const costo = fila.children[5].textContent;
      const fecha_cad = fila.children[6].textContent;
  await cargarProveedoresProductos(); 

      // Llenar formulario editar
      formEditar.elements["id_producto"].value = id_producto;
      formEditar.elements["descripcion"].value = descripcion;
      formEditar.elements["stock"].value = stock;
      formEditar.elements["id_proveedor"].value = id_proveedor;
      formEditar.elements["precio"].value = precio;
      formEditar.elements["costo"].value = costo;
      formEditar.elements["fecha_cad"].value = fecha_cad;
      // Mostrar panel editar y overlay
      panelEditar.classList.add("active");
      overlay.classList.add("active");
    }
  });

  formEditar.addEventListener("submit", async (e) => {
  e.preventDefault();

  const botonActualizar = formEditar.querySelector('button[type="submit"]');
  botonActualizar.disabled = true;
  botonActualizar.textContent = "Actualizando...";

  try {
    const formData = new FormData(formEditar);
    const data = Object.fromEntries(formData.entries());

    console.log("Enviando datos:", data);
    console.log("Valor proveedor en submit:", formEditar.elements["id_proveedor"].value);

    const id_producto = data.id_producto;
    delete data.id_producto;

    const res = await fetchConToken(`${API_URL}/productos/${id_producto}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    if (!res.ok) throw new Error("Error al actualizar producto");

    mostrarMensaje("Producto actualizado exitosamente");
    formEditar.reset();
    panelEditar.classList.remove("active");
    overlay.classList.remove("active");
    cargarProductos();

  } catch (err) {
    console.error(err);
    mostrarMensaje("Error al actualizar producto");
  } finally {
    botonActualizar.disabled = false;
    botonActualizar.textContent = "Actualizar";
  }
});
}






//----------------------------------------------------------
//                  ELIMINAR UN CLIENTE
//----------------------------------------------------------



function inicializarEliminarProducto() {
  const confirmDiv = document.getElementById("confirmacion-simple");
  const btnSi = document.getElementById("btn-si");
  const btnNo = document.getElementById("btn-no");
  const nombreProductoSpan = document.getElementById("nombre-producto-eliminar");

  let idproductoAEliminar = null;

  document.getElementById("tabla-productos").addEventListener("click", (e) => {
    const btnEliminar = e.target.closest(".btn-delete");
    if (!btnEliminar) return;

    idproductoAEliminar = btnEliminar.getAttribute("data-id");
    if (!idproductoAEliminar) return;

    // obtenemos el nombre de la fila para mostrar
    const fila = btnEliminar.closest("tr");
    const nombreProducto = fila.children[1].textContent + " " + fila.children[2].textContent; // nombre + apellido

    // Lo ponemos en el cartelito
    nombreProductoSpan.textContent = nombreProducto;

    confirmDiv.style.display = "block";
  });

  btnNo.addEventListener("click", () => {
    confirmDiv.style.display = "none";
    idproductoAEliminar = null;
  });

  btnSi.addEventListener("click", async () => {
    if (!idproductoAEliminar) return;

    try {
      const res = await fetchConToken(`${API_URL}/productos/${idproductoAEliminar}`, {
        method: "DELETE"
      });

      if (!res.ok) throw new Error("Error al eliminar producto");

      mostrarMensaje("producto eliminado exitosamente");
      cargarProductos();
    } catch (error) {
      console.error(error);
      mostrarMensaje("Error al eliminar producto");
    } finally {
      confirmDiv.style.display = "none";
      idproductoAEliminar = null;
    }
  });
}



async function cargarProveedoresProductos() {
  try {
    const res = await fetchConToken(`${API_URL}/proveedores`);
    if (!res.ok) throw new Error("Error al cargar proveedores");

    const proveedores = await res.json();

    const selectAgregar = document.getElementById("id_proveedor");
    const selectEditar = document.getElementById("id_proveedor_editar");

    // Validar que los selects existan antes de manipularlos
    if (!selectAgregar || !selectEditar) {
      console.warn("Los selects de proveedores no existen en esta página.");
      return;
    }

    selectAgregar.innerHTML = '<option value="">Seleccionar proveedor...</option>';
    selectEditar.innerHTML = '<option value="">Seleccionar proveedor...</option>';

    proveedores.forEach((proveedor) => {
      const option = document.createElement("option");
      option.value = proveedor.id_proveedor;
      option.textContent = proveedor.nombre;

      selectAgregar.appendChild(option);
      selectEditar.appendChild(option.cloneNode(true));
    });

  } catch (error) {
    console.error(error);
    mostrarMensaje("Error al cargar proveedores");
  }

}