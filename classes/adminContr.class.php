<?php 

class adminContr extends Admin {

  public function usersList(){
    $this->searchMember();
  }

  public function showInspectedUser(){
    $this->inspectUser();
  }

  public function setUser(){
    $this->createUser();
  }
}