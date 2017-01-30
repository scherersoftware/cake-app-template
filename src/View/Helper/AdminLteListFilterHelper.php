<?php
declare(strict_types = 1);
namespace App\View\Helper;

use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use ListFilter\View\Helper\ListFilterHelper;

class AdminLteListFilterHelper extends ListFilterHelper
{
    /**
     * Default Config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'formOptions' => [],
        'includeJavascript' => true,
        'templates' => [
            'containerStart' => '<div{{attrs}}>',
            'containerEnd' => '</div>',
            'toggleButton' => '<button class="btn btn-box-tool" data-widget="collapse"><i{{attrs}}></i></button>',
            'header' => '<div class="box-header with-border"><h3 class="box-title">{{title}}</h3><div class="pull-right">{{toggleButton}}</div></div>',
            'contentStart' => '<div{{attrs}} id="list-filter-content">',
            'contentEnd' => '</div>',
            'buttons' => '<div class="submit-group">{{buttons}}</div>'
        ],
        'containerClasses' => 'box box-techno-alpin',
        'contentClasses' => 'box-body',
        'title' => 'Filter',
        'filterButtonOptions' => [
            'div' => false,
            'class' => 'btn btn-techno-alpin'
        ],
        'resetButtonOptions' => [
            'class' => 'btn btn-default',
            'pass' => [
                'resetFilters' => true
            ]
        ]
    ];

    /**
     * Opens the HTML container
     *
     * @return string HTML
     */
    public function openContainer(): string
    {
        $containerClasses = $this->config('containerClasses');
        $contentClasses = $this->config('contentClasses');

        $title = __d('list_filter', 'list_filter.filter_fieldset_title');

        if ($this->filterActive() === false) {
            $containerClasses .= ' collapsed-box';
        }

        $ret = $this->templater()->format('containerStart', [
            'attrs' => $this->templater()->formatAttributes([
                'class' => $containerClasses
            ])
        ]);
        $ret .= $this->header();
        $ret .= $this->templater()->format('contentStart', [
            'attrs' => $this->templater()->formatAttributes([
                'class' => $contentClasses
            ])
        ]);

        return $ret;
    }

    /**
     * Renders the button for toggling the filter box
     *
     * @return string HTML
     */
    public function toggleButton(): string
    {
        $toggleButtonClasses = 'fa fa-minus';
        if ($this->filterActive() === false) {
            $toggleButtonClasses = 'fa fa-plus';
        }

        return $this->templater()->format('toggleButton', [
            'attrs' => $this->templater()->formatAttributes([
                'class' => $toggleButtonClasses
            ])
        ]);
    }
}
