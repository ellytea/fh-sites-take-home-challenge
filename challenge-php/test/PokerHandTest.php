<?php
namespace PokerHand;

use PHPUnit\Framework\TestCase;

class PokerHandTest extends TestCase
{
    /**
     * @test
     */
    public function check_royal()
    {
        $hand = new PokerHand('As Ks Qs Js 10s');
        $this->assertEquals('Royal Flush', $hand->get_rank());
    }

    /**
     * @test
     */
    public function check_pairs()
    {
        $hand = new PokerHand('Ah As 10c 7d 6s');
        $this->assertEquals('One Pair', $hand->get_rank());
    }

    /**
     * @test
     */
    public function check_straight()
    {
        $hand = new PokerHand('3h 4c 5s 6h 7d');
        $this->assertEquals('Straight', $hand->get_rank());
    }

    /**
     * @test
     */
    public function check_flush()
    {
        $hand = new PokerHand('Kh Qh 6h 2h 9h');
        $this->assertEquals('Flush', $hand->get_rank());
    }

    // TODO: More tests go here
}