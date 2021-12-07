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
            echo "Test wordcount_function Passed\n";
        }
        else
        {
            echo "Test wordcount_function Failed\n";
            exit(1);
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
        echo "Test Get_ValidInput Passed\n";
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
        $this->assertEquals('No Text Entered', $data['string']);
        echo "Test Get_NoInput Passed\n";
    }

    public function testGet_WrongInput_Wordcount() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://wordcount.40234272.qpc.hal.davecutting.uk']);
        
        try {
            $response = $this->client->get('/test');
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $this->assertEquals(404, $response->getStatusCode());
            echo "Test Get_WrongInput Passed\n";
        }
        
    }

    public function testGet_TenWord_Wordcount() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://wordcount.40234272.qpc.hal.davecutting.uk']);
        
        $response = $this->client->get('/', [
            'query' => [
                'text' => 'this is an api test to check for ten words'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertArrayHasKey('string', $data);
        $this->assertArrayHasKey('answer', $data);
        $this->assertEquals(10, $data['answer']);
        echo "Test Get_TenWord Passed\n";
    }

}

$t = new Test();

$t->test_wordcount_function();
$t->testGet_ValidInput_Wordcount();
$t->testGet_NoInput_Wordcount();
$t->testGet_WrongInput_Wordcount();
$t->testGet_TenWord_Wordcount();

exit(0);
