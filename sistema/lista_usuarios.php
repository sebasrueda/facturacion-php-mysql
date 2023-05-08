<?php
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include 'includes/scripts.php'; ?>
	<title>Lista de usuarios</title>
    <!-- <style>
        #container h1 {
	    font-size: 35px;
	    display: inline-block;
    }

    .btn_new {
	    display: inline-block;
	    background: #239baa;
	    color: #fff;
	    padding: 5px 25px;
	    border-radius: 4px;
	    margin: 20px;
    }

    table {
        border-collapse: collapse;
        font-size: 12pt;
        font-family: Arial;
        width: 100%;
    }

    table th {
        text-align: left;
        padding: 10px;
        background: #3d7ba8;
        color: #fff;
    }

    table tr:nth-child(odd) {
	    background-color: #fff;
    }

    table td {
        padding: 10px;
    }

    .link_edit {
        color: #0ca4ce;
    }

    .link_delete {
        color: #f26b6b;
    }
    </style> -->
</head>
<body>
	<?php include 'includes/header.php' ?>
	<section id="container">
		<h1>Lista de usuarios</h1>
        <a href="registro_usuario.php" class="btn_new">Crear usuario</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>

            <?php 
                $query = mysqli_query($connection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r WHERE u.rol = r.idrol");

                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $data["idusuario"]; ?></td>
                            <td><?php echo $data["nombre"]; ?></td>
                            <td><?php echo $data["correo"]; ?></td>
                            <td><?php echo $data["usuario"]; ?></td>
                            <td><?php echo $data["rol"]; ?></td>
                            <td>
                                <a class="link_edit" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Editar</a>
                                |
                                <a class="link_delete" href="">Eliminar</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>


        </table>
	</section>

	<?php include 'includes/footer.php' ?>
</body>
</html>