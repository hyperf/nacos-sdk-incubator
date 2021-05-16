<?php


namespace Hyperf\NacosSdk;


use Hyperf\Contract\ContainerInterface;
use Hyperf\NacosSdk\Provider\AccessToken;
use Hyperf\NacosSdk\Provider\NacosAuth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;
use Hyperf\NacosSdk\Exception\InvalidArgumentException;

/**
 * @property AccessToken $accessToken
 * @property NacosAuth $auth
 * @property NacosConfig $config
 * @property NacosInstance $instance
 * @property NacosOperator $operator
 * @property NacosService $service
 */
class Application
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $alias = [
        'accessToken' => AccessToken::class,
        'auth' => NacosAuth::class,
        'config' => NacosConfig::class,
        'instance' => NacosInstance::class,
        'operator' => NacosOperator::class,
        'service' => NacosService::class,
    ];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        if (! isset($name)) {
            throw new InvalidArgumentException("{$name} is invalid.");
        }

        return $this->container->get(
            $this->alias[$name]
        );
    }
}