{**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@touchdesign.de so we can send you a copy immediately.
 *}

<p class="payment_module">
    <a href="{$link->getModuleLink('sofortbanking', 'payment', ['token' => $static_token])|escape:'htmlall':'UTF-8'}">
        <img src="{$mod_lang.logo|escape:'htmlall':'UTF-8'}" title="{l s='Easy, comfortable and secure - without registration. Automatic data transfer and the real-time transaction notification enable a smooth payment process and a faster delivery.' mod='sofortbanking'} {l s='More' mod='sofortbanking'} {l s='https://documents.sofort.com/sb/customer-information/' mod='sofortbanking'}" width="86" height="49" />
        {l s='Easy, comfortable and secure - without registration. Automatic data transfer and the real-time transaction notification enable a smooth payment process and a faster delivery.' mod='sofortbanking'}        
    </a>
</p>
