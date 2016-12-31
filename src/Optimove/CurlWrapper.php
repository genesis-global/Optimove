<?php
namespace GenesisGlobal\Optimove\Optimove;

use Httpful\Request;
use Httpful\Response;

/**
 * Class CurlWrapper
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove
 */
class CurlWrapper implements CurlWrapperInterface
{
  /**
   * @inheritdoc
   */
  public function sendRequest(string $method, string $url, array $headers = [], string $params = '') :Response
  {
    if ($method == 'POST') {
      $request = Request::post($url, $params);
    } elseif ($method == 'GET') {
      $request = Request::get($url);
    } else {
      throw new \InvalidArgumentException('Method: ' . $method . ' is not supported.');
    }

    foreach ($headers as $name => $value) {
      $request->addHeader($name, $value);
    }

    return $request->send();
  }
}
