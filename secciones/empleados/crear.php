
<?php

    include ("../../bd.php");
    if ($_POST)
    {

    // Recolectamos los datos del metodo post
    $primernombre=(isset($_POST["primernombre"])? $_POST["primernombre"]:"" );
    $segundonombre=(isset($_POST["segundonombre"])? $_POST["segundonombre"]:"" );
    $primerapellido=(isset($_POST["primerapellido"])? $_POST["primerapellido"]:"" );
    $segundoapellido=(isset($_POST["segundoapellido"])? $_POST["segundoapellido"]:"" );
    $foto=(isset($_FILES["foto"] ['name'])? $_FILES["foto"]['name']:"" );
    $idpuesto=(isset($_POST["idpuesto"])? $_POST["idpuesto"]:"" );
    $fechadeingreso=(isset($_POST["fechadeingreso"])? $_POST["fechadeingreso"]:"" );

    // insertando los datos en la base de datos
    $sentencia=$conexion->prepare("INSERT INTO 
    `tbl_empleados` (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `idpuesto`, `fechadeingreso`) 
    VALUES (NULL, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :idpuesto, :fechadeingreso);");

    // asignando los valores que vienen del metodo post
    $sentencia->bindParam(":primernombre",$primernombre);
    $sentencia->bindParam(":segundonombre",$segundonombre);
    $sentencia->bindParam(":primerapellido",$primerapellido);
    $sentencia->bindParam(":segundoapellido",$segundoapellido);

    // agregando la foto

    $fecha_ = new DateTime(); // obtenemos la fecha de la foto para evitar duplicidad

    // Comprobación si se ha proporcionado una imagen (foto) en la carga.
    $nombreArchivo_foto = ($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name']:"";

    $tmp_foto=$_FILES["foto"]['tmp_name']; // creamos un archivo temporal

    // movemos el archivo temporal a nuevo destino

    if($tmp_foto!="") // si esta vacio hacemos el movimiento de la foto
    {
      move_uploaded_file($tmp_foto, "./".$nombreArchivo_foto); // la funcion move_uploaded_file nos permite mover la foto a una nueva ubicacion
    }

    $sentencia->bindParam(":foto",$nombreArchivo_foto); // actualizamos en la base de datos el nombre
    $sentencia->bindParam(":idpuesto",$idpuesto);
    $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
    $sentencia->execute();

    $mensaje="Registro agregado";
    header("Location:index.php?mensaje=".$mensaje);
              
    }

    // muestra los puestos en el formulario
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>



<?php include("../../templates/header.php"); ?>

    <br>

    <div class="card">
        <div class="card-header">
            Datos
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="primernombre" class="form-label">Primer nombre</label>
              <input type="text"
                class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
            </div>

            <div class="mb-3">
              <label for="segundonombre" class="form-label">Segundo nombre</label>
              <input type="text"
                class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
            </div>

            <div class="mb-3">
              <label for="primerapellido" class="form-label">Primer apellido</label>
              <input type="text"
                class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
            </div>

            <div class="mb-3">
              <label for="segundoapellido" class="form-label">Segundo apellido</label>
              <input type="text"
                class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Foto</label>
              <input type="file"
                class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">

                <?php foreach($lista_tbl_puestos as $registro) {?>
                    <option value="<?php  echo $registro ['id']  ?>">
                    <?php  echo $registro ['nombredelpuesto']  ?>
                    </option>
                    
                <?php } ?>
                </select>
            </div>

            <div class="mb-3">
              <label for="fechadeingreso" class="form-label">Fecha de ingreso</label>
              <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="">
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>

            </form>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>

<?php include("../../templates/footer.php"); ?>