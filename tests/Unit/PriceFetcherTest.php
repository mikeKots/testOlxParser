<?php
namespace Tests\Unit;
use App\Services\PriceFetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;
class PriceFetcherTest extends TestCase {
    public function test_parses_price_from_html(): void {
        $html = '<div data-testid="ad-price-container">12 345 грн</div>';
        $mock = new MockHandler([ new Response(200, [], $html) ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $fetcher = new PriceFetcher($client);
        $price = $fetcher->fetch('https://example.com/ad1');
        $this->assertEquals(12345.00, $price);
    }
    public function test_returns_null_when_no_price(): void {
        $html = '<html><body>No price here</body></html>';
        $mock = new MockHandler([ new Response(200, [], $html) ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $fetcher = new PriceFetcher($client);
        $price = $fetcher->fetch('https://example.com/ad1');
        $this->assertNull($price);
    }
}
