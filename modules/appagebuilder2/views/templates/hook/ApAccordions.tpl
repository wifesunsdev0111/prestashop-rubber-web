{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApAccordions -->
{if !isset($isSubTab)}
{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
<div{if isset($formAtts.id)} id="{$formAtts.id|escape:'html':'UTF-8'}"{/if} class="ap-accordion panel-group{if isset($formAtts.class)} {$formAtts.class|escape:'html':'UTF-8'}{/if}">
    {if isset($formAtts.title) && $formAtts.title}
    <h4 class="title_block">{$formAtts.title|rtrim|escape:'html':'UTF-8'}</h4>
    {/if}
    {$apContent}{* HTML form , no escape necessary *}
</div>
{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
<script type="text/javascript">
    $(document).ready(function() {
        {if isset($formAtts.active_type)}
            {if $formAtts.active_type=='hideall'}
				$('#{$formAtts.id|escape:'html':'UTF-8'} .panel-heading .panel-title > a').addClass('collapsed');
				//collapsed
            {else if $formAtts.active_type=='set'}
				$('#{$formAtts.id|escape:'html':'UTF-8'} .panel-heading .panel-title > a').addClass('collapsed');
				$('#{$formAtts.id|escape:'html':'UTF-8'} .panel-heading .panel-title > a:eq({$formAtts.active_accordion|escape:'html':'UTF-8'})').removeClass('collapsed');
				
                $('#{$formAtts.id|escape:'html':'UTF-8'} .panel-collapse:eq({$formAtts.active_accordion|escape:'html':'UTF-8'})').collapse('show');
				$('#{$formAtts.id|escape:'html':'UTF-8'} .panel-heading .panel-title > a').on('click', function(e) {
					e.stopPropagation();
					e.preventDefault();
					var div_id = $(this).attr('href');
					var data_parent = $(this).data('parent');
					if(!$(this).hasClass('collapsed'))
					{
						$(this).toggleClass('collapsed');
						$(div_id ).collapse("toggle");
					}
					else
					{
						$(data_parent+' .panel-title a').not('.collapsed').toggleClass('collapsed');
						$(data_parent+' .panel-collapse').not('.collapse').collapse("toggle");					
						$(this).toggleClass('collapsed');
						$(div_id ).collapse("toggle");
					}					
				});
            {else}
                $('#{$formAtts.id|escape:'html':'UTF-8'} .panel-collapse').collapse('show');
				
				$('#{$formAtts.id|escape:'html':'UTF-8'} .panel-heading .panel-title > a').on('click', function(e) {
					e.stopPropagation();
					e.preventDefault();
					// show, hidden content
					var div_id = $(this).attr('href');
					$(div_id ).collapse("toggle");
					// chage icon
					$(this).toggleClass( 'collapsed');
				});
            {/if}
        {/if}
    });
</script>
{else}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#{$formAtts.parent_id|escape:'html':'UTF-8'}" aria-controls="{$formAtts.id|escape:'html':'UTF-8'}" aria-expanded="true"
                       href="#{$formAtts.id|escape:'html':'UTF-8'}">{$formAtts.title|escape:'html':'UTF-8'}</a>
                </h4>
            </div>
            <div id="{$formAtts.id|escape:'html':'UTF-8'}" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    {$apContent}{* HTML form , no escape necessary *}
                </div>
            </div>
        </div> 
{/if}