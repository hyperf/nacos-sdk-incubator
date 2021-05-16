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
namespace Hyperf\NacosSdk\Provider;

use GuzzleHttp\RequestOptions;
use Hyperf\NacosSdk\AbstractProvider;

class NacosOperator extends AbstractProvider
{
    protected static $name = 'nacos_operator';

    public function getSwitches(): array
    {
        $response = $this->request('GET', '/nacos/v1/ns/operator/switches');

        return $this->handleResponse($response);
    }

    public function updateSwitches($entry, $value, bool $debug = false): array
    {
        $debug = $debug ? 'true' : 'false';
        $params = compact('entry', 'value', 'debug');

        $response = $this->request('PUT', '/nacos/v1/ns/operator/switches', [
            RequestOptions::QUERY => $params,
        ]);

        return $this->handleResponse($response);
    }

    public function getMetrics(): array
    {
        $response = $this->request('GET', '/nacos/v1/ns/operator/metrics');

        return $this->handleResponse($response);
    }

    public function getServers($healthy = true): array
    {
        $healthy = $healthy ? 'true' : 'false';
        $params = compact('healthy');

        $response = $this->request('GET', '/nacos/v1/ns/operator/servers', [
            RequestOptions::QUERY => $params,
        ]);

        return $this->handleResponse($response);
    }

    public function getLeader(): array
    {
        $response = $this->request('GET', '/nacos/v1/ns/raft/leader');

        return $this->handleResponse($response);
    }
}
