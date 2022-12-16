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
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css" />
    <?php
    session_start();



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
            if ($this->pantalla == "Error") {
                $this->pantalla = "";
            }
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

            $this->op .= $this->pantalla;
            $this->op .= $s;
            $this->pantalla = "";
        }
        public function igual()
        {
            $this->op .= $this->pantalla;
            try {
                $this->pantalla = $this->evaluar();
            } catch (Throwable $e) {
                $this->pantalla = "Error";
            }
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
            if ($this->op != "") {
                $aux = substr($this->op, 0, -1);
                echo ($this->op);
                $this->pantalla = intVal($aux) / 100 * $this->pantalla;
            }


        }
        public function mplus()
        {
            $this->m = $this->m + $this->pantalla;
        }

        public function mm()
        {
            $this->m = $this->m - $this->pantalla;
        }

        public function mrc()
        {

            $this->pantalla = $this->m;
        }


    }

    class CalculadoraCientifica extends CalculadoraMilan
    {
        protected $mode = "N";
        protected $sin = "sin";
        protected $cos = "cos";
        protected $tan = "tan";
        protected $rep = "F";

        protected $deg = "DEG";

        public function evaluar()
        {
            if ($this->rep == "E") {
                return number_format(eval('return ' . $this->op . ';'), 1);
            }

            return eval('return ' . $this->op . ';');
        }

        public function borrarDigito()
        {
            $this->pantalla = substr($this->pantalla, 0, -1);
        }
        public function borrarP()
        {
            $this->pantalla = "";
        }
        public function log()
        {
            $this->pantalla = log($this->pantalla);
        }
        public function sin()
        {
            if ($this->deg == "D") {
                $this->pantalla = $this->pantalla * pi() / 180;
            }

            if ($this->mode == "N") {
                $this->pantalla = sin($this->pantalla);
            }
            if ($this->mode == "H") {
                $this->pantalla = sinh($this->pantalla);
            }
            if ($this->mode == "A") {
                $this->pantalla = asin($this->pantalla);
            }
        }
        public function cos()
        {
            if ($this->deg == "D") {
                $this->pantalla = $this->pantalla * pi() / 180;
            }
            if ($this->mode == "N") {
                $this->pantalla = cos($this->pantalla);
            }
            if ($this->mode == "H") {
                $this->pantalla = cosh($this->pantalla);
            }
            if ($this->mode == "A") {
                $this->pantalla = acos($this->pantalla);
            }
        }
        public function tan()
        {
            if ($this->deg == "D") {
                $this->pantalla = $this->pantalla * pi() / 180;
            }
            if ($this->mode == "N") {
                $this->pantalla = tan($this->pantalla);
            }
            if ($this->mode == "H") {
                $this->pantalla = tanh($this->pantalla);
            }
            if ($this->mode == "A") {
                $this->pantalla = atan($this->pantalla);
            }

        }
        public function elevar()
        {
            $this->operacion("**");

        }
        public function cuadrado()
        {
            $this->igual();
            $this->pantalla = ($this->pantalla) ** 2;
        }
        public function pi()
        {
            $this->pantalla = pi();

        }
        public function elevarDiezA()
        {
            $this->pantalla = pow(10, $this->pantalla);
        }
        public function parI()
        {

            $this->pantalla .= "(";

        }
        public function parD()
        {

            $this->pantalla .= ")";

        }
        public function fact()
        {
            $this->pantalla = $this->fac($this->pantalla);

        }
        public function fac($n)
        {
            if ($n == 0) {
                return 1;
            } else {
                return $n * $this->fac($n - 1);
            }

        }

        public function mClear()
        {
            $this->m = 0;
        }
        public function mReturn()
        {
            $this->pantalla = $this->m;
        }
        public function mSave()
        {
            $this->m = $this->pantalla;
        }
        public function exp()
        {
            $this->operacion("e+");

        }
        public function mod()
        {
            $this->operacion("%");

        }
        public function setA()
        {
            if ($this->mode == "N" || $this->mode == "H") {
                $this->sin = "Asin";
                $this->cos = "Acos";
                $this->tan = "Atan";
                $this->mode = "A";
            } else if ($this->mode == "A") {
                $this->sin = "sin";
                $this->cos = "cos";
                $this->tan = "tan";
                $this->mode = "N";
            }

        }

        public function setH()
        {

            if ($this->mode == "N" || $this->mode == "A") {
                $this->sin = "sinh";
                $this->cos = "cosh";
                $this->tan = "tanh";
                $this->mode = "H";
            } else if ($this->mode == "H") {
                $this->sin = "sin";
                $this->cos = "cos";
                $this->tan = "tan";
                $this->mode = "N";
            }

        }
        public function toggleRep()
        {
            if ($this->rep == "F") {
                $this->rep = "E";
            } else {
                $this->rep = "F";
            }
        }
        public function toggleDeg()
        {
            if ($this->deg == "DEG") {
                $this->deg = "RAD";
            } else {
                $this->deg = "DEG";

            }
        }

        public function getDeg()
        {
            return $this->deg;
        }
        public function getSin()
        {
            return $this->sin;
        }
        public function getCos()
        {
            return $this->cos;
        }
        public function getTan()
        {
            return $this->tan;
        }
    }

    if (!isset($_SESSION['calculadorac'])) {
        $_SESSION['calculadorac'] = new CalculadoraCientifica();
    }

    $calculadora = $_SESSION['calculadorac'];
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
        if (isset($_POST['x']))
            $calculadora->multiplicar();
        if (isset($_POST['/']))
            $calculadora->dividir();
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
        if (isset($_POST['10^x']))
            $calculadora->elevarDiezA();
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
        if (isset($_POST['n!']))
            $calculadora->fact();
        if (isset($_POST['(']))
            $calculadora->parI();
        if (isset($_POST[')']))
            $calculadora->parD();
        if (isset($_POST['C']))
            $calculadora->borrarP();
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
                <label for="pantalla">Calculadora cientifica</label>
            </aside>
            <input type="submit" name="DEG" value='<?php echo $calculadora->getDeg() ?>' title="DEG">
            <input type="submit" name="HYP" value="HYP" title="HYP">
            <header>
                <p></p>
            </header>
            <input type="submit" name="MC" value="MC" title="MC">
            <input type="submit" name="MR" value="MR" title="MR">
            <input type="submit" name="M-" value="M-" title="r">
            <input type="submit" name="M+" value="M+" title="r">
            <input type="submit" name="MS" value="MS" title="MS">
            <input type="submit" name="x^2" value="x^2" title="x^2">
            <input type="submit" name="x^y" value="x^y" title="x^y">
            <input type="submit" name="sin" value='<?php echo $calculadora->getSin() ?>' title="sin">
            <input type="submit" name="cos" value='<?php echo $calculadora->getCos() ?>' title="cos">
            <input type="submit" name="tan" value='<?php echo $calculadora->getTan() ?>' title="tan">
            <input type="submit" name="√" value="√" title="c">
            <input type="submit" name="10^x" value="10^x" title="10^x">
            <input type="submit" name="log" value="log" title="log">
            <input type="submit" name="Exp" value="Exp" title="Exp">
            <input type="submit" name="Mod" value="Mod" title="Mod">
            <input type="submit" name="↑" value="↑" title="↑">
            <input type="submit" name="CE" value="CE" title="CE">
            <input type="submit" name="C" value="C" title="C">
            <input type="submit" name="←" value="←" title="←">
            <input type="submit" name="÷" value="÷" title="r">
            <input type="submit" name="π" value="π" title="π">
            <input type="submit" name="7" value="7" title="r">
            <input type="submit" name="8" value="8" title="r">
            <input type="submit" name="9" value="9" title="r">
            <input type="submit" name="x" value="x" title="r">
            <input type="submit" name="n!" value="n!" title="n!">
            <input type="submit" name="4" value="4" title="r">
            <input type="submit" name="5" value="5" title="r">
            <input type="submit" name="6" value="6" title="r">
            <input type="submit" name="-" value="-" title="r">
            <input type="submit" name="+/-" value="+/-" title="c">
            <input type="submit" name="1" value="1" title="r">
            <input type="submit" name="2" value="2" title="r">
            <input type="submit" name="3" value="3" title="r">
            <input type="submit" name="+" value="+" title="r">
            <input type="submit" name="(" value="(" title="(">
            <input type="submit" name=")" value=")" title=")">
            <input type="submit" name="0" value="0" title="r">
            <input type="submit" name="." value="." title="r">
            <input type="submit" name="=" value="=" title="r">

        </main>
    </form>

</body>

</html>