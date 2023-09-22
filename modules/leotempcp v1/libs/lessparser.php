<?php

/******************************************************
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

/**
 * This class uses parser less files in development folder and compile and export theme to css and put inside stylesheet of theme folder.
 * 
 * It supports tow option to export css
 * 	1) development mode: need configure target development directory and URL directory. It will compile and export file by file and not export in stylesheet folder of theme
 *  2) Compile mode: all less files are compiled and exported in stylesheet file of theme.
 *  
 * development directory structure:
 *  - developmemnt/
 *          less/
 * 				+ prestashop/
 * 				+ mixins/
 * 				+ prestashop/
 * 				+ vars/
 * 				- less files which import other less files inside it.
 *  theme directory structure :
 * 	- THEME_NAME:
 * 			 - css/ <- this folder is where store less files compiled.
 * 				       + rtl/
 * 					   + skin
 * 			  
 */
class LeoLessParser {

    /**
     * @var String $_themeDir;
     * 
     * @access private
     */
    private $_themeDir;

    /**
     * @var String $_lessDevDir;
     *
     * @access private
     */
    private $_themeCssDir;

    /**
     * @var String $_lessDevDir
     *
     * @access private
     */
    private $_developmentDir = null;

    /**
     * @var String $_lessDevDir
     * 
     * @access private
     */
    private $_themeLessDir = '';

    /**
     * @var Array $_css
     *
     * @access private
     */
    private $_lessDevTargetDir = '';

    /**
     * @var Array $_css
     *
     * @access private
     */
    private $_lessAppFolder = 'prestashop';

    /**
     * @var Array $_css;
     *
     * @access private
     */
    private $_css = array();

    /**
     * @var Array $_time;
     *
     * @access private
     */
    private $_lastTimeChanged = '';
    /**
     * @var url
     *
     * @access private
     */
    private $_lessDevURL = '';

    /**
     * @var url
     *
     * @access private
     */

    public function __construct($_developmentDir, $_themeDir, $lessDevURL, $url) {

        $this->_developmentDir = $_developmentDir;
        $this->_themeDir = $_themeDir;
        //edit it after done
        $this->_themeCssFolder = "css";
        $this->_themeLessDir = $this->_developmentDir . 'less/';
        $this->_lessDevURL   = $lessDevURL;

        //$this->_libsDir 		 = $this->_developmentDir . 'libs/';
        $this->_lastTimeChanged = $this->lastTimeChangedVars();
    }

    /**
     * compile less to css and export to stylesheet folder
     */
    public function compileLess() {
        require_once(_PS_MODULE_DIR_ . 'leotempcp/libs/lessc.inc.php');
        $lessTarget = $this->_themeDir . '/' . $this->_themeCssFolder . '/';

        /* import bootstrap framework */
        $files = glob($this->_themeLessDir . '*.less');

    
        if ($files) {
            $this->compile($files, $lessTarget); 
        }
        $skins = glob($this->_themeLessDir .$this->_lessAppFolder .'/skins/*', GLOB_ONLYDIR);


        if ($skins) {
            
            $tchanged = $this->_lastTimeChanged;

            foreach ($skins as $folder) {
                $dir = basename($folder);
                $target = $this->_themeDir . '/' . $this->_themeCssFolder . '/' . $dir . '/';

                if (!is_dir($target)) {
                    mkdir( $target, 0755 );
                }
                $files = glob($folder . '/*.less');

                $t = $this->getTimeChangedSkinVars( $dir );
                 $this->_lastTimeChanged = max( $this->_lastTimeChanged, $t );
                if ($files) {
                    $this->compile($files, $target);
                }
                $this->_lastTimeChanged = $tchanged;
            }
        }

        /* build bootstrap framework and others for rtl */
        $bootstrapLess = $this->_themeLessDir . $this->_lessAppFolder . '/rtl/bootstrap/bootstrap.less';
        $this->compileFile($bootstrapLess, $this->_themeDir . '/css/bootstrap-rtl.css');

        $files = glob($this->_themeLessDir . $this->_lessAppFolder .'/rtl/*.less');
        $target = $lessTarget.'rtl/';

        if (!is_dir($target)) {
            mkdir( $target, 0755 );
        }

        if ($files && is_dir($target)) {
            $this->compile($files, $target);
        }

        return true;
    }

