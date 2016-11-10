<?php
namespace App\View\Helper;

use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class AdminLteListFilterHelper extends \ListFilter\View\Helper\ListFilterHelper
{
    /**
     * {@inheritdoc}
     */
    protected $_defaultConfig = [
        'formOptions' => [],
        'includeJavascript' => true,
        'templates' => [
            'containerStart' => '<div{{attrs}}>',
            'containerEnd' => '</div>',
            'toggleButton' => '<a{{attrs}} data-widget="collapse"><i class="fa fa-minus"></i></a>',
            'header' => '<div class="box-header with-border">{{title}}<div class="pull-right">{{toggleButton}}</div></div>',
            'contentStart' => '<div{{attrs}}>',
            'contentEnd' => '</div>',
            'buttons' => '<div class="submit-group">{{buttons}}</div>'
        ],
        'containerClasses' => 'box box-default',
        'contentClasses' => 'box-body',
        'title' => 'Filter',
        'filterButtonOptions' => [
            'div' => false,
            'class' => 'btn btn-primary'
        ],
        'resetButtonOptions' => [
            'class' => 'btn btn-default',
            'pass' => [
                'resetFilters' => true
            ]
        ]
    ];
}
