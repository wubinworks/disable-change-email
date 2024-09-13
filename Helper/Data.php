<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wubinworks\DisableChangeEmail\Helper;

/**
 * System config helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_CUSTOMER_ACCOUNT_INFORMATION_DISABLE_CHANGE_EMAIL
        = 'customer/account_information/disable_change_email';

    /**
     * Get current store system configuration value
     *
     * @param string $path
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return mixed
     */
    public function getConfig($path, $scopeType = \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            $scopeType,
            $scopeCode
        );
    }

    /**
     * Is disable change email
     *
     * @return bool
     */
    public function isDisableChangeEmail(): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_CUSTOMER_ACCOUNT_INFORMATION_DISABLE_CHANGE_EMAIL);
    }
}
