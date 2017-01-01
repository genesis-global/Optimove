<?php
namespace GenesisGlobal\Optimove\Optimove;

use GenesisGlobal\Optimove\Optimove\Exceptions\ResponseException;

/**
 * Class HttpClient
 * @author: Fabian Rolof <fabian@rolof.pl>
 * @package GenesisGlobal\Optimove\Optimove
 */
class HttpClient implements HttpClientInterface
{
  /** @var CurlWrapperInterface */
  protected $curlWrapper;

  /** @var  string */
  protected $baseUrl;

  /** @var array */
  protected $headers = [
    'Content-type' => 'application/json',
    'Accepts' => 'application/json'
  ];

  /**
   * HttpClient constructor.
   * @param CurlWrapperInterface $curlWrapper
   * @param string $baseUrl
   */
  public function __construct(CurlWrapperInterface $curlWrapper, string $baseUrl)
  {
    $this->baseUrl = $baseUrl;
    $this->curlWrapper = $curlWrapper;
  }

  /**
   * @inheritdoc
   */
  public function request(string $uri, string $method, array $parameters = null)
  {
    $url = $this->baseUrl . $uri;

    $result = $this->curlWrapper->sendRequest(
      $method,
      $url,
      $this->getHeaders(),
      ($parameters != null) ? $this->getParameters($parameters) : ''
    );

    if ($result->code >= 400) {
      throw new ResponseException($result->body, $result->code);
    }

    return $result->body;
  }

  /**
   * @inheritdoc
   */
  public function getParameters(array $parameters) :string
  {
    return json_encode($parameters);
  }

  /**
   * @inheritdoc
   */
  public function addHeader(string $name, string $value)
  {
    $this->headers[$name] = $value;
  }

  /**
   * @inheritdoc
   */
  public function getHeaders() :array
  {
    return $this->headers;
  }
}