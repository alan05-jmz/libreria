<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería "Letras y Sabiduria"</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <nav>
        <ul>
           
            <li><a href="catalogo_clientes.php">Catálogo de Libros</a></li>
            <li><a href="carrito.php">Carrito</a></li>
        </ul>
    </nav>

    <div class="container">
        <center><h1>Librería</h1></center>
        <h2>Catálogo de Libros</h2>
     
        <table>
            <thead>
                <tr>
                    <th>Clave</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexion.php';

                $sql = "SELECT * FROM libros";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['clave']}</td>
                                <td>{$row['titulo']}</td>
                                <td>{$row['autor']}</td>
                                <td>{$row['estado']}</td>
                                <td>{$row['precio']}</td>
                                <td>
                                    <a href='editar.php?id={$row['id']}'>Editar</a>
                                    <a href='eliminar.php?id={$row['id']}'>Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay libros disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
<br><br>
        <h3>Agregar Nuevo Libro</h3>
        <form action="agregar.php" method="POST">
            <input type="text" name="clave" placeholder="Clave" required>
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="text" name="autor" placeholder="Autor" required>
            <select name="estado" required>
                <option value="En existencia">En existencia</option>
                <option value="Prestado">Prestado</option>
                <option value="No disponible">No disponible</option>
            </select>
            <input type="number" name="precio" placeholder="Precio" required>
            <button type="submit">Agregar Libro</button>
        </form>
    </div>
</body>
</html>
