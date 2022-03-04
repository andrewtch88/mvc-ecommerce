<?php

class Review{
  private $username;
  private $rating;
  private $feedback;

  function __construct($username, $rating, $feedback)
  {
    $this->username = $username;
    $this->rating = $rating;
    $this->feedback = $feedback;
  }

  public function getUsername() { return $this->username; }
  public function getRating() { return $this->rating / 5 * 100; }
  public function getFeedback() { return $this->feedback; }
}