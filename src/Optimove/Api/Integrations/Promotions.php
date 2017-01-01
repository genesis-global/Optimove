<?php
/**
 * @author: Fabian Rolof <fabian@rolof.pl>
 */
namespace GenesisGlobal\Optimove\Optimove\Api\Integrations;

use GenesisGlobal\Optimove\Optimove\HttpClientInterface;
use Symfony\Component\Ldap\Exception\ConnectionException;

/**
 * Class Promotions
 * Wrapper for integrations/promotions/* methods
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove\Api\Integrations
 */
class Promotions
{
  /** Maximum promotions in one call */
  const MAX_PROMOTIONS_IN_ONE_CALL = 100;

  /** @var HttpClientInterface */
  protected $httpClient;

  /**
   * Promotions constructor.
   * @param HttpClientInterface $httpClient
   */
  public function __construct(HttpClientInterface $httpClient)
  {
    $this->httpClient = $httpClient;
  }

  /**
   * Adds promo codes and associated names that will be available for selection when running a campaign.
   * @param array $promotions
   * @return void
   * @throws ConnectionException
   */
  public function AddPromotions(array $promotions)
  {
    $promotions = array_chunk($promotions, self::MAX_PROMOTIONS_IN_ONE_CALL);
    foreach ($promotions as $partial) {
      $this->httpClient->request('integrations/AddPromotions', 'POST', $partial);
    }
  }

  /**
   * Returns an array of all defined promo codes and associated names.
   * @return string
   * @throws ConnectionException
   */
  public function GetPromotions()
  {
    return $this->httpClient->request('integrations/GetPromotions', 'GET', []);
  }

  /**
   * Removes previously-added promo codes.
   * @param array $promotions
   * @return void
   * @throws ConnectionException
   */
  public function DeletePromotions(array $promotions)
  {
    $promotions = array_chunk($promotions, self::MAX_PROMOTIONS_IN_ONE_CALL);
    foreach ($promotions as $partial) {
      $this->httpClient->request('integrations/DeletePromotions', 'POST', $partial);
    }
  }
}