    /**
     * compilte less
     */
    protected function compile($files, $target) {
        foreach ($files as $file) {
            $cssFile = str_replace(".less", ".css", basename($file));
            if( is_file($file) ) {
                //generate default file of prestashop
               
                if($cssFile=="default.css"){
                     $this->_rcomplie( $file, $this->_themeLessDir, $target, 0, false );
                }else {

                    $this->compileFile($file, $target . $cssFile);
                }
            }
        }
    }

    /**
     * set configure path and url using for development mode.
     */
    public function setDevelopmentMode($_lessDevTargetDir) {
        $this->_lessDevTargetDir = $_lessDevTargetDir;
        return $this;
    }

    public function setLastTimeChanged( $time ){
        $this->_lastTimeChanged = $time;
        return $this;
    }
    
    public function compileBootstrap( $direction= '' ){
        if ($direction == 'rtl') {
            $bootstrapLess = $this->_themeLessDir . $this->_lessAppFolder . '/rtl/bootstrap/bootstrap.less';
            $this->compileFile($bootstrapLess,  $this->_themeDir . '/css/bootstrap-rtl.css' );
        } else {    
            $this->compileFile($this->_themeLessDir . 'bootstrap.less',  $this->_themeDir . '/css/bootstrap.css' );
        }    
    }

    public function getPageCssFiles(){

    }

    /**
     * enable development mode to compile less file.
     */
    public function compileLessDevelopment($skin = null, $direction = 'ltr') {

        require_once(_PS_MODULE_DIR_ . 'leotempcp/libs/lessc.inc.php');
        $lessTarget = $this->_lessDevTargetDir;
        $lessDir = ($skin != "default") ? $this->_themeLessDir . $this->_lessAppFolder . '/skins/' . $skin . '/' : $this->_themeLessDir;
		
        if( ($skin != "default") ){
            $t = $this->getTimeChangedSkinVars( $skin );
            $this->_lastTimeChanged = max( $this->_lastTimeChanged, $t );
        }
		//echo "<pre>".print_r($direction,1);die;
        $this->compileBootstrap( $direction );

        $files = glob($lessDir . '*.less');

        if ($files) {

            foreach ($files as $file) {
                $filename = basename($file);

                $cssFile = str_replace(".less", "-less.css", $filename);

                if ($filename == 'bootstrap.less') {
                    continue;
                } else {
                    $this->_rcomplie($file, $lessDir, $lessTarget);
                }
            }
        }


        if ($direction == 'rtl') {

            $files = glob($this->_themeLessDir . $this->_lessAppFolder . '/rtl/*.less');
            if ($files) {
                foreach ($files as $file) {
                    $filename = basename($file);
                    $cssFile = str_replace(".less", "-less.css", $filename);
                    $this->compileFile($file, $lessTarget . $cssFile);
                    $this->addCss($this->_lessDevURL . $cssFile);
                }
            }
        }
        return $this->_css;
    }

    /*
     * add css to collection.
     */

    protected function addCss($file) {
        $this->_css[] = $file;
    }

    /**
     *
     */
    protected function _rcomplie($file, $lessDir, $lessTarget, $cacheSave = 0, $replaceURL=true) {
        global $current_css_file;
        $less = new lessc();
        $content = Tools::file_get_contents($file);
        $limit  = Media::getBackTrackLimit();
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);

        preg_match_all('#^\s*@import\s+"([^"]*)"#im', $content, $matches);

