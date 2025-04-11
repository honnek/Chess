<?php


function generateArray(): array
{

    $array = file(__DIR__ . '/text.txt', FILE_IGNORE_NEW_LINES);

    return $array;
}


function viewBoard(array $array): void
{

    for ($i = 0; $i < count($array); $i++) {

        echo '<div class="row">';


        for ($j = 0; $j < strlen($array[$i]); $j++) {

            if ($array[$i][$j] === '1') {
                echo '<div class="square2" id="sqr-' . $i . '-' . $j . '"> </div>';
            }
            if ($array[$i][$j] === '0') {
                echo '<div class="square1" id="sqr-' . $i . '-' . $j . '"> </div>';
            }

        }
        echo '</div>';
    }
}


//функция только для ладьи
function movesOfRook(array $board, array $start, array $finish): array
{

    $result = [];
    $result[] = $start;

    if ($start['x'] !== $finish['x'] && $start['y'] !== $finish['y']) {
        $result[] = ['x' => $finish['x'], 'y' => $start['y']];
        $result[] = ['x' => $finish['x'], 'y' => $finish['y']];
        return $result;
    }

    if ($start['x'] !== $finish['x']) {
        $result[] = ['x' => $finish['x'], 'y' => $finish['y']];
    }

    if ($start['y'] !== $finish['y']) {
        $result[] = ['x' => $finish['x'], 'y' => $finish['y']];
    }
    return $result;
}

//функция для короля
function movesOfKing(array $board, array $start, array $finish): array
{
    $result[] = $start;
    if ($start['x'] !== $finish['x']) {

        for ($i = $start['x']; $i !== $finish['x'];) {
            if ($start['x'] > $finish['x']) {
                $i--;
                $result[] = ['x' => $i, 'y' => $start['y']];
            }
            if ($start['x'] < $finish['x']) {
                $i++;
                $result[] = ['x' => $i, 'y' => $start['y']];
            }
        }
    }

    if ($start['y'] !== $finish['y']) {

        for ($i = $start['y']; $i !== $finish['y'];) {
            if ($start['y'] > $finish['y']) {
                $i--;
                $result[] = ['x' => $finish['x'], 'y' => $i];
            }
            if ($start['y'] < $finish['y']) {
                $i++;
                $result[] = ['x' => $finish['x'], 'y' => $i];
            }
        }
    }

    return $result;
}

//функция для определения возможных клеток для движения слона
function getArrayOfCross(array $point, array $board): array
{
    for ($k = 1; $k < count($board); $k++) {

        if (isset($board[$point['x'] - $k][$point['y'] - $k]) && ($point['x'] - $k) >= 0 && ($point['y'] - $k) >= 0) {
            $cross[] = [$point['x'] - $k, $point['y'] - $k];
        }
        if (isset($board[$point['x'] - $k][$point['y'] + $k]) && ($point['x'] - $k) >= 0) {
            $cross[] = [$point['x'] - $k, $point['y'] + $k];
        }
        if (isset($board[$point['x'] + $k][$point['y'] - $k]) && ($point['y'] - $k) >= 0) {
            $cross[] = [$point['x'] + $k, $point['y'] - $k];
        }
        if (isset($board[$point['x'] + $k][$point['y'] + $k])) {
            $cross[] = [$point['x'] + $k, $point['y'] + $k];
        }
    }
    return $cross;
}
//функция для определения возможных клеток для движения королевы
function getArrayOfCrossQueen(array $point, array $board)
{
    for ($k = 1; $k < count($board); $k++) {

        if (isset($board[$point['x'] - $k][$point['y'] - $k]) && ($point['x'] - $k) >= 0 && ($point['y'] - $k) >= 0) {
            $cross[] = [$point['x'] - $k, $point['y'] - $k];
        }
        if (isset($board[$point['x'] - $k][$point['y'] + $k]) && ($point['x'] - $k) >= 0) {
            $cross[] = [$point['x'] - $k, $point['y'] + $k];
        }
        if (isset($board[$point['x'] + $k][$point['y'] - $k]) && ($point['y'] - $k) >= 0) {
            $cross[] = [$point['x'] + $k, $point['y'] - $k];
        }
        if (isset($board[$point['x'] + $k][$point['y'] + $k])) {
            $cross[] = [$point['x'] + $k, $point['y'] + $k];
        }


        if (isset($board[$point['x'] + $k][$point['y']])) {
            $cross[] = [$point['x'] + $k, $point['y']];
        }
        if (isset($board[$point['x'] - $k][$point['y']]) && ($point['x'] - $k) >= 0) {
            $cross[] = [$point['x'] - $k, $point['y']];
        }
        if (isset($board[$point['x']][$point['y'] + $k])) {
            $cross[] = [$point['x'], $point['y'] + $k];
        }
        if (isset($board[$point['x']][$point['y'] - $k]) && ($point['y'] - $k) >= 0) {
            $cross[] = [$point['x'], $point['y'] - $k];
        }
    }

    return $cross;
}

