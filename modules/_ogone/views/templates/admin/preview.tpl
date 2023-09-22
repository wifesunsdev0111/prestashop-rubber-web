{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="ogone_preview_body">
<TABLE BORDER="0" WIDTH="100%">
  <TR>
    <TD WIDTH="15%">&nbsp;
    </TD>
    <TD WIDTH="70%"><div align="center"><img class="ogone_logo" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/ingenico.png">&nbsp;<font size="4" ><strong class="ogone_preview_title">%OGONE_TITLE%</strong></font>&nbsp;</div>
    <br>
  <!-- Order overview -->
  <h2 style="display: inline; position: absolute; left: -1000px; top: -1000px; width: 0px; height: 0px; overflow: hidden;">Vue d&#39;ensemble de commande</h2>
  <table class=ncoltable1 border="0" cellpadding="2" cellspacing="0" width="95%" id="ncol_ref">
              <tr>
                <td class=ncoltxtl colspan="1" align="right" width="50%"><small>Num&#233;ro de commande :<!--External reference--></small></td>
                <td class=ncoltxtr colspan="1" width="50%"><small>123456</small></td>
              </tr>
        <tr>
              <td class=ncoltxtl colspan="1" align="right" width="50%"><small>
              Total &#224; payer :<!--Total to pay-->
              </small></td>
              <td class=ncoltxtr colspan="1" width="50%">
                <small>12.34 EUR
              </small>
              </td>

        </tr>

          <tr>
            <td class=ncoltxtl colspan="1" align="right"><small>B&#233;n&#233;ficiaire :<!--Beneficiary--></small></td>
            <td class=ncoltxtr colspan="1"><small>Ingenico</small></td>
          </tr>

  </table>



            <form method="GET" action="" name="OGONE_CC_FORM" ONSUBMIT="return false;">


          <p></p>
          <!-- Hidden title for screenreaders (Payment Data) -->
          <h2 style="display: inline; position: absolute; left: -1000px; top: -1000px; width: 0px; height: 0px; overflow: hidden;">Donn&#233;es du paiement</h2>
            <table class=ncoltable2 border="0" cellpadding="2" cellspacing="0" width="95%" >

            <tr>


            <td class=ncoltxtl2 width="50%" valign="top" align="right">
            <small>Payer avec<!--Credit card--> :</small>


            </td>
            <td class=ncolinput width="50%" valign="top" align="left" nowrap>



                  <img border="0" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/preview/VISA_choice.gif" align="middle" alt="VISA" title="VISA">

              </td>
            </tr>
            <tr>
                  <td class=ncoltxtl2 align="right"><small><label for="Ecom_Payment_Card_Name">Titulaire de la carte*</label><!--Card holder name--> :</small></td>
                  <td class=ncolinput ><small><input type="text" name="Ecom_Payment_Card_Name" id="Ecom_Payment_Card_Name" MAXLENGTH="35" size="20" value=""></small>

                  </td>
                </tr>
                <tr>
                  <td class=ncoltxtl2 align="right"><small>
                    <label for="Ecom_Payment_Card_Number">
                      Num&#233;ro de la carte*
                    </label><!--Card number--> :</small>
                  </td>
                  <td class=ncolinput ><small>
                    <input name="Ecom_Payment_Card_Number" id="Ecom_Payment_Card_Number" autocomplete="Off" MAXLENGTH="20" size="20" type="text"  class="numberLtr">
                  </small>

              </td>
                </tr>

                  <tr>
                    <td class=ncoltxtl2 align="right"><small>
                        <label for="Ecom_Payment_Card_ExpDate_Month">Date d&#39;expiration &#40;mm</label>/<label for="Ecom_Payment_Card_ExpDate_Year">aaaa&#41;*
                    </label> :</small></td>
                    <td class=ncolinput >


                      <small><select id="Ecom_Payment_Card_ExpDate_Month" name="Ecom_Payment_Card_ExpDate_Month" size="1"   title="Date d&#39;expiration &#40;mm/aaaa&#41; &#40;mois&#41;">
                          <option value=""></option>
                      <option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>


                      </select>/<select id="Ecom_Payment_Card_ExpDate_Year" name="Ecom_Payment_Card_ExpDate_Year" size="1"   title="Date d&#39;expiration &#40;mm/aaaa&#41; &#40;ann&#233;e&#41;">
                  <option value=""></option>
                  <option value="2016">2016</option>
<option value="2016">2016</option>
<option value="2017">2017</option>


                      </select></small>

                    <input type=hidden value="201401" name="Comp_Expirydate">

                </td>
                </tr>


                  <tr>



                    <td class=ncoltxtl2 align="right"><small><label for="Ecom_Payment_Card_Verification">Code de v&#233;rification de la carte</label> :</small></td>
                    <td class=ncolinput >
                      <small>

                        <input type="text" name="Ecom_Payment_Card_Verification" id="Ecom_Payment_Card_Verification" autocomplete="Off" size="10" MAXLENGTH="10" >

                      </small>&nbsp;

                      <input type="hidden" name="CVCFlag" value="-1">

                        <small>
                          <small>
                            <a class=midncol href="#"></a>
                          </small>
                        </small>

                    </td>
                  </tr>

                <tr>
                  <td colspan ="2" valign="middle" align="center" >
                    <small><small>
                    Un * indique les champs obligatoires
                    <br>

                </small>
                    </small>
                    </td>
                </tr>
                <tr align="center">
                  <td colspan="2" valign="middle" align="center" >
                    <small>

                  <input type="submit" class="ncol" name="payment" value="Oui, je confirme mon paiement" id=submit3 />

                    </small>
                    </td>
                </tr>


            </table>

          </form>

<!-- Further information / Cancel -->
<h2 style="display: inline; position: absolute; left: -1000px; top: -1000px; width: 0px; height: 0px; overflow: hidden;">Autres informations / Annuler</h2>
<table class=ncoltable3 border="0" cellpadding="2" cellspacing="0" width="95%" id="ie_cc" style="behavior:url(#default#clientCaps)">
  <tr><td class="ncollogoc" valign="middle" align="center" width="33%"><a href="#"><img border="0" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/preview/VISA_brand3D.gif" title="VISA" alt="VISA" hspace="3"></a><img border="0" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/preview/BCC.gif" hspace="5" alt="BCC" title="BCC" id="NCOLACQ"></td>
  <td class="ncollogoc" valign="middle" align="center" width="33%"><a href="#"><img border="0" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/preview/PP_ogone2.gif" alt="Paiement trait&#233; parOgone" title="Paiement trait&#233; parOgone" vspace="2" id="NCOLPP"></a><br><small><small><a class="bottom" href="#" target="">A propos de Ingenico ePayments</a> |<a class="bottom" href="#" target="_blank">Protection de la vie priv&#233;e<!--Privacy policy--></a> |<a class="bottom" href="#">S&#233;curit&#233;<!--Security--></a>| <a class="bottom" href="#" target="_blank">Informations l&#233;gales<!--Legal--></a></small></small></td><td class="ncollogoc" valign="middle" align="center" width="33%"><a href="#" target="VRSN_Splash"><IMG NAME="seal" BORDER="0" SRC="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/preview/vseal_Norton.gif" alt="Verisign" ></A></td></tr>
    <tr>
        <td class=ncollogoc align="center" colspan="3">
            <center>
              <table border="0" cellpadding="0" cellspacing="0" >
                  <tr>

                        <td class="ncollogoc" align="center" width="50%">
                          <form name=form2 style="margin-bottom:0px;">
                            <input class=ncol type="button" name="Modify" value="Retour" id="btn_Back">
                          </form>
                        </td>

                      <td class=ncollogoc align="center" width="50%">

                          <form method="get" action="#" id=form3 name=form3 onsubmit="return false;"  style="margin-bottom:0px;">
                            <small><input class=ncol ID="ncol_cancel" type="submit" name="cancel" value="Annulation"></small><!--Cancel-->
                          </form>

                      </td>

                  </tr>
              </table>
            </center>
        </td>

    </tr>


</table>



    </TD>
    <TD WIDTH="15%">&nbsp;
    </TD>

  </TR>

</TABLE>
</div>
