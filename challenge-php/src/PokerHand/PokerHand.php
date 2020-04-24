<?php

namespace PokerHand;

class PokerHand {

    private $hand;
    private $ranks = ['2','3','4','5','6','7','8','9','T','J','Q','K','A'];
    private $suits = ['s','c','d','h'];
    private $rank_cards;
    private $suit_cards;
    private $result = 'High Card';

    //passes a string of cards //ex. 'As Ks Qs Js 10s'
    public function __construct($str) {
      $t_hand = str_replace('10', 'T', $str);
      $str_hand = str_replace(' ', '', $t_hand);
      $hand = explode(' ', $t_hand);
      //creates key value array //ex.['A'=>2, '4'=>1, '6'=>1, '10'=>1]
      foreach(count_chars($str_hand, 1) as $char => $val) {
        in_array(chr($char),$this->ranks) ? $this->rank_cards[chr($char)] = $val :$this->suit_cards[chr($char)] = $val;
      }
      //creates array of only values stored in $hand //ex. [10,11,12,13,14]
      $keys = array_keys($this->rank_cards);
      foreach($hand as $el){
        $trim = rtrim($el, $el[1]);
        if ($trim == 'A' && array_sum($keys) == 14){
          $this->hand[] = 1;
          continue;
        }
        $this->hand[] = array_search($trim, $this->ranks)+2;
      }
    }

    private function check_pairs(){
      $faceCount = array_values($this->rank_cards);
      sort($faceCount);
      $faceCount == [1,1,1,1,1]? $this->check_royal(): null;
      $faceCount == [1, 1, 1, 2]? $this->result = 'One Pair': null;
      $faceCount == [1, 2, 2]? $this->result = 'Two Pairs': null;
      $faceCount == [1, 1, 3]? $this->result = 'Three of a Kind': null;
      $faceCount == [1, 4]? $this->result = 'Four of a Kind': null;
      $faceCount == [2, 3]? $this->result = 'Full House': null;
    }

    private function check_flush(){
      return count($this->suit_cards) === 1? true: false;
    }

    private function check_royal(){
      array_sum($this->hand) === 60 && $this->check_flush()? $this->result = 'Royal Flush': $this->check_straight();
    }

    private function check_straight(){
      sort($this->hand);
     if ($this->hand == range($this->hand[0], $this->hand[4]) && $this->check_flush()){
        $this->result = 'Straight Flush';
     } else if ($this->hand == range($this->hand[0],$this->hand[4])){
       $this->result = 'Straight';
     }
    }
    
    public function get_rank(){
      $this->check_pairs();
      if ($this->check_flush() && $this->result == 'High Card'){
        $this->result = 'Flush';
      }
     return $this->result;
    }
}

?>