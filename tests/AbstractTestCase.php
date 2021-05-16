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
namespace HyperfTest\NacosSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Hyperf\Config\Config;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\NacosSdk\Constants;
use Hyperf\NacosSdk\HandlerStackFactory as NacosSdkHandlerStackFactory;
use Hyperf\Guzzle\HandlerStackFactory;
use Hyperf\NacosSdk\Provider\NacosAuth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Di\Container;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @var bool
     */
    protected $isMock = true;

    protected function tearDown(): void
    {
        Mockery::close();
    }


    protected function getContainer(): ContainerInterface
    {
        $container = Mockery::mock(Container::class);
        ApplicationContext::setContainer($container);

        $container->shouldReceive('get')->with(ConfigInterface::class)->andReturn($this->getConfig());

        $container->shouldReceive('get')->with(NacosAuth::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosAuth($container);
        });
        $container->shouldReceive('make')->with(NacosAuth::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new NacosAuth($container);
        });

        $container->shouldReceive('get')->with(NacosConfig::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosConfig($container);
        });
        $container->shouldReceive('make')->with(NacosConfig::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new NacosConfig($container);
        });

        $container->shouldReceive('get')->with(NacosInstance::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosInstance($container);
        });
        $container->shouldReceive('make')->with(NacosInstance::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new NacosInstance($container);
        });

        $container->shouldReceive('get')->with(NacosOperator::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosOperator($container);
        });
        $container->shouldReceive('make')->with(NacosOperator::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new NacosOperator($container);
        });
        $container->shouldReceive('get')->with(NacosService::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosService($container);
        });
        $container->shouldReceive('make')->with(NacosService::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new NacosService($container);
        });

        $container->shouldReceive('get')->with(NacosSdkHandlerStackFactory::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosSdkHandlerStackFactory($container);
        });

        $container->shouldReceive('get')->with(HandlerStackFactory::class)->andReturnUsing(function ($_) use ($container) {
            return new HandlerStackFactory();
        });

        $container->shouldReceive('make')->with(Client::class, Mockery::any())->andReturnUsing(function ($_, $args) {
            if ($this->isMock) {
                $client = Mockery::mock(Client::class);
                $client->shouldReceive('request')->andReturnUsing(function ($_, $uri, $args) {
                    return new Response(200, [], $this->getContent($uri));
                });
//                $client->shouldReceive('post')->andReturnUsing(function ($uri, $args) {
//                    return new Response(200, [], $this->getContent($uri));
//                });
//                $client->shouldReceive('get')->andReturnUsing(function ($uri, $args) {
//                    return new Response(200, [], $this->getContent($uri));
//                });
                return $client;
            }
            return new Client(...$args);
        });
        $container->shouldReceive('make')->with(CoroutineHandler::class)->withAnyArgs()->andReturn(new CoroutineHandler());
        return $container;
    }

    protected function getContent(string $uri): string
    {
        $path = BASE_PATH . '/tests/json/';
        $maps = [
            '/nacos/v1/cs/configs' => file_get_contents($path . 'get_config.json'),
//            '/open-apis/chat/v4/list' => file_get_contents($path . 'chat_list.json'),
//            '/open-apis/bot/v3/info/' => file_get_contents($path . 'info.json'),
//            '/open-apis/message/v4/send/' => file_get_contents($path . 'send.json'),
        ];

        return $maps[$uri];
    }

    protected function getConfig(): ConfigInterface
    {
        return new Config([
            'nacos' => [
                'enable' => true,
                // nacos server url like https://nacos.hyperf.io, Priority is higher than host:port
                // 'url' => '',
                // The nacos host info
                'host' => '127.0.0.1',
                'port' => 8848,
                // The nacos account info
                'username' => null,
                'password' => null,
                'config_merge_mode' => Constants::CONFIG_MERGE_OVERWRITE,
                // The service info.
                'service' => [
                    'service_name' => 'hyperf',
                    'group_name' => 'api',
                    'namespace_id' => 'namespace_id',
                    'protect_threshold' => 0.5,
                ],
                // The client info.
                'client' => [
                    'service_name' => 'hyperf',
                    'group_name' => 'api',
                    'weight' => 80,
                    'cluster' => 'DEFAULT',
                    'ephemeral' => true,
                    'beat_enable' => true,
                    'beat_interval' => 5,
                    'namespace_id' => 'namespace_id', // It must be equal with service.namespaceId.
                ],
                'remove_node_when_server_shutdown' => true,
                'config_reload_interval' => 3,
                'config_append_node' => 'nacos_config',
                'listener_config' => [
                    // dataId, group, tenant, type, content
                    [
                        'tenant' => 'tenant', // corresponding with service.namespaceId
                        'data_id' => 'hyperf-service-config',
                        'group' => 'DEFAULT_GROUP',
                    ],
                    //[
                    //    'data_id' => 'hyperf-service-config-yml',
                    //    'group' => 'DEFAULT_GROUP',
                    //    'type' => 'yml',
                    //],
                ],
                'load_balancer' => 'random',
            ],
        ]);
    }
}
