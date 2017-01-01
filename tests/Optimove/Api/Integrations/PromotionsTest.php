<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Tests\Optimove\Api\Integrations;

use \GenesisGlobal\Optimove\Optimove\Api\Integrations\Promotions;
use GenesisGlobal\Optimove\Optimove\HttpClientInterface;

class PromotionsTest extends \PHPUnit_Framework_TestCase
{
  /** @var  Promotions */
  protected $promotions;

  /** @var \PHPUnit_Framework_MockObject_MockObject */
  protected $httpClient;

  public function setUp()
  {
    $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)->disableOriginalConstructor()->getMock();
  }

  protected function getPromotions()
  {
    return new Promotions($this->httpClient);
  }

  public function testAddPromotions()
  {
    $testData = [];

    for ($i = 0; $i < Promotions::MAX_PROMOTIONS_IN_ONE_CALL * 2 - 1; $i++) {
      $testData[] = $i;
    }

    $this->httpClient->expects($this->exactly(2))->method('request')
      ->withConsecutive(
        ['integrations/AddPromotions', 'POST', array_slice($testData, 0, Promotions::MAX_PROMOTIONS_IN_ONE_CALL)],
        [
          'integrations/AddPromotions',
          'POST',
          array_slice($testData, Promotions::MAX_PROMOTIONS_IN_ONE_CALL, Promotions::MAX_PROMOTIONS_IN_ONE_CALL - 1)
        ]
      );
    $promotions = $this->getPromotions();
    $promotions->AddPromotions($testData);
  }

  public function testGetPromotions()
  {
    $expected = '"lorem ipsum"';
    $this->httpClient->expects($this->once())->method('request')->with('integrations/GetPromotions', 'GET')
      ->willReturn($expected);
    $promotions = $this->getPromotions();
    $this->assertEquals($expected, $promotions->getPromotions());
  }

  public function testDeletePromotions()
  {
    $testData = [];

    for ($i = 0; $i < Promotions::MAX_PROMOTIONS_IN_ONE_CALL * 2 - 1; $i++) {
      $testData[] = $i;
    }

    $this->httpClient->expects($this->exactly(2))->method('request')
      ->withConsecutive(
        ['integrations/DeletePromotions', 'POST', array_slice($testData, 0, Promotions::MAX_PROMOTIONS_IN_ONE_CALL)],
        [
          'integrations/DeletePromotions',
          'POST',
          array_slice($testData, Promotions::MAX_PROMOTIONS_IN_ONE_CALL, Promotions::MAX_PROMOTIONS_IN_ONE_CALL - 1)
        ]
      );
    $promotions = $this->getPromotions();
    $promotions->DeletePromotions($testData);
  }

}