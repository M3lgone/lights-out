# Lights Out – PHP Puzzle Game

A small Lights Out puzzle game built with plain PHP, no frameworks.

Clicking a light toggles it plus its orthogonal neighbours. Turn off all the lights to win.

## Demo

Screenshot coming soon (`screenshots/game.png`).

Capture recommendation: mid-game board with some lights ON and some OFF, with the move counter and controls visible.

## Rules

- The goal is to turn off all the lights.
- Clicking a cell toggles itself plus up / down / left / right.
- Clicks outside the board are not possible; edge and corner cells only affect existing neighbours.
- You win when every light is OFF.

## How to Run

Start the PHP built-in server from the project folder:

```bash
php -S localhost:8000
```

Then open in your browser:

```text
http://localhost:8000/index.php
```

Controls:

- `Restart` restores the initial board of the current game and resets the move counter.
- `Randomize` generates a new random board (random size between 3 and 6) and resets the move counter.

## Project Structure

- `index.php` – controller: session state (`initial` / `current` / `moves`), input validation, Restart / Randomize, PRG redirects.
- `LightsOutGame.php` – game logic: flip, orthogonal neighbours, board limits, win condition, solvable random board generation.
- `BoardView.php` – presentation only: HTML + Tailwind CSS via CDN, responsive board, accessibility labels.

## Tech

- PHP (no frameworks, `declare(strict_types=1)`)
- Tailwind CSS via CDN (kept intentionally: no build step needed for this size)
- PHP sessions for game state
- Post/Redirect/Get after every action to avoid duplicate moves on refresh

Board generation: each game starts from an all-OFF board with random size 3–6, then applies random valid moves. This keeps the random size from the original kata while ensuring boards are reachable and never start already solved.
