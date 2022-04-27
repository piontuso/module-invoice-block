<?php
/**
 * @author Maciej Piatek
 * @copyright Copyright (c) PMP IT SOLUTIONS
 */

declare(strict_types=1);

namespace Pmp\InvoiceBlock\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class AddCMSBlock
 */
class AddCMSBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * Block indentifier.
     */
    public const BLOCK_ID = "invoice-extra-block";

    /**
     * @var \Magento\Cms\Model\BlockFactory 
     */
    private $blockFactory;

    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface 
     */
    private $blockRepository;

    /**
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $blockData = [
            'title' => "Invoice extra block",
            'identifier' => self::BLOCK_ID,
            'stores' => [0],
            'is_active' => 1,
            'content' => "Thank you for buying from us!"
        ];
        $this->blockFactory->create()->setData($blockData)->save();
    }

    /**
     * @inheritDoc
     */
    public function revert()
    {
        $this->blockRepository->deleteById(self::BLOCK_ID);
    }
}
