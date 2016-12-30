<?php
namespace App\View\Helper;

use ADmad\Glide\View\Helper\GlideHelper;

/**
 * Extends the GlideHelper with our custom functions.
 */
class ExtendedGlideHelper extends GlideHelper
{
    /**
     * Helpers used by this helper.
     *
     * @var array
     */
    public $helpers = ['Html', 'Url'];

    /**
     * Creates a formatted IMG element.
     * Including the srcset attribute for high quality retina images.
     *
     * @param string $path Image path.
     * @param array $params Image manipulation parameters.
     * @param array $options Array of HTML attributes for image tag.
     * @param int $pixelDensity PPI scaling of the image.
     *
     * @return string Complete <img> tag.
     *
     * @see http://glide.thephpleague.com/1.0/api/quick-reference/
     */
    public function retinaImage($path, array $params = [], array $options = [], $pixelDensity = 2)
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
