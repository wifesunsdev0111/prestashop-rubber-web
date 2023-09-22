{*
 *  Leo Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   leosliderlayer
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

<!-- MODULE Block blockleoblogstabs -->
{include file="./library/fashion_blog_owl.tpl" moduleCalling="blockleoblogs"}
<!-- /MODULE Block blockleoblogstabs -->

{assign var="call_owl_carousel" value="#{$mytab}"}
{include file='./owl_carousel_config.tpl'}