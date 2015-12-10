<?php

require_once("hangman_drawer.php");

class Hangman {

  const LIMIT = 10;
  private $word;
  private $good_letters = [];
  private $bad_letters = [];
  private $drawer;

  public function __construct() {
    echo "Starting the game\n";
    $this->drawer = new HangmanDrawer();
    $this->word = str_split(
      strtolower(
        file_get_contents("http://randomword.setgetgo.com/get.php")
      )
    );
    $this->printState();
    $this->listenForInput();
  }

  private function printState() {
    echo "Remaining wrong guesses: " . (self::LIMIT - count($this->bad_letters)) . "\n";
    echo "Bad guesses: [" . join(', ', $this->bad_letters) . "]\n";
    $this->printWordInProgress();
    $this->drawer->draw(count($this->bad_letters));
    echo "\n\n\n\n";
  }

  private function listenForInput() {
    echo "Please type a letter: ";
    $input = readline();
    $this->handleInput($input);
    $this->listenForInput();
  }

  private function handleInput($input) {
    $input = strtolower($input);
    if ($this->validateInput($input)) {
      if (in_array($input, $this->good_letters) || in_array($input, $this->bad_letters)) {
        echo "You already played that letter, weirdo. Pick again! \n\n\n";
      } else {
        if (in_array($input, $this->word)) {
          array_push($this->good_letters, $input);
        } else {
          array_push($this->bad_letters, $input);
          if(count($this->bad_letters) >= self::LIMIT) {
            $this->printState();
            echo "The word is: " . join("", $this->word) . "\n";
            echo "OMG, you murderer. You just hung someone. Game over!\n";
            exit(0);
          }
        }
      }
    } else {
      echo "ERROR: Nope. Can't do that. Please enter a single letter\n\n";
    }
    $this->printState();
  }

  private function validateInput($input) {
    if (strlen($input) != 1) {
      return false;
    }
    if (!ctype_alpha($input)) {
      return false;
    }
    return true;
  }

  private function printWordInProgress() {
    $game_won = true;
    foreach($this->word as $letter) {
      if(in_array($letter, $this->good_letters)) {
        echo $letter . " ";
      } else {
        echo "_ ";
        $game_won = false;
      }
    }
    echo "\n";
    if ($game_won){
      echo "\n Hooray!!\n";
      exit(0);
    }
  }


}


$hangman = new Hangman();
