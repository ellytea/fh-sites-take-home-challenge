<?php

namespace PokerHand;

class PokerHand {

    private $hand;
    private $ranks = ['2','3','4','5','6','7','8','9','T','J','Q','K','A'];
    private $suits = ['s', 'c', 'd', 'h'];
    private $rank_cards;
    private $suit_cards;
    private $is_paired;

    //passes a string of cards(no spaces)
    public function __construct($hand) {
      //Replaces '10' with 'T' for easy char count
      $noTen = str_replace('10', 'T', $hand);
      $this->hand = str_replace(' ', '', $noTen);

      foreach(count_chars($this->hand, 1) as $char => $val) {
        in_array(chr($char),$this->ranks) ? $this->rank_cards[chr($char)] = $val :$this->suit_cards[chr($char)] = $val;
      } 
    }

    private function check_pairs(){
      $faceCount = array_values($this->rank_cards);
      sort($faceCount);
      $faceCount == [2, 3]? $this->is_paired = 'One Pair': null;
      $faceCount == [1, 2, 2]? $this->is_paired = 'Two Pairs': null;
      $faceCount == [1, 1, 3]? $this->is_paired = 'Three Pairs': null;
      $faceCount == [1, 4]? $this->is_paired = 'Four of a Kind': null;
      $faceCount == [2, 3]? $this->is_paired = 'Full House': null;
      $faceCount == [1,1,1,1,1]?$this->check_royal() :null;
    }

    private function check_flush(){
      return array_sum($this->suit_cards) == 5 ? true:false;
    }

    private function check_royal(){
      $card_keys = array_keys($this->rank_cards);
      if (preg_match("/[TJQKA]/", $card_keys[0]) === 1){
        return true;
      } else {
        $this->check_straight($card_keys);
      } 
    }

    private function check_straight(){
      $keys = array_keys($this->rank_cards);
      if ($keys[0]+1 == $keys[1] && $keys[1]+1 == $keys[2]){
         return true;
      } else{
      }
    }
    
    public function rank_hand(){
      $this->check_pairs();
      if ($this->check_royal() && $this->check_flush()){
        return "Royal Flush!";
      }
      if($this->check_royal() && !$this->check_flush()){
        return "Straight Flush";
      }
      if($this->is_paired){
        return $this->is_paired;
      }
      if($this->check_straight()){
        return "Straight";
      }
      if ($this->check_flush()){
        return "Flush";
      }
      else {
        return "High Card";
      }
    }
}

?>