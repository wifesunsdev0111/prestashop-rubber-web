/**
 * HiPay Enterprise SDK Prestashop
 *
 * 2017 HiPay
 *
 * NOTICE OF LICENSE
 *
 * @author    HiPay <support.tpp@hipay.com>
 * @copyright 2017 HiPay
 * @license   https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 */
var hiPayInputControl={};hiPayInputControl.forms=[];function insertAfter(newElement,targetElement){var parent=targetElement.parentNode;if(parent.lastChild===targetElement){parent.appendChild(newElement)}else{parent.insertBefore(newElement,targetElement.nextSibling)}}
function removeElementsByClass(className){var elements=document.getElementsByClassName(className);while(elements.length>0){elements[0].parentNode.removeChild(elements[0])}}
function hasClass(el,className){if(el.classList){return el.classList.contains(className)}else{return!!el.className.match(new RegExp("(\\s|^)"+className+"(\\s|$)"))}}
function addClass(el,className){if(el.classList){el.classList.add(className)}else if(!hasClass(el,className)){el.className+=" "+className}}
function removeClass(el,className){if(el.classList){el.classList.remove(className)}else if(hasClass(el,className)){var reg=new RegExp("(\\s|^)"+className+"(\\s|$)");el.className=el.className.replace(reg," ")}}
function generateElement(text){var pInsert=document.createElement("span");pInsert.textContent=text;addClass(pInsert,"error-text-hp");return pInsert}
function errorMessage(element,text){addClass(element,"error-input-hp");insertAfter(generateElement(text),element)}
var validIBAN=(function(){var CODE_LENGTHS={AD:24,AE:23,AT:20,AZ:28,BA:20,BE:16,BG:22,BH:22,BR:29,CH:21,CR:21,CY:28,CZ:24,DE:22,DK:18,DO:28,EE:20,ES:24,FI:18,FO:18,FR:27,GB:22,GI:23,GL:18,GR:27,GT:28,HR:21,HU:28,IE:22,IL:23,IS:26,IT:27,JO:30,KW:30,KZ:20,LB:28,LI:21,LT:20,LU:20,LV:21,MC:27,MD:24,ME:22,MK:19,MR:27,MT:31,MU:30,NL:18,NO:15,PK:24,PL:28,PS:29,PT:25,QA:29,RO:24,RS:22,SA:24,SE:24,SI:19,SK:24,SM:27,TN:24,TR:26};function mod97(string){var checksum=string.slice(0,2),fragment;for(var offset=2;offset<string.length;offset+=7){fragment=String(checksum)+string.substring(offset,offset+7);checksum=parseInt(fragment,10)%97}
return checksum}
return function(input){var iban=String(input).toUpperCase().replace(/[^A-Z0-9]/g,""),code=iban.match(/^([A-Z]{2})(\d{2})([A-Z\d]+)$/),digits;if(!code||iban.length!==CODE_LENGTHS[code[1]]){return!1}
digits=(code[3]+code[1]+code[2]).replace(/[A-Z]/g,function(letter){return letter.charCodeAt(0)-55});return mod97(digits)===1}})();function isCardNumberValid(value){if(/[^0-9-\s]+/.test(value)){return!1}
var nCheck=0,nDigit=0,bEven=!1;value=value.replace(/\D/g,"");for(var n=value.length-1;n>=0;n--){var cDigit=value.charAt(n);nDigit=parseInt(cDigit,10);if(bEven){if((nDigit*=2)>9){nDigit-=9}}
nCheck+=nDigit;bEven=!bEven}
return nCheck%10===0}
function isCPFValid(value){return value.match(/(\d{2}[.]?\d{3}[.]?\d{3}[\/]?\d{4}[-]?\d{2})|(\d{3}[.]?\d{3}[.]?\d{3}[-]?\d{2})$/)}
function isCPNCURPValid(value){return value.match(/^[a-zA-Z]{4}\d{6}[a-zA-Z]{6}\d{2}$/)}
function isPhoneValid(value){return value.match(/^1(1[2578]|2([09]80|3(45|)|5(3?0|5)|7[67])|414|6(200|(80|91)\d|99[015679])|8(28|91))|(2([1-8]\d|9[136])|30\d|7(0[789]|60)|80[08]|9([136]\d|[124-7]))(\d{6})$/)}
function validBic(value){return value.match(/^[a-z]{6}[2-9a-z][0-9a-np-z]([a-z0-9]{3}|x{3})?$/i)}
function normalizePrice(price){price=parseFloat(price.replace(/,/g,"."));if(isNaN(price)||price===""){price=0}
return price}
function checkNotEmptyField(element){if(element.value===null||element.value===""){errorMessage(element,i18nFieldIsMandatory);return!1}
return!0}
function checkIban(element){if(!checkNotEmptyField(element)){return!1}
if(!validIBAN(element.value)){errorMessage(element,i18nBadIban);return!1}
return!0}
function checkBic(element){if(!checkNotEmptyField(element)){return!1}
if(!validBic(element.value)){errorMessage(element,i18nBadBic);return!1}
return!0}
function checkCCNumber(element){if(!checkNotEmptyField(element)){return!1}
if(!isCardNumberValid(element.value)){errorMessage(element,i18nBadCC);return!1}
return!0}
function checkCVC(element){var myCard=Jquery(".card-js");if(myCard.CardJs("cardType")!=="Bcmc"&&myCard.CardJs("cardType")!=="Maestro"&&!checkNotEmptyField(element)){return!1}
return!0}
function checkCPF(element){if(!checkNotEmptyField(element)){return!1}
if(!isCPFValid(element.value)){errorMessage(element,i18nBadCPF);return!1}
return!0}
function checkCPNCURP(element){if(!checkNotEmptyField(element)){return!1}
if(!isCPNCURPValid(element.value)){errorMessage(element,i18nBadCPNCURP);return!1}
return!0}
function checkPhone(element){if(!checkNotEmptyField(element)){return!1}
if(!isPhoneValid(element.value)){errorMessage(element,i18nBadPhone);return!1}
return!0}
function typeControlCheck(input){var element=document.getElementById(input.field);removeClass(element,"error-input-hp");switch(input.type){case "iban":return checkIban(element);case "bic":return checkBic(element);case "creditcardnumber":return checkCCNumber(element);case "cvc":return checkCVC(element);case "cpf":return checkCPF(element);case "curp-cpn":return checkCPNCURP(element);case "phone":return checkPhone(element);default:return checkNotEmptyField(element)}}
function checkControl(form){var success=!0;if(hiPayInputControl.forms[form]){removeElementsByClass("error-text-hp");hiPayInputControl.forms[form].fields.forEach(function(input){success=typeControlCheck(input)&&success})}
return success}
function Form(){this.fields=[]}
function Input(field,type,required){this.field=field;this.type=type;this.required=required}
function addInput(form,field,type,required){if(!hiPayInputControl.forms[form]){hiPayInputControl.forms[form]=new Form()}
hiPayInputControl.forms[form].fields.push(new Input(field,type,required))}
hiPayInputControl.checkControl=checkControl;hiPayInputControl.addInput=addInput;hiPayInputControl.normalizePrice=normalizePrice