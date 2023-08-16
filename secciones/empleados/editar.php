
<?php

    include ("../../bd.php");

    if(isset($_GET['txtID']))
    {
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
        $sentencia=$conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);

        $primernombre=$registro["primernombre"];
        $segundonombre=$registro["segundonombre"];
        $primerapellido=$registro["primerapellido"];
        $segundoapellido=$registro["segundoapellido"];
        $foto=$registro["foto"];
        $idpuesto=$registro["idpuesto"];
        $fechadeingreso=$registro["fechadeingreso"];
        
        // muestra los puestos en el formulario
        $sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
        $sentencia->execute();
        $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    }

    if ($_POST)
    {
    
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    
    // Recolectamos los datos del metodo post
    $primernombre=(isset($_POST["primernombre"])? $_POST["primernombre"]:"" );
    $segundonombre=(isset($_POST["segundonombre"])? $_POST["segundonombre"]:"" );
    $primerapellido=(isset($_POST["primerapellido"])? $_POST["primerapellido"]:"" );
    $segundoapellido=(isset($_POST["segundoapellido"])? $_POST["segundoapellido"]:"" );
    $idpuesto=(isset($_POST["idpuesto"])? $_POST["idpuesto"]:"" );
    $fechadeingreso=(isset($_POST["fechadeingreso"])? $_POST["fechadeingreso"]:"" );

    // actualizando los datos en la base de datos
    $sentencia=$conexion->prepare(

    " UPDATE tbl_empleados 
    SET 
        primernombre=:primernombre,
        segundonombre=:segundonombre,
        primerapellido=:primerapellido,
        segundoapellido=:segundoapellido,
        idpuesto=:idpuesto,
        fechadeingreso=:fechadeingreso

    WHERE id=:id");

    // asignando los valores que vienen del metodo post
    $sentencia->bindParam(":primernombre",$primernombre);
    $sentencia->bindParam(":segundonombre",$segundonombre);
    $sentencia->bindParam(":primerapellido",$primerapellido);
    $sentencia->bindParam(":segundoapellido",$segundoapellido);
    $sentencia->bindParam(":idpuesto",$idpuesto);
    $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $foto=(isset($_FILES["foto"] ['name'])? $_FILES["foto"]['name']:"" );

    // actualizando la foto

    $fecha_ = new DateTime(); // obtenemos la fecha de la foto para evitar duplicidad
    
    // Comprobación si se ha proporcionado una imagen (foto) en la carga.
    $nombreArchivo_foto = ($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name']:"";

    $tmp_foto=$_FILES["foto"]['tmp_name']; // creamos un archivo temporal


    if($tmp_foto!='') // si esta vacio hacemos el movimiento de la foto
    {
         move_uploaded_file($tmp_foto, "./".$nombreArchivo_foto); // la funcion move_uploaded_file nos permite mover la foto a una nueva ubicacion
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

        $sentencia=$conexion->prepare("UPDATE tbl_empleados SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(":foto",$nombreArchivo_foto); 
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();

    }

    $mensaje="Registro actualizado";
    header("Location:index.php?mensaje=".$mensaje);
              
    }

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
             <label for="txtID" class="form-label">ID</label>
             <input type="text"
              value="<?php echo $txtID;?>"
              class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
              <label for="primernombre" class="form-label">Primer nombre</label>
              <input type="text"
              value="<?php echo $primernombre;?>"
              class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
            </div>

            <div class="mb-3">
              <label for="segundonombre" class="form-label">Segundo nombre</label>
              <input type="text"
              value="<?php echo $segundonombre;?>"
              class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
            </div>

            <div class="mb-3">
              <label for="primerapellido" class="form-label">Primer apellido</label>
              <input type="text"
              value="<?php echo $primerapellido;?>"
                class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
            </div>

            <div class="mb-3">
              <label for="segundoapellido" class="form-label">Segundo apellido</label>
              <input type="text"
              value="<?php echo $segundoapellido;?>"
                class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Foto</label>
              <br/>
              <img width="100"  
                src="<?php echo $foto; ?>" 
                class="rounded" alt="" />

                <br/>
                <br/> 
              <input type="file"
            
                class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">

                <?php foreach($lista_tbl_puestos as $registro) {?>
                    <option <?php echo ($idpuesto == $registro ['id'])? "selected":"";   ?> value="<?php  echo $registro ['id']  ?>">
                    <?php  echo $registro ['nombredelpuesto']  ?>
                    </option>
                    
                <?php } ?>
                </select>
            </div>

            <div class="mb-3">
              <label for="fechadeingreso" class="form-label">Fecha de ingreso</label>
              <input type="date" 
              value="<?php echo $fechadeingreso;?>"
              class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>

            </form>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>

<?php include("../../templates/footer.php"); ?>