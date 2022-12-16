<!DOCTYPE HTML>

<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio7</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name="author" content="Sergio" />
    <meta name="description" content="Ejercicio7" />

    <!--Definición de la ventana gráfica-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="ejercicio7.css" />
    <?php
    session_start();
    class BaseDatos
    {

        protected $string = "";
        protected $state = "";
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


            $cadenaSQL = "CREATE DATABASE IF NOT EXISTS EJ7SEW COLLATE utf8_spanish_ci";
            if ($db->query($cadenaSQL) === TRUE) {
                $this->string = "<p>Base de datos 'EJ7SEW' creada con éxito</p>";
            } else {
                $this->string = "<p>ERROR en la creación de la Base de Datos 'EJ7SEW'. Error: " . $db->error . "</p>";
                exit();
            }

            $db->close();
        }
        public function getState()
        {
            return $this->state;
        }

        public function er()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($servername, $username, $password, $database);


            // comprueba la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }

            try {
                $consultaPre = $db->prepare("DROP TABLE `circuito`, `coche`, `equipo`, `etapa`, `pais`, `piloto`, `piloto_etapa`");
                $consultaPre->execute();
            } catch (Throwable $e) {

            }
            try {
                $consultaPre = $db->prepare("DROP TABLE `circuito`, `coche`, `equipo`, `etapa`, `pais`, `piloto`, `piloto_etapa`");
                $consultaPre->execute();
            } catch (Throwable $e) {

            }
            try {
                $consultaPre = $db->prepare("DROP TABLE `circuito`, `coche`, `equipo`, `etapa`, `pais`, `piloto`, `piloto_etapa`");
                $consultaPre->execute();
            } catch (Throwable $e) {

            }

            $consultaPre->close();

            //cierra la base de datos
            $db->close();

        }
        public function create()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";
            try {
                $this->er();
            } catch (Throwable $e) {

            }

            $db = new mysqli($servername, $username, $password);

            //selecciono la base de datos AGENDA para utilizarla
            $db->select_db($database);

            // se puede abrir y seleccionar a la vez
            //$db = new mysqli($servername,$username,$password,$database);
    
            //Crear las tablas
            $crearTablaPais = "CREATE TABLE IF NOT EXISTS PAIS (
                    id_pais VARCHAR(255) NOT NULL, 
                        nombre VARCHAR(255) NOT NULL, 
                        aficionados INT NOT NULL, 
                        PRIMARY KEY (id_pais))";

            if ($db->query($crearTablaPais) === TRUE) {
                $this->string = "<p>Tabla 'PAIS' creada con éxito </p>";
            } else {
                $this->string = "<p>ERROR en la creación de la tabla PAIS. Error : " . $db->error . "</p>";
                exit();
            }
            //CIRCUITO
            $crearTablaCircuito = "CREATE TABLE IF NOT EXISTS CIRCUITO (id_circuito VARCHAR(255) NOT NULL , 
                        nombre VARCHAR(255) NOT NULL, 
                        longitud INT NOT NULL, 
                        id_pais VARCHAR(255) NOT NULL,
                        PRIMARY KEY (id_circuito),
                        FOREIGN KEY (id_pais) REFERENCES PAIS(id_pais))";

            if ($db->query($crearTablaCircuito) === TRUE) {
                $this->string .= "<p>Tabla 'CIRCUITO' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla CIRCUITO. Error : " . $db->error . "</p>";
                exit();
            }
            //EQUIPO
            $crearTablaEquipo = "CREATE TABLE IF NOT EXISTS EQUIPO (id_equipo VARCHAR(255) NOT NULL , 
                        nombre VARCHAR(255) NOT NULL, 
                        presupuesto INT NOT NULL, 
                        PRIMARY KEY (id_equipo))";

            if ($db->query($crearTablaEquipo) === TRUE) {
                $this->string .= "<p>Tabla 'EQUIPO' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla EQUIPO. Error : " . $db->error . "</p>";
                exit();
            }
            //PILOTO
            $crearTablaPiloto = "CREATE TABLE IF NOT EXISTS PILOTO (id_piloto VARCHAR(255) NOT NULL , 
                        nombre VARCHAR(255) NOT NULL, 
                        apellidos VARCHAR(255) NOT NULL, 
                        id_equipo VARCHAR(255) NOT NULL,
                        PRIMARY KEY (id_piloto),
                        FOREIGN KEY (id_equipo) REFERENCES EQUIPO(id_equipo))";

            if ($db->query($crearTablaPiloto) === TRUE) {
                $this->string .= "<p>Tabla 'PILOTO' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla PILOTO. Error : " . $db->error . "</p>";
                exit();
            }
            //COCHE
            $crearTablaCoche = "CREATE TABLE IF NOT EXISTS COCHE (id_coche VARCHAR(255) NOT NULL , 
                        nombre VARCHAR(255) NOT NULL, 
                        caballos INT NOT NULL, 
                        id_piloto VARCHAR(255) NOT NULL,
                        PRIMARY KEY (id_coche),
                        FOREIGN KEY (id_piloto) REFERENCES PILOTO(id_piloto))";

            if ($db->query($crearTablaCoche) === TRUE) {
                $this->string .= "<p>Tabla 'COCHE' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla COCHE. Error : " . $db->error . "</p>";
                exit();
            }


            //ETAPA
            $crearTablaEtapa = "CREATE TABLE IF NOT EXISTS ETAPA (id_etapa VARCHAR(255) NOT NULL , 
                        nombre VARCHAR(255) NOT NULL, 
                        espectadores INT NOT NULL, 
                        patrocinador VARCHAR(255) NOT NULL,
                        id_circuito VARCHAR(255) NOT NULL,
                        PRIMARY KEY (id_etapa),
                        FOREIGN KEY (id_circuito) REFERENCES CIRCUITO(id_circuito))";

            if ($db->query($crearTablaEtapa) === TRUE) {
                $this->string .= "<p>Tabla 'ETAPA' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla ETAPA. Error : " . $db->error . "</p>";
                exit();
            }
            //PILOTO ETAPA
            $crearTablaPE = "CREATE TABLE IF NOT EXISTS PILOTO_ETAPA (
                id_piloto VARCHAR(255) NOT NULL, 
                id_etapa VARCHAR(255) NOT NULL, 
                tiempo VARCHAR(255) NOT NULL, 
                FOREIGN KEY (id_piloto) REFERENCES PILOTO(id_piloto),
                FOREIGN KEY (id_etapa) REFERENCES ETAPA(id_etapa))";

            if ($db->query($crearTablaPE) === TRUE) {
                $this->string .= "<p>Tabla 'PILOTO_ETAPA' creada con éxito </p>";
            } else {
                $this->string .= "<p>ERROR en la creación de la tabla PILOTO_ETAPA. Error : " . $db->error . "</p>";
                exit();
            }



            //cerrar la conexión
            $db->close();
            $this->insertarDatos();
            /*
            try {
            $this->insertarDatos();
            } catch (Throwable $e) {
            $this->string = "Datos ya existentes";
            }
            */

        }


        public function insertarDatos()
        {
            //PAIS CIRCUITO EQUIPO PILOTO COCHE ETAPA PILOTO-ETAPA
    
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($servername, $username, $password, $database);


            // comprueba la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }

            $consultaPre = $db->prepare("INSERT INTO PAIS VALUES ('1','Finlandia',1500)");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre2 = $db->prepare("INSERT INTO PAIS VALUES ('2','Australia',6000)");
            $consultaPre2->execute();
            $consultaPre2->close();

            $consultaPre3 = $db->prepare("INSERT INTO PAIS VALUES ('3','Kenia',400)");
            $consultaPre3->execute();
            $consultaPre3->close();

            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('1','fin_1',320,'1')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('2','fin_2',221,'1')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('3','fin_3',234,'1')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('4','aus_1',121,'2')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('5','aus_2',452,'2')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO CIRCUITO VALUES ('6','ken_1',109,'3')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO EQUIPO VALUES ('1','Toyota',700000)");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO EQUIPO VALUES ('2','Subaru',500000)");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO PILOTO VALUES ('1','Collin','Mcrae', '1')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO PILOTO VALUES ('2','Carlos','Sainz','2')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO COCHE VALUES ('1','Toyota Corolla',270, '2')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO COCHE VALUES ('2','Subaru Impreza',235,'1')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO ETAPA VALUES ('1','Etapa-1-WRC',420,'Red Bull','3')");
            $consultaPre->execute();
            $consultaPre->close();
            $consultaPre = $db->prepare("INSERT INTO ETAPA VALUES ('2','Etapa-2-WRC',235, 'Malboro','6')");
            $consultaPre->execute();
            $consultaPre->close();



            //cierra la base de datos
            $db->close();

        }
        public function insert()
        {
            //PAIS CIRCUITO EQUIPO PILOTO COCHE ETAPA PILOTO-ETAPA
    
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($servername, $username, $password, $database);


            // comprueba la conexion
            if ($db->connect_error) {
                exit("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");
            } else {
                $this->string = "<h2>Conexión establecida</h2>";
            }
            try {
                $aux = rand(1, 3) . ":" . rand(10, 59) . ":" . rand(10, 40) . "." . rand(0, 999);
                $consultaPre = $db->prepare("INSERT INTO PILOTO_ETAPA VALUES (?,?,?)");
                $consultaPre->bind_param(
                    'sss',
                    $_POST["idpiloto"],
                    $_POST["idetapa"],
                    $aux


                );
                $consultaPre->execute();
                $consultaPre->close();
                $this->state = "<p>Tiempo cronometrado</p>";
            } catch (Throwable $e) {
                $this->state = "<p>Has introducido datos erróneos</p>";

            }



            //cierra la base de datos
            $db->close();

        }

        public function select()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

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
        public function getPilotos()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            //consultar la tabla persona
            $resultado = $db->prepare('SELECT * FROM Piloto');

            $resultado->execute();
            $res = $resultado->get_result();


            $aux = "";
            // compruebo los datos recibidos     
            if ($res->num_rows > 0) {
                // Mostrar los datos en un lista
                $aux = "<p>Pilotos disponibles: </p>";
                $aux .= "<p>Número de pilotos = " . $res->num_rows . "</p>";
                $aux .= "<ul>";
                $aux .= "<li>" . 'id' . " - " . 'nombre' . " - " . 'apellidos' . "</li>";
                while ($row = $res->fetch_assoc()) {
                    $aux .= "<li>" . $row['id_piloto'] . " - " . $row['nombre'] . " - " . $row['apellidos'] .
                        "</li>";
                }
                $aux .= "</ul>";
            } else {
                $aux = "<p>Tabla vacía. Número de filas = " . $res->num_rows . "</p>";
            }
            //cerrar la conexión
            $db->close();
            return $aux;
        }


        public function getEtapas()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            //consultar la tabla persona
            $resultado = $db->prepare('SELECT * FROM Etapa');

            $resultado->execute();
            $res = $resultado->get_result();


            $aux = "";
            // compruebo los datos recibidos     
            if ($res->num_rows > 0) {
                // Mostrar los datos en un lista
                $aux = "<p>Etapas disponibles: </p>";
                $aux .= "<p>Número de etapas = " . $res->num_rows . "</p>";
                $aux .= "<ul>";
                $aux .= "<li>" . 'id' . " - " . 'nombre' . " - " . 'espectadores' . "</li>";
                while ($row = $res->fetch_assoc()) {
                    $aux .= "<li>" . $row['id_etapa'] . " - " . $row['nombre'] . " - " . $row['espectadores'] .
                        "</li>";
                }
                $aux .= "</ul>";
            } else {
                $this->string = "<p>Tabla vacía. Número de filas = " . $res->num_rows . "</p>";
            }
            //cerrar la conexión
            $db->close();
            return $aux;

        }

        public function getTiempos()
        {

            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

            // Conexión al SGBD local. En XAMPP el usuario debe estar creado previamente 
            $db = new mysqli($servername, $username, $password, $database);

            // compruebo la conexion
            if ($db->connect_error) {
                exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
            } else {
                $this->string = "<p>Conexión establecida con " . $db->host_info . "</p>";
            }

            //consultar la tabla persona
            $resultado = $db->prepare('SELECT * FROM piloto_etapa');

            $resultado->execute();
            $res = $resultado->get_result();


            $aux = "<p>Datos introducidos erróneos</p>";
            // compruebo los datos recibidos     
            if ($res->num_rows > 0) {
                // Mostrar los datos en un lista
                $aux = "<p>Tiempos disponibles: </p>";
                $aux .= "<p>Número de tiempos = " . $res->num_rows . "</p>";
                $aux .= "<ul>";
                $aux .= "<li>" . 'piloto' . " - " . 'etapa' . " - " . 'tiempo' . "</li>";
                while ($row = $res->fetch_assoc()) {
                    $aux .= "<li>" . $row['id_piloto'] . " - " . $row['id_etapa'] . " - " . $row['tiempo'] .
                        "</li>";
                }
                $aux .= "</ul>";
            } else {
                $this->string = "<p>Tabla vacía. Número de filas = " . $res->num_rows . "</p>";
            }
            //cerrar la conexión
            $db->close();
            return $aux;

        }






        public function update()
        {
            $servername = "localhost";
            $username = "DBUSER2022";
            $password = "DBPSWD2022";
            $database = "EJ7SEW";

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
            $database = "EJ7SEW";


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
            $database = "EJ7SEW";

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
            $database = "EJ7SEW";

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
            $database = "EJ7SEW";

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
        <input type="submit" name="create" value="Crear una tabla" title="Crear las tablas">
        <p>Id del piloto: <input type="text" name="idpiloto" /></p>
        <p>Id de la etapa: <input type="text" name="idetapa" /></p>
        <input type="submit" name="insert" value="Cronometrar tiempo" title="Cronometrar tiempo">




    </form>
    <main>
        <p>
            <?php echo $bd->getPilotos() ?>
            <?php echo $bd->getEtapas() ?>
            <?php echo $bd->getTiempos() ?>
            <?php echo $bd->getState() ?>
        </p>
    </main>
</body>
</body>