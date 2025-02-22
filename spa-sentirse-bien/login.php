<?php
    require "database.php";
    session_start();
    if($_SESSION['activa']) header('Location: mensaje.php?msj=3');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro al Spa "Sentirse Bien"</title>
    <link rel="shortcut icon" href="./img/iconos/loto.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="fondo fondo-contacto" style="height: 100vh;">
    <div >
        <header>
            <nav>
                <ul>
                    <li><a href="./index.html">Inicio</a></li>
                    <li><a href="./servicios.html">Servicios</a></li>
                    <li><a href="./turnos.php">Turnos</a></li>
                    <li><a href="./contacto.html">Contacto</a></li>
                    <li><a href="./nosotros.html">Nosotros</a></li>  
                </ul>
            </nav>
        </header>
        <main>
            <div class="contenedor-centrador" style="margin-top: 100px;">
                <div class="contenedor-contacto" style="width: 800px;">
                    <form action="#" method="POST" class="form-serv-indiv" style="width: 70%;">
                        <h3 style="font-size:2rem; text-decoration:underline; margin:15px">Ingreso de usuario</h3>
                        <div class="description">Ingrese los datos de la cuenta</div>
                        <?php      
                            if(!empty($_POST['email'])){
                                $contrasena = $_POST['contrasena'];
                                $email = $_POST['email'];                               

                                //print "<p style='font-size:4rem'>SIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII<p>";
                                $array_errores = array();

                                empty($email)? array_push($array_errores, "El campo email no puede estar vacio"):"";
                                strpos($email, "@") === false? array_push($array_errores, "El email debe contener un @"):"";
                                strpos($email, ".") === false? array_push($array_errores, "El email debe contener un ."):"";

                                empty($contrasena)? array_push($array_errores, "El campo contraseña no puede estar vacío"):"";
                                strlen($contrasena) < 6? array_push($array_errores, "El campo contraseña no puede tener menos de 6 caracteres."):"";

                                if($array_errores){
                                    echo "<div class='lista-errores'>";
                                    foreach ($array_errores as $value) {
                                        print "<div class='error'>$value</div>";
                                    }
                                    echo"</div>";
                                }
                                else{   
                                    $contrasena= md5($contrasena);
                                    $sql = "SELECT * FROM clientes WHERE email = '$email' AND clave= '$contrasena'";
                                    /*usar header('Location: '.$nuevaURL.php); para redireccionar y die(); */
                                    $query=mysqli_query($enlace,$sql) ;
                                    if(mysqli_num_rows($query)>0){
                                        $datos= mysqli_fetch_array($query);
                                        //session_start();
                                        $_SESSION['activa']=true;
                                        $_SESSION['id_cliente']=$datos['id_cliente'];
                                        $_SESSION['nombre']=$datos['nombre'];
                                        $_SESSION['apellido']=$datos['apellido'];
                                        $_SESSION['dni']=$datos['dni'];
                                        $_SESSION['email']=$datos['email'];                                        
                                        $_SESSION['cuit']=$datos['cuit'];
                                        $_SESSION['direccion']=$datos['direccion'];
                                        $_SESSION['sexo']=$datos['sexo']==0? "masculino":"femenino";
                                        
                                        header('Location: mensaje.php?msj=1');
                                        print "<p style='font-size: 4rem;'>exito asdasdasdasasd</p>";
                                    }
                                    else{
                                        session_destroy();
                                        print"<div class='lista-errores'><div class='error'>Email o contraseña invalido</div></div>"; 
                                    }
                                }
                            }
                        ?>
                        <label for="email">e-mail:</label>
                        <input type="email" name="email" id="email" placeholder="Ingrese su e-mail">

                        <label for="contrasena">Contraseña:</label>
                        <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese la contraseña deseada">

                        <div class="contenedor-btn" style="margin-top: 30px;">
                            <input id="enviar" type="submit" value="Ingresar" name="enviar" style="width: 50%;">
                            <a href="signup.php" style="width: 50%;"><input type="reset" value="registrarse" style="width: 100%;"></a>
                        </div>

                    </form>

                    <div class="redes">
                        Seguinos en
                        <a href="https://www.facebook.com/Spa-Sentirse-Bien" target="_blank"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/Spa-Sentirse-Bien" target="_blank"><i
                                class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/Spa-Sentirse-Bien" target="_blank"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>