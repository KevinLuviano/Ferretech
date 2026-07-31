-- ESQUEMA DE LA BASE DE DATOS
DROP DATABASE IF EXISTS ferretech_db;
CREATE DATABASE ferretech_db;
USE ferretech_db;

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(250) NOT NULL,
    rol ENUM('cliente', 'host') NOT NULL DEFAULT 'cliente',
    carrito_guardado TEXT DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Licencias (
    id_licencia INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    clave_licencia VARCHAR(50) NOT NULL UNIQUE,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_asignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
);

CREATE TABLE Categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nombre_producto VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    url_imagen VARCHAR(250),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

CREATE TABLE Pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    direccion VARCHAR(150),
    telefono_contacto VARCHAR(50),
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

CREATE TABLE Carrusel (
    id_carrusel INT AUTO_INCREMENT PRIMARY KEY,
    badge_promo VARCHAR(100) NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    id_categoria INT,
    url_imagen VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria) ON DELETE SET NULL
);

-- INSERCIONES A LA BASE DE DATOS

-- CATEGORIAS 
INSERT INTO Categorias (nombre_categoria) VALUES ('Herramientas');
INSERT INTO Categorias (nombre_categoria) VALUES ('Materiales de fijación');

-- PRODUCTOS
INSERT INTO Productos (id_categoria, nombre_producto, precio, stock, url_imagen) VALUES 
(1, 'Martillo de uña curva 16 oz', 100.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/l/t/lt0071.jpg'),
(1, 'Juego de 3 desarmadores con puntas', 200.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/f/m/fm103.jpg'),
(1, 'Flexómetro de 8 metros', 120.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/s/t/sty191_1.jpg'),
(1, 'Juego de 3 pinzas de electricista (8 pulgadas)', 250.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/f/m/fm013.jpg'),
(1, 'Llave ajustable', 150.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/a/d/ad3288_1.jpg'),
(1, 'Taladro rotomartillo inalámbrico', 1000.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/t/e/te535_1.jpg'),
(1, 'Juego de 7 llaves allen', 100.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/f/m/fm132.jpg'),
(1, 'Cutter de 7 pulgadas', 50.00, 20, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/w/f/wf0580.jpg');

INSERT INTO Productos (id_categoria, nombre_producto, precio, stock, url_imagen) VALUES 
(2, 'Pijas para metal de 10mm 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/t/r/trm501_1.jpg'),
(2, 'Clavos para herrar #5 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/i/a/iac587.jpg'),
(2, 'Taquetes de nylon 1/4 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/f/0/f002.jpg'),
(2, 'Tuercas 1/4 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/a/r/ar165_1.jpg'),
(2, 'Rondanas 1/4 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/a/r/ar168_1.jpg'),
(2, 'Remaches 1/4 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/a/d/ad11820.jpg'),
(2, 'Tornillo conector 20mm 100 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67ee89799642c567a71fc92f3699d937/m/z/mz567.jpg'),
(2, 'Armella galvanizada cerrada 50 piezas', 100.00, 50, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67ee89799642c567a71fc92f3699d937/s/t/ste005.jpg');

-- CARRUSEL
INSERT INTO Carrusel (badge_promo, titulo, descripcion, id_categoria, url_imagen) VALUES
('Mes de las Herramientas', 'Juego de 3 desarmadores con punta', 'Ideal para transportar a todas partes. Incluye garantía oficial de fábrica.', 1, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/f/m/fm103.jpg'),
('Fijación Profesional', 'Pijas al mejor precio', 'De la mejor calidad para metal.', 2, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/t/r/trm501_1.jpg'),
('Para tu comodidad', 'Taladro rotomartillo inalámbrico', 'Equípate con el potente motor de 650W sobre baleros de bolas. Ideal para concreto, acero y madera.', 1, 'https://cdn.elgrantlapalero.com/media/catalog/product/cache/67b40ad19abdf9b566f26db2b5cdbcd9/t/e/te535_1.jpg');