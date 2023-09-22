<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class LeoFontHelper
{
    /**
     * @var Array $engines
     * 
     * @access protected
     */
    protected $engines = array();
    /**
     * @var Array $fonts
     * 
     * @access protected
     */
    protected $fonts = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initFonts();
    }

    /**
     * get instance of this object
     */
    public static function getInstance()
    {
        static $_instance;
        if (!$_instance) {
            $_instance = new LeoFontHelper();
        }
        return $_instance;
    }

    public function initFonts()
    {
        $this->engines = array(
            'local' => 'Local',
            'google' => 'Google'
        );

        $this->addFonts('local', array(
            array('Verdana, Geneva, sans-serif', 'Verdana'),
            array('Georgia, "Times New Roman", Times, serif', 'Georgia'),
            array('Arial, Helvetica, sans-serif', 'Arial'),
            array('Impact, Arial, Helvetica, sans-serif', 'Impact'),
            array('Tahoma, Geneva, sans-serif', 'Tahoma'),
            array('"Trebuchet MS", Arial, Helvetica, sans-serif', 'Trebuchet MS'),
            array('"Arial Black", Gadget, sans-serif', 'Arial Black'),
            array('Times, "Times New Roman", serif', 'Times'),
            array('"Palatino Linotype", "Book Antiqua", Palatino, serif', 'Palatino Linotype'),
            array('"Lucida Sans Unicode", "Lucida Grande", sans-serif', 'Lucida Sans Unicode'),
            array('"MS Serif", "New York", serif', 'MS Serif'),
            array('"Comic Sans MS", cursive', 'Comic Sans MS'),
            array('"Courier New", Courier, monospace', 'Courier New'),
            array('"Lucida Console", Monaco, monospace', 'Lucida Console')
                )
        );
    }

    public static function saveConfigs($field, $loop = 3)
    {
        
    }

    public static function getConfig()
    {
        
    }

    public function addEngines($engine, $text)
    {
        $this->engines[$engine] = $text;
    }

    public function getFontEngines()
    {
        return $this->engines;
    }

    public function getFontsByEngine($engine)
    {

        return isset($this->fonts[$engine]) ? $this->fonts[$engine] : array();
    }

    public function addFonts($engine, $fonts = array())
    {
        $this->fonts[$engine] = $fonts;
        return $this;
    }

    public function renderForm($field, $data)
    {
        if ($data) {
            $data = unserialize($data);
        }
        // echo '<pre>'.print_r( $data, 1 );die;
        $sengine = isset($data['engine']) ? $data['engine'] : "";

        $selectors = isset($data['selectors']) ? $data['selectors'] : "";
        $output = '<div class="margin-form form-fonts">';
        $output .= '<div class="group-fields">';
        $output .= '<div class="g-fields"><label>Font Engine</label>';
        $output .= '<select id="'.$field.'" name="'.$field.'[engine]"  class="font-engine">';
        $output .='<option value="">No Use</option>';
        foreach ($this->engines as $engine => $text) {
            $selected = '';

            if ($sengine == $engine) {
                $selected = 'selected="selected"';
            }
            $output .='<option '.$selected.' value="'.$engine.'">'.$text.'</option>';
        }
        $output .= '</select></div>';

        foreach ($this->engines as $engine => $text) {
            $output .= '<div id="'.$field.'_'.$engine.'" class="font-engine-setting">';

            $fonts = $this->getFontsByEngine($engine);
            $sfont = isset($data[$engine]['font']) ? $data[$engine]['font'] : "";
            $sfontlink = isset($data[$engine]['link']) ? $data[$engine]['link'] : "";

            if (is_array($fonts) && !empty($fonts)) {
                $output .= '<div class="g-fields"><label>Select Font</label>';
                $output .= '<select name="'.$field.'['.$engine.'][font]">';
                foreach ($fonts as $font) {
                    $selected = '';
                    if (htmlspecialchars($font[0]) == htmlspecialchars($sfont)) {
                        $selected = 'selected="selected"';
                    }
                    $output .= '<option '.$selected.' value="'.htmlspecialchars($font[0]).'">'.$font[1].'</option>';
                }
                $output .= '</select></div>';
            } else {
                $output .= '<div class="g-fields"><label>'.Tools::ucfirst($engine).' Font Link</label>';
                $output .= '<input name="'.$field.'['.$engine.'][link]" value="'.$sfontlink.'" style="width:400px; margin-bottom:12px">
								<p><i>Example: <b>http://fonts.googleapis.com/css?family=Cantora+One</b></i></p>
							</div>';
                $output .= '<div class="g-fields"><label>Font Family</label>';
                $output .= '<input name="'.$field.'['.$engine.'][font]" value="'.$sfont.'" style="width:400px; margin-bottom:12px">
										<p><i>Example: <b>\'Cantora One\', sans-serif</b></i></p>
							</div>';
            }
            $output .= '</div>';
        }


        $output .= '<div class="g-fields"><label>Selectors</label>';
        $output .= '<textarea name="'.$field.'[selectors]" cols="50" rows="5">'.$selectors.'</textarea>
					<p><i>Example: <b>body, h1,h2,h3, #yourstyle, .myrule div</b></i></p>
				</div>';
        $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    public static function renderTagHeader($field, $data)
    {
        $output = '';
        if ($data) {
            $data = unserialize($data);
            $engine = $data['engine'];
            if ($engine && $data['selectors'] && $data[$engine]['font']) {
                if (isset($data[$engine]['link']) && $data[$engine]['link']) {
                    $output = '<link rel="stylesheet" type="text/css" href="'.$data[$engine]['link'].'" media="screen" />';
                }
                $output .= '<style type="text/css">'.$data['selectors']." { font-family:".$data[$engine]['font']." } </style> ";
            }
        }
        return $output;
    }
}