//функция для движения слона
function movesOfElephant(array $board, array $start, array $finish): array
{
    $result[] = $start;
    $crossOfStart = getArrayOfCross($start, $board);
    $crossOfFinish = getArrayOfCross($finish, $board);
    for ($j = 0; $j < count($board); $j++) {
        for ($i = 0; $i < count($board); $i++) {
            if ($crossOfFinish[$i][0] == $start['x'] && $crossOfFinish[$i][1] == $start['y']) {
                $result[] = $finish;
                return $result;
            }
        }
    }

    for ($j = 0; $j < count($board); $j++) {
        for ($i = 0; $i < count($board); $i++) {
            if ($crossOfStart[$i][0] == $crossOfFinish[$j][0] && $crossOfStart[$i][1] == $crossOfFinish[$j][1]) {
                $result[] = ['x' => $crossOfStart[$i][0], 'y' => $crossOfStart[$i][1]];
                $result[] = $finish;
                return $result;
            }
        }
    }
}

//функция для движения королевы
function movesOfQueen(array $board, array $start, array $finish): array
{
    $result[] = $start;
    $crossOfStart = getArrayOfCrossQueen($start, $board);
    $crossOfFinish = getArrayOfCrossQueen($finish, $board);
    for ($i = 0; $i <= count($crossOfStart) || $i <= count($crossOfFinish); $i++) {
        if ($crossOfStart[$i][0] == $finish['x'] && $crossOfStart[$i][1] == $finish['y']) {
            $result[] = $finish;
            return $result;
        }
    }

    for ($j = 0; $j <= count($crossOfStart) || $j <= count($crossOfFinish); $j++) {
        for ($i = 0; $i <= count($crossOfStart) || $i <= count($crossOfFinish); $i++) {
            if ($crossOfStart[$i][0] == $crossOfFinish[$j][0] && $crossOfStart[$i][1] == $crossOfFinish[$j][1]) {
                $result[] = ['x' => $crossOfStart[$i][0], 'y' => $crossOfStart[$i][1]];
                $result[] = $finish;
                return $result;
            }
        }
    }
}

