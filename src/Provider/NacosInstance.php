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

class NacosInstance extends AbstractProvider
{
    protected static $name = 'nacos_instance';

    public function register(InstanceModel $instanceModel): bool
    {
        $response = $this->request('POST', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $instanceModel->toArray(),
        ]);

        return $this->checkResponseIsOk($response);
    }

    public function delete(InstanceModel $instanceModel): bool
    {
        $response = $this->request('DELETE', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $instanceModel->toArray(),
        ]);

        return $this->checkResponseIsOk($response);
    }

    public function update(InstanceModel $instanceModel): bool
    {
        $instanceModel->setHealthy(null);

        $response = $this->request('PUT', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $instanceModel->toArray(),
        ]);

        return $this->checkResponseIsOk($response);
    }

    public function list(ServiceModel $serviceModel, array $clusters = [], ?bool $healthyOnly = null): array
    {
        $serviceName = $serviceModel->getServiceName();
        $groupName = $serviceModel->getGroupName();
        $namespaceId = $serviceModel->getNamespaceId();
        $params = array_filter(compact('serviceName', 'groupName', 'namespaceId', 'clusters', 'healthyOnly'), function ($item) {
            return $item !== null;
        });
        if (isset($params['clusters'])) {
            $params['clusters'] = implode(',', $params['clusters']);
        }

        $response = $this->request('GET', '/nacos/v1/ns/instance/list', [
            RequestOptions::QUERY => $params,
        ]);

        return $this->handleResponse($response);
    }

    public function getOptimal(ServiceModel $serviceModel, array $clusters = [])
    {
        $list = $this->list($serviceModel, $clusters, true);
        $instance = $list['hosts'] ?? [];
        if (! $instance) {
            return false;
        }
        $enabled = array_filter($instance, function ($item) {
            return $item['enabled'] && $item['healthy'];
        });

        $tactics = strtolower($this->config->get('nacos.load_balancer', 'random'));

        return $this->loadBalancer($enabled, $tactics);
    }

    public function detail(InstanceModel $instanceModel): array
    {
        $response = $this->request('GET', '/nacos/v1/ns/instance', [
            RequestOptions::QUERY => $instanceModel->toArray(),
        ]);

        return $this->handleResponse($response);
    }

    public function beat(ServiceModel $serviceModel, InstanceModel $instanceModel): array
    {
        $serviceName = $serviceModel->getServiceName();
        $groupName = $serviceModel->getGroupName();
        $ephemeral = $instanceModel->getEphemeral();
        $namespaceId = $instanceModel->getNamespaceId();
        $params = array_filter(compact('serviceName', 'groupName', 'ephemeral', 'namespaceId'), function ($item) {
            return $item !== null;
        });
        $params['beat'] = $instanceModel->toJson();

        $response = $this->request('PUT', '/nacos/v1/ns/instance/beat', [
            RequestOptions::QUERY => $params,
        ]);

        return $this->handleResponse($response);
    }

    public function updateHealth(InstanceModel $instanceModel): bool
    {
        if ($instanceModel->getHealthy() === null) {
            $instanceModel->setHealthy(true);
        }

        $response = $this->request('PUT', '/nacos/v1/ns/health/instance', [
            RequestOptions::QUERY => $instanceModel->toArray(),
        ]);

        return $this->checkResponseIsOk($response);
    }

    protected function loadBalancer(array $nodes, $tactics = 'random')
    {
        $loadNodes = [];
        $nacosNodes = [];
        /** @var array|InstanceModel $node */
        foreach ($nodes as $node) {
            if (is_array($node)) {
                $node = (object) $node;
            }
            $loadNodes[] = new Node($node->getIp(), $node->getPort(), (int) $node->getWeight());
            $key = sprintf('%s:%d', $node->getIp(), $node->getPort());
            $nacosNodes[$key] = $node;
        }

        $container = ApplicationContext::getContainer();
        $loadBalancerManager = $container->get(LoadBalancerManager::class);
        /** @var \Hyperf\LoadBalancer\LoadBalancerInterface $loadBalancer */
        $loadBalancer = $container->get($loadBalancerManager->get($tactics));
        $loadBalancer->setNodes($loadNodes);

        /** @var Node $availableNode */
        $availableNode = $loadBalancer->select();

        $key = sprintf('%s:%d', $availableNode->host, $availableNode->port);
        return $nacosNodes[$key];
    }
}
