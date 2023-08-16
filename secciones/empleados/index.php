
<?php

    include ("../../bd.php");

     // borrar registro

     if(isset($_GET['txtID']))
     {
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
        // buscar el archivo relacionado con empleados
        $sentencia=$conexion->prepare("SELECT foto FROM `tbl_empleados` WHERE id=:id"); // buscamos la informacion foto cuando el id = id empleados
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        
        $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY); // nos dara la informacion que se haya encontrado

        // nos permitira eliminar la foto de la carpeta
        if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!= "")
        {
            if (file_exists("./".$registro_recuperado["foto"])) 
            {
                unlink("./".$registro_recuperado["foto"]);
            }
        }

        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
        $sentencia=$conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $mensaje="Registro eliminado";
        header("Location:index.php?mensaje=".$mensaje);
         
     }

    
    $sentencia=$conexion->prepare("SELECT *,
    (SELECT nombredelpuesto
     FROM tbl_puestos
     WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1
    ) as puesto
     FROM `tbl_empleados`");

    $sentencia->execute();
    $lista_tbl_empleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php"); ?>

    <br>

    <div class="card">
        <div class="card-header">
            <a name="" id="" class="btn btn-primary" 
            href="crear.php" role="button">Agregar registro
            </a>
        </div>
        <div class="card-body">
         
            <div class="table-responsive-sm">
                <table class="table" id="tabla_id" >
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Especialidad</th>
                            <th scope="col">Fecha de ingreso</th>
                            <th scope="col">Acciones</th>              
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach($lista_tbl_empleados as $registro) {?>

                        <tr class="">
                            <td scope="row"><?php echo $registro ['id']; ?></td>
                            <td scope="row">
                            <?php echo $registro ['primernombre']; ?>
                            <?php echo $registro ['segundonombre']; ?>
                            <?php echo $registro ['primerapellido']; ?>
                            <?php echo $registro ['segundoapellido']; ?>
                            </td>
                            
                            <!-- agregamo la imagen con un tamano de 50 -->
                            <td>
                                <img width="50"  
                                 src="<?php echo $registro ['foto']; ?>" 
                                 class="img-fluid rounded-top" alt="" />
                            </td>
                        
                            <td><?php echo $registro ['puesto']; ?></td>
                            <td><?php echo $registro ['fechadeingreso']; ?></td>
                            <td>
                             
                                <a class="btn btn-primary" href="editar.php?txtID=<?php echo $registro ['id']; ?>" role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro ['id']; ?>);" role="button">Eliminar</a> 
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    </tbody>
                </table>
            </div>
                    

        </div>
       
    </div>

<?php include("../../templates/footer.php"); ?>