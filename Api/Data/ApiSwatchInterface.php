<?php

namespace Josephson\SwatchRestApi\Api\Data;

interface ApiSwatchInterface
{

    /**
     * Set option ID
     * @param int $optionId
     * @return this
     */
    public function setOptionId($optionId);

    /**
     * Return option ID
     * @return int
     */
    public function getOptionId();

    /**
     * Set store ID
     * @param int $storeId
     * @return this
     */
    public function setStoreId($storeId);

    /**
     * Get store ID
     * @return int
     */
    public function getStoreId();

}
