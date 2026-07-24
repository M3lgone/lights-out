<?php

require_once 'LightsOutGame.php';

session_start();

if (isset($_GET['randomize'])) {
    unset($_SESSION['game_state']);
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['game_state'])) {

    $randomLayout = [];
    $boardSize = rand(3, 6); 
    
    for ($row = 0; $row < $boardSize; $row++) {
        for ($col = 0; $col < $boardSize; $col++) {
            $randomLayout[$row][$col] = (bool) rand(0, 1);
        }
    }
    $_SESSION['game_state'] = $randomLayout;
}

$game = new LightsOutGame($_SESSION['game_state']);

if (isset($_GET['row'], $_GET['col'])) {
    $game->flip((int) $_GET['row'], (int) $_GET['col']);
    $_SESSION['game_state'] = $game->getGrid();
    header("Location: index.php");
    exit;
}

$grid = $game->getGrid();
$isFinished = $game->isFinished();

require_once 'BoardView.php';