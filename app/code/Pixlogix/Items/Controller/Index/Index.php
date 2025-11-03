<?php
/**
 * @category  Pixlogix
 * @package   Pixlogix_Items
 * @author    Pixlogix
 * @copyright Copyright (c) 2025 Pixlogix
 *
 * Frontend Controller — Item Listing Page
 *
 * This controller is responsible for rendering the main Pixlogix Items
 * listing page on the frontend.
 *
 * Example URL: /pixitems
 */

declare(strict_types=1);

namespace Pixlogix\Items\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor.
     *
     * Initializes dependencies used in the controller.
     *
     * @param Context $context Action context instance.
     * @param PageFactory $resultPageFactory Page factory for rendering the view.
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * Creates and returns a result page instance for the Pixlogix Items listing.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Create result page for Pixlogix Items listing
        $resultPage = $this->resultPageFactory->create();

        // Set dynamic page title
        $resultPage->getConfig()->getTitle()->set(__('Pixlogix Items'));

        return $resultPage;
    }
}
