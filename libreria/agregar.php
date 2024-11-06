<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = $_POST['clave'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO libros (clave, titulo, autor, estado, precio) VALUES ('$clave', '$titulo', '$autor', '$estado', '$precio')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