//функция для определения ближайших клеток лошади
function movesOfOneRadius(array $board, array $start, array $finish): ?array
{
    $res[] = $start;

    if ($finish['x'] == $start['x'] - 2 && $finish['y'] == $start['y'] - 1) {
        if (isset($board[$start['x'] - 2]) && isset($board[$start['y'] - 1]) && $start['x'] - 2 >= 0 && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 1 && $finish['y'] == $start['y'] - 2) {
        if (isset($board[$start['x'] - 1]) && isset($board[$start['y'] - 2]) && $start['x'] - 1 >= 0 && $start['y'] - 2 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 1 && $finish['y'] == $start['y'] - 2) {
        if (isset($board[$start['x'] + 1]) && isset($board[$start['y'] - 2]) && $start['y'] - 2 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 2 && $finish['y'] == $start['y'] - 1) {
        if (isset($board[$start['x'] + 2]) && isset($board[$start['y'] - 1]) && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 2 && $finish['y'] == $start['y'] + 1) {
        if (isset($board[$start['x'] + 2]) && isset($board[$start['y'] + 1])) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 1 && $finish['y'] == $start['y'] + 2) {
        if (isset($board[$start['x'] + 1]) && isset($board[$start['y'] + 2])) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 1 && $finish['y'] == $start['y'] + 2) {
        if (isset($board[$start['x'] - 1]) && isset($board[$start['y'] + 2]) && $start['x'] - 1 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 2 && $finish['y'] == $start['y'] + 1) {
        if (isset($board[$start['x'] - 2]) && isset($board[$start['y'] + 1]) && $start['x'] - 2 >= 0) {
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] && $finish['y'] == $start['y'] - 2) {
        if (isset($board[$start['x'] - 2][$start['y'] - 1]) && $start['x'] - 2 >= 0 && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
        if (isset($board[$start['x'] + 2][$start['y'] - 1]) && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] && $finish['y'] == $start['y'] + 2) {
        if (isset($board[$start['x'] - 2][$start['y'] + 1]) && $start['x'] - 2 >= 0) {
            $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
        if (isset($board[$start['x'] + 2][$start['y'] + 1])) {
            $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 2 && $finish['y'] == $start['y']) {
        if (isset($board[$start['x'] - 1][$start['y'] - 2]) && $start['x'] - 1 >= 0 && $start['y'] - 2 >= 0) {
            $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
        if (isset($board[$start['x'] - 1][$start['y'] + 2]) && $start['x'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 2 && $finish['y'] == $start['y']) {
        if (isset($board[$start['x'] + 1][$start['y'] - 2]) && $start['y'] - 2 >= 0) {
            $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
        if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
            $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 1 && $finish['y'] == $start['y'] - 1) {
        if (isset($board[$start['x'] + 1][$start['y'] - 2]) && $start['y'] - 2 >= 0) {
            $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        } elseif (isset($board[$start['x'] - 2][$start['y'] + 1]) && $start['x'] - 2 >= 0) {
            $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] - 1 && $finish['y'] == $start['y'] + 1) {
        if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
            $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        } elseif (isset($board[$start['x'] - 2][$start['y'] - 1]) && $start['x'] - 2 >= 0 && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 1 && $finish['y'] == $start['y'] + 1) {
        if (isset($board[$start['x'] - 1][$start['y'] + 2]) && $start['x'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        } elseif (isset($board[$start['x'] + 2][$start['y'] - 1]) && $start['y'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }

    if ($finish['x'] == $start['x'] + 1 && $finish['y'] == $start['y'] - 1) {
        if (isset($board[$start['x'] - 1][$start['y'] - 2]) && $start['y'] - 2 >= 0 && $start['x'] - 1 >= 0) {
            $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;

        } elseif (isset($board[$start['x'] + 2][$start['y'] + 1])) {
            $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
            $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
            return $res;
        }
    }


    if ($finish['x'] == $start['x'] - 1 && $finish['y'] == $start['y']) {

        if (isset($board[$start['x'] + 1][$start['y'] - 1]) && $start['x'] - 1 >= 0) {

            if (isset($board[$start['x'] + 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] + 1][$start['y'] + 1])) {

            if (isset($board[$start['x'] + 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x']][$start['y'] - 2])) {

            if (isset($board[$start['x'] + 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] - 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] - 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x']][$start['y'] + 2])) {

            if (isset($board[$start['x'] + 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] + 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] + 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        }
    }

    if ($finish['x'] == $start['x'] + 1 && $finish['y'] == $start['y']) {

        if (isset($board[$start['x'] - 1][$start['y'] - 1]) && $start['x'] - 1 >= 0) {

            if (isset($board[$start['x'] + 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] - 1][$start['y'] + 1])) {

            if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x']][$start['y'] - 2])) {

            if (isset($board[$start['x'] - 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] - 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] + 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] - 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x']][$start['y'] + 2])) {

            if (isset($board[$start['x'] + 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] + 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'], 'y' => $start['y'] + 2];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
        }
    }

    if ($finish['x'] == $start['x'] && $finish['y'] == $start['y'] - 1) {

        if (isset($board[$start['x'] - 2][$start['y']]) && $start['x'] - 2 >= 0) {

            if (isset($board[$start['x'] - 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] + 2][$start['y']])) {

            if (isset($board[$start['x'] + 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] - 1][$start['y'] + 1])) {

            if (isset($board[$start['x'] - 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] + 1][$start['y'] + 1])) {

            if (isset($board[$start['x'] - 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] + 2][$start['y'] - 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
        }
    }

    if ($finish['x'] == $start['x'] && $finish['y'] == $start['y'] + 1) {

        if (isset($board[$start['x'] - 2][$start['y']]) && $start['x'] - 2 >= 0) {

            if (isset($board[$start['x'] - 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] + 2][$start['y']])) {

            if (isset($board[$start['x'] + 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] + 1][$start['y'] + 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y']];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] + 1][$start['y'] - 1])) {

            if (isset($board[$start['x'] + 2][$start['y'] + 1])) {
                $res [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }

        } elseif (isset($board[$start['x'] - 1][$start['y'] - 1])) {

            if (isset($board[$start['x'] + 1][$start['y'] - 2])) {
                $res [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
            if (isset($board[$start['x'] - 2][$start['y'] + 1]) && $start['x'] - 2 >= 0) {
                $res [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
                $res [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 1];
                $res [] = ['x' => $finish['x'], 'y' => $finish['y']];
                return $res;
            }
        }
    }
    $res = null;
    return $res;
}

//функция для движения лошади
function movesOfHorse(array $board, array $start, array $finish): array
{
    if (movesOfOneRadius($board, $start, $finish) == null) {


        if (movesOfOneRadius($board, ['x' => $start['x'] + 2, 'y' => $start['y'] + 1], $finish) !== null && isset($board[$start['x'] + 2][$start['y'] + 1])) {
            $array [] = $start;
            $start = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] + 2, 'y' => $start['y'] - 1], $finish) !== null && isset($board[$start['x'] + 2][$start['y'] - 1])) {
            $array [] = $start;
            $start = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] + 1, 'y' => $start['y'] - 2], $finish) !== null && isset($board[$start['x'] + 1][$start['y'] - 2])) {
            $array [] = $start;
            $start = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 1, 'y' => $start['y'] - 2], $finish) !== null && isset($board[$start['x'] - 1][$start['y'] - 2])) {
            $array [] = $start;
            $start = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 2, 'y' => $start['y'] - 1], $finish) !== null && isset($board[$start['x'] - 2][$start['y'] - 1])) {
            $array [] = $start;
            $start = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 2, 'y' => $start['y'] + 1], $finish) !== null && isset($board[$start['x'] - 2][$start['y'] + 1])) {
            $array [] = $start;
            $start = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 1, 'y' => $start['y'] + 2], $finish) !== null && isset($board[$start['x'] - 1][$start['y'] + 2])) {
            $array [] = $start;
            $start = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] + 1, 'y' => $start['y'] + 2], $finish) !== null && isset($board[$start['x'] + 1][$start['y'] + 2])) {
            $array [] = $start;
            $start = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }


        if (movesOfOneRadius($board, ['x' => $start['x'] + 3, 'y' => $start['y'] + 3], $finish) !== null && isset($board[$start['x'] + 3][$start['y'] + 3])) {
            $array [] = $start;
            $array [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
            $start = ['x' => $start['x'] + 3, 'y' => $start['y'] + 3];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 3, 'y' => $start['y'] - 3], $finish) !== null && isset($board[$start['x'] - 3][$start['y'] - 3])) {
            $array [] = $start;
            $array [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
            $start = ['x' => $start['x'] - 3, 'y' => $start['y'] - 3];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] - 3, 'y' => $start['y'] + 3], $finish) !== null && isset($board[$start['x'] - 3][$start['y'] + 3])) {
            $array [] = $start;
            $array [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
            $start = ['x' => $start['x'] - 3, 'y' => $start['y'] + 3];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }

        if (movesOfOneRadius($board, ['x' => $start['x'] + 3, 'y' => $start['y'] - 3], $finish) !== null && isset($board[$start['x'] + 3][$start['y'] - 3])) {
            $array [] = $start;
            $array [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
            $start = ['x' => $start['x'] + 3, 'y' => $start['y'] - 3];
            return array_merge($array, movesOfOneRadius($board, $start, $finish));
        }


        if (movesOfOneRadius($board, ['x' => 5, 'y' => 6], $finish) !== null) {

            if (movesOfOneRadius($board, ['x' => 1, 'y' => 5], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 5]));
                $array2 [] = ['x' => 2, 'y' => 3];
                $array2 [] = ['x' => 4, 'y' => 4];
                $start = ['x' => 5, 'y' => 6];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
            if (movesOfOneRadius($board, ['x' => 5, 'y' => 1], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 1]));
                $array2 [] = ['x' => 3, 'y' => 2];
                $array2 [] = ['x' => 4, 'y' => 4];
                $start = ['x' => 5, 'y' => 6];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

            if (movesOfOneRadius($board, ['x' => 1, 'y' => 2], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 2]));
                $array2 [] = ['x' => 3, 'y' => 3];
                $array2 [] = ['x' => 5, 'y' => 2];
                $array2 [] = ['x' => 7, 'y' => 3];
                $array2 [] = ['x' => 6, 'y' => 5];
                $start = ['x' => 6, 'y' => 5];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

        }


        if (movesOfOneRadius($board, ['x' => 1, 'y' => 5], $finish) !== null) {

            if (movesOfOneRadius($board, ['x' => 5, 'y' => 6], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 6]));
                $array2 [] = ['x' => 3, 'y' => 5];
                $array2 [] = ['x' => 1, 'y' => 6];
                $start = ['x' => 1, 'y' => 5];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
            if (movesOfOneRadius($board, ['x' => 5, 'y' => 1], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 1]));
                $array2 [] = ['x' => 4, 'y' => 3];
                $array2 [] = ['x' => 3, 'y' => 5];
                $start = ['x' => 1, 'y' => 5];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

            if (movesOfOneRadius($board, ['x' => 1, 'y' => 2], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 2]));
                $array2 [] = ['x' => 0, 'y' => 4];
                $array2 [] = ['x' => 1, 'y' => 6];
                $start = ['x' => 1, 'y' => 5];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
        }

        if (movesOfOneRadius($board, ['x' => 5, 'y' => 1], $finish) !== null) {

            if (movesOfOneRadius($board, ['x' => 5, 'y' => 6], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 6]));
                $array2 [] = ['x' => 3, 'y' => 5];
                $array2 [] = ['x' => 4, 'y' => 3];
                $start = ['x' => 5, 'y' => 1];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
            if (movesOfOneRadius($board, ['x' => 1, 'y' => 5], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 5]));
                $array2 [] = ['x' => 3, 'y' => 4];
                $array2 [] = ['x' => 5, 'y' => 5];
                $array2 [] = ['x' => 6, 'y' => 3];
                $start = ['x' => 5, 'y' => 1];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

            if (movesOfOneRadius($board, ['x' => 1, 'y' => 2], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 2]));
                $array2 [] = ['x' => 2, 'y' => 4];
                $array2 [] = ['x' => 4, 'y' => 3];
                $start = ['x' => 5, 'y' => 1];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
        }

        if (movesOfOneRadius($board, ['x' => 1, 'y' => 2], $finish) !== null) {

            if (movesOfOneRadius($board, ['x' => 5, 'y' => 6], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 6]));
                $array2 [] = ['x' => 7, 'y' => 5];
                $array2 [] = ['x' => 5, 'y' => 4];
                $array2 [] = ['x' => 3, 'y' => 3];
                $start = ['x' => 1, 'y' => 2];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

            if (movesOfOneRadius($board, ['x' => 1, 'y' => 5], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 1, 'y' => 5]));
                $array2 [] = ['x' => 3, 'y' => 4];
                $array2 [] = ['x' => 5, 'y' => 3];
                $array2 [] = ['x' => 4, 'y' => 1];
                $array2 [] = ['x' => 2, 'y' => 0];
                $start = ['x' => 1, 'y' => 2];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }

            if (movesOfOneRadius($board, ['x' => 5, 'y' => 1], $start) !== null) {
                $array [] = $start;
                $array2 = array_merge($array, movesOfOneRadius($board, $start, ['x' => 5, 'y' => 1]));
                $array2 [] = ['x' => 4, 'y' => 3];
                $array2 [] = ['x' => 2, 'y' => 4];
                $start = ['x' => 1, 'y' => 2];
                return array_merge($array2, movesOfOneRadius($board, $start, $finish));
            }
        }


        if ((movesOfOneRadius($board, $start, $finish) !== null)) {
            return movesOfOneRadius($board, $start, $finish);
        }
    }
}







