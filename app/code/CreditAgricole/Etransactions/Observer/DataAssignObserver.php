<?php
/**
 * Up2pay e-Transactions Etransactions module for Magento
 *
 * Feel free to contact Credit Agricole at support@e-transactions.fr for any
 * question.
 *
 * LICENSE: This source file is subject to the version 3.0 of the Open
 * Software License (OSL-3.0) that is available through the world-wide-web
 * at the following URI: http://opensource.org/licenses/OSL-3.0. If
 * you did not receive a copy of the OSL-3.0 license and are unable
 * to obtain it through the web, please send a note to
 * support@e-transactions.fr so we can mail you a copy immediately.
 *
 * @version   1.0.7
 * @author    E-Transactions <support@e-transactions.fr>
 * @copyright 2012-2021 E-Transactions
 * @license   http://opensource.org/licenses/OSL-3.0
 * @link      http://www.e-transactions.fr/
 */

namespace CreditAgricole\Etransactions\Observer;

use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;

class DataAssignObserver extends AbstractDataAssignObserver
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $method = $this->readMethodArgument($observer);
        if ($method->getCode() !== 'etep_cb' || $method->getHasCctypes() === false) {
            return;
        }
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }

        $additionalData = new DataObject($additionalData);
        $payment = $observer->getPaymentModel();
        $payment->setCcType($additionalData->getData('cc_type'));

        $cctype = $payment->getCcType();
        if (empty($cctype)) {
            // If the cc_type wasn't provided, we might be in the XHR request made after a new payment method
            // selection, which does not provide the field. We can continue, the field will be validated when
            // using the place order button.
            return;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $selected = explode(',', $objectManager->get('CreditAgricole\Etransactions\Model\Ui\EtepcbConfig')->getCards());
        if (!in_array($cctype, $selected)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Please select a valid credit card type')
            );
        }
    }
}
