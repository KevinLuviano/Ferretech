-- CATEGORIAS 
INSERT INTO Categorias (nombre_categoria) VALUES ('Herramientas');
INSERT INTO Categorias (nombre_categoria) VALUES ('Materiales');

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

-- USUARIOS
INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES 
('Administrador', 'Ferretech', 'admin@ferretech.com', 'Admin1234', 'host'),
('Raul', 'Rosas', 'ranferinr@gmail.com', '123456ola', 'cliente');