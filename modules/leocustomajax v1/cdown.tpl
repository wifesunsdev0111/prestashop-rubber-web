{if $product}	
<div class="deal-clock lof-clock-{$product.id_product}-detail">
	{if isset($product.js) && $product.js == 'unlimited'}<div class="lof-labelexpired">{l s='Unlimited' mod='leocustomajax'}</div>{/if}
</div>
{if isset($product.js) && $product.js != 'unlimited'}	
	<script type="text/javascript">
		{literal}
		jQuery(document).ready(function($){{/literal}
			$(".lof-clock-{$product.id_product}-detail").lofCountDown({literal}{{/literal}
				TargetDate:"{$product.js.month}/{$product.js.day}/{$product.js.year} {$product.js.hour}:{$product.js.minute}:{$product.js.seconds}",
				DisplayFormat:"<div>%%D%% </div><div>%%H%% </div><div>%%M%%</div><div>%%S%% </div>",
				FinishMessage: "{$product.finish}"
			{literal}
			});
		});
		{/literal}
	</script>
{/if}
{/if}