<?php

namespace App;

final class GildedRose
{

    private $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function updateQuality()
    {
        foreach ($this->items as $item) {
            if ($item->name == 'Sulfuras, Hand of Ragnaros') {
                $this->sulfurasUpdateQuality($item);
                continue;
            }

            $item->sell_in--;

            if ($item->name == 'Aged Brie') {
                $this->agedBrieUpdateQuality($item);
            } else if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                $this->backstageUpdateQuality($item);
            } else if ($item->name == 'Conjured Mana Cake') {
                $this->conjuredUpdateQuality($item);
            } else {
                $this->normalUpdateQuality($item);
            }
        }
    }

    /**
     * @param $item
     */
    private function agedBrieUpdateQuality($item): void
    {
        if ($item->quality < 50) $item->quality++;
        if ($item->sell_in < 0 && $item->quality < 50) $item->quality++;
    }

    /**
     * @param $item
     */
    private function backstageUpdateQuality($item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
            if ($item->sell_in < 10 && $item->quality < 50) $item->quality++;
            if ($item->sell_in < 5 && $item->quality < 50) $item->quality++;
        }
        if ($item->sell_in < 0) $item->quality = 0;
    }

    /**
     * @param $item
     */
    private function normalUpdateQuality($item): void
    {
        if ($item->quality > 0)
            $item->quality--;

        if ($item->sell_in < 0 && $item->quality > 0)
            $item->quality--;
    }

    /**
     * @param $item
     */
    private function sulfurasUpdateQuality($item): void
    {
        if ($item->quality > 0) $item->quality = 80;
    }

    /**
     * @param $item
     */
    private function conjuredUpdateQuality($item): void
    {
        if ($item->quality > 0) {
            $item->quality -= 2;
        }

        if ($item->sell_in < 0 && $item->quality > 0) {
            $item->quality -= 2;
        }
    }
}

