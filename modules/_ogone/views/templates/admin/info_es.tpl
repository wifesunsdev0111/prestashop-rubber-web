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
				<p>Centraliza y monitoriza todas tus transacciones online en una única plataforma</p>
				<img style="width: 100%;"
					src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/process_sp.png" />
			</div>
			<div class="float half">
				<ul class="ogone_info_list">
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/150.png" />+ 150
						medios de pago</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/trust.png" />Confianza</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/security.png" />Seguridad</li>
					<li><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/simplicity.png" />Fácil</li>
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
					Tienes un proyecto ? Alguna pregunta ? <br />La Comentamos Juntos ? <br />Tél:
					+34 91 312 74 00 <br />Email: <a
						href="mailto:salesfr.ecom@ingenico.com">salesufr.ecom@ingenico.com</a>
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
				<p>Buenas noticias: nuestra suscripción PRO es altamente competitiva: No cobramos comisión por volumen de compra, sino únicamente una tarifa por transacción !</p>
				<p>Activa tu cuenta en tres sencillos pasos  </p>
				<p>
					Primero crea una cuenta test (gratuita y sin compromiso).
					<br />Simplemente pincha en el enlace y rellena la informacion solicitada en nuestra web. 

				</p>
				<p class="text-center">
					<a href="https://secure.ogone.com/Ncol/Test/BackOffice/accountcreation/create?BRANDING=ogone&ISP=ODE&SubId=5&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=ES&Lang=6" target="_blank"><img
						src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/test_account_en.png"
						class="account" /></a>
				</p>
				<p>
					Recibiras un email de confirmacion al concluir la creacion de la cuenta y podras conectar con tu back Office de Ingenico.
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
					<p>Configura el modulo PrestaShop y la cuenta Ingenico siguiendo nuestra guia de configuracion . </p>
					<p>
						<a href="http://payment-services.ingenico.com/es/es/ogone/support/guides/integration%20guides/prestashop-extension" target="_blank">
							<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/documentation.png"	class="documentation" />
						</a>
						Es muy sencillo siguiendo las instrucciones.
					</p>
				</div>
				<div class="clear"></div>
			</div>

			<div class="chapter step-wrapper no-border">
				<div class="float img-step">
					<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step3.png" class="step" />
				</div>
				<div class="float step-text">
					<p>Pasa tu cuenta test Ingenico a modo produccion. Todo lo que necesitas para finalizar la configuracion es registrar tus datos de facturacion y tu numero de comercio (te lo facilitara tu banco adquiriente de las transacciones).<br/>Podras obtener tu contrato y empezar a vender online</p>
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
						Tienes Preguntas ? <br />Algun paso te bloquea? No dudes encontactarnos. Estamos a tu disposicion paraguiarte en la configuracion <br />Tél:
						+34 91 312 74 00  <br />Email: <a
							href="mailto:salesfr.ecom@ingenico.com">salesfr.ecom@ingenico.com</a>
					</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div class="clear"></div>

		<hr/>

	</div>
</div>