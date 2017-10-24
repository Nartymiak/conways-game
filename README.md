# conways-game
Conway's game of life

The universe is a finite twodimensional grid of square cells (square matrix).
Each cell has 2 possible states, alive or dead. Every cell interacts with its neighbors, which are the cells that are horizontally, vertically, or diagonally adjacent. Therefore, a cell can have up to eight neighbors.
At each step in time, the following transitions occur: 
1. Any live cell with fewer than two live neighbors dies, as if caused by underpopulation.
2. Any live cell with two or three live neighbors lives on to the next generation.
3. Any live cell with more than three live neighbors dies, as if by overpopulation.
4. Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.

Program accepts a file path as its argument, which contains the initial set cells, and
outputs the next state of the universe based on the rules above. The file will contain only 0s and
1s. 1 means alive, 0 means dead. Out of bounds neighbors as dead.
