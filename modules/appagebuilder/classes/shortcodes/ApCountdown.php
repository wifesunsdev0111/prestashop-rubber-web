<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class ApCountdown extends ApShortCodeBase
{
    public $name = 'ApCountdown';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array(
            'label' => $this->l('Countdown'),
            'position' => 3,
            'desc' => $this->l('Show a __________________'),
            'icon_class' => 'icon-picture', 'tag' => 'content slider'
        );
    }

    public function getConfigList()
    {
        $html_content = " 
					
<style rel='stylesheet' type='text/css'>
.ui-datepicker.ui-widget-content{
	border: 1px solid #aaaaaa/*{borderColorContent}*/;
	background: #ffffff/*{bgColorContent}*/;
	color: #222222/*{fcContent}*/;
}
.ui-slider.ui-widget-content{
	border: 1px solid #aaaaaa/*{borderColorContent}*/;
}
</style>


<script>
			$('.datepicker').datetimepicker({
				prevText: '',
				nextText: '',
				dateFormat: 'yy-mm-dd',
				// Define a custom regional settings in order to use PrestaShop translation tools
				currentText: 'Now',
				closeText: 'Done',
				ampm: false,
				amNames: ['AM', 'A'],
				pmNames: ['PM', 'P'],
				timeFormat: 'hh:mm:ss tt',
				timeSuffix: '',
				timeOnlyTitle: 'Choose Time',
				timeText: 'Time',
				hourText: 'Hour',
				minuteText: 'Minute'
			});
</script>

				 ";

        $input = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'class',
                'label' => $this->l('Class'),
                'desc' => $this->l('css class cover the slider, example: container, container-fluid,...'),
                'default' => 'container'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Time From'),
                'name' => 'time_from',
                'class' => 'datepicker',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Time To'),
                'name' => 'time_to',
                'default' => '',
                'class' => 'datepicker',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Open new tab'),
                'desc' => $this->l('Open new tab when click to link in slider'),
                'name' => 'new_tab',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
            ),
            array(
                'type' => 'text',
                'name' => 'link_label',
                'label' => $this->l('Link Label'),
                'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'link',
                'label' => $this->l('Link'),
                'lang' => 'true',
                'default' => '',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row link-slide',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => $html_content,
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Widget Description'),
                'name' => 'description',
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'lang' => true,
                'default' => '',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row description-slide',
            ),
        );
        return $input;
    }

    public function getListGroup($list)
    {

        $result = array();
        foreach ($list as $item) {
            $status = ' ('.($item['active'] ? $this->l('Active') : $this->l('Deactive')).')';
            $result[] = array('id' => $item['id_leoslideshow_groups'], 'name' => $item['title'].$status);
        }
        return $result;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);

        $from = strtotime($assign['formAtts']['time_from']);
        $now = time();
        $end = strtotime($assign['formAtts']['time_to']);

        if (($from <= $now) && ($now < $end)) {
            $start = true;
        } else {
            $start = false;
        }

        if ($start) {
            # RUNNING
            $assign['formAtts']['time_to'] = str_replace('-', '/', $assign['formAtts']['time_to']);
            $assign['formAtts']['active'] = 1;

            # LOAD JS
            $leo_customajax_count = Configuration::get('APPAGEBUILDER_LOAD_COUNT');
            $leo_load_ajax = Configuration::get('APPAGEBUILDER_LOAD_AJAX');
            if (!$leo_load_ajax || !$leo_customajax_count) {
                //Tools::addJS(__PS_BASE_URI__.'modules/appagebuilder/views/js/countdown.js'); # NOT WORK
                $assign['formAtts']['addJS'] = 1;
                $assign['formAtts']['countdown'] = __PS_BASE_URI__.'modules/appagebuilder/views/js/countdown.js';
            }
        } else {
            # QUEUED
            $assign['formAtts']['active'] = 0;
        }

        return $assign;
    }
}
