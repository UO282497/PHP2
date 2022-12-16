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
    <link rel="stylesheet" type="text/css" href="CalculadoraBasica.css" />
    <?php
    session_start();

    if (!isset($_SESSION['calculadora'])) {
        $_SESSION['calculadora'] = new CalculadoraMilan();
    }

    $calculadora = $_SESSION['calculadora'];

    class CalculadoraMilan
    {
        protected $pantalla = "";
        protected $op = "";

        protected $m = "0";

        public function __construct()
        {

        }

        public function getPantalla()
        {
            return $this->pantalla;
        }

        public function digitos($n)
        {
            $this->pantalla = $this->pantalla . $n;
        }
        public function sumar()
        {
            $this->operacion("+");

        }
        public function restar()
        {
            $this->operacion("-");

        }
        public function dividir()
        {
            $this->operacion("/");

        }
        public function multiplicar()
        {
            $this->operacion("*");

        }
        public function raiz()
        {
            $this->igual();
            $this->pantalla = sqrt($this->pantalla);
        }
        public function operacion($s)
        {

            $this->op = $this->pantalla;
            $this->op .= $s;
            $this->pantalla = "";
        }
        public function igual()
        {
            $this->op .= $this->pantalla;
            $this->pantalla = $this->evaluar();
            $this->op = "";
        }
        public function evaluar()
        {
            return eval('return ' . $this->op . ';');
        }

        public function resetear()
        {
            $this->op = "";
            $this->pantalla = "";

        }
        public function ce()
        {
            $this->pantalla = "";

        }
        public function signo()
        {
            $this->igual();
            $this->pantalla = -($this->pantalla);
        }
        public function porcentaje()
        {
            $aux = substr($this->op, 0, -1);
            $this->pantalla = $aux / 100 * $this->pantalla;


        }
        public function mplus()
        {
            $this->m = $this->m + $this->pantalla;
        }

        public function mm()
        {
            $this->m = $this->m - $this->pantalla;
            echo ("hola");
        }

        public function mrc()
        {

            $this->pantalla = $this->m;
        }


    }
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
            $calculadora->sumar();
        if (isset($_POST['-']))
            $calculadora->restar();
        if (isset($_POST['=']))
            $calculadora->igual();
        if (isset($_POST['√']))
            $calculadora->raiz();
        if (isset($_POST['on/C']))
            $calculadora->resetear();
        if (isset($_POST['CE']))
            $calculadora->ce();
        if (isset($_POST['+/-']))
            $calculadora->signo();
        if (isset($_POST['%']))
            $calculadora->porcentaje();
        if (isset($_POST['Mr/c']))
            $calculadora->mrc();
        if (isset($_POST['M+']))
            $calculadora->mplus();
        if (isset($_POST['M-']))
            $calculadora->mm();
        if (isset($_POST['=']))
            $calculadora->igual();



    }



    $_SESSION['calculadora'] = $calculadora;

    ?>
</head>



<body>

    <form action='#' method='post' name='calculadora'>
        <main>

            <aside>
                <input type="text" name="pantalla" id="pantalla" value='<?php echo $calculadora->getPantalla() ?>'
                    lang="es" disabled />
                <label for="pantalla">Calculadora milan</label>
            </aside>
            <input type="submit" name="on/C" value="on/C" title="c">
            <input type="submit" name="CE" value="CE" title="c">
            <input type="submit" name="+/-" value="+/-" title="c">
            <input type="submit" name="√" value="√" title="c">
            <input type="submit" name="%" value="%" title="c">

            <input type="submit" name='7' value="7" title="r">
            <input type="submit" name='8' value="8" title="r">
            <input type="submit" name='9' value="9" title="r">
            <input type="submit" name="x" value="x" title="r">
            <input type="submit" name="÷" value="÷" title="r">

            <input type="submit" name='4' value="4" title="r">
            <input type="submit" name='5' value="5" title="r">
            <input type="submit" name='6' value="6" title="r">
            <input type="submit" name="-" value="-" title="r">
            <input type="submit" name="Mr/c" value="Mr/c" title="r">


            <input type="submit" name='1' value="1" title="r">
            <input type="submit" name='2' value="2" title="r">
            <input type="submit" name='3' value="3" title="r">
            <input type="submit" name="+" value="+" title="r">
            <input type="submit" name="M-" value="M-" title="r">

            <input type="submit" name='0' value="0" title="r">
            <input type="submit" name='.' value="." title="r">
            <input type="submit" name='=' value="=" title="r">

            <input type="submit" name="M+" value="M+" title="r">









        </main>
    </form>

</body>



</html>