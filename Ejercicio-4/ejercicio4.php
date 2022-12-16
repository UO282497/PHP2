<!DOCTYPE HTML>

<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio4</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name="author" content="Sergio" />
    <meta name="description" content="Ejercicio4" />

    <!--Definición de la ventana gráfica-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="ejercicio4.css" />
    <?php
    session_start();
    class GoldApiManager
    {
        protected $final = "";
        public function __construct()
        {

        }
        public function cargar($base, $text)
        {
            // set API Endpoint and API key 
            $endpoint = 'latest';
            $access_key = 'y29p8pm6parr37h793410szm118enf9kbevwz5rryqcoculm0444fnqrxxm0';
            $symbols = 'XAU';
            // Initialize CURL:
            $ch = curl_init('https://commodities-api.com/api/' . $endpoint . '?access_key=' . $access_key . '&base=' . $base . '&symbols=' . $symbols . '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $exchangeRates = json_decode($json, true);

            // Access the exchange rate values, e.g. GBP:
    
            // access the conversion result
            $this->final = "El precio en " . $base . " es de " . (1 / $exchangeRates['data']['rates']['XAU']) . " " . $text . " la onza.";
        }
        public function getString()
        {
            return $this->final;
        }

    }
    if (!isset($_SESSION['api'])) {
        $_SESSION['api'] = new GoldApiManager();
    }
    $api = $_SESSION['api'];

    if (count($_POST) > 0) {
        if (isset($_POST['euros']))
            $api->cargar('EUR', 'euros');
        if (isset($_POST['libras']))
            $api->cargar('GBP', 'libras');
        if (isset($_POST['dol']))
            $api->cargar('USD', 'dólares');
    }

    $_SESSION['api'] = $api;






    ?>
</head>

<body>
    <h1>Panel de información de los precios del oro</h1>
    <form action='#' method='post' name='preciosoro'>
        <input type="submit" name="euros" value="Precio en euros" title="Obtener datos">
        <input type="submit" name="libras" value="Precio en libras" title="Obtener datos">
        <input type="submit" name="dol" value="Precio en dólares" title="Obtener datos">


    </form>
    <main>
        <p>
            <?php echo $api->getString() ?>
        </p>
    </main>
</body>