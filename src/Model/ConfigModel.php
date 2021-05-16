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

use Hyperf\Utils\Codec\Xml;

class ConfigModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $tenant;

    /**
     * @var string
     */
    protected $dataId;

    /**
     * @var string
     */
    protected $group;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $type = 'json';

    /**
     * @var string[]
     */
    protected $requiredFields = [
        'dataId',
    ];

    public function parse($originConfig)
    {
        switch ($this->type) {
            case 'json':
                return is_array($originConfig) ? $originConfig : json_decode($originConfig, true);
            case 'yml':
            case 'yaml':
                return is_array($originConfig) ? $originConfig : yaml_parse($originConfig);
            case 'xml':
                return Xml::toArray($originConfig);
            default:
                return [$originConfig];
        }
    }

    public function getTenant(): string
    {
        return $this->tenant;
    }

    public function setTenant(string $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function getDataId(): string
    {
        return $this->dataId;
    }

    public function setDataId(string $dataId): void
    {
        $this->dataId = $dataId;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): void
    {
        $this->group = $group;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
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
