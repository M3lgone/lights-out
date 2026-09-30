<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/LightsOutGame.php';

function createNewGameState(): array
{
    $game = LightsOutGame::random();
    $grid = $game->getGrid();

    return [
        'initial' => $grid,
        'current' => $grid,
        'moves' => 0,
    ];
}

function isValidGameState(mixed $state): bool
{
    if (!is_array($state)) {
        return false;
    }

    if (!isset($state['initial'], $state['current'], $state['moves'])) {
        return false;
    }

    if (!is_int($state['moves']) || $state['moves'] < 0) {
        return false;
    }

    try {
        $initial = new LightsOutGame($state['initial']);
        $current = new LightsOutGame($state['current']);
    } catch (InvalidArgumentException | TypeError) {
        return false;
    }

    return $initial->getRows() === $current->getRows()
        && $initial->getCols() === $current->getCols();
}

if (isset($_GET['randomize'])) {
    $_SESSION['game'] = createNewGameState();
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['game']) || !isValidGameState($_SESSION['game'])) {
    $_SESSION['game'] = createNewGameState();
}

if (isset($_GET['restart'])) {
    $_SESSION['game']['current'] = $_SESSION['game']['initial'];
    $_SESSION['game']['moves'] = 0;
    header('Location: index.php');
    exit;
}

$game = new LightsOutGame($_SESSION['game']['current']);

if (isset($_GET['row'], $_GET['col']) && !$game->isFinished()) {
    $row = filter_var($_GET['row'], FILTER_VALIDATE_INT);
    $col = filter_var($_GET['col'], FILTER_VALIDATE_INT);

    $isInsideBoard = $row !== false
        && $col !== false
        && $row >= 0 && $row < $game->getRows()
        && $col >= 0 && $col < $game->getCols();

    if ($isInsideBoard) {
        $game->flip($row, $col);
        $_SESSION['game']['current'] = $game->getGrid();
        $_SESSION['game']['moves']++;
    }

    header('Location: index.php');
    exit;
}

$grid = $game->getGrid();
$isFinished = $game->isFinished();
$moves = $_SESSION['game']['moves'];

require_once __DIR__ . '/BoardView.php';
