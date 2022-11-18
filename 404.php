<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            background-color: #1a84d3;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container-404{
            text-align: center;
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 1px 10px
            rgba(0,0,0,0.3);
            border-radius: 5px;
            line-height: 1.7;
        }
        .boton {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            background-color: #1a84d3;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<!--Vista que se muestra si ocurre un fallo al buscar algo incorrecto en el Proyecto como un controlador inexistente-->
    <div class="container-404">
        <h1>Error 404</h1>
        <p>
            Esta página no se encuentra disponible
            por el momento. Disculpe las molestias.
        </p>
        <a href="index.php" class="boton">
            Página Principal
        </a>
    </div>
</body>
</html>