function getArrayOfTraces(array $array): array
{
    $result = [];
    for ($row = 0; $row < count($array); $row++) {
        for ($col = 0; $col < strlen($array[0]); $col++) {
            $result[$row][$col] = 0;
        }
    }


    return $result;
}


function checkingEightCells(array $board, array $start, array &$traces): array
{
    $traces[$start['x']][$start['y']] = 1;
    $result = [];
    $edgesY = ['min' => 0, 'max' => count($board) - 1];
    $edgesX = ['min' => 0, 'max' => strlen($board[0]) - 1];

    if (isset($board[$start['x'] + 2][$start['y'] + 1]) && $traces[$start['x'] + 2][$start['y'] + 1] == 0 && $start['x'] + 2 <= $edgesX['max'] && $start['y'] + 1 <= $edgesY['max']) {
        $result [] = ['x' => $start['x'] + 2, 'y' => $start['y'] + 1];
    }

    if (isset($board[$start['x'] + 2][$start['y'] - 1]) && $traces[$start['x'] + 2][$start['y'] - 1] == 0 && $start['x'] + 2 <= $edgesX['max'] && $start['y'] - 1 >= $edgesY['min']) {
        $result [] = ['x' => $start['x'] + 2, 'y' => $start['y'] - 1];
    }

    if (isset($board[$start['x'] + 1][$start['y'] - 2]) && $traces[$start['x'] + 1][$start['y'] - 2] == 0 && $start['x'] + 1 <= $edgesX['max'] && $start['y'] - 2 >= $edgesY['min']) {
        $result [] = ['x' => $start['x'] + 1, 'y' => $start['y'] - 2];
    }

    if (isset($board[$start['x'] - 1][$start['y'] - 2]) && $traces[$start['x'] - 1][$start['y'] - 2] == 0 && $start['x'] - 1 >= $edgesX['min'] && $start['y'] - 2 >= $edgesY['min']) {
        $result [] = ['x' => $start['x'] - 1, 'y' => $start['y'] - 2];
    }

    if (isset($board[$start['x'] - 2][$start['y'] - 1]) && $traces[$start['x'] - 2][$start['y'] - 1] == 0 && $start['x'] - 2 >= $edgesX['min'] && $start['y'] - 1 >= $edgesY['min']) {
        $result [] = ['x' => $start['x'] - 2, 'y' => $start['y'] - 1];
    }

    if (isset($board[$start['x'] - 2][$start['y'] + 1]) && $traces[$start['x'] - 2][$start['y'] + 1] == 0 && $start['x'] - 2 >= $edgesX['min'] && $start['y'] + 1 <= $edgesY['max']) {
        $result [] = ['x' => $start['x'] - 2, 'y' => $start['y'] + 1];
    }

    if (isset($board[$start['x'] - 1][$start['y'] + 2]) && $traces[$start['x'] - 1][$start['y'] + 2] == 0 && $start['x'] - 1 >= $edgesX['min'] && $start['y'] + 2 <= $edgesY['max']) {
        $result [] = ['x' => $start['x'] - 1, 'y' => $start['y'] + 2];
    }

    if (isset($board[$start['x'] + 1][$start['y'] + 2]) && $traces[$start['x'] + 1][$start['y'] + 2] == 0 && $start['x'] + 1 <= $edgesX['max'] && $start['y'] + 2 <= $edgesY['max']) {
        $result [] = ['x' => $start['x'] + 1, 'y' => $start['y'] + 2];
    }
    return $result;
}


