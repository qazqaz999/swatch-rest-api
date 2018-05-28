<?php

namespace Josephson\SwatchRestApi\Model;

use Josephson\SwatchRestApi\Api\Data\ApiSwatchInterface;

class ApiSwatch extends \Magento\Framework\Api\AbstractExtensibleObject implements ApiSwatchInterface
{

    /**
     * @var int
     */
    protected $optionId;

    /**
     * @var int
     */
    protected $storeId;

    /**
     * {@inheritdoc}
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

}
