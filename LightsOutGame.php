<?php

class LightsOutGame
{
    private array $grid;
    private int $rows;
    private int $cols;

    public function __construct(array $initialState)
    {
        $this->grid = $initialState;
        $this->rows = count($initialState);
        $this->cols = count($initialState[0]);
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
}