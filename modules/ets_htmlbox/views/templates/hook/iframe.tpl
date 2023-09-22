{*
* Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*}
<script type="text/javascript">
    function phProductFeedResizeIframe(obj) {
        $('iframe').css('height','auto');
        setTimeout(function() {
            $('iframe').css('opacity',1);
            var pHeight = $(obj).parent().height();
            $(obj).css('height','540px');
        }, 300);
    }
</script>
<div id="ph_preview_template_html">
    <iframe src="{$url_iframe|escape:'html':'UTF-8'}" style="background: #ffffff ; border : 1px solid #ccc;width:100%;height:0;opacity:0;border-radius:5px" onload="phProductFeedResizeIframe(this)"></iframe>
</div>