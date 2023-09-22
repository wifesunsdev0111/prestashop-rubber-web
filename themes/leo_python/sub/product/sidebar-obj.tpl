<ul class="products products-block">
    {foreach from=$products item=product name=myLoop}
        <li class="clearfix media">  
            <div class="product-block">
				<div class="product-container media" itemscope itemtype="https://schema.org/Product">
					 <a class="products-block-image img pull-left" href="{$product->product_link|escape:'html'}" title="{$product->legend|escape:html:'UTF-8'}">
						<img class="replace-2x img-responsive" src="{$link->getImageLink($product->link_rewrite, $product->id_image, 'small_default')|escape:'html'}" alt="{$product->name|escape:html:'UTF-8'}" />
					 </a>
					<div class="media-body">
						<div class="product-content">
							<h5 class="name media-heading">
								<a class="product-name" href="{$product->product_link|escape:'html'}" title="{$product->name|escape:html:'UTF-8'}">
									{$product->name|strip_tags|escape:html:'UTF-8'|truncate:25:'...'}
								</a>
							</h5>
							{if $page_name != "product"}
								{hook h='displayProductListReviews' product=['id_product'=> $product->id]}
							{/if}
							<div class="product-description description">{$product->description_short|strip_tags:'UTF-8'|truncate:75:'...'}</div>
						</div>
					</div>
				</div> 
            </div>    
        </li>
    {/foreach}
</ul>