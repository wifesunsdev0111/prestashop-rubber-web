<?php
/**
 * @license   GNU General Public License version 2
 */

class PsBlogConfig
{
    public $params;
    public $cat_image_dir = '';
    /** @var int id_lang current language in for, while */
    public $cur_id_lang = '';
    /** @var int id_lang current language in for, while */
    public $cur_prefix_rewrite = '';

    public static function getInstance()
    {
        static $instance;
        if (!$instance) {
            # validate module
            $instance = new PsBlogConfig();
        }
        return $instance;
    }

    public function __construct()
    {
        $data = self::getConfigValue('cfg_global');

        if ($data && $tmp = unserialize($data)) {
            # validate module
            $this->params = $tmp;
        }
    }

    public function mergeParams($params)
    {
        # validate module
        unset($params);
    }

    public function setVar($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function get($name, $value = '')
    {
        if (isset($this->params[$name])) {
            # validate module
            return $this->params[$name];
        }
        return $value;
    }

    public static function getConfigName($name)
    {
        return Tools::strtoupper(_Ps_BLOG_PREFIX_.$name);
    }

    public static function updateConfigValue($name, $value = '')
    {
        Configuration::updateValue(self::getConfigName($name), $value, true);
    }

    public static function getConfigValue($name)
    {
        return Configuration::get(self::getConfigName($name));
    }
}
