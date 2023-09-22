<?php
/**
 * @license   GNU General Public License version 2
 */

/**
 * 
 */
class PsBlogLink extends Link
{

    /**
     * Create a link to a module
     *
     * @since 1.5.0
     * @param string $module Module name
     * @param string $process Action name
     * @param int $id_lang
     * @return string
     * Get link of ROOT_BLOG "Show All"
     */
    public function getLink($route_id, $controller = 'default', array $params = array(), $ssl = null, $id_lang = null, $id_shop = null)
    {
        # validate module
        unset($controller);
        if (!$id_lang) {
            $id_lang = Context::getContext()->language->id;
        }
        $url = $this->getBaseLink($id_shop, $ssl).$this->getLangLink($id_lang, null, $id_shop);
        return $url.Dispatcher::getInstance()->createUrl($route_id, $id_lang, $params, $this->allow, '', $id_shop);
    }

    public function getPsblogLink($id_object, $controller, $params = array())
    {
        return $this->getLink($id_object, $controller, $params);
    }

    /**
     * Get pagination link
     *
     * @param string $type Controller name
     * @param int $id_object
     * @param boolean $nb Show nb element per page attribute
     * @param boolean $sort Show sort attribute
     * @param boolean $pagination Show page number attribute
     * @param boolean $array If false return an url, if true return an array
     */
    public function getPsPaginationLink($type, $id_object, $controller, $params, $nb = false, $sort = false, $pagination = false, $array = true)
    {
        // If no parameter $type, try to get it by using the controller name
        if (!$type && !$id_object) {
            $method_name = 'get'.Dispatcher::getInstance()->getController().'Link';
            if (method_exists($this, $method_name) && Tools::getValue( 'id_'.Dispatcher::getInstance()->getController() ) ) {
                $type = Dispatcher::getInstance()->getController();
                $id_object = Tools::getValue('id_'.$type);
            }
        }

        if ($type && $id_object) {
            $url = $this->{'get'.$type.'Link'}($id_object, $controller, $params);
        } else {
            if (isset(Context::getContext()->controller->php_self)) {
                $name = Context::getContext()->controller->php_self;
            } else {
                $name = Dispatcher::getInstance()->getController();
            }
            $url = $this->getPageLink($name);
        }

        $vars = array();
        $vars_nb = array('n', 'search_query');
        $vars_sort = array('orderby', 'orderway');
        $vars_pagination = array('p');

        $get = array();
        $get['isolang'] = Tools::getValue('isolang');
        $get['id_lang'] = Tools::getValue('id_lang');
        $get['id'] = Tools::getValue('id');
        $get['fc'] = Tools::getValue('fc');
        $get['module'] = Tools::getValue('module');
        $get['controller'] = Tools::getValue('controller');

        foreach ($get as $k => $value) {
            if ($k != 'id_'.$type && $k != 'controller') {
                if (Configuration::get('PS_REWRITING_SETTINGS') && ($k == 'isolang' || $k == 'id_lang')) {
                    continue;
                }
                $if_nb = (!$nb || ($nb && !in_array($k, $vars_nb)));
                $if_sort = (!$sort || ($sort && !in_array($k, $vars_sort)));
                $if_pagination = (!$pagination || ($pagination && !in_array($k, $vars_pagination)));
                if ($if_nb && $if_sort && $if_pagination) {
                    if (!is_array($value)) {
                        $vars[urlencode($k)] = $value;
                    } else {
                        foreach (explode('&', http_build_query(array($k => $value), '', '&')) as $val) {
                            $data = explode('=', $val);
                            $vars[urldecode($data[0])] = $data[1];
                        }
                    }
                }
            }
        }

        if (!$array) {
            if (count($vars)) {
                return $url.(($this->allow == 1 || $url == $this->url) ? '?' : '&').http_build_query($vars, '', '&');
            } else {
                return $url;
            }
        }

        $vars['requestUrl'] = $url;

        if ($type && $id_object) {
            $vars['id_'.$type] = (is_object($id_object) ? (int)$id_object->id : (int)$id_object);
        }

        if (!$this->allow == 1) {
            $vars['controller'] = Dispatcher::getInstance()->getController();
        }

        return $vars;
    }
}
