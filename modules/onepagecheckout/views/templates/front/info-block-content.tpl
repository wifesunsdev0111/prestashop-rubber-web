{**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*}

<!-- Sample texts, inspired by matrice theme, please change to your needs -->
<h4><a id="toggle_link" href="#" onclick="toggle_info_block('[-]', '[+]'); return false;"
       title="Expand / Collapse Info block">[-]</a>{l s='Info block' mod='onepagecheckout'}</h4>
<div class="block_content">
    <img align="right" src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/info_block_success.png"/>
    <h5>{l s='Secure payments' mod='onepagecheckout'}</h5>

    <p>{l s='we do not store any of your credit card details and have no access to your credit card information at any time'  mod='onepagecheckout'}</p>
    <img align="right" src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/info_block_success.png"/>
    <h5>{l s='Quick delivery'  mod='onepagecheckout'}</h5>

    <p>{l s='we deliver within 48h with Colissimo'  mod='onepagecheckout'}</p>
    <img align="right" src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/info_block_success.png"/>
    <h5>{l s='Respect privacy'  mod='onepagecheckout'}</h5>

    <p>{l s='we do not sell or rent your personal information to anyone'  mod='onepagecheckout'}</p>
    <img align="right" src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/info_block_phone.png"/>
    <h5>{l s='Contact'  mod='onepagecheckout'}</h5>

    <p>{l s='contact@myeshop.com'  mod='onepagecheckout'}</p>

    <p>{l s='Phone: +33 12.34.56.78'  mod='onepagecheckout'}</p>
    {*<i>*Update content of this block here: views/ templates/ front/ info-block-content.tpl </i>*}
</div>