function makeTreeHorse(array $board, array $point, array &$traces, $finish): array
{
    $result = ['x' => $point['x'], 'y' => $point['y']];
    $manyCells = checkingEightCells($board, $point, $traces);
    foreach ($manyCells as $cell) {
        $arrayOfCells = ['x' => $cell['x'], 'y' => $cell['y']];
        if ($arrayOfCells['x'] == $finish['x'] && $arrayOfCells['y'] == $finish['y']) {
            $result['nextLvl'][] = $arrayOfCells;
            return $result;
        }
    }
    foreach ($manyCells as $cell) {
        $arrayOfCells = ['x' => $cell['x'], 'y' => $cell['y']];
        $result['nextLvl'][] = makeTreeHorse($board, $arrayOfCells, $traces, $finish);
    }
    return $result;
}


function getBranches(array $tree, array &$res = null, $finish): void
{

    if (!isset($res)) {
        $res = [[['x' => $tree['x'], 'y' => $tree['y']]]];
    }


    if (isset($tree['nextLvl'])) {
        $branches = $tree['nextLvl'];
        $tempAmountOfBranchesRes = count($res);

        // дублирование нужных путей
        if (count($branches) > 1) {
            for ($j = 0; $j < count($branches) - 1; $j++) {         //Проходим по путям
                for ($i = 0; $i < $tempAmountOfBranchesRes; $i++) {         //Проходим по клеткам
                    $resBranch = $res[$i];
                    $lastPoint = $resBranch[count($resBranch) - 1];
                    if ($lastPoint['x'] === $tree['x'] && $lastPoint['y'] === $tree['y']) {     //Если последний элемент записанный в res равен текущему элементу в дереве
                        $res[] = $res[$i];      //То добавим новый элемент в массив res
                    }
                }
            }
        }

        // заполнение путей точками
        for ($j = 0; $j < count($branches); $j++) {
            $branch = $branches[$j];
            for ($i = 0; $i < count($res); $i++) {
                $resBranch = $res[$i];
                $lastPoint = $resBranch[count($resBranch) - 1];
                if ($lastPoint['x'] === $tree['x'] && $lastPoint['y'] === $tree['y']) {
                    $res[$i][] = ['x' => $branch['x'], 'y' => $branch['y']];
                    break;
                }
            }
        }

        foreach ($tree['nextLvl'] as $way) {
            getBranches($way, $res, $finish);
        }

    }

}


function checkAndGetArrayOfHorse(array &$res, array $finish): array
{
    for ($i = 0; $i < count($res); $i++) {
        if ($res[$i][count($res[$i]) - 1]['x'] == $finish['x'] && $res[$i][count($res[$i]) - 1]['y'] == $finish['y']) {
            return $res[$i];
        }
    }
}

