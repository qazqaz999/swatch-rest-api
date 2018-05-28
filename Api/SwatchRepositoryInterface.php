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

namespace Josephson\SwatchRestApi\Api;

interface SwatchRepositoryInterface
{

    /**
     * POST for swatch_repository api
     * @param string $attributeCode
     * @param \Magento\Eav\Api\Data\AttributeOptionInterface $option
     * @return bool
     */
    public function save($attributeCode, $option);

    /**
     * GET for swatch repository api
     * @param string $attributeCode
     * @param string $optionId
     * @return \Josephson\SwatchRestApi\Api\Data\ApiSwatchInterface
     */
    public function getByAttributeAndOption($attributeCode, $optionId);

    /**
     * There's no delete as the DELETE API endpoint for deleting an option is working
     */
}
