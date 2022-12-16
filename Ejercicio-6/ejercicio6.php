<!DOCTYPE HTML>

<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio6</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name="author" content="Sergio" />
    <meta name="description" content="Ejercicio6" />

    <!--Definición de la ventana gráfica-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="ejercicio6.css" />
    <?php
    session_start();
    class BaseDatos
    {

        protected $string = "";
        public function __construct()
        {

        }
        public function crearbd()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";


            $db = new mysqli($servername, $username, $password);


            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }


            $cadenaSQL = "CREATE DATABASE IF NOT EXISTS SEWPHP COLLATE utf8_spanish_ci";
            if ($db->query($cadenaSQL) === TRUE) {
                $this->string = "<p>Base de datos 'SEWPHP' creada con éxito</p>";
            } else {
                $this->string = "<p>ERROR en la creación de la Base de Datos 'SEWPHP'. Error: " . $db->error . "</p>";
                exit();
            }

            $db->close();
        }
        public function create()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";


            $db = new mysqli($servername, $username, $password);

            //selecciono la base de datos AGENDA para utilizarla
            $db->select_db($database);

            // se puede abrir y seleccionar a la vez
            //$db = new mysqli($servername,$username,$password,$database);
    
            //Crear la tabla persona DNI, Nombre, Apellido
            $crearTabla = "CREATE TABLE IF NOT EXISTS PruebasUsabilidad (dni INT NOT NULL AUTO_INCREMENT, 
                        nombre VARCHAR(255) NOT NULL, 
                        apellidos VARCHAR(255) NOT NULL, 
                        email VARCHAR(255) NOT NULL, 
                        telefono VARCHAR(255) NOT NULL,  
                        edad INT NOT NULL, 
                        sexo VARCHAR(255) NOT NULL, 
                        pericia INT NOT NULL, 
                        tiempo INT NOT NULL, 
                        exito BIT NOT NULL, 
                        comentarios VARCHAR(255) NOT NULL, 
                        propuestas VARCHAR(255) NOT NULL, 
                        valoracion INT NOT NULL, 
                        PRIMARY KEY (dni))";

            if ($db->query($crearTabla) === TRUE) {
                $this->string = "<p>Tabla 'PruebasUsabilidad' creada con éxito </p>";
            } else {
                $this->string = "<p>ERROR en la creación de la tabla PruebasUsabilidad. Error : " . $db->error . "</p>";
                exit();
            }
            //cerrar la conexión
            $db->close();

        }

        public function insert()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($servername, $username, $password, $database);


            // comprueba la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }

            //prepara la sentencia de inserción
            $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, 
            sexo, pericia, tiempo, exito, comentarios, propuestas, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $consultaPre->bind_param(
                'ssssiisiiisss',
                $_POST["id"]
                , $_POST["nombre"]
                , $_POST["apellidos"]
                , $_POST["email"]
                , $_POST["telefono"]
                , $_POST["edad"]
                , $_POST["sexo"]
                , $_POST["pericia"]
                , $_POST["tiempo"]
                , $_POST["exito"]
                , $_POST["comentarios"]
                , $_POST["propuestas"]
                , $_POST["valoracion"]

            );

            //ejecuta la sentencia
            $consultaPre->execute();

            //muestra los resultados
            $this->string = "<p>Filas agregadas: " . $consultaPre->affected_rows . "</p>";

            $consultaPre->close();

            //cierra la base de datos
            $db->close();

        }

        public function select()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            //consultar la tabla persona
            $resultado = $db->prepare('SELECT * FROM PruebasUsabilidad WHERE dni = ?');

            $resultado->bind_param(
                's',
                $_POST["idcon"]


            );
            $resultado->execute();
            $res = $resultado->get_result();



            // compruebo los datos recibidos     
            if ($res->num_rows > 0) {
                // Mostrar los datos en un lista
                $this->string = "<p>Los datos en la tabla 'PruebasUsabilidad' son: </p>";
                $this->string .= "<p>Número de filas = " . $res->num_rows . "</p>";
                $this->string .= "<ul>";
                $this->string .= "<li>" . 'nombre' . " - " . 'apellidos' . " - " . 'email' .
                    " - " . 'telefono' . " - " . 'edad' . " - " . 'sexo' . " - " . 'pericia' .
                    " - " . 'tiempo' . " - " . 'exito' . " - " . 'comentarios' . " - " . 'propuestas' .
                    " - " . 'valoracion' . "</li>";
                while ($row = $res->fetch_assoc()) {
                    $this->string .= "<li>" . $row['nombre'] . " - " . $row['apellidos'] . " - " . $row['email'] .
                        " - " . $row['telefono'] . " - " . $row['edad'] . " - " . $row['sexo'] . " - " . $row['pericia'] .
                        " - " . $row['tiempo'] . " - " . $row['exito'] . " - " . $row['comentarios'] . " - " . $row['propuestas'] .
                        " - " . $row['valoracion'] .
                        "</li>";
                }
                $this->string .= "</ul>";
            } else {
                $this->string = "<p>Tabla vacía. Número de filas = " . $res->num_rows . "</p>";
            }
            //cerrar la conexión
            $db->close();
        }
        public function update()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($servername, $username, $password, $database);


            // comprueba la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }

            //prepara la sentencia de inserción
            $consultaPre = $db->prepare("UPDATE PruebasUsabilidad SET  nombre=?, apellidos=?, email=?, telefono=?, edad=?, 
            sexo=?, pericia=?, tiempo=?, exito=?, comentarios=?, propuestas=?, valoracion=? WHERE dni=? ");

            $consultaPre->bind_param(
                'ssssiisiiisss',

                $_POST["nombre"]
                , $_POST["apellidos"]
                , $_POST["email"]
                , $_POST["telefono"]
                , $_POST["edad"]
                , $_POST["sexo"]
                , $_POST["pericia"]
                , $_POST["tiempo"]
                , $_POST["exito"]
                , $_POST["comentarios"]
                , $_POST["propuestas"]
                , $_POST["valoracion"]
                , $_POST["id"]

            );

            //ejecuta la sentencia
            $consultaPre->execute();

            //muestra los resultados
            $this->string = "<p>Filas modificadas: " . $consultaPre->affected_rows . "</p>";

            $consultaPre->close();

            //cierra la base de datos
            $db->close();

        }
        public function delete()
        {
            //Versión 1.1 22/Noviembre/2020 Juan Manuel Cueva Lovelle. Universidad de Oviedo
            //datos de la base de datos
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";


            // Conexión al SGBD local con el usuario creado previamente en XAMPP
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }

            //prepara la consulta
            $consultaPre = $db->prepare("DELETE FROM PruebasUsabilidad WHERE dni = ?");

            //obtiene los parámetros de la variable predefinida $_POST
            // s indica que dni es un string
            $consultaPre->bind_param('s', $_POST["idcon"]);


            //ejecuta la consulta
            $consultaPre->execute();
            if ($consultaPre->affected_rows > 0) {
                $this->string = "<p>Elemento/s borrado/s</p>";
            } else {
                $this->string = "<p>No existen elementos</p>";
            }


            //cerrar la conexión
            $db->close();
        }
        public function informe()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            //consultar la tabla persona
            $resultado = $db->prepare('SELECT * FROM PruebasUsabilidad');

            $resultado->execute();
            $res = $resultado->get_result();
            $c = 0;
            $d1 = 0; //media edad
            $d2 = 0; //Porcentaje sexo
            $d3 = 0; //media pericia
            $d4 = 0; //media tiempo
            $d5 = 0; //Porcentaje exito
            $d6 = 0; //media valoracion
    



            // compruebo los datos recibidos     
            if ($res->num_rows > 0) {
                // Mostrar los datos en un lista
                $this->string = "<p>Informe de la tabla 'PruebasUsabilidad': </p>";
                while ($row = $res->fetch_assoc()) {
                    $c++;
                    $d1 += $row['edad'];
                    if ($row['sexo'] == "Hombre") {
                        $d2 += 1;
                    }
                    $d3 += $row['pericia'];

                    $d4 += $row['tiempo'];

                    $d5 += $row['exito'];

                    $d6 += $row['valoracion'];


                }
            } else {
                $this->string = "<p>Tabla vacía. Número de filas = " . $res->num_rows . "</p>";
            }
            $this->string .= "<ul>
            <li>Edad media de los usuarios = " . $d1 / $c . "</li>
            <li>Frecuencia del sexo de los usuarios = " . $d2 / $c * 100 . "% de hombres, y " . (100 - $d2 / $c * 100) . "% de mujeres</li>
            <li>Pericia media de los usuarios = " . $d3 / $c . "</li>
            <li>Tiempo medio de los usuarios = " . $d4 / $c . " segundos</li>
            <li>Tasa de éxito de los usuarios = " . ($d5 / $c * 100) . "% de éxito</li>
            <li>Valoración media de los usuarios = " . $d6 / $c . "</li>
            
            </ul>";


            //cerrar la conexión
            $db->close();

        }
        public function importar()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            $fileName = $_FILES["subir"]["tmp_name"];



            if ($_FILES["subir"]["type"] != "text/csv") {
                $this->string = "<p>Archivo con formato incorrecto o no subido.</p>";
                return;
            }



            // $fileName = basename('pruebasUsabilidad.csv');
            $filePath = '' . $fileName;
            if (!empty($fileName) && file_exists($filePath)) {
                $file = fopen($fileName, "r");

                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, 
                    sexo, pericia, tiempo, exito, comentarios, propuestas, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $consultaPre->bind_param(
                        'ssssiisiiisss'
                        , $getData[0]
                        , $getData[1]
                        , $getData[2]
                        , $getData[3]
                        , $getData[4]
                        , $getData[5]
                        , $getData[6]
                        , $getData[7]
                        , $getData[8]
                        , $getData[9]
                        , $getData[10]
                        , $getData[11]
                        , $getData[12]

                    );


                    $result = $consultaPre->execute();
                    if (isset($result)) {
                        $this->string = "<p>CSV importado con exito</p>";
                    } else {
                        $this->string = "<p>Error al importar CSV.</p>";
                    }
                }

                fclose($file);
            }
        }
        public function exportar()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "SEWPHP";

            $db = new mysqli($servername, $username, $password, $database);

            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }


            $res = $db->prepare('SELECT * FROM PruebasUsabilidad');

            $res->execute();
            $resultado = $res->get_result();

            if ($resultado) {

                $file = fopen('pruebasUsabilidad.csv', 'w');


                while ($row = mysqli_fetch_assoc($resultado)) {

                    fputcsv($file, $row);


                }
                fclose($file);




            } else {
                $this->string = "<p>Error al exportar CSV.</p>";

                return;
            }


        }

        public function getString()
        {
            return $this->string;
        }





    }
    if (!isset($_SESSION['bd'])) {
        $_SESSION['bd'] = new BaseDatos();
    }
    $bd = $_SESSION['bd'];

    if (count($_POST) > 0) {
        if (isset($_POST['crearbd']))
            $bd->crearbd();
        if (isset($_POST['create']))
            $bd->create();
        if (isset($_POST['insert']))
            $bd->insert();
        if (isset($_POST['select']))
            $bd->select();
        if (isset($_POST['update']))
            $bd->update();
        if (isset($_POST['delete']))
            $bd->delete();
        if (isset($_POST['informe']))
            $bd->informe();
        if (isset($_POST['importar']))
            $bd->importar();
        if (isset($_POST['exportar']))
            $bd->exportar();
        if (isset($_POST['subir']))
            $bd->importar();
    }

    $_SESSION['bd'] = $bd;
    ?>
