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
use Wubinworks\DisableChangeEmail\Helper\System as SystemHelper;

/**
 * Prevent customer from changing account email address
 */
class EditPostObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ActionFlag
     */
    protected $actionFlag;

    /**
     * @var SystemHelper
     */
    protected $systemHelper;

    /**
     * Constructor
     *
     * @param ResponseInterface $response
     * @param ActionFlag $actionFlag
     * @param SystemHelper $systemHelper
     */
    public function __construct(
        ResponseInterface $response,
        ActionFlag $actionFlag,
        SystemHelper $systemHelper
    ) {
        $this->response = $response;
        $this->actionFlag = $actionFlag;
        $this->systemHelper = $systemHelper;
    }

    /**
     * Prevent logout and sending notification email if 'change_email' parameter is set
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        /** $request RequestInterface */
        $request = $observer->getRequest();
        if (!$request->isPost()
            || !$request->getPost('change_email', false)
            || !$this->systemHelper->isChangeEmailDisabled()) {
            return;
        }

        $this->response->setRedirect(
            $this->systemHelper->getUrl('customer/account/edit'),
            301
        );
        $this->systemHelper->getMessageManager()->addErrorMessage(
            $this->systemHelper->getChangeEmailErrorPhrase()
        );
        /** Stop further response processing */
        $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
    }
}
