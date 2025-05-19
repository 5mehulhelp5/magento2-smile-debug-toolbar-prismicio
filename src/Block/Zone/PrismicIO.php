<?php

declare(strict_types=1);

namespace Elgentos\SmileDebugToolbarPrismicIO\Block\Zone;

use Elgentos\PrismicIO\Exception\ApiNotEnabledException;
use Elgentos\PrismicIO\Model\Api;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Smile\DebugToolbar\Block\Zone\AbstractZone;
use Smile\DebugToolbar\Formatter\FormatterFactory;
use Elgentos\SmileDebugToolbarPrismicIO\Helper\PrismicIO as SearchHelper;
use Smile\DebugToolbar\Helper\Data as DataHelper;

/**
 * PrismicIO section.
 */
class PrismicIO extends AbstractZone
{
    public function __construct(
        Context $context,
        DataHelper $dataHelper,
        FormatterFactory $formatterFactory,
        protected readonly Api $api,
        protected readonly SearchHelper $prismicioHelper,
        array $data = []
    ) {
        parent::__construct($context, $dataHelper, $formatterFactory, $data);
        $this->setTemplate('Elgentos_SmileDebugToolbarPrismicIO::zone/prismicio.phtml');
    }

    /**
     * @inheritdoc
     */
    public function getCode(): string
    {
        return 'prismicio';
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'PrismicIO';
    }

    /**
     * Get the search sections.
     *
     * @throws NoSuchEntityException
     * @throws ApiNotEnabledException
     */
    public function getSearchSections(): array
    {
        $sections = $this->prismicioHelper->getPrismicIO();
        $searchSection = [
            'API' => [
                'Active' => json_encode($this->api->isActive(), JSON_PRETTY_PRINT),
                'Preview Allowed' => json_encode($this->api->isPreviewAllowed(), JSON_PRETTY_PRINT),
                'Fallback Allowed' => json_encode($this->api->isFallbackAllowed(), JSON_PRETTY_PRINT),
                'Default Content Type' => json_encode($this->api->getDefaultContentType(), JSON_PRETTY_PRINT),
            ],
            'Data' => [
                'Bookmarks' => $this->api->create()->getData()->getBookmarks(),
                'Forms' => $this->api->create()->getData()->getForms(),
                'Refs' => array_map(static fn ($ref) => [
                    'isMasterRef' => $ref->isMasterRef(),
                    'getRef' => $ref->getRef(),
                    'getLabel' => $ref->getLabel(),
                    'getId' => $ref->getId(),
                    'getScheduledAt' => $ref->getScheduledAt(),
                    'getScheduledAtTimestamp' => $ref->getScheduledAtTimestamp(),
                    'getScheduledDate' => $ref->getScheduledDate(),
                ], $this->api->create()->getData()->getRefs()),
            ],
        ];

        foreach ($sections as $sectionKey => $section) {
            foreach ($section as $key => $item) {
                $searchSection[$sectionKey][$key] = json_encode($item, JSON_PRETTY_PRINT);
            }
        }

        return $searchSection;
    }

    protected function displaySectionValue(string $name, mixed $value): string
    {
        [$class, $value] = $this->getClassAndValue($value);
        $uid = uniqid();

        return "    <tr><th class=\"align-top\" for=\"$uid\" onclick=\"smileToggle('$uid')\">$name</th><td id=\"smile-field-$uid\" class=\"field-cover $class\">$value</td></tr>\n";
    }
}
