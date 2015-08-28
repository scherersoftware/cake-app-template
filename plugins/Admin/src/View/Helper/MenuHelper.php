<?php
namespace Admin\View\Helper;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\String;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Menu helper
 */
class MenuHelper extends Helper
{

    public $helpers = ['AuthActions.Auth'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'configKey' => 'menu',
        'templates' => [
            'icon' => '<i class="fa fa-:icon fa-fw"></i>',
            'item' => '<li class=":liclass"><a href=":href" class=":class">:icon :title :childrenArrow</a>:childrenContainer</li>',
            'childrenArrow' => '<span class="fa arrow"></span>',
            'childrenContainer' => '<ul class="nav nav-second-level">:children</ul>'
        ]
    ];

    /**
     * Holds the current URL as an array
     *
     * @var array
     */
    protected $_currentUrl;

    /**
     * Configures the instance
     *
     * @param View $View CakePHP View instance
     * @param array $config helper config
     */
    public function __construct(\Cake\View\View $View, array $config = [])
    {
        parent::__construct($View, $config);
        $this->_currentUrl = Router::parse(Router::url());
    }

    /**
     * Renders
     *
     * @param string|array $config Either the config file to load or the menu config as an array
     * @return string   rendered HTML
     */
    public function renderSidebarMenuItems($config)
    {
        $config = $this->prepareMenuConfig($config);
        $this->setPageTitle($config);
        $out = '';
        foreach ($config as $mainItem => $mainData) {
            $childrenContainer = '';

            if (!empty($mainData['children'])) {
                $children = '';
                foreach ($mainData['children'] as $child) {
                    $children .= String::insert($this->_defaultConfig['templates']['item'], [
                        'class' => $child['active'] ? 'active' : '',
                        'title' => $child['title'],
                        'icon' => isset($child['icon']) ? String::insert($this->_defaultConfig['templates']['icon'], ['icon' => $child['icon']]) : '',
                        'href' => isset($child['url']) ? Router::url($child['url']) : '',
                        'childrenArrow' => '',
                        'childrenContainer' => '',
                        'liclass' => ''
                    ]);
                }
                $childrenContainer = String::insert($this->_defaultConfig['templates']['childrenContainer'], [
                    'children' => $children
                ]);
            }
            $out .= String::insert($this->_defaultConfig['templates']['item'], [
                'class' => $mainData['active'] ? 'active' : '',
                'liclass' => $mainData['active'] ? 'active' : '',
                'title' => '<span class="mm-text">' . $mainData['title'] . '</span>',
                'icon' => isset($mainData['icon']) ? String::insert($this->_defaultConfig['templates']['icon'], ['icon' => $mainData['icon']]) : '',
                'href' => isset($mainData['url']) ? Router::url($mainData['url']) : '',
                'childrenArrow' => !empty($mainData['children']) ? $this->_defaultConfig['templates']['childrenArrow'] : '',
                'childrenContainer' => $childrenContainer
            ]);
        }
        return $out;
    }

    /**
     * Set page title automatically based on the current menu item
     *
     * @param array $config Menu Config
     * @return void
     */
    public function setPageTitle(array $config)
    {
        foreach ($config as $item) {
            if (isset($item['active']) && $item['active']) {
                $this->_View->assign('title', $item['title']);
                break;
            }
        }
    }

    /**
     * Processes the given menu config, structures it and checks for permissions
     *
     * @param string|array $config Either the config file to load or the menu config as an array
     * @return array
     */
    public function prepareMenuConfig($config)
    {
        if (is_string($config)) {
            Configure::load($config);
            $config = Configure::read($this->_defaultConfig['configKey']);
        }

        foreach ($config as $mainItem => &$mainData) {
            if (isset($mainData['url']) && !$this->Auth->urlAllowed($mainData['url'])) {
                unset($config[$mainItem]);
                continue;
            }

            if (!empty($mainData['children']) && !$this->_hasAllowedChildren($mainData['children'])) {
                unset($config[$mainItem]);
                continue;
            }

            if (isset($mainData['shouldRender']) && !$mainData['shouldRender']()) {
                unset($config[$mainItem]);
                continue;
            }

            $mainData['active'] = (isset($mainData['url']) && $this->_isItemActive($mainData));

            $visibleChildCount = 0;
            if (!empty($mainData['children'])) {
                $activeChildCount = 0;
                $visibleChildCount = count($mainData['children']);
                foreach ($mainData['children'] as $subItem => &$subData) {
                    if (isset($subData['shouldRender']) && !$subData['shouldRender']()) {
                        unset($mainData['children'][$subItem]);
                        $visibleChildCount--;
                        continue;
                    }

                    $allowed = (!isset($subData['url']) || (isset($subData['url']) && $this->Auth->urlAllowed($subData['url'])));

                    if ($allowed) {
                        $subData['active'] = $this->_isItemActive($subData);
                        if ($subData['active']) {
                            $activeChildCount++;
                        }
                    } else {
                        $visibleChildCount--;
                    }
                }

                if ($activeChildCount > 1) {
                    foreach ($mainData['children'] as $subItem => &$subData) {
                        $subData['active'] = false;
                    }
                }

                // if any of the children is active, make the main item active too
                if ($activeChildCount > 0) {
                    $mainData['active'] = true;
                }
            }

            // if the main item has no displayable children, remove it.
            if ($visibleChildCount === 0 && isset($config['children']) && count($config['children']) > 0) {
                unset($config[$mainItem]);
            }
        }
        unset($mainData, $subData);

        return $config;
    }

    /**
     * Checks if the given array of item children contains at least one
     * URL that is allowed to the current user.
     *
     * @param array $children item children
     * @return bool
     */
    protected function _hasAllowedChildren(array $children)
    {
        foreach ($children as $child) {
            if ($this->Auth->urlAllowed($child['url'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the given item URL should be marked active in the menu
     *
     * @param array $item Item to check
     * @return bool
     */
    protected function _isItemActive($item)
    {
        $current = $this->_currentUrl;
        if (!empty($item['url']['plugin'])) {
            if ($item['url']['plugin'] != $current['plugin']) {
                return false;
            }
        }
        if ($item['url']['controller'] == $current['controller'] && $item['url']['action'] == $current['action']) {
            return true;
        }
        if ($item['url']['controller'] == $current['controller']) {
            return true;
        }
        return false;
    }
}
