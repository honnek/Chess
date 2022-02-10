<?php
include __DIR__ . '/functions1.php';
$start = ['x' => (int)$_POST['start']['x'], 'y' => (int)$_POST['start']['y']];
$finish = ['x' => (int)$_POST['finish']['x'], 'y' => (int)$_POST['finish']['y']];
$board = generateArray();
$traces = getArrayOfTraces(generateArray());
$board = generateArray();
$tree = makeTreeHorse($board, $start, $traces, $finish);
getBranches($tree, $res, $finish);


if ($_POST['figure'] == 1){
    echo json_encode(movesOfKing($board,$start,$finish));
    return;
}

if ($_POST['figure'] == 2){
    echo json_encode(movesOfQueen($board,$start,$finish));
    return;
}

if ($_POST['figure'] == 3){
    echo json_encode(checkAndGetArrayOfHorse($res, $finish));
    return;
}

if ($_POST['figure'] == 4){
    echo json_encode(movesOfElephant($board,$start,$finish));
    return;
}

if ($_POST['figure'] == 5){
    echo json_encode(movesOfRook($board,$start,$finish));
    return;
}