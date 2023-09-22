{*
 * @license   GNU General Public License version 2
*}

<div id="blog-localengine">
		<form class="form-horizontal" method="post" id="comment-form" action="{$blog_link|escape:'html':'UTF-8'}" onsubmit="return false;">
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputFullName">{l s='Full Name' mod='psblog'}</label>
				<div class="col-lg-9">
					<input type="text" name="fullname" placeholder="{l s='Enter your full name' mod='psblog'}" id="inputFullName" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputEmail">{l s='Email' mod='psblog'}</label>
				<div class="col-lg-9">
					<input type="text" name="email" placeholder="{l s='Enter your email' mod='psblog'}" id="inputEmail" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputComment">{l s='Comment' mod='psblog'}</label>
				<div class="col-lg-9">
					<textarea type="text" name="comment" rows="6" placeholder="{l s='Enter your comment' mod='psblog'}" id="inputComment" class="form-control"></textarea>
				</div>
			</div>
			 <div class="form-group">
			 	 <img src="{$captcha_image|escape:'html':'UTF-8'}" alt="" align="left"/>
				 <input class="form-control" type="text" name="captcha" value="" size="10" />
			 </div>
			 <input type="hidden" name="id_psblog_blog" value="{$id_psblog_blog|intval}">
			<div class="form-group">
					<div class="col-lg-9 col-lg-offset-3"><button class="btn btn-default" name="submitcomment" type="submit">{l s='Submit' mod='psblog'}</button></div>
			</div>
		</form>
</div>