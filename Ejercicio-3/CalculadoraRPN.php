<!DOCTYPE HTML>

<html lang="es">

<head>


    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Asignatura</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name="author" content="Sergio" />
    <meta name="description" content="Ejercicio 1 de javascript" />
    <meta name="keywords"
        content="aquí cada documento debe tener la lista de las palabras clave del mismo separadas por comas" />

    <!--Definición de la ventana gráfica-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css" />
    <?php
    session_start();

    class PilaLIFO
    {
        protected $m;
        protected $pila;
        protected $tamagnoMax; //número de elementos máximo que se pueden almacenar en la pila
    
        public function __construct($tamagnoMax = 5)
        {
            // Crea la pila con un array con 5 elementos como máximo (valor por defecto)
            $this->pila = array();
            // El tamaño es el número máximo de elementos en la pila
            $this->tamagnoMax = $tamagnoMax;
        }

        public function apilar($elemento)
        {
            // precondición: Comprueba que la pila no supere el tamaño máximo
            if ($this->longitud() < $this->tamagnoMax) {
                // inserta un elemento en la cabeza del array
                array_unshift($this->pila, $elemento);
            } else {
                throw new RunTimeException('¡Pila llena: no hay espacio para apilar más elementos!');
            }
        }

        public function desapilar()
        {
            try {
                //precondición: comprueba que la pila no esté vacía    
                if ($this->vacia()) {
                    throw new RunTimeException('¡Pila vacía! No se pueden desapilar elementos');
                } else {
                    // desapila un elemento del inicio del array
                    return array_shift($this->pila);
                }
            } catch (Throwable $e) {

            }

        }

        public function getTamagnoMax()
        {
            //devuelve el número de elementos máximo que se pueden almacenar en la pila
            return $this->tamagnoMax;
        }

        public function longitud()
        {
            //devuelve el número de elementos de la pila
            return count($this->pila);
        }

        public function ultimo()
        {
            return current($this->pila);
        }

        public function vacia()
        {
            return empty($this->pila);
        }

        public function ver()
        {
            $aux = "";
            foreach ($this->pila as &$valor) {
                $aux = $aux . "\n" . $valor;
            }
            return $aux;
        }

    }


    class CalculadoraRPN
    {

        protected $deg;
        protected $rep;
        protected $current;
        protected $mode;
        protected $pila;

        function __construct()
        {
            $this->deg = "D";
            $this->rep = "F";
            $this->m = "";
            $this->current = "";
            $this->mode = "N";
            $this->pila = new PilaLIFO("Pila:");
        }

        function digitos($n)
        {
            $this->current = $this->current . $n;



        }
        function punto()
        {
            $this->current = $this->current . ".";



        }
        public function fact()
        {
            $this->current = $this->fac($this->current);

        }
        public function fac($n)
        {
            if ($n == 0) {
                return 1;
            } else {
                return $n * $this->fac($n - 1);
            }

        }
        function suma()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($a) + ($b);
            $this->pila->apilar($c);
            $this->current = "";

        }
        function enter()
        {
            if ($this->current == "") {
                $this->current = "0";
            }

            $this->pila->apilar($this->current);


            $this->current = "";

        }
        function mostrar()
        {
            $stringPila = "";
            foreach ($this->pila->pila as $i) {
                $stringPila .= "\n" + $this->pila->pila[$i];
            }
            return $stringPila;


        }
        function resta()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($b) - ($a);
            $this->pila->apilar($c);
            $this->current = "";


        }
        function elevar()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($b) ** ($a);
            $this->pila->apilar($c);
            $this->current = "";


        }
        function multiplicacion()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($b) * ($a);
            $this->pila->apilar($c);
            $this->current = "";


        }
        function division()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($b) / ($a);
            $this->pila->apilar($c);
            $this->current = "";


        }
        function cambiarsigno()
        {
            $this->current = ($this->current) * -1;
        }
        function log()
        {
            $this->current = log($this->current);
        }
        function borrarDigito()
        {
            $this->current = substr($this->current, 0, -1);
        }
        function sin()
        {
            if ($this->deg == "D") {
                $this->current = $this->current * pi() / 180;
            }
            if ($this->mode == "N") {
                $this->current = sin($this->current);
            }
            if ($this->mode == "H") {
                $this->current = sinh(($this->current));
            }
            if ($this->mode == "A") {
                $this->current = asin(($this->current));
            }

        }
        function cos()
        {
            if ($this->deg == "D") {
                $this->current = $this->current * Math . PI / 180;
            }
            if ($this->mode == "N") {
                $this->current = cos(($this->current));
            }
            if ($this->mode == "H") {
                $this->current = cosh(($this->current));
            }
            if ($this->mode == "A") {
                $this->current = acos(($this->current));
            }

        }

        function tan()
        {
            if ($this->deg == "D") {
                $this->current = $this->current * pi() / 180;
            }
            if ($this->mode == "N") {
                $this->current = tan(($this->current));
            }
            if ($this->mode == "H") {
                $this->current = tanh(($this->current));
            }
            if ($this->mode == "A") {
                $this->current = atan(($this->current));
            }

        }
        function exp()
        {

            $this->current = exp(($this->current));

        }
        function cuadrado()
        {

            $this->current = ($this->current) ** 2;

        }
        function raiz()
        {

            $this->current = ($this->current) ** (1 / 2);

        }
        function mod()
        {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $c = ($b) % ($a);
            $this->pila->apilar($c);
            $this->current = "";


        }
        function mClear()
        {
            $this->m = "0";
        }
        function mReturn()
        {
            $this->current = $this->m;

        }
        function mMenos()
        {
            $this->m = $this->m - ($this->current);
        }
        function mMas()
        {
            $this->m = ($this->m) + ($this->current);
        }
        function mSave()
        {
            $this->m = $this->current;
        }
        function borrar()
        {
            $this->current = "";

        }
        function borrarE()
        {
            $this->pila = new PilaLIFO();

        }
        function pi()
        {
            $this->current = pi();

        }
        function setA()
        {
            if ($this->mode == "N" || $this->mode == "H") {
                $this->mode = "A";
            } else if ($this->mode == "A") {
                $this->mode = "N";
            }

        }

        function setH()
        {

            if ($this->mode == "N" || $this->mode == "A") {

                $this->mode = "H";
            } else if ($this->mode == "H") {

                $this->mode = "N";
            }

        }
        function toggleRep()
        {
            if ($this->rep == "F") {
                $this->rep = "E";
            } else {
                $this->rep = "F";
            }

        }
        function toggleDeg()
        {
            if ($this->deg == "D") {
                $this->deg = "R";

            } else {
                $this->deg = "D";

            }
        }
        function getPantalla()
        {
            return $this->current;
        }
        function getPila()
        {
            return $this->pila->ver();
        }
        function getDeg()
        {
            return $this->deg;
        }

        function getSh()
        {
            return $this->mode;
        }


    }








    if (!isset($_SESSION['calculadorar'])) {
        $_SESSION['calculadorar'] = new CalculadoraRPN();
    }

    $calculadora = $_SESSION['calculadorar'];
    if (count($_POST) > 0) {

        if (isset($_POST['1']))
            $calculadora->digitos("1");
        if (isset($_POST['2']))
            $calculadora->digitos("2");
        if (isset($_POST['3']))
            $calculadora->digitos("3");
        if (isset($_POST['4']))
            $calculadora->digitos("4");
        if (isset($_POST['5']))
            $calculadora->digitos("5");
        if (isset($_POST['6']))
            $calculadora->digitos("6");
        if (isset($_POST['7']))
            $calculadora->digitos("7");
        if (isset($_POST['8']))
            $calculadora->digitos("8");
        if (isset($_POST['9']))
            $calculadora->digitos("9");
        if (isset($_POST['0']))
            $calculadora->digitos("0");
        if (isset($_POST['.']))
            $calculadora->digitos(".");
        if (isset($_POST['+']))
            $calculadora->suma();
        if (isset($_POST['-']))
            $calculadora->resta();
        if (isset($_POST['x']))
            $calculadora->multiplicacion();
        if (isset($_POST['/']))
            $calculadora->division();
        if (isset($_POST['√']))
            $calculadora->raiz();
        if (isset($_POST['CE']))
            $calculadora->borrar();
        if (isset($_POST['+/-']))
            $calculadora->cambiarsigno();
        if (isset($_POST['M+']))
            $calculadora->mMas();
        if (isset($_POST['M-']))
            $calculadora->mMenos();
        if (isset($_POST['DEG']))
            $calculadora->toggleDeg();
        if (isset($_POST['MC']))
            $calculadora->mClear();
        if (isset($_POST['MR']))
            $calculadora->mReturn();
        if (isset($_POST['sin']))
            $calculadora->sin();
        if (isset($_POST['cos']))
            $calculadora->cos();
        if (isset($_POST['tan']))
            $calculadora->tan();
        if (isset($_POST['Exp']))
            $calculadora->exp();
        if (isset($_POST['Mod']))
            $calculadora->mod();
        if (isset($_POST['↑']))
            $calculadora->setA();
        if (isset($_POST['←']))
            $calculadora->borrarDigito();
        if (isset($_POST['π']))
            $calculadora->pi();
        if (isset($_POST['C']))
            $calculadora->borrar();
        if (isset($_POST['CE']))
            $calculadora->borrarE();
        if (isset($_POST['HYP']))
            $calculadora->setH();
        if (isset($_POST['F-E']))
            $calculadora->toggleRep();
        if (isset($_POST['log']))
            $calculadora->log();
        if (isset($_POST['x^y']))
            $calculadora->elevar();
        if (isset($_POST['x^2']))
            $calculadora->cuadrado();
        if (isset($_POST['Enter']))
            $calculadora->enter();
        if (isset($_POST['dot']))
            $calculadora->punto();
        if (isset($_POST['n!']))
            $calculadora->fact();




    }


    $_SESSION['calculadora'] = $calculadora;
    ?>
