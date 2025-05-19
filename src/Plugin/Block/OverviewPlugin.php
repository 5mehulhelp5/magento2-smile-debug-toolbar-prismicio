<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);


namespace Elgentos\SmileDebugToolbarPrismicIO\Plugin\Block;

use Elgentos\PrismicIO\Block\Overview;
use Elgentos\SmileDebugToolbarPrismicIO\Helper\PrismicIO as PrismicIOHelper;

class OverviewPlugin
{
    public function __construct(
        protected readonly PrismicIOHelper $prismicIOHelper,
    ) {
    }

    public function afterGetDocuments(Overview $subject, array $result): array
    {
        $this->prismicIOHelper->addToPrismicIO('Documents', $subject->getCacheKey(), $result);
        return $result;
    }
}
