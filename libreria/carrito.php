<?php
session_start(); // Iniciar la sesión

include 'conexion.php'; // Conectar a la base de datos

// Manejar la lógica para agregar libros al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['libro_id'])) {
    $libro_id = $_POST['libro_id']; // ID del libro
    $cantidad = $_POST['cantidad']; // Cantidad seleccionada

    // Comprobar si el carrito ya ha sido inicializado
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Comprobar si el libro ya está en el carrito
    if (array_key_exists($libro_id, $_SESSION['carrito'])) {
        // Si el libro ya está en el carrito, actualizar la cantidad
        $_SESSION['carrito'][$libro_id] += $cantidad;
    } else {
        // Si el libro no está en el carrito, añadirlo
        $_SESSION['carrito'][$libro_id] = $cantidad;
    }

    // Redirigir a catalogo_clientes.php con un mensaje de éxito
    header("Location: catalogo_clientes.php?msg=added");
    exit(); // Asegúrate de salir después de redirigir
}

// Mostrar libros en el carrito
$totalGeneral = 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estcarrito.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="catalogo_clientes.php">Catálogo</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Carrito de Compras</h1>

        <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['carrito'] as $libro_id => $cantidad) {
                        // Consultar información del libro
                        $sql = "SELECT TITULO, AUTOR, PRECIO FROM libros WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $libro_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($row = $result->fetch_assoc()) {
                            $total = $row['PRECIO'] * $cantidad;
                            $totalGeneral += $total;

                            echo "<tr>
                                    <td>{$row['TITULO']}</td>
                                    <td>{$row['AUTOR']}</td>
                                    <td>{$row['PRECIO']}</td>
                                    <td>{$cantidad}</td>
                                    <td>$total</td>
                                    <td>
                                        <form method='POST' action='carrito.php'>
                                            <input type='hidden' name='libro_id' value='{$libro_id}'>
                                            <input type='hidden' name='cantidad' value='0'> <!-- Usar 0 para eliminar -->
                                            <button type='submit' name='eliminar' class='btn-eliminar'>Eliminar</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    }

                    echo "<tr><td colspan='4'>Total General</td><td colspan='2'>$$totalGeneral</td></tr>";
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>El carrito está vacío.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Manejar eliminación de libros del carrito
if (isset($_POST['eliminar'])) {
    $libro_id = $_POST['libro_id'];
    unset($_SESSION['carrito'][$libro_id]); // Eliminar libro del carrito
    header("Location: carrito.php"); // Redirigir de nuevo al carrito
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
