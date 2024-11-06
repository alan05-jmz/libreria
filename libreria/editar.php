<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $clave = $_POST['clave'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];

    $sql = "UPDATE libros SET clave='$clave', titulo='$titulo', autor='$autor', estado='$estado', precio='$precio' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM libros WHERE id=$id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
</head>
<body>
    <h1>Editar Libro</h1>
    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
        <input type="text" name="clave" value="<?php echo $book['clave']; ?>" required>
        <input type="text" name="titulo" value="<?php echo $book['titulo']; ?>" required>
        <input type="text" name="autor" value="<?php echo $book['autor']; ?>" required>
        <select name="estado" required>
            <option value="En existencia" <?php if ($book['estado'] == "En existencia") echo 'selected'; ?>>En existencia</option>
            <option value="Prestado" <?php if ($book['estado'] == "Prestado") echo 'selected'; ?>>Prestado</option>
            <option value="No disponible" <?php if ($book['estado'] == "No disponible") echo 'selected'; ?>>No disponible</option>
        </select>
        <input type="number" name="precio" value="<?php echo $book['precio']; ?>" required>
        <button type="submit">Actualizar Libro</button>
    </form>
</body>
</html>
