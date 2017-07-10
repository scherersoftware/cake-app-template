<?php
declare(strict_types = 1);
namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Paginator helper
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\NumberHelper $Number
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class PaginatorHelper extends \Cake\View\Helper\PaginatorHelper
{

    /**
     * Paginator Widget
     *
     * @param string:mixed[] $options Options
     * @return string Markup
     */
    public function numbers(array $options = []): string
    {
        $options = Hash::merge([
            'first' => 1,
            'last' => 1
        ], $options);

        parent::setTemplates([
            'ellipsis' => '<li class="disabled"><a>...</a></li>',
        ]);
        $pagination = '';
        $pagination .= parent::prev('&laquo;', [
            'escape' => false
        ]);
        $pagination .= parent::numbers($options);
        $pagination .= parent::next('&raquo;', [
            'escape' => false
        ]);
        $counter = parent::counter([
            'format' => '{{count}} Einträge'
        ]);
        $ret = sprintf('<nav><ul class="pagination">%s<li class="counter"><a>%s</a></li></ul></nav>', $pagination, $counter);

        return $ret;
    }
}
