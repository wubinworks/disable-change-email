<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wubinworks\DisableChangeEmail\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\UrlInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Wubinworks\DisableChangeEmail\Helper\Data as Helper;

/**
 * Prevent customer from changing account email address
 */
class EditPostObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var ActionFlag
     */
    private $actionFlag;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param ActionFlag $actionFlag
     * @param UrlInterface $urlBuilder
     * @param MessageManagerInterface $messageManager
     * @param Helper $helper
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        ActionFlag $actionFlag,
        UrlInterface $urlBuilder,
        MessageManagerInterface $messageManager,
        Helper $helper
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->actionFlag = $actionFlag;
        $this->urlBuilder = $urlBuilder;
        $this->messageManager = $messageManager;
        $this->helper = $helper;
    }

    /**
     * Check change_email parameter
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void

     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        if (!$this->request->isPost()
            || !$this->request->getPost('change_email', false)
            || !$this->helper->isDisableChangeEmail()) {
            return;
        }

        $this->response->setRedirect(
            $this->urlBuilder->getUrl('customer/account/edit'),
            301
        );
        $this->messageManager->addErrorMessage(__('You cannot change email address.'));
        /* Stop further response processing */
        $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
    }
}
