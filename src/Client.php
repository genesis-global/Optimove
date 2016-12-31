<?php
namespace GenesisGlobal\Optimove;

use GenesisGlobal\Optimove\Optimove\Api\General;
use GenesisGlobal\Optimove\Optimove\Api\Integrations\Promotions;
use GenesisGlobal\Optimove\Optimove\CurlWrapper;
use GenesisGlobal\Optimove\Optimove\HttpClient;
use GenesisGlobal\Optimove\Optimove\HttpClientInterface;

/**
 * Class Client
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove
 */
class Client
{
  /** API url */
  const API_URL = 'https://api2.optimove.net/';

  /** API version */
  const API_VERSION = 'v3.0';

  /** @var HttpClient */
  protected $httpClient;

  /** @var General */
  protected $general;

  /** @var Promotions */
  protected $promotions;

  /**
   * Client constructor.
   * @param string $username Optimove account username
   * @param string $password Optimove account password
   * @param HttpClientInterface $httpClient
   */
  public function __construct(string $username, string $password, HttpClientInterface $httpClient = null)
  {
    $apiUrl = self::API_URL . self::API_VERSION . '/';
    $this->httpClient = $httpClient ?? new HttpClient(new CurlWrapper(), $apiUrl);
    $this->general()->login($username, $password);
  }

  /**
   * Get General methods instance
   * @return General
   */
  public function general()
  {
    if ($this->general == null) {
      $this->general = new General($this->httpClient);
    }

    return $this->general;
  }

  /**
   * Get Promotions method instance
   * @return Promotions
   */
  public function promotions()
  {
    if ($this->promotions == null) {
      $this->promotions = new Promotions($this->httpClient);
    }

    return $this->promotions;
  }
}
