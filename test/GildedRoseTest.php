<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase
{
    public function testSafetyNet()
    {
        $legacyItems = array(
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49)
        );
        
        $items = array(
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49)
        );

        $legacy = new LegacyGildedRose($legacyItems);
        $new = new GildedRose($items);

        for ($i = 0; $i < 50; $i++) {
            $legacy->updateQuality();
            $new->updateQuality();

            $this->assertEquals(array_map(function ($item) {
                return $item->name;
            }, $legacyItems), array_map(function ($item) {
                return $item->name;
            }, $items));

            $this->assertEquals(array_map(function ($item) {
                return $item->sell_in;
            }, $legacyItems), array_map(function ($item) {
                return $item->sell_in;
            }, $items));

            $this->assertEquals(array_map(function ($item) {
                return $item->quality;
            }, $legacyItems), array_map(function ($item) {
                return $item->quality;
            }, $items));
        }
    }
    
    public function testConjured() {
        $conjured = new Item('Conjured Mana Cake',2, 2);
        $new = new GildedRose(array($conjured));
        
        $new->updateQuality();
        
        $this->assertEquals(0, $conjured->quality);
    }
    
    public function testConjured_should_reduce_quality_only_when_greater_than_zero() {
        $conjured = new Item('Conjured Mana Cake',2, 0);
        $new = new GildedRose(array($conjured));

        $new->updateQuality();

        $this->assertEquals(0, $conjured->quality);
    }
    
    public function testConjured_should_reduce_quality_another_time_when_sell_in_is_negative() {
        $conjured = new Item('Conjured Mana Cake',0, 4);
        $new = new GildedRose(array($conjured));

        $new->updateQuality();

        $this->assertEquals(0, $conjured->quality);
    }
    
    public function testConjured_should_not_reduce_quality_another_time_when_sell_in_is_negative_but_quality_already_negative() {
        $conjured = new Item('Conjured Mana Cake',0, 2);
        $new = new GildedRose(array($conjured));

        $new->updateQuality();

        $this->assertEquals(0, $conjured->quality);
    }
    
    /*
     * si sell_in < 0 && quality > 0 alors quality - 2 
     * 
     * */
}
