# Disable Change Email Extension for Magento 2
<a href="https://www.wubinworks.com/disable-change-email.html" target="_blank"><img src="https://raw.githubusercontent.com/wubinworks/home/master/images/Wubinworks/DisableChangeEmail/disable-change-email.jpg" alt="Wubinworks Disable Change Email" title="Wubinworks Disable Change Email"/></a>

## Introduction
A simple Magento 2 extension that prevents customer from changing account email address. Suitable for many business environments such as B2B. It is also useful when you have an integration that the account email is used as an identifier in the other systems.

## Features
 - Disables/Enables customer's ability to change account email
 - Prevents a hack that can resulting in sending "Email Change Notification" email even the account email is not changed and unintentional logout
 - Works for both Frontend and WebAPI area

## Compatibility
This extension does not use `preference` and `template override`.

\*Note: this extension disables the `change email checkbox` in frontend customer account editing page. If you are looking for a better UI experience such as removing the `change email checkbox` or the email input box, you may need to do a theme customization for `Magento_Customer::form/edit.phtml` template.

## Requirements
**Magento 2.4**

## Installation
**`composer require wubinworks/module-disable-change-email`**

## Configuration
Admin Panel `Stores > Configuration > Customers > Customer Configuration > Account Information Options`.
 - `Disable Change Email`: Yes/No

## For Developers
If you want to change customer email programmatically in `Customer User Context`(e.g., in your frontend controller), use `\Magento\Customer\Model\Customer` instead of `\Magento\Customer\Api\CustomerRepositoryInterface`. See [example](https://github.com/wubinworks/magento2-disable-customer/blob/d8e473f79c4afe54007b3370d7012cde9882e7cb/Helper/Customer.php#L225).

## ♥
If you like this extension please star this repository.

You may also like: [Disable Customer for Magento 2](https://github.com/wubinworks/magento2-disable-customer)
