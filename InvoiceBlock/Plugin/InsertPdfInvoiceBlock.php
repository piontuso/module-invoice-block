<?php
/**
 * @author Maciej Piatek
 * @copyright Copyright (c) PMP IT SOLUTIONS
 */

declare(strict_types=1);

namespace Pmp\InvoiceBlock\Plugin;

class InsertPdfInvoiceBlock
{
    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface 
     */
    private $blockRepository;

    /**
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
    }

    /**
     * Add extra cms block on the end of pdf invoice.
     * 
     * @param \Magento\Sales\Model\Order\Pdf\Invoice $subject
     * @param \Zend_Pdf $pdf
     * @param array $invoices
     * @return \Zend_Pdf
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetPdf(
        \Magento\Sales\Model\Order\Pdf\Invoice $subject,
        \Zend_Pdf $pdf,
        array $invoices
    ) {
        try {
            /* @var \Magento\Cms\Api\Data\BlockInterface $block */
            $block = $this->blockRepository->getById(
                \Pmp\InvoiceBlock\Setup\Patch\Data\AddCMSBlock::BLOCK_ID
            );
            $page = array_pop($pdf->pages);
            $page->drawText(strip_tags($block->getContent()), 25, $subject->y, 'UTF-8');
            $pdf->pages[] = $page;
        } catch (\Exception $e) {
            // log
        }
        return $pdf;
    }
}
