<?php
/**
* 2007-2017 PrestaShop.
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
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class BablicSDK
{
    public $site_id = '';
    private $save_flag = true;
    private $done = false;
    private $subdir = false;
    private $subdir_base = '';
    private $url = '';
    private $nocache = false;
    public $access_token = '';
    private $channel_id = '';
    private $version = '';
    private $snippet = '';
    private $meta = '';
    public $trial_started = false;
    private $_body = '';
    private $pos = 0;
    private $timestamp = 0;
    private $use_snippet_url = false;
    private $folders = array();
    public function __construct($options)
    {
        if (empty($options['channel_id'])) {
            $options['channel_id'] = 'php';
        }
        $this->channel_id = $options['channel_id'];
        if (!empty($options['store'])) {
            $this->store = $options['store'];
        }
        if ($this->store->get('site_id') != '') {
            $this->getDataFromStore();
        }
        if (!empty($options['site_id'])) {
            $this->site_id = $options['site_id'];
            if ($this->store->get('site_id') != $this->site_id) {
                $this->getSiteFromBablic();
            }
        }
        if ($this->site_id) {
            try {
                header('x-bablic-id: '.$this->site_id);
            } catch (Exception $e) {
            }
        }
        if ($this->site_id && (empty($this->timestamp) || ((time() - $this->timestamp) > 12000))) {
            $this->timestamp = time();
            $this->getSiteFromBablic();
        }
        if (!empty($options['subdir']) && $this->meta) {
            $meta = Tools::jsonDecode($this->meta, true);
            $locale_keys = $meta['localeKeys'];
            if (count($locale_keys) > 0) {
                $this->subdir = $options['subdir'];
                if (!empty($options['subdir_base'])) {
                    $this->subdir_base = $options['subdir_base'];
                }
            }
        }
        if (isset($options['use_snippet_url'])) {
            $this->use_snippet_url = true;
        }
        if (!empty($options['folders'])) {
            $this->folders = $options['folders'];
        }
    }

    private function getFolder($locale)
    {
        foreach ($this->folders as $folder => $l) {
            if ($l == $locale) {
                return $folder;
            }
        }
        $locale = Tools::substr($locale, 0, 2);
        foreach ($this->folders as $folder => $l) {
            if (Tools::substr($l, 0, 2) == $locale) {
                return $folder;
            }
        }

        return '';
    }

    private function getLocaleFromFolder($folderLocale, $locales)
    {
        foreach ($locales as $l) {
            if ($l == $folderLocale) {
                return $l;
            }
        }
        $folderLocale = Tools::substr($folderLocale, 0, 2);
        foreach ($locales as $l) {
            if (Tools::substr($l, 0, 2) == $folderLocale) {
                return $l;
            }
        }

        return $folderLocale;
    }

    private function saveDataToStore()
    {
        $this->store->set('meta', $this->meta);
        $this->store->set('access_token', $this->access_token);
        $this->store->set('version', $this->version);
        $this->store->set('trial_started', $this->trial_started ? '1' : '');
        $this->store->set('snippet', $this->snippet);
        $this->store->set('site_id', $this->site_id);
        $this->store->set('time', $this->timestamp);
    }
    public function clearData()
    {
        $this->site_id = '';
        $this->version = '';
        $this->trial_started = false;
        $this->snippet = '';
        $this->meta = '';
        $this->access_token = '';
        $this->saveDataToStore();
    }
    private function getDataFromStore()
    {
        $this->site_id = $this->store->get('site_id');
        $this->version = $this->store->get('version');
        $this->trial_started = $this->store->get('trial_started') == '1';
        $this->meta = $this->store->get('meta');
        $this->snippet = $this->store->get('snippet');
        $this->access_token = $this->store->get('access_token');
        $this->timestamp = $this->store->get('time');
    }
    public function setSite($site, $callback = '')
    {
        if (empty($site['id'])) {
            die('No site id');
        }
        $this->site_id = $site['id'];
        if ($this->access_token == '') {
            $this->access_token = isset($site['access_token']) ? $site['access_token'] : '';
        }
        $this->getSiteFromBablic();
        if ($callback == '') {
            return;
        }
        $url = 'https://www.bablic.com/api/v1/site/'.$site['id']."?access_token=$this->access_token&channel_id=$this->channel_id";
        $payload = array(
            'callback' => $callback,
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-HTTP-Method-Override:PUT', 'Expect:'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Tools::jsonEncode($payload));
        $result = curl_exec($ch);
        $result = Tools::jsonDecode($result, true);
        if (!empty($result['error'])) {
            return array('error' => 'Bablic returned error');
        }
    }
    public function createSite($options)
    {
        $url = "https://www.bablic.com/api/v1/site?channel_id=$this->channel_id";
        $payload = array(
            'url' => $options['site_url'],
            'email' => isset($options['email']) ? $options['email'] : '',
            'original' => isset($options['original_locale']) ? $options['original_locale'] : '',
            'callback' => isset($options['callback']) ? $options['callback'] : '',
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'Expect:'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Tools::jsonEncode($payload));
        $result = curl_exec($ch);
        $result = Tools::jsonDecode($result, true);
        if (!empty($result['error'])) {
            return array('error' => 'Bablic returned error');
        }
        $this->access_token = $result['access_token'];
        $this->site_id = $result['id'];
        $this->snippet = $result['snippetURL'];
        $this->version = $result['version'];
        $this->trial_started = false;
        $this->meta = Tools::jsonEncode($result['meta']);
        $this->saveDataToStore();
    }
    public function getSiteFromBablic()
    {
        $url = "https://www.bablic.com/api/v1/site/$this->site_id?access_token=$this->access_token&channel_id=$this->channel_id";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = Tools::jsonDecode($result, true);
        if (!empty($result['error'])) {
            if (!empty($result['error']['code']) && $result['error']['code'] == 410) {
                $this->clearData();
                $this->saveDataToStore();

                return array('error' => 'Site removed');
            }

            return array('error' => 'Bablic returned error');
        }
        if (!empty($result['access_token'])) {
            $this->access_token = $result['access_token'];
        }
        $this->site_id = $result['id'];
        $this->snippet = $result['snippetURL'];
        $this->version = $result['version'];
        $this->trial_started = $result['trialStarted'];
        $this->meta = Tools::jsonEncode($result['meta']);
        $this->timestamp = time();
        $this->saveDataToStore();
    }
    public function refreshSite()
    {
        $this->getSiteFromBablic();
    }
    public function clearCache()
    {
        $tmp_dir = sys_get_temp_dir();
        $folder = "$tmp_dir/bablic_cache";
        if (!file_exists($folder)) {
            return;
        }
        array_map('unlink', glob("$folder/*"));
    }
    public function getMeta()
    {
        return $this->meta;
    }
    public function getSite()
    {
        return array(
            'meta' => $this->meta,
            'access_token' => $this->access_token,
            'site_id' => $this->site_id,
            'version' => $this->version,
            'trial_started' => $this->trial_started,
            'snippet' => $this->snippet,
        );
    }

    public function getSnippet()
    {
        $locale = $this->getLocale();

        return $this->snippet;
    }

    public function getAltTags()
    {
        $meta = Tools::jsonDecode($this->meta, true);
        $locale_keys = $meta['localeKeys'];
        $locale = $this->getLocale();
        $url = $_SERVER['REQUEST_URI'];
        $str = '';
        $res = array();
        if (is_array($locale_keys)) {
            foreach ($locale_keys as $alt) {
                if ($alt != $locale) {
                    $parts = explode('_', $alt);
                    $iso = sizeof($parts) > 1 ? $parts[0].'-'.Tools::strtoupper($parts[1]) : $parts[0];
                    array_push($res, array($this->getLink($alt, $url), $iso));
                }
            }
            if ($locale != $meta['original']) {
                array_push($res, array($this->getLink($meta['original'], $url), 'x-default'));
            }
        }

        return $res;
    }
    private function getAllHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (Tools::substr($key, 0, 5) != 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', Tools::strtolower(Tools::substr($key, 5)))));
            $headers[$header] = $value;
        }

        return $headers;
    }
    public function detectLocaleFromHeader()
    {
        $headers = $this->getAllHeaders();
        if (!isset($headers['Accept-Language'])) {
            return false;
        }
        $lang = explode(',', $headers['Accept-Language']);
        if (!empty($lang)) {
            return $lang[0];
        }

        return false;
    }
    public function detectLocaleFromCookie($allowed_keys)
    {
        if (!empty($_COOKIE) && !empty($_COOKIE['bab_locale']) && !empty($allowed_keys)) {
            $cookie_locale = $_COOKIE['bab_locale'];
            $match = false;
            foreach ($allowed_keys as &$value) {
                if ($value === $cookie_locale) {
                    $match = true;
                }
                if (!$match) {
                    if (Tools::substr($value, 0, 2) === Tools::substr($cookie_locale, 0, 2)) {
                        $match = true;
                    }
                }
            }
            if ($match) {
                return $cookie_locale;
            }
        }

        return false;
    }
    public function getLink($locale, $url)
    {
        if ($url[0] != '/' && $url[0] != 'h') {
            return $url;
        }
        $parsed = parse_url($url);
        $scheme = isset($parsed['scheme']) ? $parsed['scheme'].'://' : '';
        $host = isset($parsed['host']) ? $parsed['host'] : '';
        $port = isset($parsed['port']) ? ':'.$parsed['port'] : '';
        $path = isset($parsed['path']) ? $parsed['path'] : '/';
        $query = isset($parsed['query']) ? '?'.$parsed['query'] : '';
        $fragment = isset($parsed['fragment']) ? '#'.$parsed['fragment'] : '';
        $meta = Tools::jsonDecode($this->meta, true);
        $link = 'javascript:void(0);';
        $localeDetection = $meta['localeDetection'];
        if ($this->subdir) {
            $localeDetection = 'subdir';
        }
        if ($localeDetection == 'custom' && empty($meta['customUrls'])) {
            $localeDetection = 'querystring';
        }
        switch ($localeDetection) {
            case 'custom':
                $custom_url = $meta['customUrls'][$locale];
                if ($custom_url) {
                    $scheme = $scheme == '' ? 'http://' : $scheme;
                    if (strpos($custom_url, '/') !== false) {
                        // custom contains querystring
                        if (strpos($custom_url, '?') !== false) {
                            return $scheme.$custom_url.$fragment;
                        }
                        // custom contains path
                        return $scheme.$custom_url.$query.$fragment;
                    }
                    // custom is only domain
                    return $scheme.$custom_url.$path.$query.$fragment;
                }
                break;
            case 'querystring':
                $query_locale = '';
                if (!isset($parsed['query'])) {
                    return $scheme.$host.$port.$path.'?locale='.$locale.$fragment;
                }
                $output = array();
                parse_str(Tools::substr($query, 1), $output);
                $output['locale'] = $locale;
                $query = http_build_query($output);

                return $scheme.$host.$port.$path.'?'.$query.$fragment;
            case 'subdir':
                if ($this->subdir_base != '') {
                    $path = preg_replace('/^'.preg_quote($this->subdir_base, '/').'\//', '/', $path);
                }
                $folder_keys = array_keys($this->folders);
                $prefix = '';
                if (sizeof($folder_keys) > 0) {
                    $prefix = '/'.$this->getFolder($locale);
                    $locale_keys = $folder_keys;
                } else {
                    $locale_keys = $meta['localeKeys'];
                    if ($locale != $meta['original']) {
                        $prefix = '/'.$locale;
                    }
                }
                $locale_regex = '('.implode('|', $locale_keys).')';
                $path = preg_replace('/^\/?'.$locale_regex.'\//', '/', $path);

                return $scheme.$host.$port.$this->subdir_base.$prefix.$path.$query.$fragment;
            case 'hash':
                $fragment = '#locale_'.$locale;

                return $scheme.$host.$port.$path.$query.$fragment;
        }

        return $url;
    }
    public function getOriginal()
    {
        if ($this->meta == '') {
            return null;
        }
        $meta = Tools::jsonDecode($this->meta, true);

        return $meta['original'];
    }
    public function getLocales()
    {
        if ($this->meta == '') {
            return array();
        }
        $meta = Tools::jsonDecode($this->meta, true);

        return $meta['localeKeys'];
    }
    public function getLocale()
    {
        if (!empty($_SERVER['HTTP_BABLIC_LOCALE'])) {
            return $_SERVER['HTTP_BABLIC_LOCALE'];
        }
        if ($this->meta == '') {
            return '';
        }
        $meta = Tools::jsonDecode($this->meta, true);
        $auto = $meta['autoDetect'];
        $default = $meta['default'];
        $custom_urls = $meta['customUrls'];
        $locale_keys = $meta['localeKeys'];
        $locale_detection = $meta['localeDetection'];
        if ($this->subdir) {
            $locale_detection = 'subdir';
        }
        $detected = '';
        if ($auto && !empty($locale_keys)) {
            $detected_lang = $this->detectLocaleFromHeader();
            $normalized_lang = Tools::strtolower(str_replace('-', '_', $detected_lang));
            foreach ($locale_keys as &$value) {
                if ($value === $normalized_lang) {
                    $detected = $value;
                    break;
                }
                if (Tools::substr($value, 0, 2) === Tools::substr($normalized_lang, 0, 2)) {
                    $detected = $value;
                    break;
                }
            }
        }
        $from_cookie = $this->detectLocaleFromCookie($locale_keys);
        $parsed_url = parse_url($this->getCurrentUrl());
        switch ($locale_detection) {
            case 'querystring':
                $tl = Tools::getValue('locale');
                if (!empty($tl)) {
                    return Tools::getValue('locale');
                } elseif ($from_cookie) {
                    return $from_cookie;
                } elseif ($detected) {
                    return $detected;
                }

                return $default;
            case 'subdir':
                $path = $parsed_url['path'];
                preg_match('/^(?:'.preg_quote($this->subdir_base, '/').")?(\/(\w\w(_\w\w)?))(?:\/|$)/", $path, $matches);
                if ($matches) {
                    if (!empty($this->folders[$matches[2]])) {
                        $folder = $this->folders[$matches[2]];
                        array_push($locale_keys, $meta['original']);

                        return $this->getLocaleFromFolder($folder, $locale_keys);
                    }

                    return $matches[2];
                }
                if ($from_cookie) {
                    return $default;
                }
                if ($detected) {
                    return $detected;
                }

                return $default;
            case 'custom':
                foreach ($custom_urls as &$value) {
                    $pattern = $this->createDomainRegex($value);
                    if (preg_match($pattern, $parsed_url['host'], $matches)) {
                        return $value;
                    }
                }

                return $default;
            default:
                return $from_cookie;
        }

        return;
    }
    private function createDomainRegex($str)
    {
        $new_str = preg_replace("/([.?+^$[\]\\(){}|-])/g", '\$1', $str);

        return preg_replace("/\*/g", '.*', $new_str);
    }
    public function editorUrl()
    {
        return "https://www.bablic.com/channels/editor?site=$this->site_id&access_token=$this->access_token";
    }
    public function removeSite()
    {
        $url = "https://www.bablic.com/api/v1/site/$this->site_id?access_token=$this->access_token&channel_id=$this->channel_id";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->clearData();
        curl_close($ch);
    }
    public function handleRequest($options = array())
    {
        if ($this->site_id == '') {
            return;
        }
        if (($this->isBot() == false) && (empty($options['debug']) || $options['debug'] == false)) {
            return;
        }
        if (!empty($options['url'])) {
            $this->url = $options['url'];
        } else {
            $this->url = $this->getCurrentUrl();
        }
        if (!empty($options['nocache']) && $options['nocache'] == true) {
            $this->nocache = true;
        }
        if ($this->meta) {
            $meta = Tools::jsonDecode($this->meta, true);
            $default = $meta['default'];
            $locale = $this->getLocale();
            if ($default == $locale) {
                return;
            }
            $this->getHtmlForUrl($this->url);
        } else {
            $this->getHtmlForUrl($this->url);
        }
    }
    private function isBot()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $is_bot = '/bot|crawler|baiduspider|80legs|google|facebook|twitter|seo/i';
        if (preg_match($is_bot, $_SERVER['HTTP_USER_AGENT'], $matches)) {
            return true;
        }

        return false;
    }
    private function getCurrentUrl()
    {
        $protocol = 'http';
        if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
            $protocol .= 's';
        }
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];

        return "$protocol://$host$uri";
    }
    public function ignorable($url)
    {
        $filename_tester = "/\.(js|css|jpg|jpeg|png|mp3|avi|mpeg|bmp|wav|pdf|doc|xml|docx|xlsx|xls|json|kml|svg|eot|woff|woff2)/";

        return preg_match($filename_tester, $url, $matches);
    }
    public function processBuffer($buffer)
    {
        $headers = headers_list();
        $rcode = 200;
        if (function_exists('http_response_code')) {
            $rcode = http_response_code();
        } else {
            $rcode = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }
        if ($rcode < 200 || $rcode >= 300) {
            return false;
        }
        if ($this->ignorable($this->getCurrentUrl())) {
            return false;
        }
        foreach ($headers as &$value) {
            $html_found = 0;
            $contenttype_found = 0;
            $html_found = strpos($value, 'text/html;');
            $contenttype_found = strpos($value, 'Content-Type');
            if ($html_found === false) {
                // do nothing
            } else {
                break;
            }
        }
        if (($html_found === false) && ($contenttype_found === 0)) {
            return false;
        }
        $html = ob_get_contents();
        $url = $this->url;
        $response = $this->sendToBablic($url, $html);

        return $response;
    }
    private function filenameFromUrl($url)
    {
        return md5($url);
    }
    private function fullPathFromUrl($url)
    {
        $tmp_dir = sys_get_temp_dir();
        $folder = "$tmp_dir/bablic_cache";
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $filename = $this->filenameFromUrl($url);

        return "$folder/$filename";
    }
    public function writeBuffer($ch, $fp, $len)
    {
        $data = Tools::substr($this->_body, $this->pos, $len);
        // increment $pos
        $this->pos += Tools::strlen($data);
        // return the data to send in the request
        return $data;
    }
    private function sendToBablic($url, $html)
    {
        $bablic_url = "http://seo.bablic.com/api/engine/seo?site=$this->site_id&url=".urlencode($url).($this->subdir ? '&ld=subdir' : '').($this->subdir_base ? '&sdb='.urlencode($this->subdir_base) : '');
        $bablic_url .= '&folders='.urlencode(Tools::jsonEncode($this->folders));
        $curl = curl_init($bablic_url);
        $length = Tools::strlen($html);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: text/html', "Content-Length: $length", 'Expect:'));
        curl_setopt($curl, CURLOPT_POST, true);
        $this->_body = $html;
        $this->pos = 0;
        curl_setopt($curl, CURLOPT_READFUNCTION, array(&$this, 'writeBuffer'));
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (($status != 200) && ($status != 301)) {
            return $html;
        }
        curl_close($curl);
        $this->saveHtml($response, $this->fullPathFromUrl($url));

        return $response;
    }
    private function saveHtml($content, $filename)
    {
        $file = fopen($filename, 'w') or die('Unable to open file!');
        fwrite($file, $content);
        fclose($file);
    }
    public function noop()
    {
        return '';
    }
    public function getHtmlForUrl($url)
    {
        $cached_file = $this->readFromCache($this->fullPathFromUrl($url));
        if ($cached_file) {
            exit;

            return;
        }
        ob_start(array(&$this, 'processBuffer'));

        return;
    }
    private function readFromCache($filename)
    {
        if ($this->nocache == true) {
            return false;
        }
        try {
            $html_file = file_exists($filename);
            if ($html_file) {
                $file_modified = filemtime($filename);
                $now = round(microtime(true) * 1000);
                $validity = ($now - (2 * 24 * 60 * 60 * 1000) > $file_modified);
                if ($validity === false) {
                    return false;
                }
                readfile($filename);

                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
