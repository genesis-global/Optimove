<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Tests\Optimove;

use GenesisGlobal\Optimove\Optimove\CurlWrapperInterface;
use GenesisGlobal\Optimove\Optimove\HttpClient;
use Httpful\Response;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{

  protected $baseUrl = 'http://localhost/';

  /** @var \PHPUnit_Framework_MockObject_MockObject */
  protected $curlWrapper;

  public function setUp()
  {
    $this->curlWrapper = $this->getMockBuilder(CurlWrapperInterface::class)->disableOriginalConstructor()->getMock();
  }

  public function tearDown()
  {
    \Mockery::close();
  }

  public function getHttpClient()
  {
    return new HttpClient($this->curlWrapper, $this->baseUrl);
  }


  public function testRequest()
  {
    $uri = 'test-uri';
    $method = 'POST';
    $parameters = ['lorem' => 'ipsum'];

    $response = $this->prophesize(Response::class);
    $response->body = 'Hello World';
    $response->code = '200';

    $httpClient = $this->getHttpClient();

    $this->curlWrapper->expects($this->once())->method('sendRequest')
      ->with($method, $this->baseUrl . $uri, $httpClient->getHeaders(), json_encode($parameters))
      ->willReturn($response->reveal());


    $actual = $httpClient->request($uri, $method, $parameters);
    $this->assertEquals($response->body, $actual);
  }

  /**
   * @expectedException \GenesisGlobal\Optimove\Optimove\Exceptions\ResponseException
   */
  public function testRequestExpectResponseException()
  {
    $uri = 'test-uri';
    $method = 'POST';
    $parameters = ['lorem' => 'ipsum'];

    $response = $this->prophesize(Response::class);
    $response->code = '400';

    $httpClient = $this->getHttpClient();

    $this->curlWrapper->expects($this->once())->method('sendRequest')
      ->with($method, $this->baseUrl . $uri, $httpClient->getHeaders(), json_encode($parameters))
      ->willReturn($response->reveal());

    $httpClient->request($uri, $method, $parameters);
  }

  public function testAddHeader()
  {
    $httpClient = $this->getHttpClient();
    $httpClient->addHeader('test-header', 'test-value');

    $actual = $httpClient->getHeaders();
    $this->assertInternalType('array', $actual);
    $this->assertArrayHasKey('test-header', $actual);
    $this->assertEquals($actual['test-header'], 'test-value');
  }

}