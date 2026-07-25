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