<?php
declare(strict_types = 1);
namespace App\View\Helper;

use ADmad\Glide\View\Helper\GlideHelper;

/**
 * Extends the GlideHelper with our custom functions.
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class ExtendedGlideHelper extends GlideHelper
{
    /**
     * Helpers used by this helper.
     *
     * @var string[]
     */
    public $helpers = ['Html', 'Url'];

    /**
     * Creates a formatted IMG element.
     * Including the srcset attribute for high quality retina images.
     *
     * @param string $path Image path.
     * @param string:mixed[] $params Image manipulation parameters.
     * @param string:mixed[] $options Array of HTML attributes for image tag.
     * @param int $pixelDensity PPI scaling of the image.
     *
     * @return string Complete <img> tag.
     *
     * @see http://glide.thephpleague.com/1.0/api/quick-reference/
     */
    public function retinaImage(string $path, array $params = [], array $options = [], int $pixelDensity = 2): string
    {
        if ($pixelDensity > 1) {
            $baseUrl = $this->url($path, $params + ['_base' => false]);

            $srcset = '';
            for ($i = 1; $i <= $pixelDensity; $i++) {
                $srcset .= $this->Url->image($this->url($path, $params + ['_base' => false, 'dpr' => $i]), $options) . ' ' . $i . 'x,';
            }
            $srcset = str_replace('&amp;', '&', $srcset);

            return $this->Html->image($baseUrl, $options + ['srcset' => $srcset]);
        }

        return $this->Html->image($this->url($path, $params + ['_base' => false]), $options);
    }
}
