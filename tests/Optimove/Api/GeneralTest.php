<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Tests\Optimove\Api;

use GenesisGlobal\Optimove\Optimove\Api\General;
use GenesisGlobal\Optimove\Optimove\HttpClientInterface;

class GeneralTest extends \PHPUnit_Framework_TestCase
{
  /** @var  General */
  protected $promotions;

  /** @var \PHPUnit_Framework_MockObject_MockObject */
  protected $httpClient;

  public function setUp()
  {
    $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)->disableOriginalConstructor()->getMock();
  }

  protected function getGeneral()
  {
    return new General($this->httpClient);
  }

  public function testLogin()
  {
    $token = 'hello-world';
    $testData = ['Username' => 'lorem', 'Password' => 'ipsum'];
    $this->httpClient->expects($this->once())->method('request')->with('general/login', 'POST', $testData)
      ->willReturn($token);
    $this->httpClient->expects($this->once())->method('addHeader')->with('Authorization-Token', $token);

    $general = $this->getGeneral();
    $general->login($testData['Username'], $testData['Password']);
  }


}