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
namespace Hyperf\NacosSdk\Model;

class InstanceModel extends AbstractModel
{
    /**
     * @var null|string
     */
    protected $serviceName;

    /**
     * @var null|string
     */
    protected $groupName;

    /**
     * @var null|string
     */
    protected $ip;

    /**
     * @var null|int
     */
    protected $port;

    /**
     * @var null|string
     */
    protected $clusterName;

    /**
     * @var null|string
     */
    protected $namespaceId;

    /**
     * @var null|float|float|int
     */
    protected $weight;

    /**
     * @var null|string
     */
    protected $metadata;

    /**
     * @var null|bool
     */
    protected $enabled;

    /**
     * @var null|bool
     */
    protected $ephemeral;

    /**
     * @var null|bool
     */
    protected $healthy;

    /**
     * @var string[]
     */
    protected $requiredFields = [
        'ip',
        'port',
        'serviceName',
    ];

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(?string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(?string $groupName): void
    {
        $this->groupName = $groupName;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port): void
    {
        $this->port = $port;
    }

    public function getClusterName(): ?string
    {
        return $this->clusterName;
    }

    public function setClusterName(?string $clusterName): void
    {
        $this->clusterName = $clusterName;
    }

    public function getNamespaceId(): ?string
    {
        return $this->namespaceId;
    }

    public function setNamespaceId(?string $namespaceId): void
    {
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return null|float|int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param null|float|int $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    public function setMetadata(?string $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getEphemeral(): ?bool
    {
        return $this->ephemeral;
    }

    public function setEphemeral(?bool $ephemeral): void
    {
        $this->ephemeral = $ephemeral;
    }

    public function getHealthy(): ?bool
    {
        return $this->healthy;
    }

    public function setHealthy(?bool $healthy): void
    {
        $this->healthy = $healthy;
    }

    /**
     * @return string[]
     */
    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }

    /**
     * @param string[] $requiredFields
     */
    public function setRequiredFields(array $requiredFields): void
    {
        $this->requiredFields = $requiredFields;
    }
}
