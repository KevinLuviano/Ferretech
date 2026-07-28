function actualizarContador() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let totalArticulos = 0;

    carrito.forEach(producto => {
        totalArticulos += producto.cantidad;
    });

    const contadorElemento = document.getElementById('contador-carrito');
    
    if (contadorElemento) {
        if (totalArticulos > 0) {
            contadorElemento.innerText = totalArticulos; 
            contadorElemento.style.display = 'block';
        } else {
            contadorElemento.style.display = 'none'; 
        }
    }
}

document.addEventListener("click", function(e) {
    if (e.target && e.target.id === "btn-logout") {
        e.preventDefault(); 

        let carrito = localStorage.getItem('carrito') || "[]";

        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'cerrar.php';

        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'carrito';
        input.value = carrito;

        form.appendChild(input);
        document.body.appendChild(form);
        
        form.submit();
    }
});

fetch('/Ferretech/html/header.php')
  .then(response => response.text())
  .then(data => {
      document.getElementById('header-placeholder').innerHTML = data;
      actualizarContador();
  });

fetch('/Ferretech/html/footer.php')
  .then(response => response.text())
  .then(data => {
      document.getElementById('footer-placeholder').innerHTML = data;
  });