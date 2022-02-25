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

  public function GetUsername() { return $this->username; }
  public function GetRating() { return $this->rating / 5 * 100; }
  public function GetFeedback() { return $this->feedback; }
}