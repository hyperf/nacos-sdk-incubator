<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\NacosSdk;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Hyperf\Contract\ContainerInterface;
use Hyperf\NacosSdk\Exception\RequestException;
use Hyperf\NacosSdk\Provider\AccessToken;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractProvider implements ProviderInterface
{
    use AccessToken;

    protected static $name = '';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var HandlerStackFactory
     */
    protected $factory;

    /**
     * @var NacosClientInterface
     */
    protected $app;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $container->get(Config::class);
        $this->factory = $container->get(HandlerStackFactory::class);
        $this->app = $container->get(NacosClientInterface::class);
    }

    public function request($method, $uri, array $options = [])
    {
        $token = $this->getAccessToken();
        $token && $options[RequestOptions::QUERY]['accessToken'] = $token;
        return $this->client()->request($method, $uri, $options);
    }

    public function client(): Client
    {
        return $this->container->make(Client::class, [
            [
                'base_uri' => $this->config->getBaseUri(),
                'handler' => $this->factory->get($this->getName()),
                RequestOptions::HEADERS => [
                    'charset' => 'UTF-8',
                ],
            ],
        ]);
    }

    public function getName(): string
    {
        return static::$name;
    }

    protected function checkResponseIsOk(ResponseInterface $response): bool
    {
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return (string) $response->getBody() === 'ok';
    }

    protected function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $contents = (string) $response->getBody();
        if ($statusCode !== 200) {
            throw new RequestException($contents, $statusCode);
        }
        return Json::decode($contents);
    }
}
