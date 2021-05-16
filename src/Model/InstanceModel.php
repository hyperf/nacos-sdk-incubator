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

    /**
     * @return string|null
     */
    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    /**
     * @param string|null $serviceName
     */
    public function setServiceName(?string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @param string|null $groupName
     */
    public function setGroupName(?string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     */
    public function setPort(?int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return string|null
     */
    public function getClusterName(): ?string
    {
        return $this->clusterName;
    }

    /**
     * @param string|null $clusterName
     */
    public function setClusterName(?string $clusterName): void
    {
        $this->clusterName = $clusterName;
    }

    /**
     * @return string|null
     */
    public function getNamespaceId(): ?string
    {
        return $this->namespaceId;
    }

    /**
     * @param string|null $namespaceId
     */
    public function setNamespaceId(?string $namespaceId): void
    {
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return float|int|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float|int|null $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string|null
     */
    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @param string|null $metadata
     */
    public function setMetadata(?string $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return bool|null
     */
    public function getEphemeral(): ?bool
    {
        return $this->ephemeral;
    }

    /**
     * @param bool|null $ephemeral
     */
    public function setEphemeral(?bool $ephemeral): void
    {
        $this->ephemeral = $ephemeral;
    }

    /**
     * @return bool|null
     */
    public function getHealthy(): ?bool
    {
        return $this->healthy;
    }

    /**
     * @param bool|null $healthy
     */
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
