<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);


namespace Elgentos\SmileDebugToolbarPrismicIO\Plugin\Model;

use Elgentos\PrismicIO\Model\Api;
use Elgentos\SmileDebugToolbarPrismicIO\Helper\PrismicIO as PrismicIOHelper;
use stdClass;

class ApiPlugin
{
    public function __construct(
        protected readonly PrismicIOHelper $prismicIOHelper,
    ) {
    }

    public function afterGetDocumentById(Api $subject, array $result, string $id, array $options = []): array
    {
        $this->prismicIOHelper->addToPrismicIO(
            'Documents',
            json_encode([$id, $options]),
            $result
        );

        return $result;
    }

    public function afterGetDocumentByUid(Api $subject, stdClass $result, string $uid, string $contentType = null, array $options = []): stdClass
    {
        $this->prismicIOHelper->addToPrismicIO(
            'Documents',
            json_encode([$uid, $contentType, $options]),
            $result
        );

        return $result;
    }

    public function afterGetSingleton(Api $subject, stdClass $result, string $contentType = null, array $options = []): stdClass
    {
        $this->prismicIOHelper->addToPrismicIO(
            'Documents',
            json_encode([$contentType, $options]),
            $result
        );

        return $result;
    }
}
