<?php
namespace GenesisGlobal\Optimove\Optimove\Api;

use GenesisGlobal\Optimove\Optimove\HttpClientInterface;

/**
 * Class General
 * Wrapper for general/* methods
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove\Api
 */
class General
{
  /** @var HttpClientInterface */
  protected $httpClient;

  /**
   * General constructor.
   * @param HttpClientInterface $httpClient
   */
  public function __construct(HttpClientInterface $httpClient)
  {
    $this->httpClient = $httpClient;
  }

  /**
   * Login to Optimove API and sets token header in http client
   * @param string $username
   * @param string $password
   * @return void
   */
  public function login(string $username, string $password)
  {
    $parameters = [
      'Username' => $username,
      'Password' => $password
    ];

    $result = $this->httpClient->request('general/login', 'POST', $parameters);
    $this->httpClient->addHeader('Authorization-Token', $result);
  }
}
