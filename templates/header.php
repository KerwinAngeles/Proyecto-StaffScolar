<?php 
    session_start();
    $url_base="http://localhost/app/";

    if(!isset($_SESSION['usuario']))
    {
        header("Location: ".$url_base."login.php");
    }

?>


<!doctype html>
<html lang="en">

<head>
  <title>StaffScolar</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- jquery -->

  <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

  <!-- datatable -->

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
  .nav-link
    {
    position:relative;
    }

  .nav-link::after
    { 
    content: '';
    opacity:0;
    transition: all 0.2s;
    height: 2px;
    width: 100%;
    background-color: greenYellow;
    position:absolute;
    bottom:0;
    left:0;
    }
  .nav-link:hover::after
  {
    opacity: 1;
  }

  </style>

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>

    <nav class="navbar navbar-expand navbar-light navbar-dark bg-primary ">
      
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="#" aria-current="page"><i class="fa-solid fa-graduation-cap"></i> StaffScolar<span class="visually-hidden">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo $url_base;?>secciones/empleados"><i class="fa-solid fa-circle-user"></i> Empleados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo $url_base;?>secciones/puestos"><i class="fa-solid fa-briefcase"></i> Especialidad</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo $url_base;?>secciones/usuarios"><i class="fa-solid fa-user"></i> Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo $url_base;?>cerrar.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
            </li>
        </ul>
    </nav>

  <main class="container">

<?php if(isset($_GET['mensaje'])) {?>
<script>
Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje']; ?>"})

<?php }?>
</script>