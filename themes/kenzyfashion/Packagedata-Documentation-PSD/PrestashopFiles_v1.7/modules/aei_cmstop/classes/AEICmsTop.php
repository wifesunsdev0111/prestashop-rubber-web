<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

class AEICmsTop extends ObjectModel
{
    /**
     * Identifier of AEICmsTop
     *
     * @var int
     */
    public $id_aeicmstopinfo;

    /**
     * HTML format of AEICmsTop values
     *
     * @var array
     */
    public $text;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'aeicmstopinfo',
        'primary' => 'id_aeicmstopinfo',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => [
            'id_aeicmstopinfo' => ['type' => self::TYPE_NOTHING, 'validate' => 'isUnsignedId'],
            // Lang fields
            'text' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true],
        ],
    ];

    /**
     * Return the AEICmsTop ID By shop ID
     *
     * @param int $shopId
     *
     * @return bool|int
     */
    public static function getAEICmsTopIdByShop($shopId)
    {
        $sql = 'SELECT i.`id_aeicmstopinfo` FROM `' . _DB_PREFIX_ . 'aeicmstopinfo` i
		LEFT JOIN `' . _DB_PREFIX_ . 'aeicmstopinfo_shop` ish ON ish.`id_aeicmstopinfo` = i.`id_aeicmstopinfo`
		WHERE ish.`id_shop` = ' . (int) $shopId;

        if ($result = Db::getInstance()->executeS($sql)) {
            return (int) reset($result)['id_aeicmstopinfo'];
        }

        return false;
    }
}
