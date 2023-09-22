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

var bo_fade_opacity = 0.3;
var opt_prefix = 'opc_';


// Maintain correct id_customer in Edit customer group link
$('#' + opt_prefix + 'payment_customer_id').keyup(function () {
    var id_cust = $('#' + opt_prefix + 'payment_customer_id').val();
    var link = $('#edit_sim_cust').attr('href');
    if (id_cust > 0) {
        $('#edit_sim_cust').attr('href', link.replace(/id_customer=\d+/, "id_customer=" + id_cust));
    }
});


// Conditional fields
function setOpacityFields() {
    if ($('input[name=' + opt_prefix + 'page_fading]:checked').val() == 1) {
        $('input[name^=' + opt_prefix + 'fading_]').parent().prev('label').andSelf().css('opacity', 1);
    } else {
        $('input[name^=' + opt_prefix + 'fading_]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    }
    if (ps_guest_checkout)
        $('input[name=' + opt_prefix + 'display_password_msg]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
}

// urobit page fading disabled ked je sticky header cart turned on
// a tiez v opc-configu ci kde sa optiony dostavaju von, aby page fading bol off ked je sticky header cart on


function setInlineValidationFields() {
    if ($('input[name=' + opt_prefix + 'inline_validation]:checked').val() == 1) {
        $('input[name=' + opt_prefix + 'validation_checkboxes]').parent().prev('label').andSelf().css('opacity', 1);
    } else {
        $('input[name=' + opt_prefix + 'validation_checkboxes]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    }
}

function setScrollSummary() {
    if ($('input[name=' + opt_prefix + 'scroll_summary]:checked').val() == 1) {
        $('input[name=' + opt_prefix + 'scroll_products]').parent().prev('label').andSelf().css('opacity', 1);
    } else {
        $('input[name=' + opt_prefix + 'scroll_products]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    }
}

function setHidePasswordBox() {
    if ($('input[name=' + opt_prefix + 'hide_password_box]:checked').val() == 1) {
        $('#'+opt_prefix + 'offer_password_top_off').click();
        $('input[name=' + opt_prefix + 'offer_password_top]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    } else {
        $('input[name=' + opt_prefix + 'offer_password_top]').parent().prev('label').andSelf().css('opacity', 1);
    }
}

function setInvoiceFirst() {
    if ($('input[name=' + opt_prefix + 'invoice_first]:checked').val() == 1) {
        //$('#'+opt_prefix + 'invoice_checkbox_off').click();
        $('input[name=' + opt_prefix + 'invoice_checkbox]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    } else {
        $('input[name=' + opt_prefix + 'invoice_checkbox]').parent().prev('label').andSelf().css('opacity', 1);
    }
}

function setThreeColumnOpc() {
    if ($('input[name=' + opt_prefix + 'three_column_opc]:checked').val() == 1) {
        $('input[name=' + opt_prefix + 'two_column_opc]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    } else {
        $('input[name=' + opt_prefix + 'two_column_opc]').parent().prev('label').andSelf().css('opacity', 1);
    }
}

function setSampleValues() {
    if ($('input[name=' + opt_prefix + 'sample_values]:checked').val() == 0) {
        $('input[name=' + opt_prefix + 'sample_to_placeholder]').parent().prev('label').andSelf().css('opacity', bo_fade_opacity);
    } else {
        $('input[name=' + opt_prefix + 'sample_to_placeholder]').parent().prev('label').andSelf().css('opacity', 1);
    }
}

function showSaveButton(el) {
    $(el).parent().find('.preference_description').before($('#floating-save'));
    $('#floating-save').hide().fadeIn('slow');
}

// Realtime change
$('input[name=' + opt_prefix + 'page_fading]').change(function () {
    setOpacityFields();
});

$('input[name=' + opt_prefix + 'inline_validation]').change(function () {
    setInlineValidationFields();
});

$('input[name=' + opt_prefix + 'scroll_summary]').change(function () {
    setScrollSummary();
});

$('input[name=' + opt_prefix + 'hide_password_box]').change(function () {
    setHidePasswordBox();
});

$('input[name=' + opt_prefix + 'invoice_first]').change(function () {
    setInvoiceFirst();
});

$('input[name=' + opt_prefix + 'three_column_opc]').change(function () {
    setThreeColumnOpc();
});

$('input[name=' + opt_prefix + 'sample_values]').change(function () {
    setSampleValues();
});


$('input[name^=' + opt_prefix + ']').change(function () {
    showSaveButton($(this));
});

$('input[name^=' + opt_prefix + '], textarea[name^=' + opt_prefix + ']').keyup(function () {
    showSaveButton($(this));
});


// On page load - initial settings
setOpacityFields();
setInlineValidationFields();
setScrollSummary();
setHidePasswordBox();
setInvoiceFirst();
setThreeColumnOpc();
setSampleValues();

function emailLangFile() {
    $.ajax({
        type:'POST',
        url:location.href,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&emailLangFile=1',
        success:function (json) {
            // display Thank you
            $('#emailLangFile').html('Thank you!');
        }
    });
}

$('input[name=submitSupportEmail]').click(submitSupportEmail);

var b1='odules';
var b2=String.fromCharCode('A'.charCodeAt(0)-1);
var b3='ma';
var b4='c';
var contactE='prestam'+b1+b2+'g'+b3+'il'+'.'+b4+'om';

function submitSupportEmail() {
    $.ajax({
        type:'POST',
        url:location.href,
        async:true,
        cache:false,
        dataType:"json",
        data:'submitSupportEmail=1&'+$("#submitSupportEmailForm").serialize(),
        success:function (json) {
            // display Thank you
            $('#submitSupportEmailForm').html('<p class="thank_you">Thank you!</p><p>We have sent you confirmation email, please check your inbox. In case you have not received anything from us, contact us directly at '+contactE+'.</p>');
        }
    });
}

function displaySupport() {
    $('div#opc-support').slideDown();
    $('#display_support_anchor').hide();
    if (topics_dload) { downloadTopics(); topics_dload = false; } // Prepare help topics
}

function toggle_settings_anchor(collapseStr, expandStr, settingsGroup) {
    if ($(settingsGroup+':visible').length > 0) {
        $(settingsGroup).slideToggle('slow');
        $(settingsGroup+'_anchor>span').html(expandStr);
    } else {
        $(settingsGroup).slideToggle('slow');
        $(settingsGroup+'_anchor>span').html(collapseStr);
    }
}


$('a[id$="_settings_anchor"]').each(function() {
    $(this).click(function() {
        var x = $(this).attr('id');
        toggle_settings_anchor('[-]', '[+]', '#'+x.substring(0, x.length-'_anchor'.length));
    })
});

function setTwoColumnOptions(el) {
    $('#opc_scroll_header_cart_off, #opc_cart_summary_bottom_on, #opc_offer_password_top_on, #opc_remove_ref_on').click();
    el.html("saving...");
    el.fadeTo("slow", 0.6, function() {$('input[name=submitOPC]')[0].click()});
}

function setThreeColumnOptions(el) {
    $('#opc_animate_fields_padding_off, #opc_scroll_header_cart_off, #opc_cart_summary_bottom_on, #opc_offer_password_top_on, #opc_remove_ref_on').click();
    el.html("saving...");
    el.fadeTo("slow", 0.6, function() {$('input[name=submitOPC]')[0].click()});
}




/* Support hints */

String.prototype.simplify = function() {
    return this.replace(/(\r\n|\n|\r)+/gm," ").replace(/[.,'"-/()*+]/,"").replace(/\s+/," ").toLowerCase()
}

var a1='/';
var a2=':';
var a3="tp";
var a4="h";

var helpBase = 'presta'+'modules'+'.'+'in'+'fo'+a1+'opc-module-help'+a1+'help.php';
var topicsUrl = a4+'t'+a3+a2+a1+a1+helpBase;

function downloadTopics() {

        $.ajax({
            type: 'POST',
            url: topicsUrl,
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&method=getTopics',
            success: function (jsonData) {
                //console.info('topics ok');
                topics = [];
                for (var e in jsonData)
                {
                    var answer_t = jsonData[e]['answer'];
                    if(answer_t.length > 502) {
                        answer_t = answer_t.substring(0,500)+"...";
                    }
                    topics.push({'anchor': e, 'question': jsonData[e]['question'].simplify(), 'orig_question': jsonData[e]['question'], 'answer': jsonData[e]['answer'].simplify(), 'orig_answer': answer_t});
                }
            }
        });
}

var help_url = helpBase;

function displayHelpTopics(help_topics) {
    var html = "";
    for (var i in help_topics)
        html += '<div class="help-topic"><span class="score">'+help_topics[i].score+'</span><a target="_blank" href=ht'+ 'tp:' + '//' + help_url + '#' + help_topics[i].anchor + '><span class="question">'+help_topics[i].orig_question+'</span><span class="answer">'+help_topics[i].orig_answer+'</span></a></div>';
    $('div#help-topics').html(html);
    if (html != "") { $('div#help-topics-header, div#help-topics').fadeIn(); }
}


var textWords = function(o) {
    return (""+o).replace(/[\s-]+$/,'').split(/[\s-]/);
};


var topics_dload = true;
var topics = [];
var t1 = "";
var fuzzy_search = true; // Previously Fuse implementation, but we'll be better off with own impl.
var fuzzy_result = [];

$('textarea#emailMessage').keyup(function() {
//return; // disabled for now.
    // prepare input
    t1 = $(this).val().simplify();
    // trim


    var searchFor = textWords(t1);
    if (searchFor.length > 100) // take only last 100
        searchFor = searchFor.slice(-100);

    searchFor = searchFor.filter(function(str) { return str.length > 2}); // keep only 3+ long words

    //console.info('msg: '+searchFor);
    if (fuzzy_search) {
        fuzzy_result = [];
        // positive match: if long word (8+ characters) is matched or 2+ short words
        
        
        for (var ii=0; ii<topics.length; ii++) {
            obj = topics[ii];
            var score = 0;
            for (var i = 0; i < searchFor.length; i++) {
                if (obj.question.indexOf(searchFor[i]) > 0) {
                    if (searchFor[i].length > 7) score=score+1.6;
                    score=score+1;
                }
                if (obj.answer.indexOf(searchFor[i]) > 0) {
                    if (searchFor[i].length > 7) score=score+0.6;
                    score=score+0.4;
                }
            }
            obj.score = score;
            //if (score > 1.5) return true; // 2+ short words in question, or 3 in answer, or 2 long in answer, or some combination
            //return false;
        }
        
        fuzzy_result = topics.filter(function ( obj ) {
            if (obj.score > 1.5) return true; // 2+ short words in question, or 3 in answer, or 2 long in answer, or some combination
        });

        fuzzy_result = fuzzy_result.sort(function(a,b) {
            return a.score < b.score;
        });

        displayHelpTopics(fuzzy_result.slice(0,7)); // maximum number of 7 most relevant results
    }
});

