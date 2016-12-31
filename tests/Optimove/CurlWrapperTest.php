<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Tests\Optimove;

use GenesisGlobal\Optimove\Optimove\CurlWrapper;
use Httpful\Response;

class CurlWrapperTest extends \PHPUnit_Framework_TestCase
{
  /** @var  CurlWrapper */
  private $wrapper;

  public function setUp()
  {
    $response = $this->prophesize(Response::class);
    $mock = \Mockery::mock('alias:Httpful\Request');
    $mock->shouldReceive('get')->andReturn($mock);
    $mock->shouldReceive('post')->andReturn($mock);
    $mock->shouldReceive('addHeader')->andReturn($mock);
    $mock->shouldReceive('send')->andReturn($response->reveal());
    $this->wrapper = new CurlWrapper();
  }

  public function tearDown()
  {
    \Mockery::close();
  }

  /**
   * @dataProvider dataProvider
   */
  public function testSendRequest($method, $url, $headers, $data)
  {
    $actual = $this->wrapper->sendRequest($method, $url, $headers, $data);
    $this->assertInstanceOf(Response::class, $actual);
  }

  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage  Method: PUT is not supported.
   */
  public function testSendRequestExpectException()
  {
    $this->wrapper->sendRequest('PUT', '', [], '');
  }

  public function dataProvider()
  {
    return [
      ['GET', 'hello', [], ''],
      ['POST', 'world', ['header1' => 'value1'], '']
    ];
  }

}