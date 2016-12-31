<?php
namespace GenesisGlobal\Optimove\Optimove;

use GenesisGlobal\Optimove\Optimove\Exceptions\ResponseException;

/**
 * Interface HttpClientInterface
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove
 */
interface HttpClientInterface
{
  /**
   * Sends request to API
   * @param string $uri
   * @param string $method
   * @param array|null $parameters
   * @return string
   * @throws ResponseException
   */
  public function request(string $uri, string $method, array $parameters = null) :string;

  /**
   * @param array $parameters
   * @return string
   */
  public function getParameters(array $parameters) :string;

  /**
   * Add or replace header
   * @param string $name header name
   * @param string $value header value
   * @return void
   */
  public function addHeader(string $name, string $value);

  /**
   * Get headers
   * @return array
   */
  public function getHeaders() :array;
}