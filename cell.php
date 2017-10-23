<?php
/**
 * Conways game of life
 * PHP version 5.2.9
 *
 * @author  Nick Artymiak
**/


class Cell {

  private $status = 1;

  public function __construct(){

  }

 /**
 * status of Cell, if alive (1) or dead (0)
 * @return int | the status
 */
  public function getStatus(){
    return $this->status;
  }

 /**
 * sets Status based on param
 *@param int | 1 or 0
 */
  public function setStatus($s){
    $this->status = $s;
  }

 /**
 * death to cell, status = 0;
 */
  public function death(){
    $this->status = 0;
  }

  /**
  * life to cell, status = 1;
  */
  public function live(){
    $this->status = 1;
  }

}

?>
