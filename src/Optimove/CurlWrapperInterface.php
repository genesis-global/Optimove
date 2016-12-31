<?php
namespace GenesisGlobal\Optimove\Optimove;

use Httpful\Response;

/**
 * Interface CurlWrapperInterface
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove
 */
interface CurlWrapperInterface
{
  /**
   * @param string $method
   * @param string $url
   * @param array $params
   * @param array $headers
   * @return Response
   */
  public function sendRequest(string $method, string $url, array $headers = [], string $params = '') :Response;
}