<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Tests;

use GenesisGlobal\Optimove\Client;
use GenesisGlobal\Optimove\Optimove\Api\General;
use GenesisGlobal\Optimove\Optimove\Api\Integrations\Promotions;
use GenesisGlobal\Optimove\Optimove\HttpClientInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{
  public function getClient()
  {
    $httpClient = $this->prophesize(HttpClientInterface::class);
    $httpClient->request("general/login", "POST", ["Username" => "hello", "Password" => "world"])
      ->willReturn('hello-world');
    $httpClient->addHeader("Authorization-Token", "hello-world")->willReturn('');

    return new Client('hello', 'world', $httpClient->reveal());
  }

  public function testGeneral()
  {
    $this->assertInstanceOf(General::class, $this->getClient()->general());
  }

  public function testPromotions()
  {
    $this->assertInstanceOf(Promotions::class, $this->getClient()->promotions());
  }
}