/**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author    Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*/
$(document).ready(function()
{
    bindStateInputAndUpdate();
});

function bindStateInputAndUpdate()
{
    $('select#id_country').change(function(){
        updateState();
        updateNeedIDNumber();
        updateZipCode();
    });

    if ($('select#id_country_invoice').length != 0)
    {
        $('select#id_country_invoice').change(function(){
            updateState('invoice');
            updateNeedIDNumber('invoice');
            updateZipCode();
        });
        if ($('select#id_country_invoice:visible').length != 0)
        {
            updateState('invoice');
            updateNeedIDNumber('invoice');
            updateZipCode('invoice');
        }
    }

    updateState();
    updateNeedIDNumber();
    updateZipCode();
}

function updateState(suffix)
{
    $('select#id_state'+(suffix !== undefined ? '_'+suffix : '')+' option:not(:first-child)').remove();
    var states = countries[$('select#id_country'+(suffix !== undefined ? '_'+suffix : '')).val()];
    if(typeof(states) != 'undefined')
    {
        var idSelectedState = (suffix == 'invoice')?idSelectedCountry_invoice:idSelectedCountry; // Yes, it has name with 'country', but it refers to states.
        $(states).each(function (key, item){
            $('select#id_state'+(suffix !== undefined ? '_'+suffix : '')).append('<option value="'+item.id+'"'+ (idSelectedState == item.id ? ' selected="selected"' : '') + '>'+item.name+'</option>');
        });

        $('p.id_state'+(suffix !== undefined ? '_'+suffix : '')+':hidden').slideDown('slow', function() {validateFieldAndDisplayInline($('#id_state'));});
    }
    else
        $('p.id_state'+(suffix !== undefined ? '_'+suffix : '')).hide();

}

function updateNeedIDNumber(suffix)
{
    var idCountry = parseInt($('select#id_country'+(suffix !== undefined ? '_'+suffix : '')).val());

    if ($.inArray(idCountry, countriesNeedIDNumber) >= 0)
        $('.dni'+(suffix !== undefined ? '_'+suffix : '')).slideDown('slow');
    else
        $('.dni'+(suffix !== undefined ? '_'+suffix : '')).slideUp('fast');
}

function updateZipCode(suffix) {
    var idCountry = parseInt($('select#id_country' + (suffix !== undefined ? '_' + suffix : '')).val());

    if (countriesNeedZipCode[idCountry] !== undefined) {
        if (countriesNeedZipCode[idCountry] != 0)
            $('.postcode' + (suffix !== undefined ? '_' + suffix : '')).slideDown('slow');
        else
            $('.postcode' + (suffix !== undefined ? '_' + suffix : '')).slideUp('fast');
    }
}



/*function updateState(suffix) {
    selectedCountry = (suffix == "invoice") ? idSelectedCountry_invoice : idSelectedCountry;

    $('select#id_state' + (suffix !== undefined ? '_' + suffix : '') + ' option:not(:first-child)').remove();
    var states = countries[$('select#id_country' + (suffix !== undefined ? '_' + suffix : '')).val()];
    if (typeof(states) != 'undefined') {
        $(states).each(function (key, item) {
            $('select#id_state' + (suffix !== undefined ? '_' + suffix : '')).append('<option value="' + item.id + '"' + (selectedCountry == item.id ? ' selected="selected"' : '') + '>' + item.name + '</option>');
        });

        $('p.id_state' + (suffix !== undefined ? '_' + suffix : '') + ':hidden').slideDown('slow');
    }
    else
        $('p.id_state' + (suffix !== undefined ? '_' + suffix : '')).slideUp('fast');
}

function updateNeedIDNumber(suffix) {
    var idCountry = parseInt($('select#id_country' + (suffix !== undefined ? '_' + suffix : '')).val());

    if ($.inArray(idCountry, countriesNeedIDNumber) >= 0)
        $('.dni' + (suffix !== undefined ? '_' + suffix : '')).slideDown('slow');
    else
        $('.dni' + (suffix !== undefined ? '_' + suffix : '')).slideUp('fast');
}

function updateZipCode(suffix) {
    var idCountry = parseInt($('select#id_country' + (suffix !== undefined ? '_' + suffix : '')).val());

    if (countriesNeedZipCode[idCountry] != 0 && isVirtualCart == 0)
        $('.postcode' + (suffix !== undefined ? '_' + suffix : '')).slideDown('slow');
    else
        $('.postcode' + (suffix !== undefined ? '_' + suffix : '')).slideUp('fast');
}*/
