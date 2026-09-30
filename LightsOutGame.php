<?php

declare(strict_types=1);

class LightsOutGame
{
    public const MIN_SIZE = 3;
    public const MAX_SIZE = 6;

    private array $grid;
    private int $rows;
    private int $cols;

    public function __construct(array $initialState)
    {
        if ($initialState === []) {
            throw new InvalidArgumentException('Initial state must not be empty.');
        }

        $expectedCols = null;
        foreach ($initialState as $row) {
            if (!is_array($row) || $row === []) {
                throw new InvalidArgumentException('Each row must be a non-empty array.');
            }
            if ($expectedCols === null) {
                $expectedCols = count($row);
            } elseif (count($row) !== $expectedCols) {
                throw new InvalidArgumentException('All rows must have the same number of columns.');
            }
            foreach ($row as $cell) {
                if (!is_bool($cell)) {
                    throw new InvalidArgumentException('Each cell must be a boolean.');
                }
            }
        }

        $this->grid = array_values(array_map('array_values', $initialState));
        $this->rows = count($this->grid);
        $this->cols = count($this->grid[0]);
    }

    public static function random(?int $size = null): self
    {
        $size ??= random_int(self::MIN_SIZE, self::MAX_SIZE);

        if ($size < self::MIN_SIZE || $size > self::MAX_SIZE) {
            throw new InvalidArgumentException(
                sprintf('Size must be between %d and %d.', self::MIN_SIZE, self::MAX_SIZE)
            );
        }

        $offGrid = array_fill(0, $size, array_fill(0, $size, false));
        $game = new self($offGrid);

        $scrambleMoves = $size * $size;
        for ($i = 0; $i < $scrambleMoves; $i++) {
            $game->flip(random_int(0, $size - 1), random_int(0, $size - 1));
        }

        if ($game->isFinished()) {
            $game->flip(random_int(0, $size - 1), random_int(0, $size - 1));
        }

        return $game;
    }

    public function flip(int $row, int $col): void
    {
        $this->flipCell($row, $col);
        $this->flipCell($row - 1, $col);
        $this->flipCell($row + 1, $col);
        $this->flipCell($row, $col - 1);
        $this->flipCell($row, $col + 1);
    }

    private function flipCell(int $row, int $col): void
    {
        $isInsideBoard = $row >= 0 && $row < $this->rows && $col >= 0 && $col < $this->cols;

        if ($isInsideBoard) {
            $this->grid[$row][$col] = !$this->grid[$row][$col];
        }
    }

    public function isFinished(): bool
    {
        foreach ($this->grid as $row) {
            foreach ($row as $cell) {
                if ($cell) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function getCols(): int
    {
        return $this->cols;
    }
}
