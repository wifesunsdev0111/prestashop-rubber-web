<?php
/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
class Ets_ttn_paggination_class {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
    public $text_first = '';
    public $text_last = '';
    public $text_next = '';
    public $text_prev = '';
	public $style_links = 'links';
	public $style_results = 'results';
    public $alias;
    public $friendly;
    public $name;
    public function __construct()
    {
        $this->alias = false;
        $this->friendly = false;
        $this->text_first = Module::getInstanceByName('ets_testimonial')->displayText('|&lt;','span','');
        $this->text_last = Module::getInstanceByName('ets_testimonial')->displayText('&gt;|','span','');
        $this->text_next = Module::getInstanceByName('ets_testimonial')->displayText('&gt;','span','');
        $this->text_prev = Module::getInstanceByName('ets_testimonial')->displayText('&lt;','span','');
    }
	public function render() {
	    
		$total = $this->total;
		if($total<=1)
            return false;
		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		
		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}
		
		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		
		if ($page > 1) {
            $output .= Module::getInstanceByName('ets_testimonial')->displayText($this->text_first,'a','frist','',$this->replacePage(1)).Module::getInstanceByName('ets_testimonial')->displayText($this->text_prev,'a','prev','',$this->replacePage($page-1));
        }

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 1) {
				$output .= Module::getInstanceByName('ets_testimonial')->displayText(' .... ','p','paginration_vv');
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
                    $output .= Module::getInstanceByName('ets_testimonial')->displayText($i,'b','');
				} else {
                    $output .= Module::getInstanceByName('ets_testimonial')->displayText($i,'a','','',$this->replacePage($i));
				}	
			}
							
			if ($end < $num_pages) {
				$output .= Module::getInstanceByName('ets_testimonial')->displayText(' .... ','p','paginration_vv');
			}
		}
		
   		if ($page < $num_pages) {
            $output .= Module::getInstanceByName('ets_testimonial')->displayText($this->text_next,'a','next','',$this->replacePage($page+1)).Module::getInstanceByName('ets_testimonial')->displayText($this->text_last,'a','last','', $this->replacePage($num_pages));
        }
		
		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);
		
		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total, 
			$num_pages
		);
		if($num_pages==1)
            $this->text= 'Showing {start} to {end} of {total} ({pages} Page)';
        return   Module::getInstanceByName('ets_testimonial')->displayText(str_replace($find, $replace, $this->text),'div',$this->style_results). Module::getInstanceByName('ets_testimonial')->displayPaggination($limit,$this->name).($output ? Module::getInstanceByName('ets_testimonial')->displayText($output,'div','links') : '');
    }
    public function replacePage($page)
    {
        $controller = Tools::getValue('controller');
        if(!Validate::isControllerName($controller))
            $controller='';
        if($limt = (int)Tools::getValue('paginator_'.$this->name.'_select_limit'))
            $extra ='&paginator_'.$this->name.'_select_limit='.$limt;
        else
            $extra ='';
        if($page > 1)
            return str_replace('_page_', $page, $this->url.$extra);
        elseif($this->friendly && $this->alias && $controller != 'AdminModules')
            return str_replace('/_page_', '', $this->url).$extra;
        else
            return str_replace('_page_', $page, $this->url).$extra;            
    }
}
?>