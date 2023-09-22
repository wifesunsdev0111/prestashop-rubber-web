{*
 * Bablic Localization.
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @category  localization
 *
 * @author    Ishai Jaffe <ishai@bablic.com>
 * @copyright Bablic 2017
 * @license   http://www.gnu.org/licenses/ GNU License
*}

<!-- start Bablic Head {$version|escape:'htmlall':'UTF-8'} -->
{foreach from=$locales item=locale}
    <link rel="alternate" href="{$locale[0]|escape:'htmlall':'UTF-8'}" hreflang="{$locale[1]|escape:'htmlall':'UTF-8'}">
{/foreach}
{if $subdir eq true}
  <script>
    var bablic = {};
    bablic.localeURL = 'subdir';
    bablic.folders = {$folders_json}; 
    bablic.subDirBase = '{$subdir_base|escape:'htmlall':'UTF-8'}';
</script>
{/if}
<script data-cfasync="false"{if $async eq true} async{/if} src="{$snippet_url|escape:'htmlall':'UTF-8'}"></script>
<!-- end Bablic Head -->
