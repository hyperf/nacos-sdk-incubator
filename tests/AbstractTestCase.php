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
use Hyperf\Di\Container;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Guzzle\HandlerStackFactory;
use Hyperf\NacosSdk\Application;
use Hyperf\NacosSdk\Constants;
use Hyperf\NacosSdk\HandlerStackFactory as NacosSdkHandlerStackFactory;
use Hyperf\NacosSdk\Provider\Auth;
use Hyperf\NacosSdk\Provider\Configs;
use Hyperf\NacosSdk\Provider\Instance;
use Hyperf\NacosSdk\Provider\Operator;
use Hyperf\NacosSdk\Provider\Service;
use Hyperf\Utils\ApplicationContext;
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

        $container->shouldReceive('get')->with(Application::class)->andReturnUsing(function ($_) use ($container) {
            return new Application($container);
        });

        $container->shouldReceive('get')->with(ConfigInterface::class)->andReturn($this->getConfig());

        $container->shouldReceive('get')->with(Auth::class)->andReturnUsing(function ($_) use ($container) {
            return new Auth($container);
        });
        $container->shouldReceive('make')->with(Auth::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new Auth($container);
        });

        $container->shouldReceive('get')->with(Configs::class)->andReturnUsing(function ($_) use ($container) {
            return new Configs($container);
        });
        $container->shouldReceive('make')->with(Configs::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new Configs($container);
        });

        $container->shouldReceive('get')->with(Instance::class)->andReturnUsing(function ($_) use ($container) {
            return new Instance($container);
        });
        $container->shouldReceive('make')->with(Instance::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new Instance($container);
        });

        $container->shouldReceive('get')->with(Operator::class)->andReturnUsing(function ($_) use ($container) {
            return new Operator($container);
        });
        $container->shouldReceive('make')->with(Operator::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new Operator($container);
        });
        $container->shouldReceive('get')->with(Service::class)->andReturnUsing(function ($_) use ($container) {
            return new Service($container);
        });
        $container->shouldReceive('make')->with(Service::class)->andReturnUsing(function ($_, $args) use ($container) {
            return new Service($container);
        });

        $container->shouldReceive('get')->with(NacosSdkHandlerStackFactory::class)->andReturnUsing(function ($_) use ($container) {
            return new NacosSdkHandlerStackFactory($container);
        });

        $container->shouldReceive('get')->with(HandlerStackFactory::class)->andReturnUsing(function ($_) {
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
            '/nacos/v1/auth/users/login' => file_get_contents($path . 'login.json'),
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
                'username' => 'nacos',
                'password' => 'nacos',
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
