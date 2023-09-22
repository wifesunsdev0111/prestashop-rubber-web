{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
{$apContent}{*contain html can not escape*}
{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}