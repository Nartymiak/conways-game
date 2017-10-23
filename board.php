<?php
/**
 * Conways game of life
 * PHP version 5.2.9
 *
 * @author  Nick Artymiak
**/


  class Board {
    private $board = array();

    public function __construct() {
    }


   /**
   * adds a Cell to the Board
   */
    public function addCell($row,$col,$cell){
      if(is_int($row) && is_int($col) && get_class($cell) ==="Cell" ){
        $this->board[$row][$col] = $cell;
      }
    }

   /**
   * gets the cell in a board space
   * @param int, int | the row and column coordinates
   * @return Cell | the cell
   */
    public function getCell($row,$col){
      $rowCount = $this->getRowCount();
      // out of bounds request return a dead cell
      if($row < 0 || $col < 0 || $row >= $rowCount || $col >= $rowCount ){
        $deadCell = new Cell();
        $deadCell->death();
        return $deadCell;
      } else {
        return($this->board[$row][$col]);
      }
    }

   /**
   * echos the board to the DOM while wrapped in <pre> tags.
   */
    public function showBoard() {

      echo "<pre>";
        foreach($this->board as $key => $row){
          foreach($row as $key2 => $cell){
            echo $cell->getStatus();
          }
          echo "\n\r";
        }
      echo "</pre>";
    }

    /**
   * Counts the number of rows by counting the number of arrays in the Board array
   * @return int | number of rows
   */
    public function getRowCount() {
      return sizeof($this->board);
    }

    /**
   * First checks the board object to see if the number of columns in each row are same.
   * Second checks to see if the number of rows is same as number of columns
   * @return Bool | if its a square grid or not
   */
    public function isSquareGrid(){
      $c = 0;
      $r = 0;
      $numberOfCols = 0;
      foreach($this->board as $row){
        foreach($row as $col){
          $c++;
        }
        if($r>0){
          if ($numberOfCols !== $c){
            return false;
          }
        }else{
          $numberOfCols = $c;
        }
        $c = 0;
        $r++;
      }

      if($numberOfCols !== $this->getRowCount()){
        return false;
      }

      return true;
    }
  }

 ?>
