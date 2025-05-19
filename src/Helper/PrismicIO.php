<?php

declare(strict_types=1);

namespace Elgentos\SmileDebugToolbarPrismicIO\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * PrismicIO helper.
 */
class PrismicIO extends AbstractHelper
{
    protected array $prismicio = [];

    public function getPrismicIO(): array
    {
        return $this->prismicio;
    }

    /**
     * @inheritdoc
     */
    public function addToPrismicIO(
        string $sectionName,
        string $key,
        mixed $value
    ): self {
        if (is_array($value) && array_key_exists('has_warning',
                $value) && $value['has_warning']) {
            $this->hasWarning();
        }

        $this->prismicio['Documents'][$key] = $value;

        return $this;
    }
}
