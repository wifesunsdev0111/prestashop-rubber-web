/**
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: 
 */
imgId = null; // using for store object image select a source in function select image
function log(message) {
    console.log(message);
}
function htmlentities(str) {
    var textarea = document.createElement("textarea");
    textarea.innerHTML = str;
    return textarea.innerHTML;
}
function htmlentitiesDecode(str) {
    var textarea = document.createElement("textarea");
    textarea.innerHTML = str;
    return textarea.value;
}
(function ($) {
    $.fn.apPageBuilder = function () {
        this.currentElement = null;
        this.ajaxShortCodeUrl = null;
        this.ajaxHomeUrl = null;
        this.shortCodeField = null;
        this.shortcodeInfos = null;
        this.languages = null;
        this.lang_id = 0;
        this.classWidget = 'ui-widget ui-widget-content ui-helper-clearfix ui-corner-all';
        this.classWidgetHeader = 'ui-widget-header ui-corner-all';
        this.widthSupport = null;
        this.arrayCol = null;
        this.windowWidth = 0;
        this.imgController = null;
        this.parentId = null;
        this.profileId = null;

        this.process = function (DATAFORM, DATAINFO, LANGS) {
            var $globalthis = this;
            $globalthis.windowWidth = $(window).width();
            $globalthis.shortcodeInfos = jQuery.parseJSON(DATAINFO);
            $globalthis.languages = jQuery.parseJSON(LANGS);
            $globalthis.initDataFrom(DATAFORM);
            $globalthis.widthSupport = ["1", "2", "2.4", "3", "4", "5", "4.8", "6", "7", "7.2", "8", "9", "9.6", "10", "11", "12"];
            $globalthis.arrayCol = ["sp", "xs", "sm", "md", "lg"];
            $globalthis.initColumnSetting();

            $globalthis.setGroupAction();
            $globalthis.sortable();
            $globalthis.setButtonAction();
            $globalthis.submitForm();

            // Load form after come back from live edit mode
            var type = window.location.href.split('#');
            var hash = '';
            if (type.length > 1) {
                hash = type[1];
                var btn = $("." + hash).find(".btn-edit");
                //$(btn).trigger("click");
            }
            //$globalthis.setRowAction();
        };
        this.initDataFrom = function (data) {
            if (data != '{}') {
                dataObj = jQuery.parseJSON(data);

                Object.keys(dataObj).forEach(function (key) {
                    $('.' + key).data('form', dataObj[key]);
                });
            }
        };
        this.getColDefault = function () {
            return {lg: 12, md: 12, sm: 12, xs: 12, sp: 12};
        };
        //set action for group
        this.setGroupAction = function () {

            //duplicate group
            $('.gaction-duplicate').click(function () {
                var duplicate = $(this).closest('.group-row').clone(1);
                //remove tooltip because wrong position
                $('.tooltip', $(duplicate)).remove();
                $('.label-tooltip', $(duplicate)).tooltip('disable');
                $('.hook-content-footer', $(this).closest('.hook-content')).before(duplicate);
            });

            $('.number-column').click(function () {
                column = $(this).data('cols');
            });

            $('.gaction-toggle').click(function () {
                $(this).closest('.group-row').find('.group-content').first().toggle('clip');
            });
        };
        //sort group
        this.sortable = function () {
            var $globalthis = this;

            $(".hook-content").sortable({
                connectWith: ".hook-content",
                handle: ".gaction-drag"
            });
            $(".group-row").addClass($globalthis.classWidget)
                    .find(".gaction-drag").addClass($globalthis.classWidgetHeader);

            $(".hook-content .group-content").sortable({
                connectWith: ".group-content",
                handle: ".caction-drag"
            });
            $(".column-row").addClass($globalthis.classWidget)
                    .find(".caction-drag").addClass($globalthis.classWidgetHeader);

            $(".group-content .column-content").sortable({
                connectWith: ".column-content",
                handle: ".waction-drag"
            });
            $(".widget-row").addClass($globalthis.classWidget)
                    .find(".waction-drag").addClass($globalthis.classWidgetHeader);

            $(".subwidget-content").sortable({
                connectWith: ".subwidget-content",
                handle: ".waction-drag"
            });
//            $( ".widget-row" ).addClass( $globalthis.classWidget )
//                .find( ".waction-drag" ).addClass( $globalthis.classWidgetHeader );    

        };
        this.downloadFile = function (filename, result) {
            //csvData = 'data:application/xml;charset=utf-8,' + result;
            //console.log(result);
            $("#export_process")
                    .attr({
                        'download': filename,
                        'href': result,
                        'target': '_blank'
                    });
            $("#export_process").get(0).click();
        };
        //general action
        this.setButtonAction = function () {
            var $globalthis = this;
            $globalthis.initControllInRow();
            this.createColumn = function (obj, currentId) {
                var widthCol = $(obj).data('width');
                var classActive = $globalthis.returnWidthClass();
                var col = $(obj).data('col');
                var realValue = widthCol.toString().replace('.', '-');
                for (var i = 1; i <= col; i++) {
                    wrapper = currentId;///$($globalthis.currentElement).find('.group-content').first();
                    column = $('#default_column').clone();
                    var cls = $(column).attr("class");
                    //column-row col-sp-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 ui-widget ui-widget-content ui-helper-clearfix ui-corner-all
                    cls = cls.replace("col-lg-12", "col-lg-" + realValue);
                    cls = cls.replace("col-sp-12", "col-sp-" + realValue);
                    cls = cls.replace("col-xs-12", "col-xs-" + realValue);
                    cls = cls.replace("col-sm-12", "col-sm-" + realValue);
                    cls = cls.replace("col-md-12", "col-md-" + realValue);
                    $(column).attr("class", cls);
                    objColumn = {form_id: "form_" + $globalthis.getRandomNumber()};
                    if (classActive == "md" || classActive == "lg") {
                        objColumn.md = widthCol;
                        objColumn.lg = widthCol;
                    }
                    //jQuery.extend(objColumn, $globalthis.getColDefault());
                    $(column).data("form", objColumn);

                    column.removeAttr('id');
                    wrapper.append(column);
                    $globalthis.getNumberColumnInClass(column, classActive);
                    $(".label-tooltip").tooltip();
                }
            }
            $(document).on("click", ".column-add", function () {
                $globalthis.createColumn(this, $globalthis.currentElement);
            });
            $(document).on("click", ".group-add", function () {
                var item = $(this).data("col");
                currentE = $globalthis.currentElement;
                // Create a group blank
                if (item == 0) {
                    group = $("#default_row").clone();
                    group.removeAttr('id');
                    //var html = $(group).find(".group-controll-right").html();
                    //$(group).find(".group-controll-right").html(html);
                    $(group).data("form", {form_id: "form_" + $globalthis.getRandomNumber(), 'class': 'row'});
                    $(currentE).before(group);
                    $globalthis.initControllInRow();
                }
                // Display popup list Widget for add new a widget
                else if (item == 1) {
                    // This code similar event click to button:
                    // $(".btn-new-widget").trigger("click");
                    url = $globalthis.ajaxShortCodeUrl + '&action=renderList';
                    data = '';
                    $("#ap_loading").show();

                    $.ajax({
                        type: 'POST',
                        headers: {"cache-control": "no-cache"},
                        url: url,
                        async: true,
                        cache: false,
                        data: data,
                        success: function (data) {
                            $("#txt-search").show();
                            $('#myModalLabel').html($('#myModalLabel').data('addnew'));
                            $('#modal_form .modal-body').html(data);
                            $('#modal_form .modal-footer').hide();
                            $('#modal_form').modal('show');
                            $('#modal_form').removeClass('modal-edit').addClass('modal-new');

                            $globalthis.setFormAction();
                            $globalthis.initControllInRow();
                            $("#txt-search").focus();
                            $("#ap_loading").hide();
                            $globalthis.initIsotopAction();
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $("#ap_loading").hide();
                            alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                        }
                    });
                } else {
                    group = $("#default_row").clone();
                    group.removeAttr('id');
                    //var html = $(group).find(".group-controll-right").html();
                    //$(group).find(".group-controll-right").html(html);
                    $(group).data("form", {form_id: "form_" + $globalthis.getRandomNumber(), 'class': 'row'});
                    $(currentE).before(group);
                    $globalthis.createColumn(this, group);
                    $globalthis.initControllInRow();
                }
            });
            $(document).on("click", ".btn-select-profile", function () {
                if (!confirm($("#form_content").data('select')))
                    return false;
            });

            $(document).on("click", ".btn-back-to-list", function () {
                currentElement = $globalthis.currentElement;
                //add new in column
                if ($(currentElement).hasClass('column-content') || $(currentElement).hasClass('subwidget-content')) {
                    $(currentElement).parent().find('.btn-new-widget').first().trigger('click');
                }
                //add new in group
                else {
                    $(currentElement).parent().find('.hook-content-footer .btn-new-widget').trigger('click');
                }
                $('#modal_form .modal-footer').hide();
            });
            //save widget

            $(document).on("click", ".btn-savewidget", function () {
                currentElement = $globalthis.currentElement;
                //add new widget
                if ($("#modal_form").hasClass("modal-new")) {
                    //add new widget in column
                    if ($(currentElement).hasClass('column-content')) {
                        $globalthis.saveWidget('column');
                    }
                    else if ($(currentElement).hasClass('subwidget-content')) {
                        $globalthis.saveWidget('column');
                    }
                    //add new widget in hook
                    else {
                        $globalthis.saveWidget('hook');
                    }
                } else {
                    $globalthis.saveWidget('update');
                }
                $globalthis.currentElement = null;
                $(".label-tooltip").tooltip();
                $('#modal_form').modal('hide');
                $globalthis.initControllInRow();
            });

            $(document).on("click", ".btn-fwidth", function () {
                $('#home_wrapper').css('width', $(this).data('width'));

                btnElement = $(this);
                $('.btn-fwidth').removeClass('active');
                $(this).addClass('active');
                //reset    
                if ($(this).hasClass('width-default')) {
                    $globalthis.windowWidth = $(window).width();
                    $('#home_wrapper').attr('class', 'default');
                } else {
                    $('#home_wrapper').attr('class', 'col-' + $globalthis.returnWidthClass(parseInt($(this).data('width'))));
                    $globalthis.windowWidth = $(this).data('width');
                }
                classVal = $globalthis.returnWidthClass();
                $(".column-row", $('#home_wrapper')).each(function () {
                    valueFra = $(this).data("form")[classVal];
                    $(".apbtn-width .width-val", $(this)).attr("class", "width-val ap-w-" + valueFra.toString().replace(".", "-"));
                });
                $globalthis.initColumnSetting();
            });

            $(document).on("click", ".btn-import", function () {
                $("#ap_loading").show();
                url = $globalthis.ajaxShortCodeUrl + '&showImportForm=1&idProfile=' + $globalthis.profileId;
                button = $(this);
                data = '';
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (result)
                    {
                        $("#txt-search").hide();
                        $("#ap_loading").hide();
                        $('#myModalLabel').html($('#myModalLabel').data('addnew'));
                        $("#ap_loading").hide();
                        $('#modal_form .modal-body').html(result);
                        $('#modal_form .modal-footer').hide();
                        $('#modal_form').modal('show');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            });

            $(document).on("click", ".btn-export", function () {
                var objects = new Object();
                type = $(this).data("type");
                var position = '';
                if (type == "group") {
                    objHook = {};
                    objHook.groups = {};
                    objHook.groups[0] = $globalthis.getHookSubmit($(this).closest('.group-row'));
                    objects[0] = objHook;
                } else if (type == "position") {
                    position = $(this).data("position");
                    type = "position-" + position;
                    var id = "#position-" + $(this).data("position") + " .hook-wrapper";
                    $(id).each(function (iHook) {
                        //hook object contain group
                        var objHook = {};
                        objHook.name = $(this).data('hook');
                        objHook.position = $(this).data('hook');
                        objHook.groups = {};
                        $('.group-row', $(this)).each(function (iGroup) {
                            objHook.groups[iGroup] = $globalthis.getHookSubmit(this);
                        });

                        objects[iHook] = objHook;
                    });
                } else if (type == "all") {
                    $('.hook-wrapper').each(function (iHook) {
                        //hook object contain group
                        var objHook = {};
                        objHook.name = $(this).data('hook');
                        objHook.position = $(this).data('hook');
                        objHook.groups = {};
                        $('.group-row', $(this)).each(function (iGroup) {
                            objHook.groups[iGroup] = $globalthis.getHookSubmit(this);
                        });

                        objects[iHook] = objHook;
                    });
                } else {
                    objHook = {};
                    objHook.groups = {};
                    $('.group-row', $('.' + type)).each(function (iGroup) {
                        objHook.groups[iGroup] = $globalthis.getHookSubmit(this);
                    });
                    objects[0] = objHook;
                }

                data = 'dataForm=' + JSON.stringify(objects);

                $("#ap_loading").show();
                url = $globalthis.ajaxShortCodeUrl + '&action=export&type=' + type;

                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (result)
                    {
                        $("#ap_loading").hide();
                        if (type == 'all')
                            type = 'appagebuilderhome';
                        $globalthis.downloadFile(type + '.xml', result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            });

            //delete group
            $(document).on("click", ".btn-delete", function () {
                if (!confirm($("#form_content").data("delete")))
                    return false;

                // Deleta a panel
                if ($(this).hasClass("tabcontent-action") && $(this).hasClass("accordions")) {
                    // Check this must be have greater than 2 accordions
                    var cover = $(this).closest(".panel-group");
                    if ($(cover).find(".panel").length < 3) {
                        alert("Can not delete when have 2 panel");
                        return;
                    }

                    // remove
                    if ($(this).closest('.panel-default').length > 0) {
                        $(this).closest('.panel-default').remove();
                        return;
                    }
                }

                // Deleta tab
                if ($(this).hasClass("tabcontent-action") && $(this).hasClass("tab")) {
                    // Check this must be have greater than 2 tabs
                    var tabcontent = $(this).closest(".tab-content");
                    var limit = $(tabcontent).find("#default_tabcontent").length > 0 ? 4 : 3;
                    if ($(tabcontent).find(".tab-pane").length < limit) {
                        alert("Can not delete when have " + (limit - 1) + " tabs");
                        return;
                    }

                    // remove
                    tabId = $(this).closest(".tab-pane").attr('id');
                    $('a[href$="' + tabId + '"]:first()').closest("li").remove();
                    $("#" + tabId).remove();
                    return;
                }

                if ($(this).hasClass("accordions")) {
                    if ($(this).closest('.panel-default').length > 0) {
                        $(this).closest('.panel-default').remove();
                    }
                }

                if ($(this).data("for") == undefined) {
                    if ($(this).hasClass("group-action")) {
                        $(this).closest(".group-row").remove();
                    } else if ($(this).hasClass("column-action")) {
                        $(this).closest(".column-row").remove();
                    } else {
                        // Delete group of tag, accordion
                        $(this).closest(".widget-row").remove();
                    }
                }
                else {
                    $(this).closest($(this).data("for")).remove();
                }

            });

            //edit group
            $(document).on("click", ".btn-edit", function () {
                if ($(this).data('type' == undefined) && $(this).data('type') == undefined) {
                    type = $(this).closest('.widget-row').data("type");
                } else
                    type = $(this).data("type");

                if (type.indexOf("apSub") == 0) {
                    if (type == "apSubAccordions") {
                        idContainer = $(this).closest('.widget-container-content').attr("id");
                    } else {
                        idContainer = $(this).closest('.widget-wrapper-content').attr("id");
                    }
                    type = type.replace("Sub", "") + "&subTab";
                    $globalthis.currentElement = $('a[href*="' + idContainer + '"]', $(this).closest(".widget-row"));
                } else {
                    if ($(this).data('for') == undefined) {
                        if (type == "ApRow") {
                            $globalthis.currentElement = $(this).closest(".group-row");
                        } else if (type == "ApColumn") {
                            $globalthis.currentElement = $(this).closest(".column-row");
                        } else {
                            $globalthis.currentElement = $(this).parent().parent();
                        }
                    }
                    else
                        $globalthis.currentElement = $(this).closest($(this).data('for'));
                }
                var url = $globalthis.ajaxShortCodeUrl;
                if (type === "apModule") {
                    url += '&edit&type_shortcode=any&type=module';
                } else if (type === "ApRow") {
                    var hook_name = $(this).closest("[data-hook]").attr('data-hook');
                    url += '&edit&type_shortcode=' + type + "&type=widget" + "&id_appagebuilder_profiles=" + $globalthis.profileId + "&hook_name=" + hook_name;
                } else {
                    url += '&edit&type_shortcode=' + type + "&type=widget";
                }
                obj = $($globalthis.currentElement).data("form");

                data = '';
                if (obj)
                    Object.keys(obj).forEach(function (key) {
                        data += (data ? "&" : "") + key + "=" + obj[key];
                    });
                $("#txt-search").hide();
                $("#ap_loading").show();

                // Store parent id
                if (type == "apSubAccordions" || type == "apAccordions&subTab") {
                    $globalthis.parentId = $(this).closest(".panel-group").attr("id");
                }
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (data) {
                        data = data.replace(/_APNEWLINE_/g, "&#10;");
                        $("#ap_loading").hide();
                        $('#myModalLabel').html($('#myModalLabel').data('edit') + " " + type.replace('ap_', ''));
                        $('#modal_form .modal-body').html(data);
                        $('#modal_form').removeClass('modal-new').addClass('modal-edit');
                        resetSelectedImage();
                        //$('#modal_form').modal('show');
                        $("#modal_form").modal({
                            "backdrop": "static"
                        });
                        if (type == "ApBlockLink") {
                            initBlockLink("edit");
                        }
                        if (type == "ApFullSlider" || type == "ApBlockCarousel") {
                            initFullSlider("edit");
                        }
                        $globalthis.setFormAction();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            });
            $(document).on("click", ".btn-new-widget", function () {
                url = $globalthis.ajaxShortCodeUrl + '&action=renderList';
                if ($(this).hasClass('tabcontent-action'))
                    url += '&subTab=1'
                data = '';
                if ($(this).hasClass('column-action')) {
                    $globalthis.currentElement = $(this).closest('.column-row').find('.column-content').first();
                } else if ($(this).hasClass('tabcontent-action')) {
                    if ($(this).hasClass('accordion'))
                        $globalthis.currentElement = $(this).closest('.panel-collapse').find('.subwidget-content').first();
                    else
                        $globalthis.currentElement = $(this).closest('.tab-pane').find('.subwidget-content').first();
                } else {
                    $globalthis.currentElement = $(this).closest('.hook-content-footer');
                }
                $("#ap_loading").show();

                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (data) {
                        $("#txt-search").show();
                        $('#myModalLabel').html($('#myModalLabel').data('addnew'));
                        $('#modal_form .modal-body').html(data);
                        $('#modal_form .modal-footer').hide();
                        $('#modal_form').modal('show');
                        $('#modal_form').removeClass('modal-edit').addClass('modal-new');

                        $globalthis.setFormAction();
                        $("#txt-search").focus();
                        $("#ap_loading").hide();
                        $globalthis.initIsotopAction();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            });
            $("#modal_form").on('shown.bs.modal', function () {
                $("#txt-search").focus();
            })

            $(document).on("click", ".btn-status", function () {
                if ($(this).data("for") == undefined) {
                    if ($(this).hasClass("group-action")) {
                        $globalthis.currentElement = $(this).closest(".group-row");
                    } else if ($(this).hasClass("column-action")) {
                        $globalthis.currentElement = $(this).closest(".column-row");
                    } else {
                        $globalthis.currentElement = $(this).closest(".widget-row");
                    }
                }
                else
                    $globalthis.currentElement = $(this).closest($(this).data("for"));
                objForm = $globalthis.currentElement.data("form");

                if ($(this).hasClass("deactive")) {
                    $(this).removeClass("deactive").addClass("active");
                    objForm.active = 1;
                    $(this).children().removeClass("icon-remove");
                    $(this).children().addClass("icon-ok");
                } else {
                    $(this).removeClass("active").addClass("deactive");
                    objForm.active = 0;
                    $(this).children().addClass("icon-remove");
                    $(this).children().removeClass("icon-ok");
                    // icon-remove
                }
                objForm = $globalthis.currentElement.data('form', objForm);
            });

            $(document).on("click", ".btn-change-colwidth", function () {
                cla = $globalthis.returnWidthClass();
                elementColumn = $(this).closest('.column-row');
                objColumn = $(elementColumn).data('form');

								valueColToNum = objColumn[cla].toString().replace("-", ".");
                val = $(this).data("value");
//                console.log(cla + '--' + valueColToNum + 'claa' + cla);
                if (val == 1 && parseFloat(valueColToNum) >= 12) {
                    alert($("#form_content").data("increase"));
                    return false;
                }
                if (val == -1 && parseFloat(valueColToNum) <= 1) {
                    alert($("#form_content").data("reduce"));
                    return false;
                }
                //get index of current width
                indexW = jQuery.inArray(valueColToNum.toString(), $globalthis.widthSupport);
                indexW = parseInt(indexW) + val;
                //get new width
                objColumn[cla] = $globalthis.widthSupport[indexW];
                //set class again
                classColumn = $globalthis.getClassColumn(objColumn);

                $(elementColumn).attr("class", classColumn);
                $(".apbtn-width .width-val", $(elementColumn)).attr("class", "width-val ap-w-" + objColumn[cla].toString().replace(".", "-"));
                $(elementColumn).data("form", objColumn);
                $globalthis.getNumberColumnInClass(elementColumn, $globalthis.returnWidthClass());
                return false;
            });

            $(document).on("click", ".change-colwidth", function () {
                cla = $globalthis.returnWidthClass();
                width = $(this).data('width');
                elementColumn = $(this).closest('.column-row');
                objColumn = $(elementColumn).data('form');
                //get new width
                objColumn[cla] = width;
                //set class again
                classColumn = $globalthis.getClassColumn(objColumn);

                $(elementColumn).attr("class", classColumn);
                $(".apbtn-width .width-val", $(elementColumn)).attr("class", "width-val ap-w-" + objColumn[cla].toString().replace(".", "-"));
                $(elementColumn).data("form", objColumn);
                $(this).closest("ul").find("li").removeClass("selected");
                $(this).closest("li").addClass("selected");
                $globalthis.getNumberColumnInClass(elementColumn, $globalthis.returnWidthClass());
                return false;
            });


            $(document).on("click", ".btn-add-tab", function () {
                //nav-tabs tab-content
                widget = $(this).closest('.widget-row');
                tabID = "tab_" + $globalthis.getRandomNumber();

                tab = $("#default_tabnav").clone(1);
                tab.removeAttr("id");
                $(tab).find('a').attr('href', '#' + tabID);

                $(this).parent().before(tab);

                var ObjectTab = {form_id: "form_" + $globalthis.getRandomNumber()};
                ObjectTab.id = tabID;
                ObjectTab["css_class"] = "";
                ObjectTab["override_folder"] = "";
                titleTab = $.trim($(tab).find('a').html());
                Object.keys($globalthis.languages).forEach(function (key) {
                    ObjectTab["title_" + $globalthis.languages[key]] = titleTab;
                });
                $(tab).find('a').data("form", ObjectTab);

                tabContent = $("#default_tabcontent").clone(1);
                tabContent.attr('id', tabID);
                $('.tab-pane', $(widget)).removeClass('active');
                $(tabContent).addClass('active');
                $('.tab-content', $(widget)).append(tabContent);

                $(tab).tab('show');
                $(tab).trigger('click');
                $(tab).addClass('active');
                return false;
            });

            $(document).on("click", ".btn-add-accordion", function () {
                //nav-tabs tab-content
                panel = $(this).closest('.panel-group');
                //$('.panel-collapse', $(panel)).collapse();
                panelDefault = $(panel).find('.panel-default').first().clone();
                var parent = $(panel).find('.panel-default').first().find(".panel-title a").data("parent");
                collapseID = "collapse-" + $globalthis.getRandomNumber();
                $('.panel-title a', $(panelDefault)).html('New Accordion');
                $('.panel-title a', $(panelDefault)).attr('href', "#" + collapseID);
                $('.panel-title a', $(panelDefault)).data("parent", parent.replace("#", ""));
                $('.panel-collapse', $(panelDefault)).attr('id', collapseID);
                $('.panel-collapse .subwidget-content', $(panelDefault)).html('');

                ObjectForm = $globalthis.assignDataForm($(panel).find('.panel-default').first().find(".panel-title a"), collapseID);
                //ObjectForm = $globalthis.assignDataForm($('.panel-title a',$(panelDefault)), collapseID);
                // var ObjectForm = {form_id:"form_"+$globalthis.getRandomNumber()};
                // ObjectForm['parent_id'] = parent;
                // ObjectForm['id'] = collapseID;
                // ObjectForm['title_1'] = 'New Accordion';
                ObjectForm['title_' + $globalthis.lang_id] = "New Accordion";
                $('.panel-title a', $(panelDefault)).data('form', ObjectForm);
                $(this).before(panelDefault);
            });

            $(document).on("click", ".btn-duplicate", function () {
                parent = $(this).parent().parent();
                //dublicate widget
                if ($(parent).hasClass('widget-row')) {
                    if ($(this).hasClass('widget-action')) {
                        duplicate = $(parent).clone(1);
                        ObjectForm = $globalthis.assignDataForm(duplicate);
                        $(duplicate).data('form', ObjectForm);
                        $(parent).parent().append(duplicate);
                    }
                }

                //duplicate accordion
                if ($(parent).hasClass('panel-body')) {
                    panel = $(parent).closest('.panel').clone(1);
                    panelGroup = $(parent).closest('.panel-group');
                    $globalthis.changWidgetFormID(panel);
                    $globalthis.changeAccordionPanel(panel);

                    $(panelGroup).parent().find('.btn-add-accordion').before(panel);
                }

                //duplicate accordions
                if ($(parent).hasClass("ApAccordions")) {
                    widgetRow = $(parent).clone(1);
                    accId = "accordion_" + $globalthis.getRandomNumber();
                    ObjectForm = $globalthis.assignDataForm(widgetRow, accId);

                    $(widgetRow).data('form', ObjectForm);
                    $(widgetRow).attr('id', accId);
                    $(widgetRow).attr('class', 'widget-row ApAccordions ' + $globalthis.classWidget + ' ' + ObjectForm.form_id);

                    $globalthis.changWidgetFormID(widgetRow);
                    $globalthis.changeAccordionPanel(widgetRow, accId);

                    $(parent).closest('.column-content').append(widgetRow);
                }

                //duplicate tab
                if ($(parent).hasClass('tab-pane')) {
                    widgetRow = $(parent).closest('.widget-row');
                    //duplicate tab content
                    tabContent = $(parent).clone(1);
                    tabId = "tab_" + $globalthis.getRandomNumber();
                    $globalthis.changWidgetFormID(tabContent);
                    hrefOld = "#" + tabContent.attr('id');
                    $(tabContent).attr('id', tabId);
                    $(parent).closest('.tab-content').append(tabContent);
                    $('.tab-pane', $(parent).removeClass('active'));
                    $(tabContent).addClass('active');
                    $(parent).parent().append(tabContent);

                    //duplicate a
                    tabTile = $(widgetRow).find('a[href*="' + hrefOld + '"]').parent().clone(1);
                    tab = $(tabTile).find('a').first();
                    $(tab).attr('href', '#' + tabId);
                    ObjectForm = $globalthis.assignDataForm(tab, tabId);
                    $(tab).data('form', ObjectForm);

                    $(parent).closest('.widget-row').find('.tab-button').before(tabTile);

                    $(tab).tab('show');
                    $(tab).trigger('click');
                    $(tab).addClass('active');
                }

                //duplicate tabs
                if ($(parent).hasClass('ApTabs')) {
                    widgetRow = $(parent).clone(1);
                    ObjectForm = $globalthis.assignDataForm(widgetRow);
                    $(widgetRow).data('form', ObjectForm);
                    $(widgetRow).attr('class', 'widget-row ApTabs ' + $globalthis.classWidget + ' ' + ObjectForm.form_id);
                    $globalthis.changWidgetFormID(widgetRow);

                    $globalthis.changeTabs(widgetRow);

                    $(parent).closest('.column-content').append(widgetRow);
                }
                //duplicate column
                if ($(parent).hasClass('for-column-row')) {
                    var parentColumn = $(parent).closest(".column-row");
                    column = $(parentColumn).clone(1);
                    column = $globalthis.changeDatacolumn(column);
                    $(parentColumn).parent().append(column);
                }
                //duplicate group
                if ($(parent).hasClass('for-group-row')) {
                    var parentGroup = $(parent).closest(".group-row");
                    group = $(parentGroup).clone(1);
                    ObjectForm = $globalthis.assignDataForm(group);
                    $(group).data('form', ObjectForm);
                    $('.column-row', $(group)).each(function () {
                        $globalthis.changeDatacolumn(this);
                    });

                    $(parentGroup).parent().find('.hook-content-footer').before(group);
                }
                $('.label-tooltip', $($(parent).parent())).tooltip('disable');
                $('.tooltip', $($(parent).parent())).remove();
            });

            $(document).on("click", ".choose-img", function (e) {
                e.preventDefault();
                var link = $(this);
                // Store object image for hold the destination after select back
                imgId = $(link).data("for");
                $.ajax({
                    url: $(link).attr("href"),
                    beforeSend: function () {
                        $("#ap_loading").show();
                    },
                    success: function (response) {
                        $("#modal_select_image .modal-body").html(response);
                        $("#modal_select_image .modal-body").css('min-height', $(window).height() * 0.8);
                        $("#modal_select_image").modal('show');
                        $(".img-link").tooltip();
                    },
                    complete: function () {
                        $("#ap_loading").hide();
                    }
                });
                return false;
            });
            $(document).on("click", ".image-manager .img-link", function (e) {
                e.stopPropagation();
                var img = $(this).find("img");
                $("#s-image").removeClass("hidden");
                var name = $(img).attr("src");
                $(imgId).val($(img).attr("data-name"));

                var div = $(imgId).closest("div");
                imgDest = $(div).find("img");
                if (imgDest.length > 0) {
                    $(imgDest).attr("src", $(img).attr("src"));
                    $(imgDest).data("img", $(img).data("name"));
                    $(imgDest).show();
                    if ($(imgDest).attr("widget") === "ApCategoryImage") {
                        $(imgDest).closest(".list-image").find(".remove-img").removeClass("hidden");
                        $(imgDest).removeClass("hidden");
                        $(imgDest).attr("src-url", $(img).data("name"));
                        $(imgDest).data('img', $(img).attr("data-name"));
                        updateStatusCheck(imgDest);
                    }
                } else {
                    $(div).prepend("<img src='" + $(img).attr("src") + "' class='img-thumbnail' data-img='" + $(img).attr("data-name") + "'/>");
                }
                $("#modal_select_image").modal('hide');
                return false;
            });
            $(document).on("click", ".remove-img", function (e) {
                e.stopPropagation();
                var img = $(this).closest(".list-image").find("img");
                $(img).attr("src-url", "");
                $(img).attr("src", "");
                $(img).addClass("hidden");
                updateStatusCheck(img);
            });
            $(".tree-folder-name input:checkbox").change(function () {
                $(this).find("input:checkbox").removeAttr("checked");
            });
        };

        this.changeDatacolumn = function (column) {
            var $globalthis = this;
            ObjectForm = $globalthis.assignDataForm(column);
            $(column).data('form', ObjectForm);
            $('.widget-row', $(column)).each(function () {
                widgetRow = $(this);
                if ($(this).hasClass('ApAccordions')) {
                    accId = "accordion_" + $globalthis.getRandomNumber();
                    ObjectForm = $globalthis.assignDataForm(widgetRow, accId);

                    $(widgetRow).data('form', ObjectForm);
                    $(widgetRow).attr('id', accId);
                    $(widgetRow).attr('class', 'widget-row ApAccordions ' + $globalthis.classWidget + ' ' + ObjectForm.form_id);

                    $globalthis.changeAccordionPanel(widgetRow, accId);
                } else {
                    ObjectForm = $globalthis.assignDataForm(widgetRow);
                    $(widgetRow).data('form', ObjectForm);

                    if ($(this).hasClass('ApTabs')) {
                        $(widgetRow).attr('class', 'widget-row ApTabs ' + $globalthis.classWidget + ObjectForm.form_id);
                        $globalthis.changeTabs(widgetRow);
                    }
                }
            });

            return column;
        };
        this.returnWidthClass = function (width) {
            $globalthis = this;
            if (!width)
                width = $globalthis.windowWidth;
            if (parseInt(width) >= 1200)
                return 'lg';
            if (parseInt(width) >= 992)
                return 'md';
            if (parseInt(width) >= 768)
                return 'sm';
            if (parseInt(width) >= 481)
                return 'xs';
            if (parseInt(width) < 481)
                return 'sp';
        };
        this.getClassColumn = function (objCol) {
            $globalthis = this;
            classColumn = 'column-row ' + $globalthis.classWidget;
            for (ic = 0; ic < $globalthis.arrayCol.length; ic++) {
                if (objCol[$globalthis.arrayCol[ic]]) {
                    valueCol = objCol[$globalthis.arrayCol[ic]];
                    if (valueCol.toString().indexOf(".") != -1) {
                        valueCol = valueCol.toString().replace(".", "-");
                    }
                    classColumn += " col-" + $globalthis.arrayCol[ic] + "-" + valueCol;
                }
            }
            return classColumn;
        };
        this.changWidgetFormID = function (panel) {
            var $globalthis = this;
            $('.widget-row', $(panel)).each(function () {
                var ObjectForm = {form_id: "form_" + $globalthis.getRandomNumber()};
                dataForm = $(this).data("form");
                Object.keys(dataForm).forEach(function (key) {
                    if (key != 'form_id')
                        ObjectForm[key] = dataForm[key];
                });

                $(this).data('form', ObjectForm);
            });
        };
        this.assignDataForm = function (element, id) {
            var $globalthis = this;
            dataForm = $(element).data("form");
            var ObjectForm = {form_id: "form_" + $globalthis.getRandomNumber()};
            Object.keys(dataForm).forEach(function (key) {
                if (key != 'form_id') {
                    if (id && key == 'id')
                        ObjectForm[key] = id;
                    else
                        ObjectForm[key] = dataForm[key];
                }
            });
            return ObjectForm;
        };
        this.changeTabs = function (widget) {
            var $globalthis = this;
            $('.widget-container-heading li a', $(widget)).each(function () {
                if ($(this).parent().attr("id") != "default_tabnav" && !$(this).parent().hasClass("tab-button")) {
                    OldHref = $(this).attr('href').replace('#', '');
                    tabID = "tab_" + $globalthis.getRandomNumber();
                    $(this).attr('href', "#" + tabID);
                    ObjectForm = $globalthis.assignDataForm(this, tabID);
                    $(this).data('form', ObjectForm);
                    $(widget).find('.tab-pane').each(function () {
                        if ($(this).attr('id') == OldHref) {
                            $(this).attr('id', tabID);
                            return false;
                        }
                    });

                    accId = "accordion_" + $globalthis.getRandomNumber();
                    ObjectForm = $globalthis.assignDataForm(widgetRow, accId);

                    $(widgetRow).data('form', ObjectForm);
                    $(widgetRow).attr('id', accId);
                    $(widgetRow).attr('class', 'widget-row ApAccordions ' + $globalthis.classWidget + ' ' + ObjectForm.form_id);

                    $globalthis.changWidgetFormID(widgetRow);
                    $globalthis.changeAccordionPanel(widgetRow, accId);
                }
            });
        };
        this.changeAccordionPanel = function (panel, accId) {
            var $globalthis = this;
            $('.panel-title a', $(panel)).each(function () {
                newHref = "collapse_" + $globalthis.getRandomNumber();
                ObjectForm = $globalthis.assignDataForm($(this), newHref);
                if (accId) {
                    ObjectForm.parent_id = accId;
                    $(this).data('parent', '#' + accId);
                }
                $(this).data('form', ObjectForm);
                $(this).attr('class', ObjectForm.form_id);
                oldHref = $(this).attr('href').replace('#', '');

                $(this).attr('href', '#' + newHref);

                $(panel).find('.panel-collapse').each(function () {
                    if ($(this).attr('id') == oldHref) {
                        $(this).attr('id', newHref);
                        return false;
                    }
                });
            });
        };
        this.getRandomNumber = function () {
            return (+new Date() + (Math.random() * 10000000000000000)).toString().replace('.', '');
        };
        this.testAnim = function (x) {
            $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass();
            });
        };
        //action in form, only write when use ajax
        this.setFormAction = function () {
            var $globalthis = this;
            setTimeout(function () {
                intiForApCategoryImage();
            }, 1000);
            $('.form-action').change(function () {
                elementName = $(this).attr('name');
                $('.' + elementName + '_sub').hide();
                $('.' + elementName + '-' + $(this).val()).show();
            });

            if ($('select[name="bg_config"]').length) {

                $('select[name="bg_config"]').change(function () {
                    if ($(this).val() == "fullwidth") {
                        if ($("#container").val() == "") {

                            bgType = $('select[name="bg_type"] option');
                            bgType.prop('selected', false);
                            bgType.find('option[value="normal"]').prop('selected', true);

                            $('select[name="bg_type"] option').each(function () {
                                if ($(this).val() != "normal" && $(this).val() != "fixed")
                                    $(this).attr('disabled', 'disabled');
                            });
                        } else {
                            $('select[name="bg_type"] option').each(function () {
                                if ($(this).val() != "normal" && $(this).val() != "fixed")
                                    $(this).removeAttr('disabled', 'disabled');
                            });
                        }
                    } else {
                        $('select[name="bg_type"] option').each(function () {
                            if ($(this).val() != "normal" && $(this).val() != "fixed")
                                $(this).removeAttr('disabled', 'disabled');
                        });
                    }
                });
                $("#container").change(function () {
                    $('select[name="bg_config"]').trigger("change");
                })
                $('select[name="bg_config"]').trigger("change");
            }

            $('.checkbox-group').change(function () {
                $globalthis.showOrHideCheckBox($(this));
            });

            $('.width-select').click(function () {
                btnGroup = $(this).closest('.btn-group');
                spanObj = $('.width-val', $(this));
                width = $(spanObj).data('width');
                $('.col-val', $(btnGroup)).val(width);
                $('.apbtn-width .width-val', $(btnGroup)).html($(spanObj).html());
                $('.apbtn-width .width-val', $(btnGroup)).attr('class', $(spanObj).attr('class'));
            });
            if ($('.aptab-config').length > 0) {
                //set tab aciton
                $('.aptab-config').each(function () {
                    if (!$(this).parent().hasClass('active')) {
                        element = $(this).attr('href').toString().replace("#", ".");
                        $(element).hide();
                    }
                });

                $('.aptab-config').click(function () {
                    divElement = $(this).attr('href').toString().replace("#", ".");
                    aElement = $(this);
                    $('.aptab-config').each(function () {
                        if ($(this).parent().hasClass('active')) {
                            element = $(this).attr('href').toString().replace("#", ".");
                            $(this).parent().removeClass('active');
                            $(element).hide();
                            return false;
                        }
                    });
                    $(divElement).show();
                    $(aElement).parent().addClass('active');

                    $('.form-action', $(divElement)).each(function () {
                        $(this).trigger("change");
                    });

                    $('.checkbox-group', $(divElement)).each(function () {
                        $globalthis.showOrHideCheckBox($(this));
                    });


                    if ($(this).attr('href') == "#aprow_animation" && $('#animation').length > 0)
                        $('#animation').trigger("change");

                });
            }

            if ($('.em_text').length > 0) {
                //page in column form
                $('.em_text').change(function () {
                    var list = $(this).closest('.well').find('.em_list');
                    var values = "";
                    if ($(this).val())
                        values = $(this).val().split(',');
                    var len = values.length;

                    list.find('option').prop('selected', false);
                    for (var i = 0; i < len; i++)
                        list.find('option[value="' + $.trim(values[i]) + '"]').prop('selected', true);
                });
                $('.em_list').change(function () {
                    if ($(this).val()) {
                        var str = $(this).val().join(', ');
                        var text = $(this).closest('.well').find('.em_text');
                        $(text).val(str);
                    }
                });
            }

            if ($('#animation').length > 0) {
                $('#animation').after('<button type="button" class="btn btn-default animate-it animate_sub">Animate it</button>');
                $('.animate-it').click(function () {
                    $('#animation').trigger("change");
                });
                $('#animation').change(function () {
                    if ($(this).val() == "none") {
                        $('.animate_sub').hide();
                    } else {
                        $('.animate_sub').show();
                        $globalthis.testAnim($(this).val());
                    }
                });
            }

            if ($('.select-img').length > 0) {
                /*$('.select-img').click(function(){
                 $.fancybox.open([{
                 type: 'iframe',
                 href: $globalthis.imgController,
                 afterLoad: function () {
                 $globalthis.hideSomeElement();
                 //$('.fancybox-iframe').load( $this.hideSomeElement );
                 },
                 afterClose: function (event, ui) {
                 //location.reload();
                 }
                 }], {
                 padding: 10
                 });
                 return false;
                 });
                 */
            }

            if ($('.form-action').length > 0 || $('.checkbox-group').length) {
                if ($("#configuration_form .nav-tabs").length)
                    $("#configuration_form .nav-tabs li.active a").trigger("click");
                else {
                    $('.form-action').trigger("change");
                    $('.checkbox-group').each(function () {
                        $globalthis.showOrHideCheckBox($(this));
                    });
                }
            }

            if ($(".select-class").length) {
                $(".select-class").click(function () {
                    classChk = $(this).data("value");
                    elementText = $(this).closest('.well').find('.element_class').first();
                    //add
                    if ($(this).is(':checked')) {
                        if ($(elementText).val().indexOf(classChk) == -1) {
                            if ($(elementText).val() != "") {
                                $(elementText).val($(elementText).val() + " " + classChk);
                            } else {
                                $(elementText).val(classChk);
                            }
                        }
                    } else {
                        //remove
                        if ($(elementText).val().indexOf(classChk) != -1) {
                            $(elementText).val($(elementText).val().replace(classChk + " ", ""));
                            $(elementText).val($(elementText).val().replace(" " + classChk, ""));
                            $(elementText).val($(elementText).val().replace(classChk, ""));
                        }
                    }
                });

                $(".element_class").change(function () {
                    elementChk = $(this).closest('.well').find('input[type=checkbox]');
                    classText = $(this).val();
                    $(elementChk).each(function () {
                        classChk = $(this).data("value");
                        if (classText.indexOf(classChk) != -1) {
                            if (!$(this).is(':checked'))
                                $(this).prop("checked", true);
                        } else {
                            $(this).prop("checked", false);
                        }
                    });
                });
                $(".element_class").trigger("change");
            }

            //$('.new-shortcode').click(function() {
            $(".cover-short-code").click(function () {
                var a = $(this).find("a");
                var tab = $(a).hasClass("module") ? "module" : "widget";
                $(".btn-back-to-list").attr("tab", tab);
                // Add widget
                url = $globalthis.ajaxShortCodeUrl + "&addnew&type_shortcode="
                        + $(a).data("type") + "&type=" + tab;

                data = "";
                $("#ap_loading").show();
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (data) {
                        $("#txt-search").hide();
                        $('#myModalLabel').html($('#myModalLabel').data('addnew'));
                        $("#ap_loading").hide();
                        $('#modal_form .modal-footer').show();
                        $('#modal_form .modal-body').html(data);
                        $('#myModalLabel').html($('#myModalLabel').html() + ' : ' + $('.modal-widget-title').html());
                        resetSelectedImage();
                        if ($(a).data("type") == "ApBlockLink") {
                            initBlockLink("add");
                        }
                        if ($(a).data("type") == "ApFullSlider" || $(a).data("type") == "ApBlockCarousel") {
                            initFullSlider("add");
                        }
                        $globalthis.setFormAction();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            });
            if ($("#list-slider").length > 0) {
                $("#list-slider").sortable({accept: "div",
                    update: function () {
                        var listId = "";
                        var sep = "";
                        $("#list-slider li").each(function () {
                            var id = (typeof $(this).attr("id") != "undefined") ? $(this).attr("id") : "";
                            if (id) {
                                listId += sep + id;
                                sep = "|";
                            }
                        });
                        $("#total_slider").val(listId);
                    }
                });
            }
        };
        this.initControllInRow = function () {
            $globalthis = this;
            $('.btn-custom').popover({
                html: true,
                content: function () {
                    $globalthis.currentElement = $('.group-content', $(this).closest('.group-row'));
                    return $('#addnew-group-form').html();
                }
            });
            $('.btn-custom').on('shown.bs.popover', function () {
                $('.number-column').click(function () {
                    widthCol = $(this).data('width');
                    classActive = $globalthis.returnWidthClass();
                    realValue = widthCol.toString().replace('.', '-');
                    $('.column-row', $($globalthis.currentElement)).each(function () {
                        ObjColumn = $(this).data('form');
                        oldClass = ObjColumn[classActive].toString().replace('.', '-');
                        if (classActive == "md" || classActive == "lg") {
                            classColumn = $(this).attr('class').replace('col-lg-' + oldClass, 'col-lg-' + realValue).replace('col-md-' + oldClass, 'col-md-' + realValue);
                            ObjColumn.md = ObjColumn.lg = widthCol;
                        } else {
                            classColumn = $(this).attr('class').replace('col-' + classActive + '-' + oldClass, 'col-' + classActive + '-' + realValue);
                            ObjColumn[classActive] = widthCol;
                        }

                        $(this).attr('class', classColumn);
                        $(this).data('form', ObjColumn);
                        $globalthis.getNumberColumnInClass(this, classActive);
                    });
                });
            });

            $('.btn-add-column').popover({
                html: true,
                content: function () {
                    $globalthis.currentElement = $('.group-content', $(this).closest('.group-row'));
                    return $('#addnew-column-form').html();
                }
            });
            $('.btn-add-column').on('shown.bs.popover', function () {
            });

            btn_new_widget_group('.btn-new-widget-group');

        }
        this.initIsotopAction = function () {
            var $containerWidget = $("#widget_container");
            var $containerModule = $("#module_container");
            var currentTab = "widget";
            // init
            $containerWidget.isotope({
                // options
                itemSelector: ".item",
                layoutMode: "fitRows"
            });
            $containerModule.isotope({
                // options
                itemSelector: ".item",
                layoutMode: "fitRows"
            });
            function searchWidget(search) {
                var tab = currentTab;
                //log(tab);
                //log(search);
                $("#modal_form .for-" + tab + " .btn").removeClass("is-checked");
                $("#modal_form .for-" + tab + " li:first-child .btn").addClass("is-checked");

                // Detect and search by name
                var container = (tab === "widget" ? $containerWidget : $containerModule);
                container.isotope({
                    filter: function () {
                        if (search === "") {
                            return true;
                        } else {
                            var label = $(this).find(".label").text().toLowerCase() + " "
                                    + $(this).find("small i").text().toLowerCase();
                            return label.search(search) !== -1;
                        }
                    }
                });
            }
            searchWidget($("#modal_form #txt-search").val().toLowerCase());

            $("#tab-new-widget").on("click", "a", function () {
                currentTab = $(this).attr("aria-controls");
                var search = $("#txt-search").val().toLowerCase();
                var filterValue = $(".for-" + currentTab + " .is-checked").data("filter");
                // Reinit
                var container = (currentTab === "widget" ? $containerWidget : $containerModule);

                // Priority is action search, in the case text search is not empty 
                // will search and reset sub category is Show all
                if (filterValue !== "*") {
                    $(".for-" + currentTab + " .btn").removeClass("is-checked");
                    $(".for-" + currentTab + " li:first-child .btn").addClass("is-checked");
                }
                setTimeout(function () {
                    container.isotope({
                        // options
                        itemSelector: ".item",
                        layoutMode: "fitRows",
                        filter: function () {
                            if (search === "") {
                                // Check selected other category
                                if (filterValue === "*") {
                                    return true;
                                } else {
                                    return $(this).data("tag") === filterValue;
                                }
                            } else {
                                var label = $(this).find(".label").text().toLowerCase() + " "
                                        + $(this).find("small i").text().toLowerCase();
                                return label.search(search) !== -1;
                            }
                        }
                    });
                }, 100);
            });
            $("#modal_form").on("keyup", "#txt-search", function () {
                var search = $(this).val().toLowerCase();
                searchWidget(search);
            });

            $(".filters").on("click", "button", function () {
                var tab = $(this).closest("ol").data("for");
                var filterValue = filterValue = $(this).data("filter");
                var container = (tab === "widget" ? $containerWidget : $containerModule);
                $("#modal_form .for-" + tab + " button").removeClass("is-checked");
                $(this).addClass("is-checked");
                $("#txt-search").val("");
                $("#txt-search").focus();
                container.isotope({
                    filter: function () {
                        if (filterValue === "*") {
                            return true;
                        } else {
                            return $(this).data("tag").search(filterValue) >= 0;
                        }
                    }
                });
            });
            $(".filters li:first-child button").trigger("click");
        };
        this.hideSomeElement = function () {
            $('body', $('.fancybox-iframe').contents()).find("#header").hide();
            $('body', $('.fancybox-iframe').contents()).find("#footer").hide();
            $('body', $('.fancybox-iframe').contents()).find(".page-head, #nav-sidebar ").hide();
        };
        this.showOrHideCheckBox = function (checkbox) {
            id = $(checkbox).attr('id');
            if ($(checkbox).is(':checked'))
                $('.' + id).show();
            else
                $('.' + id).hide();
        };
        this.copyLang = function (element) {
            var $globalthis = this;
            var reg = new RegExp("_" + $globalthis.lang_id, "g");
            //if(typeof $(element) != undefined && !$(element).hasClass("ignore-lang") && typeof $(element).attr("id") != undefined) {
            if (typeof $(element) != undefined && !$(element).hasClass("ignore-lang") && $(element).attr("id")) {
                idTemp = $(element).attr("id").replace(reg, "");

                Object.keys($globalthis.languages).forEach(function (key) {
                    lang = $globalthis.languages[key];
                    if (lang != $globalthis.lang_id && $("#" + idTemp + "_" + lang).val() == "") {
                        $("#" + idTemp + "_" + lang).val($("#" + idTemp + "_" + $globalthis.lang_id).val());
                    }
                });
            }
        };
        this.saveWidget = function (type) {
            var $globalthis = this;
            currentE = $globalthis.currentElement;

            var ObjectForm = {form_id: "form_" + $globalthis.getRandomNumber()};
            contentHtml = "";

            widgetType = '';
            if (typeof tinyMCE != "undefined") {
                tinyMCE.triggerSave();
                //var mce = tinyMCE.activeEditor.getContent();
                //log(tinyMCE.activeEditor.settings.id);
                //$("#" + tinyMCE.activeEditor.settings.id).val(mce);
            }

            //update language for other field
            $("#configuration_form .lang-" + $globalthis.lang_id).each(function () {
                $(this).find('input[type="text"]').each(function () {
                    $globalthis.copyLang($(this));
                });
                $(this).find('textarea').each(function () {
                    $globalthis.copyLang($(this));
                });
            });

            $($("#configuration_form").serializeArray()).each(function (i, field) {
                if (field.name.substring(0, 2).toLowerCase() == 'ap' && field.value == '1') {
                    widgetType = field.name;
                } else {
                    if (field.name == "content_html_" + $globalthis.lang_id) {
                        contentHtml = field.value.replace(/[\n]/g, "").replace(/[\r]/g, "");
                        if (type == "update") {
                            //$(currentE).find('.html-code').html(contentHtml);
                        }
                    }

                    fName = field.name;
                    if (fName.indexOf('[]') != -1) {
                        fName = fName.replace('[]', '');
                        if (ObjectForm[fName]) {
                            ObjectForm[fName] += ',' + field.value;
                        }
                        else {
                            ObjectForm[fName] = field.value;
                        }
                    } else {
                        //ObjectForm[fName] = field.value.replace(/\&/g,'_APAMP_').replace(/\'/g,'_APAPOST_').replace(/\"/g,'_APQUOT_').replace(/[\t]/g, "_APTAB_").replace(/[\r]/g, "_APNEWLINE_").replace(/[\n]/g, "_APENTER_").replace(/\[/g, "_APOBRACKET_").replace(/\]/g, "_APCBRACKET_");
                        var valTemp = field.value.replace(/\&/g, '_APAMP_')
                                .replace(/\'/g, '_APAPOST_')
                                .replace(/\"/g, '_APQUOT_')
                                .replace(/[\t]/g, "_APTAB_")
                                .replace(/\[/g, "_APOBRACKET_")
                                .replace(/[\n]/g, "_APENTER_")
                                .replace(/[\r]/g, "")
                                .replace(/[+]/g, "_APPLUS_")
                                .replace(/\]/g, "_APCBRACKET_");
                        ObjectForm[fName] = valTemp;
                    }
                }
            });

            //for sub tab
            if (widgetType.indexOf('ApSub') == 0) {
                tmpObjectForm = {};
                tmpObjectForm.form_id = ObjectForm.form_id;
                tmpObjectForm.id = ObjectForm.id;
                Object.keys($globalthis.languages).forEach(function (key) {
                    tmpObjectForm["title_" + $globalthis.languages[key]] = ObjectForm["title_" + $globalthis.languages[key]];
                });
                ObjectForm = tmpObjectForm;
                oldHref = $(currentE).attr("href").toString().replace('#', '');
                panelFind = '.panel-collapse';
                if (widgetType == 'ApSubAccordion') {
                    ObjectForm.parent_id = $(currentE).data('form').parent_id;
                    panelFind = '.panel-collapse';
                } else {
                    panelFind = '.tab-pane';
                }
                $(currentE).html(ObjectForm['title_' + $globalthis.lang_id]);
                $(currentE).closest('.widget-row').find(panelFind).each(function () {
                    if ($(this).attr('id') == oldHref) {
                        $(this).attr('id', ObjectForm.id);
                        return false;
                    }
                });

                $(currentE).attr("href", "#" + ObjectForm.id);
            }
            if (type == "update") {
                if (widgetType == "ApColumn") {
                    $globalthis.changeColumnClass(currentE, ObjectForm);
                }
                if (widgetType == "ApRawHtml") {
                    $(currentE).data("form", ObjectForm);
                    $(currentE).find(".html-code").html(htmlentities(contentHtml));
                } else if (widgetType == "ApSubAccordion") {
                    ObjectForm["parent_id"] = $globalthis.parentId;
                    $(currentE).data("form", ObjectForm);
                } else {
                    $(currentE).data("form", ObjectForm);
                }
                $(".label-tooltip").tooltip();
                return true;
            }
            dataInfo = $globalthis.shortcodeInfos[widgetType];

            if (widgetType == "ApTabs") {
                widget = $("#default_ApTabs").clone(1);
                widget.removeAttr('id');
                $(".widget-container-heading a", $(widget)).each(function () {
                    if ($(this).parent().attr("id") != "default_tabnav" && !$(this).parent().hasClass("tab-button")) {
                        var ObjectTab = {form_id: "form_" + $globalthis.getRandomNumber()};
                        tabID = "tab_" + $globalthis.getRandomNumber();
                        ObjectTab.id = tabID;
                        ObjectTab["css_class"] = "";
                        ObjectTab["override_folder"] = "";
                        //set href for tab a
                        titleTab = $.trim($(this).html());
                        Object.keys($globalthis.languages).forEach(function (key) {
                            ObjectTab["title_" + $globalthis.languages[key]] = titleTab;
                        });

                        OldHref = $(this).attr('href').replace('#', '');
                        $(this).attr("href", "#" + tabID);
                        $(this).data("form", ObjectTab);

                        $(widget).find('.tab-pane').each(function () {
                            if ($(this).attr('id') == OldHref) {
                                $(this).attr('id', tabID);
                                return false;
                            }
                        });
                    }
                });
            } else if (widgetType == "ApAccordions") {
                widget = $("#default_ApAccordions").clone();
                widget.removeAttr('id');
                accIdWraper = "accordion_" + $globalthis.getRandomNumber();
                ObjectForm.id = accIdWraper;
                $('.panel-group', $(widget)).attr('id', accIdWraper);
                $(".panel-title a", $(widget)).each(function () {
                    $(this).data('parent', accIdWraper);
                    accIdSub = "collapse_" + $globalthis.getRandomNumber();
                    OldHref = $(this).attr('href').replace('#', '');
                    $(this).attr('href', "#" + accIdSub);
                    $('.panel-collapse', $(this).closest('.panel-default')).attr('id', accIdSub);
                    var ObjectTab = {form_id: "form_" + $globalthis.getRandomNumber()};
                    ObjectTab.parent_id = accIdWraper;
                    ObjectTab.id = accIdSub;
                    titleTab = $(this).html();
                    Object.keys($globalthis.languages).forEach(function (key) {
                        ObjectTab["title_" + $globalthis.languages[key]] = titleTab;
                    });
                    $(widget).find('.panel-collapse').each(function () {
                        if ($(this).attr('id') == OldHref) {
                            $(this).attr('id', tabID);
                            return false;
                        }
                    });

                    $(this).data("form", ObjectTab);
                });
                //$('.panel-collapse', $(widget)).last().collapse();
            } else {
                if ($("#default_" + widgetType).length)
                    widget = $("#default_" + widgetType).clone(1);
                else
                    widget = $("#default_widget").clone(1);
                if (widgetType == "ApRawHtml") {
                    $('.widget-title', $(widget)).remove();
                    if ($(widget).find('.html-code').first().length == 0) {
                        $(".widget-content", $(widget)).append("<pre><code class='html-code'>" + htmlentities(contentHtml) + "</code></pre>");
                    } else {
                        $(widget).find('.html-code').first().html(htmlentities(contentHtml));
                    }
                }
                widget.removeAttr('id');
            }

            //add new widget in column
            if (type == 'column') {
                widget.removeAttr('id');
                $(currentE).append(widget);
            } else {
                column = $("#default_column").clone(1);
                column.removeAttr('id');
                objColumn = {form_id: "form_" + $globalthis.getRandomNumber()};
                jQuery.extend(objColumn, $globalthis.getColDefault());
                $(column).data("form", objColumn);

                $('.column-content', $(column)).append(widget);

                group = $("#default_row").clone();
                group.removeAttr('id');
                //var html = $(group).find(".group-controll-right").html();
                //$(group).find(".group-controll-right").html(html);
                $(group).data("form", {form_id: "form_" + $globalthis.getRandomNumber(), 'class': 'row'});
                $('.group-content', $(group)).append(column);
                $(currentE).before(group);
            }

            //if element is widget
            if (widgetType) {
                $(widget).addClass('widget-icon');
                $('.widget-title', $(widget)).html(dataInfo.label);
                $('.widget-title', $(widget)).attr('title', dataInfo.desc);
                $('.w-icon', $(widget)).addClass(dataInfo.icon_class).addClass(widgetType);
            }
            //if element is module
            $(widget).data("form", ObjectForm);
            $(widget).data("type", widgetType);
            $(widget).find(".label-tooltip").tooltip();
            $globalthis.sortable();
        };
        this.returnColValue = function (colNumber, finalVal) {
            $globalthis = this;
            widthVal = $globalthis.returnWidthClass();

            startSet = 0;
            var colDefault = $globalthis.getColDefault();
            for (j = 0; j < $globalthis.arrayCol.length; j++) {
                if ($globalthis.arrayCol[j] == widthVal) {
                    startSet = 1;
                    colDefault[$globalthis.arrayCol[j]] = finalVal;
                    continue;
                }

                //default xs = 6-> 2 cols.but we set 2 cols, we have to assign again 
                if (startSet && ((12 / parseInt(colDefault[$globalthis.arrayCol[j]])) < colNumber)) {
                    colDefault[$globalthis.arrayCol[j]] = finalVal;
                }
            }
            return colDefault;
        };
        this.changeColumnClass = function (element, dataObj) {
            var $globalthis = this;
            columnClass = 'column-row ' + $globalthis.classWidget;
            Object.keys($globalthis.getColDefault()).forEach(function (key) {
                columnClass += ' col-' + key + '-' + dataObj[key].toString().replace('.', '-');
            });
            $(element).attr('class', columnClass);
        };
        this.getSubWidget = function (container) {
            var $globalthis = this;
            var widgetList = new Object();

            $(container).children().each(function (iWidget) {
                var objWidget = new Object();
                objWidget.params = $(this).data('form');
                objWidget.type = $(this).data('type');

                //if it is special widget - load sub widget
                if ($(this).find('.subwidget-content').length) {
                    objWidget.widgets = new Object();
                    iSubWidget = 0

                    $(this).find('.widget-container-heading a').each(function () {
                        if ($(this).parent().attr("id") != "default_tabnav" && !$(this).parent().hasClass("tab-button")) {

                            var objSubWidget = new Object();
                            objSubWidget.params = $(this).data('form');
                            element = $($(this).attr('href')).find('.subwidget-content').first();
                            objSubWidget.widgets = $globalthis.getSubWidget(element);

                            objWidget.widgets[iSubWidget] = objSubWidget;
                            iSubWidget++;
                        }
                    });
                }
                widgetList[iWidget] = objWidget;
            });
            return widgetList;
        };
        this.getHookSubmit = function (group, isEscape) {
            var $globalthis = this;
            //group object - contain column
            var objGroup = new Object();
            objGroup.params = $(group).data('form');
            objGroup.columns = new Object();
            //find column in this group
            $('.column-row', $(group)).each(function (iColumn) {
                var objColumn = new Object();
                objColumn.params = $(this).data('form');
                //pass widget for each column
                objColumn.widgets = $globalthis.getSubWidget($(this).find('.column-content').first());
                //pass column for each group
                objGroup.columns[iColumn] = objColumn;
            });

            //pass group for each hook
            return objGroup;
        };
        this.submitForm = function () {
            var $globalthis = this;
            $("#page-header-desc-appagebuilder-save").removeAttr("onclick");
            $(document).on("click", "#page-header-desc-appagebuilder-save", function () {
                //filter all group
                $("#ap_loading").show();
                url = $globalthis.ajaxShortCodeUrl + '&action=save&id_profile=' + $('#current_profile').data('id');
                //form object
                var objects = new Object();
                var isValid = true;
                $('.hook-wrapper').each(function (iHook) {
                    //hook object contain group
                    var objHook = new Object();
                    objHook.name = $(this).data("hook");

                    // Get position id
                    var select = $(this).closest(".position-cover").find(".dropdown ul");
                    objHook.position = $(select).data("position");
                    objHook.position_id = $(select).data("id");
                    if (!objHook.position_id) {
                        //alert($(select).data("blank-error"));
                        isValid = false;
                        //return false;
                    }

                    objHook.groups = {};
                    $('.group-row', $(this)).each(function (iGroup) {
                        objHook.groups[iGroup] = $globalthis.getHookSubmit(this, true);
                    });
                    //set hook to object
                    objects[iHook] = objHook;
                });
                /*
                 if(!isValid) {
                 $("#ap_loading").hide();
                 return;
                 }
                 */
                data = 'dataForm=' + JSON.stringify(objects);
                $.ajax({
                    type: "POST",
                    headers: {"cache-control": "no-cache"},
                    url: url,
                    async: true,
                    cache: false,
                    data: data,
                    success: function (data) {
                        $("#ap_loading").hide();
                        if (!isValid) {
                            window.location.reload(true);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
                return false;
            });

            $(document).on("click", ".position-cover .list-position .position-name", function () {
                var select = $(this).closest("ul");
                var isRunning = (typeof $(select).attr("isRunning") != "undefined") ? $(select).attr("isRunning") : "";
                if (isRunning.length > 0) {
                    return;
                }
                $(select).attr("isRunning", "running");

                var id = parseInt($(this).data("id"));
                var cover = $(select).closest(".position-cover");
                $("#ap_loading").show();
                $.ajax({
                    type: "POST",
                    dataType: "Json",
                    headers: {"cache-control": "no-cache"},
                    url: $globalthis.ajaxHomeUrl,
                    async: true,
                    cache: false,
                    data: {
                        "id": id,
                        "action": "selectPosition",
                        "position": $(select).data("position"),
                        "id_profile": $('#current_profile').data('id')
                    },
                    success: function (response) {
                        $("#ap_loading").hide();
                        $(cover).html(response.html);
                        $globalthis.reInstallEvent(response.data);

                        btn_new_widget_group('.btn-new-widget-group');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    },
                    complete: function () {
                        $(select).attr("isRunning", "");
                    }
                });
                return false;
            });

            $(document).on("click", ".box-edit-position .btn-save", function () {
                var btn = $(this);
                var mode = $(this).closest(".box-edit-position").data("mode");
                var position = $(this).closest(".box-edit-position").data("position");
                var name = $.trim($(this).closest(".box-edit-position").find(".edit-name").val());
                var id = $(this).closest(".box-edit-position").data("id");
                var cover = $(this).closest(".position-cover");
                $("#ap_loading").show();
                $.ajax({
                    type: "POST",
                    dataType: "Json",
                    headers: {"cache-control": "no-cache"},
                    url: $globalthis.ajaxHomeUrl,
                    async: true,
                    cache: false,
                    data: {
                        "id": id,
                        "name": name,
                        "mode": mode,
                        "action": "processPosition",
                        "position": position,
                        "id_profile": $('#current_profile').data('id')
                    },
                    success: function (response) {
                        $("#ap_loading").hide();
                        if (mode == "new" || mode == "duplicate") {
                            $(cover).html(response.html);
                            $globalthis.reInstallEvent(response.data);
                        }
                        // Update name after changed
                        else {
                            $(cover).find(".dropdown .lbl-name").text(name);
                            $(btn).closest(".box-edit-position").addClass("hide");
                        }
                        btn_new_widget_group('.btn-new-widget-group');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#ap_loading").hide();
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    },
                    complete: function () {
                        $("#ap_loading").hide();
                    }
                });
                //$(this).closest(".box-edit-position").addClass("hide");
            });

            $(document).on("click", ".position-cover .list-position .icon-edit, .add-new-position", function (e) {
                var boxEdit = $(this).closest(".dropdown").find(".box-edit-position");
                var input = $(boxEdit).find(".edit-name");
                $(boxEdit).removeClass("hide");
                $(boxEdit).attr("data-mode", $(this).hasClass("add-new-position") ? "new" : "edit");
                $(boxEdit).attr("data-position", $(this).closest("ul").data("position"));
                $(boxEdit).attr("data-id", $(this).data("id"));
                $(this).closest(".dropdown").removeClass("open");

                var span = $(this).closest("a").find("span");
                input.val(span.text());
                input.focus();
                e.stopPropagation();
                return false;
            });
            //icon-edit
            $(document).on("click", ".box-edit-position .btn-default", function () {
                $(this).closest(".box-edit-position").addClass("hide");
                //var id = "#dropdown-" + $(this).closest(".box-edit-position").data("position");
                //log(id);
                $("#dropdown-header").trigger("click");
            });

            $(document).on("click", ".position-cover .list-position .icon-paste", function (e) {
                var boxEdit = $(this).closest(".dropdown").find(".box-edit-position");
                var input = $(boxEdit).find(".edit-name");
                $(boxEdit).removeClass("hide");
                $(boxEdit).attr("data-mode", "duplicate");
                $(boxEdit).attr("data-position", $(this).closest("ul").data("position"));
                $(boxEdit).attr("data-id", $(this).data("id"));
                $(this).closest(".dropdown").removeClass("open");

                var span = $(this).closest("a").find("span");
                input.val($(this).data("temp") + " " + span.text());
                input.focus();
                e.stopPropagation();
                return false;

                var boxEdit = $(this).closest(".dropdown").find(".box-edit-position");
                var input = $(boxEdit).find(".edit-name");
                $(boxEdit).removeClass("hide");
                $(boxEdit).attr("mode", "duplicate");
                $(boxEdit).attr("id", $(this).data("id"));
                $(this).closest(".dropdown").removeClass("open");

                var span = $(this).closest("a").find("span");
                input.val(span.text());
                input.focus();
                e.stopPropagation();
                return false;
                return false;
            });
        };
        this.reInstallEvent = function (dataForm) {
            var $globalthis = this;
            $globalthis.initDataFrom(dataForm);
            $globalthis.setGroupAction();
            $globalthis.sortable();
            $(".label-tooltip").tooltip();
            //$globalthis.setButtonAction();
            //$globalthis.submitForm();
        }
        this.initColumnSetting = function () {
            var $globalthis = this;
            var classActive = $globalthis.returnWidthClass();
            $(".column-row").each(function () {
                $globalthis.getNumberColumnInClass(this, classActive);
            });
        }
        this.getNumberColumnInClass = function (obj, type) {
            var cls = $(obj).attr("class").split(" ");
            var len = cls.length;
            var result = "";
            for (var i = 0; i < len; i++) {
                if (cls[i].search("col-" + type) >= 0) {
                    result = cls[i];
                    break;
                }
            }
            var temp = result.replace("col-" + type + "-", "");
            $(obj).find(".pull-right .btn-group .btn span:first-child").attr("class", "width-val ap-w-" + temp);
            var group = $(obj).find("ul.dropdown-menu-right");
            $(group).find("li").removeClass("selected");
            $(group).find(".col-" + temp).addClass("selected");
        }
        //THIS IS VERY IMPORTANT TO KEEP AT THE END
        return this;
    };
})(jQuery);

/**
 * FIX : cant focus to textbox of popup TinyMCE
 * http://screencast.com/t/9r6kLtiTMR8S
 */
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});

/**
 * Fixed case : ajax load html, doesnt have event popover
 */
function btn_new_widget_group() {
    $('.btn-new-widget-group').popover({
        html: true,
        content: function () {
            $globalthis.currentElement = $(this).closest('.hook-content-footer');
            //$globalthis.currentElement = $('.group-content',$(this).closest('.group-row'));
            return $('#addnew-widget-group-form').html();
        }
    });
}