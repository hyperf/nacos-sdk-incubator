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
use Hyperf\LoadBalancer\LoadBalancerManager;
use Hyperf\LoadBalancer\Node;
use Hyperf\NacosSdk\AbstractProvider;
use Hyperf\NacosSdk\Model\InstanceModel;
use Hyperf\NacosSdk\Model\ServiceModel;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;

class InstanceProvider extends AbstractProvider
{
    public function register(string $serviceName, string $groupName, string $ip, int $port, ?string $clusterName = null, ?string $namespaceId = null, ?float $weight = null, ?array $metadata = null, ?bool $enabled = null, ?bool $ephemeral = null): ResponseInterface
    {
        return $this->request('POST', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ip' => $ip,
                'port' => $port,
                'clusterName' => $clusterName,
                'namespaceId' => $namespaceId,
                'weight' => $weight,
                'metadata' => empty($metadata) ? null : json_encode($metadata, JSON_UNESCAPED_UNICODE),
                'enabled' => $enabled,
                'ephemeral' => $ephemeral,
            ]),
        ]);
    }

    public function delete(string $serviceName, string $groupName, string $ip, int $port, ?string $clusterName = null, ?string $namespaceId = null,  ?bool $ephemeral = null): ResponseInterface
    {
        return $this->request('DELETE', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ip' => $ip,
                'port' => $port,
                'clusterName' => $clusterName,
                'namespaceId' => $namespaceId,
                'ephemeral' => $ephemeral,
            ]),
        ]);

    }

    public function update(string $serviceName, string $groupName, string $ip, int $port, ?string $clusterName = null, ?string $namespaceId = null, ?float $weight = null, ?array $metadata = null, ?bool $enabled = null, ?bool $ephemeral = null): ResponseInterface
    {

        return $this->request('PUT', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ip' => $ip,
                'port' => $port,
                'clusterName' => $clusterName,
                'namespaceId' => $namespaceId,
                'weight' => $weight,
                'metadata' => empty($metadata) ? null : json_encode($metadata, JSON_UNESCAPED_UNICODE),
                'enabled' => $enabled,
                'ephemeral' => $ephemeral,
            ]),
        ]);
    }

    public function list(string $serviceName, ?string $groupName = null, ?string $namespaceId = null, array $clusters = [], ?bool $healthyOnly = null): ResponseInterface
    {
        if (! empty($clusters)) {
            $clusters = implode(',', $clusters);
        }

        return $this->request('GET', '/nacos/v1/ns/instance/list', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
                'clusters' => $clusters,
                'healthyOnly' => $healthyOnly,
            ]),
        ]);
    }

    public function detail(string $ip, int $port, string $namespaceId,string $serviceName, ?float $weight = null, ?bool $enabled = null, ?bool $healthy,?string $metadata = null, ?string $clusterName = null, ?string $groupName = null, ?bool $ephemeral = null): ResponseInterface
    {
        return $this->request('GET', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $this->filter([
                'ip' => $ip,
                'port' => $port,
                'namespaceId' => $namespaceId,
                'serviceName' => $serviceName,
                'weight' => $weight,
                'enabled' => $enabled,
                'healthy' => $healthy,
                'metadata' => $metadata,
                'clusterName' => $clusterName,
                'groupName' => $groupName,
                'ephemeral' => $ephemeral,
            ]),
        ]);
    }

    public function beat(string $serviceName,string $groupName, bool $ephemeral, string $namespaceId): ResponseInterface
    {
        return $this->request('PUT', '/nacos/v1/ns/instance/beat', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'ephemeral' => $ephemeral,
                'beat' => json_encode([
                    'serviceName' => $serviceName,
                    'groupName' => $groupName,
                    'ephemeral' => $ephemeral,
                    'namespaceId' => $namespaceId
                ], JSON_UNESCAPED_UNICODE),
            ]),
        ]);
    }

    public function updateHealth(string $serviceName, string $groupName,string $clusterName, string $ip, int $port, bool $healthy, ?string $namespaceId = null): ResponseInterface
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
