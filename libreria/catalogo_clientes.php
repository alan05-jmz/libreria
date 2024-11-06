<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros - Clientes</title>
    <link rel="stylesheet" href="estilo_catalogo.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="carrito.php">Carrito</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Catálogo de Libros</h1>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
            <div class="alert alert-success">
                Libro agregado al carrito.
            </div>
        <?php endif; ?>

        <div class="catalogo">
            <?php
            include 'conexion.php'; // Conectar a la base de datos

            $sql = "SELECT * FROM libros";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='libro'>
                            <img src='imagenes/frank.jpeg' alt='{$row['titulo']}'>
                            <h3>{$row['titulo']}</h3>
                            <p><strong>Autor:</strong> {$row['autor']}</p>
                            <p><strong>Precio:</strong> $ {$row['precio']}</p>
                            <p><strong>Estado:</strong> <span class='estado {$row['estado']}'>{$row['estado']}</span></p>
                            <form action='carrito.php' method='POST'>
                                <input type='hidden' name='libro_id' value='{$row['id']}'>
                                <input type='number' name='cantidad' value='1' min='1' required>
                                <button type='submit' class='btn-agregar'>Agregar al Carrito</button>
                            </form>
                          </div>";
                }
            } else {
                echo "<p>No hay libros disponibles en este momento.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
