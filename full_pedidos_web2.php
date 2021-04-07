<?php
    
    $where = '';
    if(isset($_REQUEST['nombre'])){ 
        $nombre = $_REQUEST['nombre'];
        if($nombre != ""){            
            $where = "WHERE c.nombre = '$nombre'";  
        } 

        if(isset($_REQUEST['fecha_entrega'])){ 
            $fecha_entrega = $_REQUEST['fecha_entrega'];
            if($fecha_entrega != ""){  
                if($where == ""){
                    $where = "WHERE p.fecha_entrega = '$fecha_entrega'";
                } 
                else{
                    $where = "$where OR p.fecha_entrega = '$fecha_entrega'";
                }          
                }
                     
            }

    if(isset($_REQUEST['genero'])){    // función isset sirve para saber si existe lo que viene en el request   
        $genero = $_REQUEST['genero'];
        if($genero != ""){
            if($where == ""){
            $where = "WHERE c.genero = '$genero'";
            }
            else{
                $where = "$where OR c.genero = '$genero' OR c.edad = '$edad'";
            }
        }     
    }
    else{
        $where = "$where OR c.genero = '$genero' OR c.edad = '$edad' OR pr.valor = '$valor'";
    } 
}



    //1. Connect to Database
    $host = "localhost";
    $dbname = "pasteleria";
    $username = "root";
    $password = "";

    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    //2. Build SQL sentence
    $sql = "SELECT c.nombre as nombre_cli, p.fecha_entrega, pr.nombre as nombre_pro, pr.valor, prov.nombre as nombre_proveedor 
    FROM `clientes` as c JOIN pedidos as p ON c.id = p.id_cliente JOIN productos as pr JOIN proveedores as prov ON p.id_producto = pr.id 
    $where
    ORDER BY c.nombre ASC";

    var_dump($sql);
    ?>
    <hr/>
    <?php

    //3. Prepare SQL sentence
    $a = $conexion->prepare($sql);

    //4. Execute SQL sentence
    $resultado = $a->execute();   

    $pedidos = $a->fetchAll();  // fetchAll lee, carga, trae todo de la consulta sql y lo guarda en esta variable

    //var_dum para imprimir toda la variable

    //var_dump($pedidos);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" type="text/css">

    <title>Consultas OR pág 1</title>
</head>
<body background="imagenes/3.jpg">

<table>

            <tr>
                <td><hr/><hr/><hr/><img src="imagenes/logo.jpeg"" alt="Imagen"><hr/><hr/><hr/></td>
                
                <td>
                <center>
                <h1>BÚSQUEDA WEB2 / PÁGINA 3</h1>
    <form action="full_pedidos_web2.php">
        Nombre Cliente:
        <input type="number" name="nombre_cli" value="<?php echo $nombre; ?>">
        <br/><br/>
        
        Valor:
        <input type="number" name="valor" value="<?php echo $valor; ?>">
        <br/><br/>
        Nombre Proveedor:
        <input type="number" name="edad" value="<?php echo $edad; ?>">
        <br/><br/>
        <input type="submit" value="Buscar por OR"/>  
        <a href="full_pedidos_and.php"><input type="button" value="Ir a buscar por AND"></a>
        <hr/>
    </form>    

    <h1>Lista de consultas</h1>
    <table border="1">
        <tr>
            <td><b>Nombre Cliente</b></td>
            <td><b>Fecha entrega</b></td>
            <td><b>Nombre Producto</b></td>
            <td><b>Valor</b></td>
            <td><b>Nombre Proveedor</b></td>            
        </tr>
<?php
    for($i=0; $i<count($pedidos); $i++){
?>    
    <tr>
        <td> 
            <?php echo $pedidos[$i]["nombre_cli"] ?> 
        </td>


        <td>
            <?php echo $pedidos[$i]["fecha_entrega"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["nombre_pro"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["valor"] ?>
        </td>

        <td>
            <?php echo $pedidos[$i]["nombre_proveedor"] ?>
        </td>
    </tr>
<?php  
    }
?>    
</center>
    </table>
                
                </td>
                <td><hr/><hr/><hr/><img src="imagenes/logo.jpeg"" alt="Imagen"><hr/><hr/><hr/></td> 
                       
    </tr>
    </table>
 
</body>
</html>