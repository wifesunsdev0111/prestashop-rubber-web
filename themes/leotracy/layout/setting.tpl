{assign var="ENABLE_RESPONSIVE" value="1" scope="global"}
{assign var="LISTING_GRIG_MODE" value="grid" scope="global"}
{assign var="LISTING_PRODUCT_COLUMN" value="3" scope="global"}
{assign var="LISTING_PRODUCT_COLUMN_MODULE" value="3" scope="global"}
{assign var="LISTING_PRODUCT_TABLET" value="2" scope="global"}
{assign var="LISTING_PRODUCT_MOBILE" value="1" scope="global"}
{assign var="ENABLE_WISHLIST" value="0" scope="global"}
{assign var="ENABLE_COLOR" value="0" scope="global"}
{if $LISTING_PRODUCT_COLUMN=="5"}
    {assign var="colValue" value="col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-2-4" scope="global"}
{else}
    {assign var="colValue" value="col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-{12/$LISTING_PRODUCT_COLUMN}" scope="global"}
{/if}