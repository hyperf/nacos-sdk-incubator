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
use Psr\Http\Message\ResponseInterface;

class InstanceProvider extends AbstractProvider
{
    /**
     * @param $optional = [
     *     'groupName' => '',
     *     'clusterName' => '',
     *     'namespaceId' => '',
     *     'weight' => 99.0,
     *     'metadata' => '',
     *     'enabled' => true,
     *     'ephemeral' => false, // 是否临时实例
     * ]
     */
    public function register(string $ip, int $port, string $serviceName, array $optional = []): ResponseInterface
    {
        return $this->request('POST', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'serviceName' => $serviceName,
                'ip' => $ip,
                'port' => $port,
            ])),
        ]);
    }

    /**
     * @param $optional = [
     *     'clusterName' => '',
     *     'namespaceId' => '',
     *     'ephemeral' => '',
     * ]
     */
    public function delete(string $serviceName, string $groupName, string $ip, int $port, array $optional = []): ResponseInterface
    {
        return $this->request('DELETE', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                    'serviceName' => $serviceName,
                    'groupName' => $groupName,
                    'ip' => $ip,
                    'port' => $port,

                ])),
        ]);
    }

    /**
     * @param $optional = [
     *     'clusterName' => '',
     *     'namespaceId' => '',
     *     'weight' => '',
     *     'metadata' => '',
     *     'enabled' => '',
     *     'ephemeral' => '',
     * ]
     */
    public function update(string $serviceName, string $groupName, string $ip, int $port, array $optional = []): ResponseInterface
    {
        return $this->request('PUT', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ip' => $ip,
                'port' => $port,
            ])),
        ]);
    }

    /**
     * @param $optional = [
     *     'groupName' => '',
     *     'namespaceId' => '',
     *     'clusters' => '',
     *     'healthyOnly' => '',
     * ]
     */
    public function list(string $serviceName, array $optional = []): ResponseInterface
    {
        if (! empty($clusters)) {
            $clusters = implode(',', $clusters);
        }

        return $this->request('GET', '/nacos/v1/ns/instance/list', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'serviceName' => $serviceName,
            ])),
        ]);
    }

    /**
     * @param array $optional = [
     *      'weight' => '',
     *      'enabled' => '',
     *      'healthy' => '',
     *      'metadata' => '',
     *      'clusterName' => '',
     *      'groupName' => '',
     *      'ephemeral' => '',
     * ]
     */
    public function detail(string $ip, int $port, string $namespaceId, string $serviceName, array $optional = []): ResponseInterface
    {
        return $this->request('GET', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'ip' => $ip,
                'port' => $port,
                'namespaceId' => $namespaceId,
                'serviceName' => $serviceName,
            ])),
        ]);
    }


    public function beat(string $serviceName, string $groupName, bool $ephemeral, array $beat): ResponseInterface
    {
        return $this->request('PUT', '/nacos/v1/ns/instance/beat', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ephemeral' => $ephemeral,
                'beat' => $beat,
            ]),
        ]);
    }

    public function updateHealth(string $serviceName, string $groupName, string $clusterName, string $ip, int $port, bool $healthy, ?string $namespaceId = null): ResponseInterface
    {
        return $this->request('PUT', '/nacos/v1/ns/health/instance', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'clusterName' => $clusterName,
                'ip' => $ip,
                'port' => $port,
                'healthy' => $healthy,
                'namespaceId' => $namespaceId,
            ]),
        ]);
    }
}
