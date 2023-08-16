
<?php

    include ("../../bd.php");

    if(isset($_GET['txtID']))
    {
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
        $sentencia=$conexion->prepare("SELECT * FROM tbl_puestos WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);
        $nombredelpuesto=$registro["nombredelpuesto"];
    }

    if ($_POST)
    {
        print_r($_POST);
        // Recolectamos los datos del metodo post
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        $nombredelpuesto=(isset($_POST["nombredelpuesto"])? $_POST["nombredelpuesto"]:"" );

        // Preparar la inserccion de los datos
        $sentencia=$conexion->prepare(" UPDATE tbl_puestos SET nombredelpuesto=:nombredelpuesto WHERE id=:id");

        // asignando valores del metodo post

        $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
        $sentencia->bindParam(":id",$txtID);

        $sentencia->execute();

        $mensaje="Registro actualizado";
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
                  <label for="txtID" class="form-label">ID</label>
                  <input type="text"
                    value="<?php echo $txtID;?>"
                    class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
                </div>

                <div class="mb-3">
                  <label for="nombredelpuesto" class="form-label">Nombre del puesto</label>
                  <input type="text"
                    value="<?php echo $nombredelpuesto;?>"
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