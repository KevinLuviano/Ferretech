const botonesAgregar = document.querySelectorAll('.btn-agregar');

for (let boton of botonesAgregar) {
    boton.addEventListener('click', function (evento) {

        const articulo = evento.target.closest('.producto');

        const titulo = articulo.querySelector('h3').innerText;
        const precio = articulo.querySelector('.precio').innerText;
        const imagen = articulo.querySelector('img').src;
        const id = articulo.getAttribute('data-id');

        const precioNumerico = parseFloat(precio.replace(/[^0-9.]/g, ''));

        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        const productoExistente = carrito.find(function (item) {
            return item.id === id;
        });

        if (productoExistente) {
            productoExistente.cantidad += 1;
        } else {
           const productoSeleccionado = {
                id: id,
                titulo: titulo,
                precio: precioNumerico,
                imagen: imagen,
                cantidad: 1
            };
            carrito.push(productoSeleccionado);
        }

        localStorage.setItem('carrito', JSON.stringify(carrito));

        console.log("Producto procesado:", titulo);

        actualizarContador();
    });
}