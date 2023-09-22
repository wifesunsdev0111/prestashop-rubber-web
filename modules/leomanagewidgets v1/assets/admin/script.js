(function($) {
    $.fn.leomanagewidgets = function(initvar) {
        this.currentElement = null;
        this.fieldChange = null;
        this.groupField = null;
        this.columnField = null;
        this.groupDeleted = "";
        this.columnDeleted = "";
        this.submitLink = "";
        this.widgetLink = "";
        this.moduleLink = "";
        this.windowWidth = 0;
        this.widthSupport = "";
        this.arrayCol = null;
        
        //apply data for group and column
        this.setData = function(JSLIST) {
            var list = jQuery.parseJSON(JSLIST);
            var $globalthis = this;
            $globalthis.windowWidth = $(window).width();
            $globalthis.widthSupport = ["1","2", "2.4","3","4","4.8","6","7.2","8","9","9.6","10","12"];
            $globalthis.arrayCol = ["sp","xs","sm","md","lg"];
            if (list) {
                //load object by hook
                $.each(list, function(ihook, hookObj) {
                    //load object by position in hook - 0 : top,1 : middle,2: bottom
                    $.each(hookObj, function(ipos, positionOject) {
                        //load object group
                        $.each(positionOject, function(igro, groupObj) {
                            $globalthis.setDataForm(groupObj, "group", $globalthis.groupField);
                            if (groupObj.columns) {
                                $.each(groupObj.columns, function(icol, columnObj) {
                                    $globalthis.setDataForm(columnObj, "column", $globalthis.columnField);
                                });
                            }
                        });
                    });
                });
                $globalthis.setGroupAction();
                $globalthis.setColumnAction();
            }
            $globalthis.setUpGeneralAction();
            $globalthis.submitForm();
        };
        this.getColDefault = function(){
          return {lg:6,sm:6,md:6,sm:6,xs:6,sp:12};  
        };
        //set data for group or column
        this.setDataForm = function(ObjForm, ObjName, ObjField) {
            var $globalthis = this;
            //exist group in list
            if ($("#" + ObjName + "_" + ObjForm.id).length) {
                objTmp = new Object();
                for (i = 0; i < ObjField.length; i++) {
                    objTmp[ObjField[i]] = ObjForm[ObjField[i]];
                }
                $("#" + ObjName + "_" + ObjForm.id).data("form", objTmp);
                if (ObjName == "column"){
                    cla = $globalthis.returnWidthClass();
                    valueFra = objTmp[cla];
                    if(valueFra && valueFra.toString().indexOf("-") != -1){
                        valueFra = valueFra.toString().replace("-",".");
                    }
                    $(".width-val",$("#" + ObjName + "_" + ObjForm.id)).html(valueFra+'/12');
                }
            }
        };
        //set action for element
        this.setGroupAction = function() {
            var $globalthis = this;            
            //delete group button
            $(".leo-remove-group").click(function() {
                if (confirm($(this).data("confirm"))) {
                    objGroup = $(this).parent().parent().parent();
                    if ($(objGroup).attr("id")) {
                        groupId = $(objGroup).attr("id").replace("group_", "");
                        $globalthis.groupDeleted += groupId + ",";
                    }
                    $('.column-row', $(objGroup)).each(function() {
                        if ($(this).attr("id")) {
                            columnId = $(this).attr("id").replace("column_", "");
                            $globalthis.columnDeleted += columnId + ",";
                        }
                    });
                    objGroup.remove();
                }
            });
            
            $(".leo-edit-group").click(function(){
                title   = $("#data_form .group_form").data("title");
                content = $("#data_form .group_form").clone(1);
                
                $globalthis.initGroupContent($(this), content);
                
                $globalthis.currentElement = $(this).closest(".group-row");
                bootbox.dialog({
                    title: title,
                    message: content,
                });
                valueColor = $(".leo-color",$(content)).val();
                $(".leo-color",$(content)).mColorPicker({});
                $(".leo-color",$(content)).val(valueColor);
            });
            //save group
            var defaultData = ["id","hook_name","type","position"];
            $(".btn-savegroup").click(function() {
                groupForm = $(this).parent().parent();
                var objGroup = $($globalthis.currentElement).data("form");
                $('input[type!=radio]', $(groupForm)).each(function(){
                    name = $(this).attr("name").replace("group_","");
                    objGroup[name] = $(this).val();
                });
                active = $('[name="group_active"]:checked', $(groupForm)).val();
                for(i=0;i<$globalthis.groupField.length;i++){
                    if($globalthis.groupField[i] == "active"){
                        if(active != $($globalthis.currentElement).data("form").active){
                            $globalthis.setGroupStatus(($globalthis.currentElement), objGroup.active);
                        }
                        continue;
                    }
                    if(jQuery.inArray( $globalthis.groupField[i].toString(), defaultData )){
                        objGroup[$globalthis.groupField[i]] = $($globalthis.currentElement).data("form")[$globalthis.groupField[i]];
                    }
                    
                }
                
                $($globalthis.currentElement).data("form", objGroup);
                $(".bootbox-close-button").trigger("click");
            });
            
            //status group
            $(".leo-group-status").click(function() {
                elementGroup = $(this).parent().parent().parent();
                newValue = 1;
                if($(this).data("value") == 1)
                    newValue = 0;
                else
                    newValue = 1;
                
                var objGroup = new Object();
                for(i=0;i<$globalthis.groupField.length;i++){
                    objGroup[$globalthis.groupField[i]] = $(elementGroup).data("form")[$globalthis.groupField[i]];
                }
                objGroup.active = newValue;
                $(elementGroup).data("form",objGroup);
                
                $globalthis.setGroupStatus($(elementGroup), newValue);
            });
            
            //create - edit group
            $(".leo-add-group").click(function() {
                //find group-list and insert column
                hookName = $(this).data("hook");

                cloneObject = $("#default_group").clone(1);
                cloneObject.removeAttr("id");
                objTmp = new Object();
                for(i=0;i<$globalthis.groupField.length;i++){
                    if($globalthis.groupField[i]=="id"){
                        objTmp[$globalthis.groupField[i]] = 0;
                    }else if($globalthis.groupField[i]=="hook_name"){
                        objTmp[$globalthis.groupField[i]] = $(this).data("hook");
                    }else if($globalthis.groupField[i]=="active"){
                        objTmp[$globalthis.groupField[i]] = 1;
                    }else
                        objTmp[$globalthis.groupField[i]] = "";
                }
                objTmp.type = 1;
                cloneObject.data("form",objTmp);
                
                $(".group-list", $("#"+hookName+"_container")).append(cloneObject);
                //add column for group
                cloneCol = $globalthis.appendColumn(parseInt($(this).data("cols")), cloneObject);
                
                $globalthis.setColumnDragAction($(".column-list",$(cloneObject)));
            });
            
            $(".leo-content .group-list").sortable({
                opacity: 0.6,
                connectWith: ".group-list",
                cursor: "move",
                update: function(event, ui) {
                    //update hook_name in group if move to other hook
                    if (ui.item.data("form").hook_name != ui.item.parent().data("hook")) {
                        objTmp = new Object();
                        for (i = 0; i < $globalthis.groupField.length; i++) {
                            if ($globalthis.groupField[i] == "hook_name")
                                objTmp[$globalthis.groupField[i]] = ui.item.parent().data("hook");
                            else
                                objTmp[$globalthis.groupField[i]] = ui.item.data("form")[$globalthis.groupField[i]];
                        }
                        $(ui.item).data("form", objTmp);
                    }
                }
            });
            
        };
        //set action for element
        this.initGroupContent = function(obj, objForm) {
            var $globalthis = this;
            $globalthis.currentElement = $(obj).parent().parent().parent();
            groupData = $($globalthis.currentElement).data("form");
            
            if (groupData) {
                $("input[type!=radio]", $(objForm)).each(function(){
                    name = $(this).attr("name").replace("group_","");
                    $(this).val(groupData[name]);
                });
                
                if (parseInt(groupData.active) == 1)
                    $(".groupactive_on", $(objForm)).attr("checked", 1);
                else
                    $(".groupactive_off", $(objForm)).attr("checked", 1);
            }
        };
        this.setGroupStatus = function(groupObj, newValue) {
            statusObj = $(groupObj).find(".leo-group-status").first();
            $(statusObj).data("value",newValue);
                
            imgSrc = $(statusObj).find("img").first().attr("src");
            if(imgSrc.indexOf("enabled.gif") != -1)
                $(statusObj).find("img").first().attr("src",imgSrc.replace("enabled.gif","disabled.gif"));
            else
                $(statusObj).find("img").first().attr("src",imgSrc.replace("disabled.gif","enabled.gif"));
        };
        this.setColumnDragAction = function(element) {
            $(element).sortable({
                opacity: 0.6,
                connectWith: ".column-list",
                cursor: "move",
                update: function(event, ui) {
                    ui.item.css("z-index",1);
                    groupRow = ui.item.closest(".group-row");
                    if($(groupRow).data('form' == undefined) && $(groupRow).data('form') == undefined){
                        objTmp = new Object();
                        objTmp.id = 0;
                        objTmp.active = 1;
                        objTmp.type = $(groupRow).data("type");
                        leohook = $(groupRow).closest(".leohook");
                        objTmp.hook_name = $(leohook).data("hook");

                        $(groupRow).data("form", objTmp);
                    }
                }
            });
        }
        //set action for element
        this.setColumnAction = function() {
            $globalthis = this;
            $globalthis.setColumnDragAction(".leo-content .column-list");
            //increase and reduce width
            $(".width-action").click(function(){
                cla = $globalthis.returnWidthClass();
                elementColumn = $(this).closest(".column-row");
                
                //get data from column and set to object
                var objColumn = $(elementColumn).data("form");
                
                //get current width of column and convert it to number
                valueColToNum = objColumn[cla];

                val = parseInt($(this).data("action"));
                if(val == 1 && parseFloat(valueColToNum) >= 12){ alert($("#leo-mess").data("increase"));return false;}
                if(val == -1 && parseFloat(valueColToNum) <= 1){ alert($("#leo-mess").data("reduce"));return false;}
                //get index of current width
                indexW = jQuery.inArray( objColumn[cla].toString(), $globalthis.widthSupport );
                
                indexW = parseInt(indexW) + val;
                //get new width
                objColumn[cla] = $globalthis.widthSupport[indexW];
                
                //set class again
                classColumn = $globalthis.getClassColumn(objColumn);
                $(elementColumn).attr("class",classColumn);
                
                $('.width-val',$(elementColumn)).html(objColumn[cla]+'/12');
                
                $(elementColumn).data("form",objColumn);
                
                return false;
            });
            
            $('.leo-change-width').click(function(){
                cla = $globalthis.returnWidthClass();
                elementColumn = $(this).closest(".column-row");
                var objColumn = $(elementColumn).data("form");
                
                objColumn[cla] = $(this).data('width');
                
                classColumn = $globalthis.getClassColumn(objColumn);
                $(elementColumn).attr("class",classColumn);
                
                $('.width-val',$(elementColumn)).html(objColumn[cla]+'/12');
                
                $(elementColumn).data("form",objColumn);
            });
            
            //column group
            $(".leo-column-status").click(function() {
                elementColumn = $(this).parent().parent().parent();
                newValue = 1;
                if($(this).data("value") == 1)
                    newValue = 0;
                else
                    newValue = 1;
                
                var objColumn = new Object();
                for(i=0;i<$globalthis.columnField.length;i++){
                    objColumn[$globalthis.columnField[i]] = $(elementColumn).data("form")[$globalthis.columnField[i]];
                }
                objColumn.active = newValue;
                //set count
                
                $(elementColumn).data("form",objColumn);
                
                $globalthis.setColumnStatus($(elementColumn), newValue);
            });
            
            $(".leo-add-column").click(function(event){
                groupRow = $(this).closest(".group-row");
                $globalthis.appendColumn(1, $(groupRow), $(this).data('width'));
                
                //if don't exist data form, add data form for group
                if(parseInt($(groupRow).data("type")) != 1){
                    if($(groupRow).data('form') == undefined){
                        var objects = new Object();
                        objects.id = 0;
                        objects.active = 1;
                        objects.type = $(groupRow).data("type");
                        objects.hook_name = $(groupRow).closest(".leohook").data("hook");
                        $(groupRow).data('form',objects);
                    }
                }
            });
            
            $(".leo-edit-column").click(function(){
                title   = $("#data_form .column-form").data("title");
                content = $("#data_form .column-form").clone(1);
                $globalthis.initColumnContent($(this), content);
                
                $globalthis.currentElement = $(this).closest(".column-row");
                bootbox.dialog({
                    title: title,
                    message: content,
                });
                valueColor = $(".leo-color",$(content)).val();
                $(".leo-color",$(content)).mColorPicker({});
                $(".leo-color",$(content)).val(valueColor);
                });
            
            //save column
            $(".btn-savecolumn").click(function(){
                form = $(".bootbox-body .column-form");
                //check valid data
                if($(".modal-dialog .column_type").val()  == "widget"){
                if(!$('select[name="column_key_widget"]', $(form)).val()){
                    alert($('select[name="column_key_widget"]', $(form)).data("text"));
                    return false;
                    }
                }else{
                    if(!$('select[name="column_module"]', $(form)).val()){
                        alert($('select[name="column_module"]', $(form)).data("text"));
                        return false;
                    }
                    if(!$('select[name="column_module_hook"]', $(form)).val()){
                        alert($('select[name="column_module_hook"]', $(form)).data("text"));
                        return false;
                    }
                }
                
                var objCol = new Object();
                if($($globalthis.currentElement).data("form").id != 0)
                    objCol.id = $($globalthis.currentElement).data("form").id;
                else
                    objCol.id = 0;
                
                objCol.active = $('[name="column_active"]:checked', $(form)).val();
                if(objCol.active != $($globalthis.currentElement).data("form").active){
                    $globalthis.setColumnStatus(($globalthis.currentElement), objCol.active);
                }
                $globalthis.currentElement.find('.leo-edit-widget').removeClass('disabled');
                $globalthis.currentElement.find('.leo-column').removeClass('unset-widget');
                if($(".modal-dialog .column_type").val()  == "widget"){
                objCol.key_widget = $('select[name="column_key_widget"]', $(form)).val();
                   //delete value of module, hook, deleteMolue variable
                   objCol.module = ""; 
                   objCol.hook = "";
                   objCol.deleteModule = "";
                 }else{
                    objCol.key_widget = "0"; //delete value of key_widget variable
                    objCol.module = $('select[name="column_module"] option:selected', $(form)).text();
                    objCol.hook = $('select[name="column_module_hook"] option:selected', $(form)).text();
                    deleteModuleStatus = $('input[type=checkbox][name=delete_module]', $(form)).attr('checked');
                    objCol.deleteModule = deleteModuleStatus? "1":"0";

                }
                objCol.class = $('[name="column_class"]', $(form)).val();
                objCol.background = $('[name="column_background"]', $(form)).val();
                objCol.pages = $('[name="column_pages"]', $(form)).val();
                
                for(i=0;i<$globalthis.arrayCol.length;i++){
                    objCol[$globalthis.arrayCol[i]] = $('[name="column_'+$globalthis.arrayCol[i]+'"]', $(form)).val();
                }
                
                $($globalthis.currentElement).data("form", objCol);
                
                $($globalthis.currentElement).attr("class", $globalthis.getClassColumn(objCol));
                
                $(".width-val",$($globalthis.currentElement)).html(objCol[$globalthis.returnWidthClass()]+'/12');
                if($(".modal-dialog .column_type").val()  == "widget"){
                $(".leo-column_title",$($globalthis.currentElement)).html($('select[name="column_key_widget"] option:selected',$(form)).text());
                }else{
                    $(".leo-column_title",$($globalthis.currentElement)).html($('select[name="column_module"] option:selected',$(form)).text());
                }
                
                if($(this).data("action") != undefined)
                    $(".bootbox-close-button").trigger("click");
            });
            
            //delete column
            $(".leo-delete-column").click(function(){
                if (confirm($(this).data("confirm"))) {
                    columnObj = $(this).closest(".column-row");
                    if ($(columnObj).attr("id")) {
                        columnId = $(columnObj).attr("id").replace("column_", "");
                        $globalthis.columnDeleted += columnId + ",";
                    }
                    $(columnObj).remove();
                }
            });
            
            $(".leo-edit-widget").click(function(){
            $globalthis.currentElement = $(this).closest(".panel");
            keyWidget = $(this).closest(".column-row").data("form").key_widget;
            if(keyWidget > 0) //is a widget
            {
                $globalthis.currentElement = $(this).closest(".panel");
                keyWidget = $(this).closest(".column-row").data("form").key_widget;
                 $.fancybox.open([
                    {
                        type: 'iframe', 
                        href : $globalthis.widgetLink+"&key="+keyWidget+"&updateleowidgets",
                        afterLoad:function(){
                            $globalthis.hideSomeElement();
                            $('.fancybox-iframe').load( $globalthis.hideSomeElement );
                        },
                        afterClose: function (event, ui) {
                            $('html, body').animate({
                                scrollTop: parseInt(parseInt($globalthis.currentElement.offset().top) + 200)
                            }, 2000);
                        }
                    }
                ], {
                    padding: 10
                });
            }else{// is a module
                    var module_name = $(this).closest(".column-row").data("form").module;
                    $globalthis.currentElement = $(this).closest(".panel");
                    $.fancybox.open([
                        {
                            type: 'iframe', 
                            href : $globalthis.moduleLink + '&configure=' + module_name + '&module_name=' + module_name,
                            afterLoad:function(){
                                $globalthis.hideSomeElement();
                                $('.fancybox-iframe').load( $globalthis.hideSomeElement );
                            },
                            afterClose: function (event, ui) {
                                $('html, body').animate({
                                    scrollTop: parseInt(parseInt($globalthis.currentElement.offset().top) + 200)
                                }, 2000);
                            }
                        }
                    ], {
                        padding: 10
            });
                 }
            }
            );
            
        };
        //get all column from group
        this.initColumnContent = function(btnElement, objFrom) {
            $globalthis = this;
            colElement = $(btnElement).closest('.column-row');
            
            $globalthis.currentElement = colElement;
            colData = $(colElement).data("form");
            list = $('select[name="column_type"]', $(objFrom));
            moduleList = $('select[name="column_module"]', $(objFrom));
            hookList = $('select[name="column_module_hook"]', $(objFrom));
            moduleList.change(
                function (){
                                hookList.empty();
                                hookList.append('<option value='+ "" + '>'+ "--------- Select a Hook ---------" + '</option>'); 
                                if($(this).val()!=""){
                                    var strHook= $(this).find(":selected").data("hook");
                                    var arrHooks = strHook.split(',');
                                    var i;
                                    for(i = 0; i < arrHooks.length; i++){
                                        aHook = arrHooks[i].split('-');
                                        hookList.append('<option data-status = ' + aHook[1] +' value="'+ aHook[0] + '">'+ aHook[0] + '</option>'); 
                                    }
                                }
                            }
            );
            hookList.change(
                function (){
                        $('input[type=checkbox][name=delete_module]', $(objFrom)).removeAttr("checked");
                        var status= $(this).find(":selected").data("status");
                        if(status == 1){
                            $('input[type=checkbox][name=delete_module]', $(objFrom)).removeAttr("disabled");
                        }else{
                            $('input[type=checkbox][name=delete_module]', $(objFrom)).attr("disabled",true);
                        }        
            
                            }
            );
            list.change(function(event) {
                var type = $(this).val();
                if(type=="module"){
                    $('.column_type_widget', $(objFrom)).css("display","none");
                    $('.column_type_module', $(objFrom)).css("display","block");
                    moduleList.find('option').prop('selected', false);
                    moduleList.find('option[value = "' + colData.module + '"]').prop('selected', true);
                    moduleList.trigger("change");
                    hookList.find('option').prop('selected', false);
                    hookList.find('option[value="' + colData.hook + '"]').prop('selected', true);
                    hookList.trigger("change");
                }   
                else{
                    $('.column_type_module', $(objFrom)).css("display","none");
                    $('.column_type_widget', $(objFrom)).css("display","block");
                    //auto select widget key
                    widgetList = $('select[name="column_key_widget"]', $(objFrom));
                    widgetList.find('option').prop('selected', false);
                    widgetList.find('option[value="' + colData.key_widget + '"]').prop('selected', true);
                }
            });
            //set data in form
            if (colData) {
                if(colData.key_widget != "0"){
                    list.find('option').prop('selected', false);
                    list.find('option[value="widget"]').prop('selected', true);     
                }else{
                list.find('option').prop('selected', false);
                    list.find('option[value="module"]').prop('selected', true);
                }
                list.trigger("change");
                for(i=0;i<$globalthis.arrayCol.length;i++){
                    $('input[name="column_'+$globalthis.arrayCol[i]+'"]', $(objFrom)).val(colData[$globalthis.arrayCol[i]]);
                    $('input[name="column_'+$globalthis.arrayCol[i]+'"]', $(objFrom)).parent().find('.leo-w-option').each(function(){
                        widthVal = $(this).data("width");
                        if(widthVal == colData[$globalthis.arrayCol[i]]){
                            html = $(this).html()+'<span class="caret"></span>';
                            elementDiv = $(this).closest("div");
                            $(".col-val", $(elementDiv)).val(widthVal);
                            $("button", $(elementDiv)).html(html);
                        }
                    });
                }
                
                $('[name="column_class"]', $(objFrom)).val(colData.class);
                $('[name="column_background"]', $(objFrom)).val(colData.background);
                $('[name="column_pages"]', $(objFrom)).val(colData.pages);
                $('[name="column_pages"]', $(objFrom)).trigger("change");
                
                $('[name="column_class"]', $(objFrom)).trigger("change");
                
                if (parseInt(colData.active, 0))
                    $(".default-on", $(objFrom)).attr("checked", 1);
                else
                    $(".default-off", $(objFrom)).attr("checked", 1);
                
            }
        }
        this.setColumnStatus = function(columnObj, newValue) {
            statusObj = $(columnObj).find(".leo-column-status").first();
            $(statusObj).data("value",newValue);
                
            imgSrc = $(statusObj).find("img").first().attr("src");
            if(imgSrc.indexOf("enabled.gif") != -1)
                $(statusObj).find("img").first().attr("src",imgSrc.replace("enabled.gif","disabled.gif"));
            else
                $(statusObj).find("img").first().attr("src",imgSrc.replace("disabled.gif","enabled.gif"));
        };
        //get data to submit
        this.setUpGeneralAction = function() {
            $globalthis = this;
            $('.leo-resize button').click(function(){
                btnElement = $(this);
                
                if($(this).data('class') == 'reset'){    
                    $('.leo-heading').parent().css('width',$(this).data('width'));
                    $('.leo-heading').parent().attr('class','panel');
                    $('.leo-resize button').removeClass('active');
                    
                    $globalthis.windowWidth = $(window).width();
                    $(".column-row", $('.leo-heading').parent()).each(function(){
                        classVal = $globalthis.returnWidthClass();
                        $(".width-val", $(this)).html($(this).data("form")[classVal]+'/12');
                    });
                }else{
                    $('.leo-heading').parent().css('width',$(this).data('width')+'px');
                    $('.leo-heading').parent().attr('class','panel '+$(this).data('class'));
                    $('.leo-resize button').removeClass('active');
                    $(this).addClass('active');
                    $globalthis.windowWidth = $(this).data('width');
                    //action in column
                    $(".column-row", $('.leo-heading').parent()).each(function(){
                        classVal = $(btnElement).data('class').replace("col-","");    
                        $(".width-val", $(this)).html($(this).data("form")[classVal]+'/12');
                    });
                }
                
            });
            
            $(".leo-col-class input[type=checkbox]").click(function(){
                classChk = $(this).attr("name").replace("col_","");
                elementText = $(this).closest('.well').find('input[type=text][name=column_class]').first();
                //add
                if($(this).is(':checked')){
                    if($(elementText).val().indexOf(classChk) == -1){
                        if($(elementText).val() != ""){
                            $(elementText).val($(elementText).val()+" "+classChk);
                        }else{
                            $(elementText).val(classChk);
                        }
                    }
                }else{
                    //remove
                    if($(elementText).val().indexOf(classChk) != -1){
                        $(elementText).val($(elementText).val().replace(classChk+" ",""));
                        $(elementText).val($(elementText).val().replace(" "+classChk,""));
                        $(elementText).val($(elementText).val().replace(classChk,""));
                    }
                }
            });
            
            $(".column-form input[type=text][name=column_class]").change(function(){
                elementChk = $(this).closest('.well').find('input[type=checkbox]');
                classText = $(this).val();
                $(elementChk).each(function(){
                    classChk = $(this).attr("name").replace("col_","");
                    if(classText.indexOf(classChk) != -1){
                        if(!$(this).is(':checked')) $(this).prop("checked",true);
                    }else{
                       $(this).prop("checked",false);
                    }
                });
            });
            //resize window
            $( window ).resize(function() {
                $globalthis.windowWidth = $( window ).width();
            });
            
            $(".leo-w-option").click(function(){
               widthVal = $(this).data("width");
               html = $(this).html()+'<span class="caret"></span>';
               elementDiv = $(this).closest("div");
               $(".col-val", $(elementDiv)).val(widthVal);
               $("button", $(elementDiv)).html(html);
            });
            
            $(".leo-redirect a").click(function(){
                if($("#"+$(this).data("element")).length){
                    $('html, body').animate({
                        scrollTop: parseInt(parseInt($("#"+$(this).data("element")).offset().top)-130)
                    }, 2000);
                }
                return false;
            });
        
            $(".btn-addnewwidget").click(function(){
                
                if (!!$.prototype.fancybox)
                {
                    $.fancybox.open([
                        {
                            type: 'iframe', 
                            href : $globalthis.widgetLink,
                            afterLoad:function(){
                                $globalthis.hideSomeElement();
                                $('.fancybox-iframe').load( $globalthis.hideSomeElement );
                            },
                            afterClose: function (event, ui) {
                                location.reload();
                            }
                        }
                    ], {
                        padding: 10
                    });
                }
            });
                    
            $(".choise-class").click(function(){
                $(this).parent().find('input[type=checkbox]').trigger("click");
            });
            
            //auto move
            $(".leo-close-open").click(function() {
                obj = $(this).parent().parent().parent();
                if ($(this).data("status") == 1) {
                    $(".leo-content", obj).hide();
                    $(this).data("status", 0);
                    $("i", $(this)).attr("class", "icon-sort-down");
                } else {
                    $(".leo-content", obj).show();
                    $(this).data("status", 1);
                    $("i", $(this)).attr("class", "icon-sort-up");
                }
            });
            
            $(".closeoropen").click(function() {
                if ($(this).attr("id")=="closeoropen") {
                    $(".leo-content").hide();
                    $(".leo-close-open").data("status", 0);
                    $("i", $(".leo-close-open")).attr("class", "icon-sort-down");
                    $(this).hide();
                    $("#openorclose").show();
                } else {
                    $(".leo-content").show();
                    $(".leo-close-open").data("status", 1);
                    $("i", $(".leo-close-open")).attr("class", "icon-sort-up");
                    $(this).hide();
                    $("#closeoropen").show();
                }
            });
            
            //page in column form
            $('.em_text').change(function(){
                var list = $(this).closest('.well').find('.em_list');
                var values = "";
                if($(this).val())
                    values = $(this).val().split(',');
                var len = values.length;

                list.find('option').prop('selected', false);
                for (var i = 0; i < len; i++)
                        list.find('option[value="' + $.trim(values[i]) + '"]').prop('selected', true);
            });
            $('.em_list').change(function(){
                if($(this).val()){
                    var str = $(this).val().join(', ');
                    var text = $(this).closest('.well').find('.em_text');
                    $(text).val(str);
                }
            });
        };
        this.hideSomeElement = function(){
            $('body',$('.fancybox-iframe').contents()).find("#header").hide();
            $('body',$('.fancybox-iframe').contents()).find("#footer").hide();
            $('body',$('.fancybox-iframe').contents()).find(".page-head, #nav-sidebar ").hide();
            $('body',$('.fancybox-iframe').contents()).find("#content.bootstrap").css( 'padding',0).css('margin',0);
        };
        this.returnWidthClass = function(){
            $globalthis = this;
            width = $globalthis.windowWidth;
            if(parseInt(width) >= 1200) return 'lg';
            if(parseInt(width) >= 992) return 'md';
            if(parseInt(width) >= 768) return 'sm';
            if(parseInt(width) >= 481) return 'xs';
            if(parseInt(width) < 481) return 'sp';
        };
        this.getClassColumn = function(objCol){
            $globalthis = this;
            classColumn = "column-row label-tooltip";
            for(ic=0;ic<$globalthis.arrayCol.length;ic++){
                 if(objCol[$globalthis.arrayCol[ic]]){
                     valueCol = objCol[$globalthis.arrayCol[ic]];
                     if(valueCol.toString().indexOf(".") != -1){
                        valueCol = valueCol.toString().replace(".","-");
                     }
                     classColumn += " col-"+$globalthis.arrayCol[ic]+"-"+valueCol;
                 }
            }
            return classColumn;
        };
        this.appendColumn = function(colNumber, objGroup, colVal){
            $globalthis = this;
            
            for(i=0;i<colNumber;i++){
                cloneObject = $("#default_column").clone(1);
                cloneObject.removeAttr("id");
                objNewCol = new Object();
                objNewCol.id = 0;
                objNewCol.active = 1;
                var colDefault = new Object();
                
                if(colVal){
                    colDefault = $globalthis.returnColValue(12/parseInt(colVal), colVal);
                }else{
                    classVal = 12/colNumber;
                    colDefault = $globalthis.returnColValue(colNumber, classVal);
                }
                
                Object.keys(colDefault).forEach(function(key) {
                    objNewCol[key] = colDefault[key];
                });
                
                cla = $globalthis.returnWidthClass();
                //valueFra = $globalthis.float2rat(parseFloat(objNewCol[cla]/12));
                $('.width-val',$(cloneObject)).html(objNewCol[cla]+'/12');
                
                colClass = $globalthis.getClassColumn(objNewCol);
                cloneObject.attr('class',colClass);
                
                $(cloneObject).data("form",objNewCol);
                $(".column-list", $(objGroup)).append(cloneObject);
            }
        };
        this.returnColValue = function(colNumber, finalVal){
            $globalthis = this;
            widthVal = $globalthis.returnWidthClass();
            
            startSet = 0;
            var colDefault = $globalthis.getColDefault();
            for(j=0;j<$globalthis.arrayCol.length;j++){
                if($globalthis.arrayCol[j] == widthVal){
                    startSet = 1;
                    colDefault[$globalthis.arrayCol[j]] = finalVal;
                    continue;
                }

                //default xs = 6-> 2 cols.but we set 2 cols, we have to assign again 
                if(startSet && ((12/parseInt(colDefault[$globalthis.arrayCol[j]])) < colNumber)){
                    colDefault[$globalthis.arrayCol[j]] = finalVal;
                }
            }
            return colDefault;
        }; 
        //convert a decimal into a float2rat
        this.float2rat =  function(x){
            var tolerance = 1.0E-6;
            var h1=1; var h2=0;
            var k1=0; var k2=1;
            var b = x;
            do {
                var a = Math.floor(b);
                var aux = h1; h1 = a*h1+h2; h2 = aux;
                aux = k1; k1 = a*k1+k2; k2 = aux;
                b = 1/(b-a);
            } while (Math.abs(x-h1/k1) > x*tolerance);

            return h1+"/"+k1;
        };
        this.submitForm = function(){
            $globalthis = this;
            $(".leobtnsave").click(function() {
                var objects = new Object();
                objects.deletedObj = new Object();
                objects.deletedObj["deletedColumn"] = $globalthis.columnDeleted;
                objects.deletedObj["deletedGroup"] = $globalthis.groupDeleted;
                objects.groups = new Object();
                
                var igrop = 0;
                //get data by hook
                
                $(".leo-content .group-row").each(function() {
                    //if static group, continue
                    if($(this).data('form') != undefined && ($(this).find('.column-row').length > 0 || $(this).hasClass('label-tooltip'))){
                        var objGroup = new Object();
                        objGroup.params = $(this).data('form');
                        if($(".column-row .leo-column", $(this)).length){
                            objGroup.columns = new Object();
                            var objCol = new Object();
                            var i = 0;
                            $(".column-row", $(this)).each(function() {
                                if($(this).data('form') != undefined){
                                    objCol = $(this).data('form');
                                    objGroup.columns[i] = objCol;
                                    i++;
                                }
                            });
                        }
                        
                        objects.groups[igrop] = objGroup;
                        igrop++;
                    }
                });
                
                params = JSON.stringify(objects);
                $("#data_forms").val(params);
                $("#module_form").submit();
                return false;
            });
        };
        //THIS IS VERY IMPORTANT TO KEEP AT THE END
        return this;
    };
})(jQuery);