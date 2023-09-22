How to override template in theme's folder:

1/ please copy main template file - front/order-opc.tpl to /themes/YOUR_THEME/modules/onepagecheckout
2/ in /themes/YOUR_THEME/modules/onepagecheckout/order-opc.tpl there are references to sub-templates, like this: 
   {include file="$opc_templates_path/order-opc-new-account.tpl"}
   That means, you can override only single template, but you need to start with order-opc.tpl as an entry point and there update references to particular subtemplates, depending on whether you want to override them or whether you want to use default ones in /modules/onepagecheckout/views/templates/front folder
3/ If you want to override also subtemplate, copy it from /modules/onepagecheckout/views/templates/front to /themes/YOUR_THEME/modules/onepagecheckout and change reference in already copied order-opc.tpl:
   {include file="./order-opc-new-account.tpl"}


Why so difficult? 

From overridden templates, we have no (relative) way to refer to not-overridden subtemplates in original folder, so we need absolute paths. This way, we can override only needed subtemplates, whilst keeping others untouched (compared to need for overriding all templates in /modules/onepagecheckout/views/templates/front)