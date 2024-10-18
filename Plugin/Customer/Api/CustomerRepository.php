<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wubinworks\DisableChangeEmail\Plugin\Customer\Api;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface as CustomerDataInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Wubinworks\DisableChangeEmail\Helper\System as SystemHelper;

/**
 * CustomerRepositoryInterface plugin
 */
class CustomerRepository
{
    /**
     * @var SystemHelper
     */
    protected $systemHelper;

    /**
     * Constructor
     *
     * @param SystemHelper $systemHelper
     */
    public function __construct(
        SystemHelper $systemHelper
    ) {
        $this->systemHelper = $systemHelper;
    }

    /**
     * Prevent changing email in `Customer User Context`
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerDataInterface $customer
     * @return null
     */
    public function beforeSave(
        CustomerRepositoryInterface $subject,
        CustomerDataInterface $customer
    ) {
        if ($this->systemHelper->isChangeEmailDisabled()
                && !$this->systemHelper->isAdminOrIntegration()) {
            try {
                $origCustomer = $subject->getById((int)$customer->getId());
            } catch (\Exception $e) {
                // Create account case
                return null;
            }

            if ($origCustomer->getEmail() !== $customer->getEmail()) {
                throw new InvalidEmailOrPasswordException($this->systemHelper->getChangeEmailErrorPhrase());
            }
        }

        return null;
    }
}
