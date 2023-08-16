<?php

    include ("../../bd.php");
    if ($_POST)
    {
        
        // Recolectamos los datos del metodo post
        $nombredelpuesto=(isset($_POST["nombredelpuesto"])? $_POST["nombredelpuesto"]:"" );

        // Preparar la inserccion de los datos
        $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto)
                    VALUES(null, :nombredelpuesto)");

        // asignando valores del metodo post

        $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
        $sentencia->execute();

        $mensaje="Registro agregado";
        header("Location:index.php?mensaje=".$mensaje);
    }

?>

<?php include("../../templates/header.php"); ?>

    <br>
    
    <div class="card">
        <div class="card-header">
            Especialidad
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                  <label for="nombredelpuesto" class="form-label">Nombre del puesto</label>
                  <input type="text"
                    class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>
                <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>

            </form>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>

<?php include("../../templates/footer.php"); ?>