/**
 * @copyright Commercial License By LeoTheme.Com 
 * @email leotheme.com
 * @visit http://www.leotheme.com
 */
$(document).ready(function(){
    $('#panelTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    var expiresThemConfigDay = 1;
    $('#panelTab a:first').tab('show');
    $(".bg-config").hide();
    var $MAINCONTAINER = $("html");

    /**
     * BACKGROUND-IMAGE SELECTION
     */
    $(".background-images").each(function() {
        var $parent = this;
        var $input = $(".input-setting", $parent);
        $(".bi-wrapper > div", this).click(function() {
            $input.val($(this).data('val'));
            $(".bg-config",$parent).show();
            $('.bi-wrapper > div', $parent).removeClass('active');
            $(this).addClass('active');

            if ($input.data('selector')) {
                $($input.data('selector'), $($MAINCONTAINER)).css($input.data('attrs'), 'url(' + $(this).data('image') + ')');
            }
        });
        $(".bg-config select", this).change(function(){
            if ($input.data('selector')) {
                $($input.data('selector'), $($MAINCONTAINER)).css($(this).data('attrs'), $(this).val());
            }
        });
    });

    $(".clear-bg").click(function() {
        var $parent = $(this).parent();
        var $input = $(".input-setting", $parent);
        if ($input.val('')) {

            if ($parent.hasClass("background-images")) {
                $('.bi-wrapper > div', $parent).removeClass('active');
                $($input.data('selector'), $($MAINCONTAINER)).css($input.data('attrs'), 'none');
                $('ul select', $parent).each(function(){
                    $($input.data('selector'), $($MAINCONTAINER)).css($(this).data('attrs'), '');
                });
                $('ul.bg-config', $parent).hide();
                $('ul select', $parent).val("");
            } else {
                $input.attr('style', '')
            }
            $($input.data('selector'), $($MAINCONTAINER)).css($input.data('attrs'), 'inherit');

        }
        $input.val('');

        return false;
    });

    $('.accordion-group input.input-setting').each(function() {
        var input = this;
        $(input).attr('readonly', 'readonly');
        $(input).ColorPicker({
            onChange: function(hsb, hex, rgb) {
                $(input).css('backgroundColor', '#' + hex);
                $(input).val(hex);
                if ($(input).data('selector')) {
                    $($MAINCONTAINER).find($(input).data('selector')).css($(input).data('attrs'), "#" + $(input).val())
                }
            }
        });
    });

    $('.accordion-group select.input-setting').change(function() {
        var input = this;
        if ($(input).data('selector')) {
            var ex = $(input).data('attrs') == 'font-size' ? 'px' : "";
            $($MAINCONTAINER).find($(input).data('selector')).css($(input).data('attrs'), $(input).val() + ex);
        }
    });
    $(".paneltool .panelbutton").click(function() {
        $(this).parent().toggleClass("active");
    });


    /** Panel tool code */
    $('.leo-dynamic-theme-skin').click(function(){
        if(!$(this).hasClass('current-theme-skin'))
        {
            $('.leo-dynamic-theme-skin').removeClass('current-theme-skin');
            $(this).addClass('current-theme-skin');

            selectedSkin = $(this).data('theme-skin-id');
            //add class to html when selec skin
            $('.leo-dynamic-theme-skin').each(function(){
                    $('html').removeClass($(this).data('theme-skin-id'));
            });
            $('html').addClass(selectedSkin);
            if(selectedSkin=='default')
            {
                $('head #leo-dynamic-skin-css').remove();
                $('head #leo-dynamic-skin-css-rtl').remove();
            }else{
                skinRTLCss = $(this).data('theme-skin-rtl');
                skinFileUrl = $(this).data('theme-skin-css');

                if($('head #leo-dynamic-skin-css').length)
                {
                    $('head #leo-dynamic-skin-css').attr('href',skinFileUrl+'skin.css');

                }else{
                    $('head').append('<link rel="stylesheet" id="leo-dynamic-skin-css" href="'+skinFileUrl+'skin.css" type="text/css" media="all" />');
                }

                if($('head #leo-dynamic-skin-css-rtl').length && skinRTLCss)
                {
                    $('head #leo-dynamic-skin-css-rtl').attr('href',skinFileUrl+'custom-rtl.css');
                }else if(skinRTLCss)
                {
                    $('head').append('<link rel="stylesheet" id="leo-dynamic-skin-css-rtl" href="'+skinFileUrl+'custom-rtl.css" type="text/css" media="all" />');
                }else{
                    $('head #leo-dynamic-skin-css-rtl').remove();
                }
            }
            configName = $('#leo-paneltool').data('cname')+'_default_skin';
            $.cookie(configName, selectedSkin, {expires: expiresThemConfigDay, path: '/'});
        }
    });

    /* float header */
    $('.enable_fheader').click(function(){
        if(!$(this).hasClass('current')){
            configName = $('#leo-paneltool').data('cname')+'_enable_fheader';
            $('.enable_fheader').removeClass('current');
            $(this).addClass('current');
            if($(this).data('value')){
                $('body').addClass('keep-header');
                floatHeader();
                $.cookie(configName, 1, {expires: expiresThemConfigDay, path: '/'});
            }
            else{
                $('body').removeClass('keep-header');
                processFloatHeader(0,0);
                $.cookie(configName, 0, {expires: expiresThemConfigDay, path: '/'});
            }
        }
    });
    /* header style */
    var currentHeaderStyle = $('.leo-dynamic-update-header.current-header').data('header-style');
    $('.leo-dynamic-update-header').click(function(){
        if(!$(this).hasClass('current-header'))
        {
            $('.leo-dynamic-update-header').removeClass('current-header');
            $(this).addClass('current-header');

            selectedHeader = $(this).data('header-style');
            $('body').removeClass(currentHeaderStyle);
            $('body').addClass(selectedHeader);
            currentHeaderStyle = selectedHeader;
            configName = $('#leo-paneltool').data('cname')+'_header_style';
            $.cookie(configName, selectedHeader, {expires: expiresThemConfigDay, path: '/'});
        }
    });
    var currentSideBarStyle = $('.leo-dynamic-update-side.current-sidebar').data('sidebar');
    var sideBarStyleList = [];
    $('.leo-dynamic-update-side').each(function(i){
        sideBarStyleList[i] = $(this).data('sidebar');
    });
    $('.leo-dynamic-update-side').click(function(){
        if(!$(this).hasClass('current-sidebar'))
        {
            $('.leo-dynamic-update-side').removeClass('current-sidebar');
            $(this).addClass('current-sidebar');

            selectedHeader = $(this).data('sidebar');
            $.each(sideBarStyleList, function( index, value ) {
                $('body').removeClass(value);
            });
            $('body').addClass(selectedHeader);
            currentSideBarStyle = selectedHeader;
            getBodyClassByMenu();

            configName = $('#leo-paneltool').data('cname')+'_sidebarmenu';
            $.cookie(configName, selectedHeader, {expires: expiresThemConfigDay, path: '/'});
        }
    });
    
    var currentLayoutMode = $('.leo-dynamic-update-layout.current-layout-mod').data('layout-mod');
    $('.leo-dynamic-update-layout').click(function(){
        if(!$(this).hasClass('current-layout-mod'))
        {
            $('.leo-dynamic-update-layout').removeClass('current-layout-mod');
            $(this).addClass('current-layout-mod');

            selectedLayout = $(this).data('layout-mod');
            $('body').removeClass(currentLayoutMode);
            $('body').addClass(selectedLayout);
            currentLayoutMode = selectedLayout;
			
			getBodyClassByMenu();
			
            configName = $('#leo-paneltool').data('cname')+'_layout_mode';
            $.cookie(configName, selectedLayout, {expires: expiresThemConfigDay, path: '/'});
        }
    });
	
	function getBodyClassByMenu(){
        if($('body').hasClass('sidebar-hide') || $('body').hasClass('header-hide-topmenu'))
           $('body').removeClass('double-menu'); 
        else
            if(!$('body').hasClass('double-menu')) $('body').addClass('double-menu'); 
    }

});