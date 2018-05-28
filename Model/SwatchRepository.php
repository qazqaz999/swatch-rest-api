<?php
/**
 * Swatch Rest API
 * Copyright (C) 2017  2018
 * 
 * This file is part of Josephson/SwatchRestApi.
 * 
 * Josephson/SwatchRestApi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Josephson\SwatchRestApi\Model;

use Josephson\SwatchRestApi\Api\SwatchRepositoryInterface;

class SwatchRepository implements SwatchRepositoryInterface
{

    /**
     * @var \Magento\Swatches\Model\SwatchFactory
     */
    protected $swatchFactory;

    /**
     * @var \Josephson\SwatchRestApi\Api\Data\ApiSwatchInterfaceFactory;
     */
    protected $apiSwatchFactory;

    /**
     * @var \Magento\Catalog\Api\ProductAttributeOptionManagementInterface
     */
    protected $productAttributeOptionManagement;

    /**
     * Class construct
     * @param \Magento\Swatches\Model\SwatchFactory $swatchFactory
     * @param \Josephson\SwatchRestApi\Api\Data\ApiSwatchInterfaceFactory $apiSwatchFactory
     * @param \Magento\Catalog\Api\ProductAttributeOptionManagementInterface $productAttributeOptionManagement
     * @param \Magento\Eav\Model\Config $eavConfig
     */
    public function __construct(
        \Magento\Swatches\Model\SwatchFactory $swatchFactory,
        \Josephson\SwatchRestApi\Api\Data\ApiSwatchInterfaceFactory $apiSwatchFactory,
        \Magento\Catalog\Api\ProductAttributeOptionManagementInterface $productAttributeOptionManagement,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->swatchFactory = $swatchFactory;
        $this->apiSwatchFactory = $apiSwatchFactory;
        $this->productAttributeOptionManagement = $productAttributeOptionManagement;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function save($attributeCode, $option)
    {
        $wasOptionSaved = $this->productAttributeOptionManagement->add($attributeCode, $option);
        if ($wasOptionSaved && !empty($option->getStoreLabels()[0])) {
            
            $firstOptionStoreLabel = $option->getStoreLabels()[0];
            $label = $firstOptionStoreLabel->getLabel();
            $attribute = $this->eavConfig->getAttribute(\Magento\Catalog\Model\Product::ENTITY, $attributeCode);
            $optionId = $attribute->getSource()->getOptionId($label);

            $swatch = $this->swatchFactory->create();
            $swatch->setOptionId($optionId)
                ->setStoreId(0)
                ->setType(0)
                ->setValue($label)
                ->save();

            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getByAttributeAndOption($attributeCode, $optionId)
    {
        $storeId = 0;
        $swatch = $this->swatchFactory->create();

        $swatchCollection = $swatch->getCollection();
        $swatchCollection->addFieldToFilter('option_id', $optionId);
        $swatchCollection->addFieldToFilter('store_id', $storeId);
        $swatchCollection->load();

        if (count($swatchCollection) > 0) {
            $swatch = $swatchCollection->getFirstItem();
        }
        
        $apiSwatch = $this->apiSwatchFactory->create();
        $apiSwatch->setOptionId($swatch->getOptionId())
            ->setStoreId($swatch->getStoreId());

        return $apiSwatch;

    }

}