</head>

<body>

    <script src="CalculadoraRPN.js"></script>
    <form action='#' method='post' name='calculadora'>

        <main>
            <script src="CalculadoraRPN.js"></script>



            <textarea id="pila" name="pila" cols="50" disabled>
            <?php echo $calculadora->getPila() ?>

        </textarea>
            <label for="pila">Calculadora cientifica

            </label>
            <input type="text" name="pantalla" id="pantalla" value='<?php echo $calculadora->getPantalla() ?>' lang="es"
                disabled />
            <label for="pantalla">Milan |
                <?php echo $calculadora->getDeg() ?>
                <?php echo $calculadora->getSh() ?> |
            </label>

            <input type="submit" name="DEG" value="DEG" title="DEG">
            <input type="submit" name="HYP" value="HYP" title="HYP">
            <input type="submit" name="F-E" value="F-E" title="F-E">

            <aside>

            </aside>
            <input type="submit" name="MC" value="MC" title="MC">
            <input type="submit" name="MR" value="MR" title="MR">
            <input type="submit" name="M-" value="M-" title="r">
            <input type="submit" name="M+" value="M+" title="r">
            <input type="submit" name="MS" value="MS" title="MS">
            <input type="submit" name="x^2" value="x^2" title="x^2">
            <input type="submit" name="x^y" value="x^y" title="x^y">
            <input type="submit" name="sin" value="sin" title="sin">
            <input type="submit" name="cos" value="cos" title="cos">
            <input type="submit" name="tan" value="tan" title="tan">
            <input type="submit" name="√" value="√" title="c">
            <input type="submit" name="log" value="log" title="log">
            <input type="submit" name="Exp" value="Exp" title="Exp">
            <input type="submit" name="Mod" value="Mod" title="Mod">
            <input type="submit" name="↑" value="↑" title="↑">
            <input type="submit" name="C" value="C" title="C">
            <input type="submit" name="←" value="←" title="←">
            <input type="submit" name="÷" value="÷" title="r">
            <input type="submit" name="π" value="π" title="π">
            <input type="submit" name="CE" value="CE" title="CE">
            <input type="submit" name="7" value="7" title="r">
            <input type="submit" name="8" value="8" title="r">
            <input type="submit" name="9" value="9" title="r">
            <input type="submit" name="x" value="x" title="r">
            <input type="submit" name="n!" value=" n!" title="n!">
            <input type="submit" name="4" value="4" title="r">
            <input type="submit" name="5" value="5" title="r">
            <input type="submit" name="6" value="6" title="r">
            <input type="submit" name="-" value="-" title="r">
            <input type="submit" name="+/-" value="+/-" title="c">
            <input type="submit" name="1" value="1" title="r">
            <input type="submit" name="2" value="2" title="r">
            <input type="submit" name="3" value="3" title="r">
            <input type="submit" name="+" value="+" title="r">
            <input type="submit" name="0" value="0" title="r">
            <input type="submit" name="dot" value="." title="r">
            <input type="submit" name="Enter" value="Enter" title="r">

        </main>

    </form>
</body>

</html>