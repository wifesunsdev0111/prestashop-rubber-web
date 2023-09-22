{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{literal}
<style>
	.nobootstrap{
		min-width: inherit !important;
	}
	.ogone {}
	.ogone hr{border:1px solid #fff; margin: 10px auto;}
	.ogone .no-border{border: none !important;}
	.ogone .text-center{text-align: center;}
	.ogone p {text-align: left;font-size: 1.2em;}
	.ogone p a {text-decoration: none;}
	.ogone #chapter_step_wrapper{
		float: left;
		width: 60%;
	}
	.ogone #contact_wrapper{
		float: left;
		width: 40%;
	}
	.ogone .img-step{
		width: 100px;
		position: absolute;
		vertical-align: middle;
		height: 100%;
	}
	.ogone .img-step img{
		position: absolute;
		top: 50%;
		max-width: 80px;
		margin-top: -40px;
	}
	.ogone .step-text{
		width: 100%;
		padding: 0 10px 0 110px !important;
	}
	.ogone .chapter {margin-bottom: 30px; width: 100%;box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;}
	.ogone .chapter.step-wrapper {border-bottom: 1px dotted #fff; padding-bottom: 10px; position: relative;}
	.ogone .float {float: left; padding: 0 10px; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;}
	.ogone .half {width: 50%; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;}
	.ogone .ogone_info_list {list-style-type: none; margin-top: 50px; }
	.ogone .ogone_info_list LI {height: 80px; margin-bottom: 30px;font-size: 1.2em;}
	.ogone .ogone_info_list LI IMG {height:80px;vertical-align: middle;margin-right: 10px; max-width: 80px;}
	.ogone  IMG {max-width: 100%; margin: 0 auto; width: auto !important; height: auto !important;}
	.ogone  IMG.callcenter {width: 80px; margin-top: 15px; max-width: 80px;}
	.ogone  IMG.documentation {width: 40px; vertical-align: middle; margin-right: 5px; max-width: 40px;}
	.ogone  IMG.account {}
	.ogone TABLE {border: 1px solid #777; margin: 20px 0; width: 100%;}
	.ogone TABLE TH {background-color: #0033a0; color: #ffffff; font-weight: bold; text-align :left; font-size: 1.4em; padding: 5px; border: 1px solid #0033a0;}
	.ogone TABLE TD {padding: 5px; border: 1px solid #fff;}
	.ogone TABLE TBODY TR {padding: 5px}
	.ogone .big-strong{
		font-size: 15px;
		font-weight: 600;
	}

	.ogone_acc {
		width: 125px;
		height : 20px;
		background-color: #00c3d7;
		color: #fff;
		font-weight: normal;
		padding: 10px 10px 10px 40px;
		font-size: 14px;
		cursor: pointer;
		text-transform: uppercase;
		text-align: left;
		-webkit-border-top-right-radius: 10px;
		-moz-border-radius-topright: 10px;
		border-top-right-radius: 10px;
		border-top-left-radius: 5px;
	}
	.ogone_acc.active { background-color: #0033a1}
	.ogone_acc:HOVER { background-color: #0033a1}
	.ogone_acc_container {
		padding: 20px;
		background-color: #fff;
		border: 1px solid #d6d4d4;
		margin-bottom: 15px;
		border-top-right-radius: 10px;
		border-bottom-right-radius: 10px;
		width: 100%;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
	}

	@media (max-width: 1199px){
		.ogone p{
			text-align: center;
		}
		.ogone ul{
			padding: 0;
		}
		.ogone .chapter .float, .ogone .half{
			width: 100%;
			margin-bottom: 15px;
			text-align: center;
		}
		.ogone_info_list li{
			text-align: center;
			margin-bottom: 15px;
			height: inherit !important;
		}
		.ogone_info_list img{
			display: block;
			max-width: 50px !important;
			margin: 0 auto 10px auto !important;
		}
		#ogone_config .half{
			text-align: left;
		}
		.ogone #chapter_step_wrapper{
			float: left;
			width: 100%;
		}
		.ogone #contact_wrapper{
			float: left;
			width: 100%;
		}
		.ogone .img-step{
			width: 100px;
			position: relative;
			vertical-align: middle;
			height: 40px;
		}
		.ogone .img-step img{
			position: inherit;
			max-width: 50px;
			margin-top: 0px;
			top: 0;
		}
		.ogone .step-text{
			width: 100%;
			padding: 0 10px 0 10px !important;
		}
	}

</style>
{/literal}
<div class="ogone ogone_acc_container">
	<div id="ogone_info" class="ogone ogone_acc_tgt">
		<div class="chapter">
			<div class="float half" style="text-align: center">
				<p>Eén platform om al uw online transacties te verwerken </p>
				<img style="width: 100%;"
					src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/process_en.png" />
			</div>
			<div class="float half">
				<ul class="ogone_info_list">
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/150.png" />Meer dan 150 lokale en international betaalmethoden</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/trust.png" />Betrouwbaar</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/security.png" />veilig</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/simplicity.png" />Eenvoudig</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>

		<div class="chapter">
			<div class="float half text-center">
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/callcenter.png"
					class="callcenter" />
			</div>
			<div class="float half">
				<p>
					Bent u op zoek naar een betaaloplossing ? Of heeft u een vraag ? <br />Laten we het samen bespreken <br />Telefoon:
					+31 (0)20 840 8400 <br />E-mail: <a
						href="mailto:salesnl.ecom@ingenico.com">salesnl.ecom@ingenico.com</a>
				</p>
			</div>
			<div class="clear"></div>
		</div>

		<hr/>

		<div class="chapter step-wrapper">
			<div class="float img-step">
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step1.png" class="step" />
			</div>
			<div class="float step-text">
				<p>Met ons Pro abonnement rekenen wij een vaste vergoeding per transactie.</p>
				<p>Activeer uw account in slechts 3 stappen: </p>
				<p>
					Open een GRATIS testaccount
					<br /> Dit is volledig vrijblijvend. Klik op de onderstaande knop en vul de benodigde informatie in. 

				</p>
				<p class="text-center">
					<a href="https://secure.ogone.com/Ncol/Test/BackOffice/accountcreation/create?BRANDING=ogone&ISP=ONL&SubId=2&MODE=STD&SOLPRO=Prestashopcosp&ACOUNTRY=NL&Lang=8" target="_blank"><img
						src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/test_account_en.png"
						class="account" /></a>
				</p>
				<p>
					Nadat u een account heeft aangemaakt, ontvangt u een bevestigingsmail voor uw koppeling met de Ingenico Back Office. Onze sales collega’s nemen vervolgens zo snel mogelijk contact op om u te helpen met uw accountinstellingen. 
				</p>
			</div>
			<div class="clear"></div>
		</div>

		<div id="chapter_step_wrapper">
			<div class="chapter step-wrapper">
				<div class="float img-step">
					<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step2.png" class="step" />
				</div>
				<div class="float step-text">
					<p>Configureer uw PrestaShop-module en uw Ingenico Back Office. Gebruik hiervoor onze integratiegids </p>
					<p>
						<a href="http://payment-services.ingenico.com/nl/nl/ogone/support/guides/integration%20guides/prestashop-extension" target="_blank">
							<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/documentation.png"	class="documentation" />
						</a>
						De setup is eenvoudig, volg onze instructies of neem contact op met ons Support team.
					</p>
				</div>
				<div class="clear"></div>
			</div>

			<div class="chapter step-wrapper no-border">
				<div class="float img-step">
					<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step3.png" class="step" />
				</div>
				<div class="float step-text">
					<p>Zet uw testaccount om in een productie-account. U ontvangt uw overeenkomst en u bent klaar voorbetalingen te accepteren.</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id="contact_wrapper">
			<div class="chapter">
				<div class="float half text-center">
					<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/callcenter.png"
						class="callcenter" />
				</div>
				<div class="float half">
					<p>
						Hulp nodig ? <br />We helpen u graag <br/> Neem contact op ! <br />Telefoon :
						+31 (0)20 840 8400  <br />E-mail: <a
							href="mailto:salesnl.ecom@ingenico.com">salesnl.ecom@ingenico.com</a>
					</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div class="clear"></div>

		<hr/>

	</div>
</div>