/**
* 2007-2018 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

const throttle = (func, limit) => {
    let lastFunc
    let lastRan
    return function() {
        const context = this
        const args = arguments
        if (!lastRan) {
        func.apply(context, args)
        lastRan = Date.now()
        } else {
        clearTimeout(lastFunc)
        lastFunc = setTimeout(function() {
            if ((Date.now() - lastRan) >= limit) {
            func.apply(context, args)
            lastRan = Date.now()
            }
        }, limit - (Date.now() - lastRan))
        }
    }
}

$(window).ready(function() {
    controller_url = controller_url.replace(/\amp;/g,'');

    if (!isPs17) {
        ad = 'test';
        iso = 'en';
    }

    $('#CB-OPACITY').bootstrapSlider();
    $("#CB-OPACITY").on("slide", function(slideEvt) {
        $(".cookiebanner-number").val(slideEvt.value);
    });

    $('.cookiebanner-number').bind('input', function() {
        $('#CB-OPACITY').bootstrapSlider('setValue', $(this).val());
    });

    tinySetup({
        height: 100,
        editor_selector : 'loadTinyMce',
        plugins : 'code advlist autolink link lists charmap print textcolor colorpicker style',
    });

    $('#product1').select2({
        placeholder: select2placeholder,
        allowClear: true
    });

    $('#product2').select2({
        placeholder: select2placeholder,
        allowClear: true
    });

    $(document).on('click', '#saveAssignProduct', function (e) {
        var id_image = $(this).attr('data-id-image');
        var id_product1 = $('#product1').val();
        var id_product2 = $('#product2').val();

        $.ajax({
            type: 'POST',
            url: controller_url,
            dataType: 'JSON',
            data: {
                action: 'AssignProduct',
                ajax: true,
                id_image: id_image,
                id_product1: id_product1,
                id_product2: id_product2
            },
            success: function(data) {
                generateCache();
                showSuccessMessage(msgAssignProduct);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            var tag = $("input[name=PS_INSTA_SEARCH]").val();
            getTag(tag);
        }
    });

    $(document).on('click', '.switch', function (e) {
        var toggleOption = $(this).children(':first').attr('name');
        var isChecked = $("input[name='"+toggleOption+"']:checked").val();

        if (isChecked == 1) {
            $('#'+toggleOption).removeClass('hide');
        } else {
            $('#'+toggleOption).addClass('hide');
        }
    });

    $(document).on('click', '.input_img', function () {
        if ($(this).hasClass('js-show-all')) {
            $('.confirm_deny').slideDown();
        } else {
            $('.confirm_deny').slideUp();
        }
    });

    $(document).on('click', '.input_upload_img', function () {
        if ($(this).hasClass('js-upload-img')) {
            $('#upload-image').slideDown();
        } else {
            $('#upload-image').slideUp();
            $('#upload-image').removeClass('hide');
        }
    });

    vImagePreselection = new Vue({
        el: '#image-preselection',
        delimiters: ["((","))"],
        data: {
            items: '',
            paginate: ['items'],
            search : false,
        },
        components: {
        },
        methods: {
            getTag: function () {
                var tag = $("input[name=PS_INSTA_SEARCH]").val();
                getTag(tag);
            },
            addImage: function (idMedia, index) {
                imageData = this.items[index];
                addImage(imageData, index);
            },
            removeImage: function (idMedia, index) {
                removeImageByIdMedia(idMedia, index);
            },
        }
    });

    function getImages() {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: controller_url,
            data: {
                ajax: true,
                action: 'GetImages',
            },
            success: function(data) {
                vImageManager.imageList = data;
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function getTag(tagName) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: controller_url,
            data: {
                ajax: true,
                action: 'GetTag',
                tagName: tagName,
            },
            success: function(data) {
                vImagePreselection.items = data;
                vImagePreselection.search = true;
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function addImage(imageData, index) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: controller_url,
            data: {
                ajax: true,
                action: 'AddImage',
                imageData: imageData,
            },
            success: function(data) {
                vImagePreselection.paginate.items.list[index].isActive = 1;
                getImages();
                generateCache();
                showSuccessMessage(msgAddImage);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function removeImageByIdMedia(idMedia, index) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: controller_url,
            data: {
                ajax: true,
                action: 'RemoveImageByIdMedia',
                idMedia: idMedia,
            },
            success: function(data) {
                //vImagePreselection.items[index].isActive = 0;
                vImagePreselection.paginate.items.list[index].isActive = 0;
                getImages();
                generateCache();
                showSuccessMessage(msgRemoveImage);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function generateCache() {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: controller_url,
            data: {
                ajax: true,
                action: 'GenerateCache',
            },
            success: function(data) {
            },
            error: function(err) {
                showErrorMessage(tradSmthWrongHappenedTryAgain);
            }
        });
    }

    $(document).on('change', '.slide_image', function (e) {
        readURL(this, $(this).attr('data-preview'));
    });

    function readURL(input, id) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                if ($('#'+id).hasClass('hide')) {
                    $('#'+id).removeClass('hide');
                }
                $('#'+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            $(".slide_url").attr('value', input.files[0].name);
        }
    }

    $(".slide_url").each(function() {
        var str = $(this).attr('value');
        var delimiter = '/';
        var split = str.split(delimiter);
        var image_name = split[split.length-1];
        $(this).attr('value', image_name);
    });

    $(document).on('change', ':file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(':file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;

        if(input.length) {
            input.val(log);
        } else {
            if(log) alert(log);
        }
    });

    function handleClickOnAllShop(context) {

        $('.PopupDisplaySelector').each(function(index) {
            if ($(this).prop("value") == 'all') { return; }
            $(this).prop("checked", false);
        });

        $('#PopupDisplaySelectCategories').addClass('hide');
        $('#PopupDisplaySelectProducts').addClass('hide');
        $('#jstreecategories ul').empty();

        var jsTreeCategories = $.jstree.reference('#jstreecategories');
        if (null != jsTreeCategories) {
            jsTreeCategories.destroy();
        }
    };

    function onJsTreeSelectCategories(event, data) {
        var id = data.node.id.replace('category_',''),
            categoriesString = $('#PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES').val(),
            categoriesArray = categoriesString.split(','),
            isAlreadyPresent = false;

        categoriesArray.forEach(catId => {
            if (catId == id) { isAlreadyPresent = true; }
        });

        if (!isAlreadyPresent) {
            categoriesArray.push(id);
            categoriesString = categoriesArray.join(',');
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES').val(categoriesString);
        };
    };

    function onJsTreeUnselectCategories(event, data) {
        var id = data.node.id.replace('category_',''),
            categoriesString = $('#PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES').val(),
            categoriesArray = categoriesString.split(',');

        categoriesArray.forEach((catId, index) => {
            if (catId == id) {
                categoriesArray.splice(1 ,index);
                index--;
            }
        });
        categoriesString = categoriesArray.join(',');
        $('#PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES').val(categoriesString);
    };

    function initJsTreeCategories(html) {
        $('#jstreecategories ul')
        .empty()
        .promise( $('#jstreecategories ul').append(html) )
        .done(function() {
            $('#jstreecategories').jstree({
                "checkbox" : {
                    "three_state" : false,
                    "keep_selected_style" : true
                },
                "plugins" : ["checkbox"]
            });

            $('#jstreecategories')
                .on("select_node.jstree", onJsTreeSelectCategories)
                .on("deselect_node.jstree", onJsTreeUnselectCategories);
        });
    };

    function handleSuccessGetCategories(response) {
        var html = '',
            categories = JSON.parse(response);

        function handleNestedCategories(category) {
            for (key in categories[category]) {
                var isSelected = '';
                popupDisplaySelectedCategories.forEach(selectedCategory => {
                    if (categories[category][key].id == selectedCategory.id) {
                        isSelected = 'class="jstree-clicked"';
                    }
                });
                html += '<ul>'
                html += '<li id="category_'+ categories[category][key].id +'" ><a '+isSelected+' >' + categories[category][key].name +'</a>';
                handleNestedCategories(categories[category][key].id);
                html += '</li>';
                html += '</ul>'
            }
        };

        for (key in categories) {
            categories[key].forEach(category => {
                // show only child of Home category
                if (category.id_parent == PS_HOME_CATEGORY) {
                    var isSelected = '';
                    popupDisplaySelectedCategories.forEach(selectedCategory => {
                        if (category.id == selectedCategory.id) {
                            isSelected = 'class="jstree-clicked"';
                        }
                    });

                    html += '<li id="category_'+ category.id +'" ><a '+isSelected+' >' + category.name +'</a>';

                    // recursive on all childrens
                    handleNestedCategories(category.id);
                    html += '</li>';
                };
            });
        }

        initJsTreeCategories(html);
        $('#PopupDisplaySelectCategories').removeClass('hide');
    };

    function onChangePopupDisplaySelector(event) {
        // Clicked on all shop
        if ($(this).prop("value") == 'all' ) {
            handleClickOnAllShop(this);
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE').val('true');
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES').val('');
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS').val('');
        };

        if ($(this).prop("value") != 'all') {
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE').val('false');
            $('input.PopupDisplaySelector[value="all"]').prop("checked", false);

            // Handle click on categories
            if ($(this).prop("value") == 'categories') {
                if ($(this).prop("checked") == true) {
                    $.ajax({
                        type: 'GET',
                        url: AjaxPsAgeCheckerController,
                        data: {
                            ajax: true,
                            action: 'GetCategories',
                        },
                        success: handleSuccessGetCategories,
                        error: function(err) {
                            showErrorMessage(tradSmthWrongHappenedTryAgain);
                        }
                    });
                }

                if ($(this).prop("checked") == false) {
                    // remove AllCategories on inputCategories
                    $('#PopupDisplaySelectCategories').addClass('hide');
                    $.jstree.reference('#jstreecategories').destroy();
                    $('#jstreecategories ul').empty();
                }
            }

            // Handle click on products
            if ($(this).prop("value") == 'products') {
                if ($(this).prop("checked") == true) {
                    $('#PopupDisplaySelectProducts').removeClass('hide');
                } else {
                    $('#PopupDisplaySelectProducts').addClass('hide');
                }
            }
        };
    };

    function onClickPopupDisplaySelectProduct(event) {
        var html = '',
            id = $(event.target).attr('id'),
            name = $(event.target).text(),
            imgLink = $(event.target).find('img').attr('src'),
            isAlreadyPresent = false,
            productsString = $('#PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS').val(),
            productsArray = productsString.split(',');

        html = '<tr id="'+ id +'"><td>'+ id +'</td> <td><img class="img-thumbnail" src="'+ imgLink +'"></td> <td>'+ name +'</td> <td><i class="material-icons" data-id="'+ id +'">delete</i></td> </td>'+ name +'</tr>';
        $('#PopupDisplaySelectProducts #selectedProducts tbody').append(html);
        $(event.target).remove();

        productsArray.forEach(productId => {
            if (productId == id) { isAlreadyPresent = true; }
        });

        if (!isAlreadyPresent) {
            productsArray.push(id);
            productsString = productsArray.join(',');
            $('#PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS').val(productsString);
        };
    };

    function onClickPopupDisplayUnselectProduct(event) {
        var id = $(event.target).attr('data-id'),
            productsString = $('#PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS').val(),
            productsArray = productsString.split(',');

        $("#selectedProducts").find("tr#"+id).remove();

        productsArray.forEach((productId, index) => {
            if (productId == id) {
                productsArray.splice(index, 1);
                index--;
            }
        });

        productsString = productsArray.join(',');
        $('#PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS').val(productsString);
    };

    function onMouseEnterPopupDisplaySelectProduct(event) {
        $(event.target).css("background-color", "#25B9D7");
    };

    function onMouseLeavePopupDisplaySelectProduct(event) {
        $(event.target).css("background-color", "none");
    };

    function onClickTranslatableDropdownMenu(event) {
        var idLang = $(event.target).attr('data-id'),
            $autoloads_rte = $('.autoload_rte.loadTinyMce');

        for (let i = 0; i < $autoloads_rte.length; i++) {
            console.log(i);
            $($autoloads_rte[i]).removeClass('loadTinyMce');
        }

        // destroy all others tinyMce instances
        for (let i = 0; i < tinyMCE.editors.length; i++) {
            var ed_id = tinymce.editors[i].id;
            tinyMCE.execCommand("mceRemoveEditor", true, ed_id);
        }

        $('textarea[name="PS_AGE_CHECKER_CUSTOM_TITLE_'+ idLang +'"]').addClass('loadTinyMce');
        $('textarea[name="PS_AGE_CHECKER_CUSTOM_MSG_'+ idLang +'"]').addClass('loadTinyMce');
        $('textarea[name="PS_AGE_CHECKER_DENY_MSG_'+ idLang +'"]').addClass('loadTinyMce');

        tinySetup({
            height: 100,
            editor_selector : 'loadTinyMce',
            plugins : 'code advlist autolink link lists charmap print textcolor colorpicker style',
        });

    };

    function onClickBody(event) {
        if (!$(event.target).is('li')) {
            $('#resultProducts').addClass('hide');
        }
    }

    $(document)
        .on('mouseenter', '#PopupDisplaySelectProducts ul#resultProducts li', onMouseEnterPopupDisplaySelectProduct)
        .on('mouseleave', '#PopupDisplaySelectProducts ul#resultProducts li', onMouseLeavePopupDisplaySelectProduct)
        .on('click', '#PopupDisplaySelectProducts ul#resultProducts li', onClickPopupDisplaySelectProduct)
        .on('click', '#PopupDisplaySelectProducts #selectedProducts td i', onClickPopupDisplayUnselectProduct)
        .on('click', '#PS_AGE_CHECKER_SHOW_POPUP .translatable-field ul.dropdown-menu', onClickTranslatableDropdownMenu)
        .on('click', 'body', onClickBody)
        .on('change', '.PopupDisplaySelector', onChangePopupDisplaySelector);

    // throttle fuck up context/scope
    $(document).on('keyup', '#PopupDisplaySelectProducts input[type="text"]', throttle(function(event) {
        var $inputText = $('#PopupDisplaySelectProducts input[type="text"]');
        if ($inputText.val().length > 2) {
            $.ajax({
                type: 'GET',
                url: AjaxPsAgeCheckerController,
                data: {
                    ajax: true,
                    action: 'GetProductsByNameLike',
                    searchTerm: $inputText.val()
                },
                success: function(response) {
                    var html = '',
                    products = JSON.parse(response);

                    $('#PopupDisplaySelectProducts ul#resultProducts').empty();

                    if (Array.isArray(products)) {
                        products.forEach(product => {
                            html += '<li id="'+ product.id_product +'"><img class="img-thumbnail" src="'+ product.imgLink +'"> '+ product.name +'</li>';
                        });
                        $('#resultProducts').removeClass('hide');
                    } else {
                        html = '<li>No products found for '+ $('#PopupDisplaySelectProducts input[type="text"]').val() +'</li>';
                    }

                    $('#PopupDisplaySelectProducts ul#resultProducts').append(html);
                },
                error: function(err) {
                    showErrorMessage(tradSmthWrongHappenedTryAgain);
                }
            });
        }
    }, 1000));

    if (!$('#PopupDisplaySelectCategories').hasClass('hide')) {
        $.ajax({
            type: 'GET',
            url: AjaxPsAgeCheckerController,
            data: {
                ajax: true,
                action: 'GetCategories',
            },
            success: handleSuccessGetCategories,
            error: function(err) {
                showErrorMessage(tradSmthWrongHappenedTryAgain);
            }
        });
    }
});
