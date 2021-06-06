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
namespace HyperfTest\NacosSdk\Cases\Provider;

use Hyperf\NacosSdk\Application;
use Hyperf\NacosSdk\Config;
use Hyperf\Utils\Codec\Json;
use HyperfTest\NacosSdk\AbstractTestCase;
use HyperfTest\NacosSdk\HandlerMockery;

/**
 * @internal
 * @coversNothing
 */
class NacosOperatorTest extends AbstractTestCase
{
    public function testGetSwitches()
    {
        $application = new Application(new Config([
            'guzzle_config' => [
                'handler' => new HandlerMockery(),
                'headers' => [
                    'charset' => 'UTF-8',
                ],
            ],
        ]));
        $result = $application->operator->getSwitches();
        $result = Json::decode((string) $result->getBody());
        $this->assertSame('00-00---000-NACOS_SWITCH_DOMAIN-000---00-00', $result['name']);
    }

    public function testGetMetrics()
    {
        $application = new Application(new Config([
            'guzzle_config' => [
                'handler' => new HandlerMockery(),
                'headers' => [
                    'charset' => 'UTF-8',
                ],
            ],
        ]));
        $result = $application->operator->getMetrics();
        $result = Json::decode((string) $result->getBody());
        $this->assertSame('UP', $result['status']);
    }

    public function testGetServers()
    {
        $application = new Application(new Config([
            'guzzle_config' => [
                'handler' => new HandlerMockery(),
                'headers' => [
                    'charset' => 'UTF-8',
                ],
            ],
        ]));
        $result = $application->operator->getServers();
        $result = Json::decode((string) $result->getBody());
        $this->assertArrayHasKey('servers', $result);
    }

    public function testGetLeader()
    {
        $application = new Application(new Config([
            'guzzle_config' => [
                'handler' => new HandlerMockery(),
                'headers' => [
                    'charset' => 'UTF-8',
                ],
            ],
        ]));
        $result = $application->operator->getLeader();
        $result = Json::decode((string) $result->getBody());
        $this->assertArrayHasKey('leader', $result);
    }
}
