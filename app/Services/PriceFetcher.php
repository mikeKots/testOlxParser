<?php
namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class PriceFetcher
{
    /**
     * Fetch price from OLX ad URL
     *
     * @param string $html
     * @return int|null
     */
    public function fetchPrice(string $html): ?int
    {
        $crawler = new Crawler($html);

        try {
            // or any selector that matches the price
            $priceNode = $crawler->filter('h3.css-12vqlj3, div.css-dcwlyx, div.css-e2ir3r');

            if ($priceNode->count() > 0) {
                $priceText = $priceNode->text();

                if (preg_match('/(\d[\d\s]*)/', $priceText, $matches)) {
                    return (int) str_replace(' ', '', $matches[1]);
                }
            }
        } catch (\Exception $e) {
            \Log::error("Price fetch error: " . $e->getMessage());
        }

        return null;
    }
}
