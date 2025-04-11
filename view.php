<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        div.square2 {
            border: inset 5px #000000;
            background: #000000;
            width: 15px;
            height: 15px;
            display: flex;
            flex-direction: row;
        }

        div.square1 {
            border: solid 5px #ffffff;
            background: #ffffff;
            width: 15px;
            height: 15px;
            display: flex;
            flex-direction: row;
        }


        div.square3 {
            border: solid 5px #b60e0e;
            background: #ffffff;
            width: 15px;
            height: 15px;
            display: flex;
            flex-direction: row;
        }

        div.square4 {
            border: solid 5px #362d72;
            background: #ffffff;
            width: 15px;
            height: 15px;
            display: flex;
            flex-direction: row;
        }

        div.row {
            display: flex;
        }

        div.branchBackground {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #467762;

        }


    </style>
</head>
<body>

<?php
require __DIR__ . '/functions1.php';

?>
<br>
<br>
<div id="root">
<?php viewBoard(generateArray()); ?>
</div>



<form id="form">
    <p><strong>Введите координаты начальной точки: </strong></p>
    <p>координата по Х  <input maxlength="3" size="1" id="startX">  </p>
    <p>координата по У  <input maxlength="3" size="1" id="startY"> </p>




    <select name="category" id="figure">
        <option selected value="0">Выберите фигуру</option>
        <option value="1">Король</option>
        <option value="2">Королева</option>
        <option value="3">Конь</option>
        <option value="4">Слон</option>
        <option value="5">Ладья</option>
    </select>



    <p><strong>Введите координаты конечной точки: </strong></p>
    <p>координата по Х  <input maxlength="3" size="1" id="finishX">  </p>
    <p>координата по У  <input maxlength="3" size="1" id="finishY"> </p>

    <input type="submit" value="GO">
    <br>
    <br>
    <br>

    <button onclick=location=URL>Сброс</button>

</form >
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="chess.js"></script>

</html>
