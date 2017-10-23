<?php
/**
 * Conways game of life
 * PHP version 5.2.9
 *
 * @author  Nick Artymiak
**/


include_once('cell.php');
include_once('board.php');
ini_set("auto_detect_line_endings", true);


class Game {

  private $board;
  private $stepBoard; // holds the new board after one turn.
  private $filepath;
  private $fileSize;
  private $file;

 /**
 * constructor for game object
 * @param String | the filepath to a plain text file a square grid of 1's and 0's.
 */
  public function __construct($fp) {

    $this->board = new Board();
    $this->filepath = $fp;
    $this->fileSize = filesize($this->filepath);
  }

  /**
 * opens the file and parses the contents
 * @return true if there are no errors
 * @throws Exception if file doesnt exist, is not a file, failed to open, other characters than 1's and 0's
 */
  public function startGame(){

    try {
      $this->openFile($this->filepath);
      $this->loopThroughContents();

    } catch(Exception $e) {
        echo "Could not start game: " .$e->getMessage();
    }

    return true;
  }

  /**
 * called from outside the app, from javascript or url call perhaps. Steps the game through 1 round.
 * calls showBoard which prints the game twice. Once before the round and once after the round.
 */
  public function stepGameTurn(){

    $this->stepBoard = new Board();
    $this->board->showBoard();
    $gridSize = $this->board->getRowCount();
    $cell;
    $stepCell;

    if($this->board->isSquareGrid()){
      // for rows
      for($i = 0; $i<$gridSize; $i++){
        //for columns
        for($j = 0; $j<$gridSize; $j++){
          $cell = $this->board->getCell($i,$j);
          $liveNeighbors = $this->analyzeNeighbors($i,$j);
          $stepCell = $this->processRulesOfTheGame($cell, $liveNeighbors);
          // add the result of processRulesOfTheGame to the step board
          $this->stepBoard->addCell($i,$j,$stepCell);
        }
      }
      $this->stepBoard->showBoard();
    }
  }

  /**
 * Called in stepGameTurn() on each cell.
 * Determines the new status of the cell based on rules set in the game
 * @return Cell | a copy of the cell after it is evaluated by the rules of the game
 * @throws Exception if state is not a 1 or 0 and somehow mutated
 */
  private function processRulesOfTheGame($cell, $liveNeighbors){

    $stepCell =  new Cell();
    $stepCell->setStatus($cell->getStatus());

    if($cell->getStatus() === 1){

      //Any live cell with fewer than two live neighbors dies, as if caused by under­population.
      if($liveNeighbors < 2){
        $stepCell->death();

      //Any live cell with more than three live neighbors dies, as if by over­population
      }elseif($liveNeighbors > 3){
        $stepCell->death();

      //Any live cell with two or three live neighbors lives on to the next generation.
      }else{
        $stepCell->live();
      }

    }else if($cell->getStatus() === 0){

      //Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.
      if($liveNeighbors === 3){
        $stepCell->live();
      }
    }else{
      throw new Exception("Mutated, the status is neighter 1 or 0. Hmmmm.");
    }
    // don't change the original one so you dont affect further calculations
    return $stepCell;
  }

  /**
 * @return integer | the number of cells surrounding cell that are alive.
 */
  private function analyzeNeighbors($row,$col){
    //echo 'analyzing: ' .$row. ", " .$col. "<br>";
    $liveNeighbors = 0;
    for($k=-1;$k<2;$k++){
      for($l=-1;$l<2;$l++){

        $rowCoord = $row + $k;
        $colCoord = $col + $l;

        //echo "coord: " .$rowCoord. ", " .$colCoord. "<br>";
        if($row != $rowCoord || $col != $colCoord){

          $cell = $this->board->getCell($row + $k, $col + $l);
          $tvr = $row+$k;
          $tvc = $col+$l;
          //echo 'neighbor: ' .$tvr. ', ' .$tvc. ' status: ' .$cell->getStatus(). '<br>';

          if( $cell->getStatus() == 1){
            $liveNeighbors ++;
          }
        }
      }
    }
    //echo "liveNeighbors: " + $liveNeighbors. "<br>";
    return $liveNeighbors;
  }
  /**
 * checks the file path for errors, calls fopen
 * @return a copy of the cell after it is evaluated by the rules of the game
 * @throws Exception if path doesnt lead to a file or fopen fails
 */
  private function openFile($filepath) {

    if(!file_exists($filepath) || !is_file($filepath)){
        throw new Exception("File does not exist or incorrect file name supplied.");
    }

    try {
      $this->file = fopen($filepath, 'r');
    }
    catch(Exception $e) {
      echo "Could not open file: " .$e->getMessage();
    }
  }

  /**
 * parse the contents that should be 1's and 0's representing cells into a board object that is already initialized.
 * creates Cell objects and adds them to the Board. Closes the file.
 * @throws Exception if a character being scanned is not a 1,0, or newline
 */
  private function loopThroughContents() {
    //counts
    $row = 0;
    $col = 0;

    // loop through each each line from filereader
    while(!feof($this->file)){
      $line = fgets($this->file);

      // loop through each character in the line
      for($i=0;$i<strlen($line);$i++){

        // add cell and kill it
        if( $line[$i] == '0' ){
          $cell = New Cell();
          $cell->death();
          $this->board->addCell($row,$col,$cell);
          $col ++;
        // add cell and let it live
        } else if ($line[$i] == '1' ){
          $cell = New Cell();
          $this->board->addCell($row,$col,$cell);
          $col ++;
        // in case the character is a newlne ...
        } else if ($line[$i] == 0 ){

        }else{
          // if its anything else throw an error
          throw new Exception("File contains characters other than 1, 0, and returns.");
        }
      }
      // increment the row and reset the column count
      $row ++;
      $col = 0;
    }
    fclose($this->file);
  }
}


?>
