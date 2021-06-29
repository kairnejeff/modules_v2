{*
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 *
 * @author    Arnaud Merigeau <contact@arnaud-merigeau.fr>
 * @copyright  Copyright (c) 2009-2018 Arnaud Merigeau - https://www.arnaud-merigeau.fr
 * @license    You only can use module, nothing more!
*}

<div class="m-b-1 m-t-1">
    <h2>{l s='Nurtiscore' mod='nutriscore'}</h2>
    <label class="form-control-label">{l s='Nutriscore' mod='nutriscore'}</label>
    <input type="text" name="nutriscore" class="form-control" {if $nutriscore && $nutriscore != ''}value="{$nutriscore}"{/if}/>
    <div class="clearfix"></div>
</div>