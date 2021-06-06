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

class ServiceProvider extends AbstractProvider
{
    /**
     * @param $optional = [
     *     'groupName' => '',
     *     'namespaceId' => '',
     *     'protectThreshold' => 0.99,
     *     'metadata' => '',
     *     'selector' => '', // json字符串
     * ]
     */
    public function create(string $serviceName, array $optional = []): ResponseInterface
    {
        return $this->request('POST', '/nacos/v1/ns/service', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'serviceName' => $serviceName,
            ])),
        ]);
    }

    public function delete(string $serviceName, ?string $groupName = null, ?string $namespaceId = null): ResponseInterface
    {
        return $this->request('DELETE', '/nacos/v1/ns/service', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
            ]),
        ]);
    }

    /**
     * @param $optional = [
     *     'groupName' => '',
     *     'namespaceId' => '',
     *     'protectThreshold' => 0.99,
     *     'metadata' => '',
     *     'selector' => '', // json字符串
     * ]
     */
    public function update(string $serviceName, array $optional = []): ResponseInterface
    {
        return $this->request('PUT', '/nacos/v1/ns/service', [
            RequestOptions::QUERY => $this->filter(array_merge($optional, [
                'serviceName' => $serviceName,
            ])),
        ]);
    }

    public function detail(string $serviceName, ?string $groupName = null, ?string $namespaceId = null): ResponseInterface
    {
        return $this->request('GET', '/nacos/v1/ns/service', [
            RequestOptions::QUERY => $this->filter([
                'serviceName' => $serviceName,
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
            ]),
        ]);
    }

    public function list(int $pageNo, int $pageSize, ?string $groupName = null, ?string $namespaceId = null): ResponseInterface
    {
        return $this->request('GET', '/nacos/v1/ns/service/list', [
            RequestOptions::QUERY => $this->filter([
                'pageNo' => $pageNo,
                'pageSize' => $pageSize,
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
            ]),
        ]);
    }
}
