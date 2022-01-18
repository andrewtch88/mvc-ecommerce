<?php 

class InitDbExec extends InitDB{
  public function initDbExec() {
    $this->CreateNeededTables();
  }
}