<?php
/**
 * @category  Pixlogix
 * @package   Pixlogix_Items
 * @author    Pixlogix
 * @copyright Copyright (c) 2025 Pixlogix
 *
 * Frontend Controller — View action for displaying a single item.
 */

declare(strict_types=1);

namespace Pixlogix\Items\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Pixlogix\Items\Model\ItemFactory;
use Magento\Framework\Registry;

class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Constructor.
     *
     * @param Context        $context
     * @param PageFactory    $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param ItemFactory    $itemFactory
     * @param Registry       $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        ItemFactory $itemFactory,
        Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->itemFactory = $itemFactory;
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * Loads the item by `url_key` and renders the detail page.
     * If the item does not exist, forwards to the "no route" page.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // Retrieve the URL key from the request
        $urlKey = $this->getRequest()->getParam('url_key');

        // Forward to 404 if missing
        if (!$urlKey) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        // Load the item model using the url_key field
        $item = $this->itemFactory->create()->load($urlKey, 'url_key');

        // If no matching item, show 404
        if (!$item->getId()) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        // Register item for layout and blocks
        $this->registry->register('current_item', $item);

        // Render the item detail page with dynamic title
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($item->getTitle());

        return $resultPage;
    }
}