</head>

<body>
    <h1>Panel de opciones de la base de datos</h1>
    <form action='#' method='post' name='preciosoro' enctype='multipart/form-data'>
        <input type="submit" name="crearbd" value="Crear Base de Datos" title="Crear Base de Datos">
        <input type="submit" name="create" value="Crear una tabla" title="Crear una tabla">
        <p>Dni: <input type="text" name="id" /></p>
        <p>Nombre: <input type="text" name="nombre" /></p>
        <p>Apellidos: <input type="text" name="apellidos" /></p>
        <p>E-mail: <input type="text" name="email" /></p>
        <p>Teléfono: <input type="number" name="telefono" /></p>
        <p>Edad: <input type="number" name="edad" /></p>
        <p>Sexo: <input type="text" name="sexo" /></p>
        <p>Pericia informática: <input type="number" name="pericia" /></p>
        <p>Tiempo empleado: <input type="number" name="tiempo" /></p>
        <p>Éxito en completar la tarea (0 no completada, 1 completada): <input type="number" name="exito" max=1 min=0 />
        </p>
        <p>Comentarios: <input type="text" name="comentarios" /></p>
        <p>Propuestas: <input type="text" name="propuestas" /></p>
        <p>Valoración: <input type="number" name="valoracion" max=10 min=0 /></p>
        <input type="submit" name="insert" value="Insertar datos en una tabla" title="Insertar datos en una tabla">
        <p>Dni para buscar o eliminar: <input type="text" name="idcon" /></p>
        <input type="submit" name="select" value="Buscar datos en una tabla" title="Buscar datos en una tabla">
        <input type="submit" name="update" value="Modificar datos en una tabla" title="Modificar datos en una tabla">
        <input type="submit" name="delete" value="Eliminar datos de una tabla" title="Eliminar datos de una tabla">
        <input type="submit" name="informe" value="Generar informe" title="Generar informe">
        <input type="submit" name="exportar"
            value="Exportar datos a un archivo en formato CSV los datos desde una tabla de la Base de Datos"
            title="Exportar datos a un archivo en formato CSV los datos desde una tabla de la Base de Datos">

        <label for='subir'>Sube tu CSV para crear las entradas</label><br>
        <input type='file' id='subir' name='subir' />
        <input type='submit' value='Cargar datos desde un archivo CSV en una tabla de la Base de Datos' name='subir' />



    </form>
    <main>
        <p>
            <?php echo $bd->getString() ?>
        </p>
    </main>
</body>