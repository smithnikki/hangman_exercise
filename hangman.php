<?php

class Hangman {
  private $remaining_wrong_guesses = 10;
  private $word;
  private $letters = [];

  public function __construct() {
    echo "Starting the game\n";
    $this->word = file_get_contents("http://randomword.setgetgo.com/get.php?len=10");
    $this->printState();
    $this->listenForInput();

    // for ($i = 0; $i < strlen($word); $i ++) {
      // if ($word[$i] = $guess) {
        // echo $guess . " ";
        // $rightAnwer = true;
      // } else {
        // echo "_ ";
      // };
    // }
  }

  private function printState() {
    echo "Remaining wrong guesses: " . $this->remaining_wrong_guesses . "\n";
    for($i = 0; $i < strlen($this->word) ; $i++) {
      echo "_ ";
    }
    echo "\n";
  }

  private function listenForInput() {
    echo "Please type a letter: ";
    $input = readline();
    array_push ($this->letters, $input);
    $this->listenForInput();
  }

}


$hangman = new Hangman();
