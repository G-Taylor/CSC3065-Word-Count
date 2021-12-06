<?php
echo "Test Script Starting\n";
require('functions.inc.php');
require('vendor/autoload.php');
use PHPUnit\Framework\TestCase;


class Test extends TestCase {

    protected $client;
    
    public function test_wordcount_function() {
        $t ="there are four words";
        $expect=4;

        $answer=wordcount($t);

        echo "Test Result: '".$t."'=".$answer." (expected: ".$expect.")\n";

        if ($answer==$expect)
        {
            echo "Test Passed\n";
        }
        else
        {
            echo "Test Failed\n";
        }
    }

    public function testGet_ValidInput_Wordcount() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://wordcount.40234272.qpc.hal.davecutting.uk']);
        
        $response = $this->client->get('/', [
            'query' => [
                'text' => 'this is a test'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertArrayHasKey('string', $data);
        $this->assertArrayHasKey('answer', $data);
        $this->assertEquals(4, $data['answer']);
        echo "Test Passed\n";
    }

    public function testGet_NoInput_Wordcount() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://wordcount.40234272.qpc.hal.davecutting.uk']);
        
        $response = $this->client->get('/', [
            'query' => [
                'text' => ''
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertArrayHasKey('string', $data);
        $this->assertArrayHasKey('answer', $data);
        $this->assertEquals(0, $data['answer']);
        echo "Test Passed\n";
    }
}