        if (isset($matches[1]) && ($lessFiles = $matches[1])) {
            $mixs = '';
            $vars = '';
            $lastTime = '';

            foreach ($lessFiles as $lessFile) {
                if (preg_match("#mixins#", $lessFile)) {
                    $content = Tools::file_get_contents($lessDir . $lessFile);
                    $mixs .= $content;
                }
                if (preg_match("#vars#", $lessFile)) {
                    $content = Tools::file_get_contents($lessDir . $lessFile);
                    $vars .= $content;
                }
            }

            $mixvars = $mixs . "\r\n" . $vars;


            foreach ($lessFiles as $lessFile) {

                if (preg_match("#mixins#", $lessFile)) {
                    continue;
                }
                if (!preg_match("#vars#", $lessFile)) {
                  
                  
                    $cssFile  = str_replace(".less", ".css", $lessFile);
                    $cssFile  = str_replace($this->_lessAppFolder."/", "", $cssFile);
                    $cssFile = str_replace("../", "", $cssFile);


                    $current_css_file = _THEME_CSS_DIR_.$cssFile;

                    //replace image url
                    $isChange = true;
                    /* check this file have any changes based on file time */

                    if ($this->hasChange($lessDir . $lessFile, $lessTarget . $cssFile)) {  
                        $content = Tools::file_get_contents($lessDir . $lessFile);
                        $out = $less->compile($mixvars . "\r\n" . $content);
                        if( $replaceURL ) {
                            $out = preg_replace_callback('#(url\((?!data:)(?:\'|")?)([^\)\'"]*(?:\'|")?\))#s', array('Tools', 'replaceByAbsoluteURL'), $out, $limit);
                            $out = preg_replace_callback('#(AlphaImageLoader\(src=\')([^\']*\',)#s', array('Tools', 'replaceByAbsoluteURL'), $out);
                        } 
                        file_put_contents( $lessTarget . str_replace("/","-",$cssFile), $out);
                    }

                    $this->addCss( $this->_lessDevURL . $cssFile );
                }
            }/* end foreach */
        }
    }


    /**
     * compile less to css and save cache.
     */
    public function compileFile($sfile, $tfile) {

        if ($this->hasChange($sfile, $tfile)) {
        
            $less = new lessc(); 
            $less->compileFile($sfile, $tfile);   
        }
    }

    /**
     * check source files and target files having changes based on file time.
     */
    public function hasChange($sfile, $tfile) {

        if (!file_exists($sfile) || !file_exists($tfile)) {
            return true;
        } else if ($this->_lastTimeChanged > filemtime($tfile)) {
            return true;
        }
        return filemtime($sfile) > filemtime($tfile);
    }

    /**
     *
     */
    public function getTimeChangedSkinVars( $skin ){
        $tmp = array();
        $files = glob( $this->_themeLessDir . 'prestashop/skins/'.$skin.'/vars/*.less');
        if ($files) {
            $tmp = array_merge_recursive($tmp, $files);
        }
     
        $files = glob($this->_themeLessDir . 'prestashop/'.$skin.'/mixins/*.less');
       
        if ($files) {
            $tmp = array_merge_recursive($tmp, $files);
        }
        $t = 0; 
        if( $tmp ) {
            $t = filemtime($tmp[0]);
            foreach ($tmp as $file) {
                $t = max($t, filemtime($file));
            }
        }    
        return $t;
    }
    
    /**
     *
     */
    public function lastTimeChangedVars() {
        $tmp = array();
        $files = glob( $this->_themeLessDir . 'vars/*.less');
        if ($files) {
            $tmp = array_merge_recursive($tmp, $files);
        }
        $files = glob($this->_themeLessDir . 'mixins/*.less');
        if ($files) {
            $tmp = array_merge_recursive($tmp, $files);
        }

        $t = filemtime($tmp[0]);
        foreach ($tmp as $file) {
            $t = max($t, filemtime($file));
        }

        return $t;
    }
}

?>