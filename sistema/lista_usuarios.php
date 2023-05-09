<?php
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include 'includes/scripts.php'; ?>
	<title>Lista de usuarios</title>
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
                // Paginador
                $sql_register = mysqli_query($connection, "SELECT COUNT(*) AS total_registros FROM usuario WHERE estatus = 1");
                $result_register = mysqli_fetch_array($sql_register);
                $total_registros = $result_register['total_registros'];

                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas  = ceil($total_registros / $por_pagina);

                $query = mysqli_query($connection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1 ORDER BY u.idusuario ASC LIMIT $desde, $por_pagina");

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
                                <?php if ($data["idusuario"] != 1) { ?>
                                    |
                                    <a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Eliminar</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>


        </table>

        <section class="paginador">
            <ul>
                <?php if ($pagina != 1) { ?>
                        <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
                        <li><a href="?pagina=<?php echo $pagina - 1; ?>"><<</a></li>
                        <?php
                    }

                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina) {
                            echo '<li class="pagina_seleccionada">'.$i.'</li>';
                        } else {
                            echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                        }
                    }

                    if ($pagina != $total_paginas) { ?>
                        <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                        <li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
                <?php } ?>
            </ul>
        </section>
	</section>

	<?php include 'includes/footer.php' ?>
</body>
</html>