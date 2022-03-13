<?php 

class adminContr extends Admin {

  public function usersList(){
    $this->searchMember();
  }

  public function showInspectedUser(){
    $this->inspectUser();
  }

  public function productsList(){
    $this->showProduct();
  }

  public function showInspectedProduct(){
    $this->inspectProduct();
  }

  public function showSearchMember(){
    $this->searchMembers();
  }

  public function showReviews(){
    $this->adminReviews();
  }
}