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
 * @version   1.0.7-psr
 * @author    E-Transactions <support@e-transactions.fr>
 * @copyright 2012-2021 E-Transactions
 * @license   http://opensource.org/licenses/OSL-3.0
 * @link      http://www.e-transactions.fr/
 */

namespace CreditAgricole\Etransactions\Controller\Payment;

use \Magento\Framework\Validator\Exception;

class Cancel extends \CreditAgricole\Etransactions\Controller\Payment
{
    public function execute()
    {
        try {
            $session = $this->getSession();
            $creditagricole = $this->getCreditagricole();

            // Retrieves params
            $params = $creditagricole->getParams();
            if ($params === false) {
                return $this->_404();
            }

            // Load order
            $order = $this->_getOrderFromParams($params);
            if (is_null($order) || is_null($order->getId())) {
                return $this->_404();
            }

            // Payment method
            $order->getPayment()->getMethodInstance()->onPaymentCanceled($order);

            // Set quote to active
            $this->_loadQuoteFromOrder($order)->setIsActive(true)->save();

            // Cleanup
            $session->unsCurrentEtepOrderId();

            $message = sprintf('Order %d: Payment was canceled by user on Up2pay e-Transactions payment page.', $order->getIncrementId());
            $this->logDebug($message);

            $message = __('Payment canceled by user');
            $this->_messageManager->addError($message);

            // redirect
            $this->_redirectResponse($order, false /* is success ? */);
        } catch (\Exception $e) {
            $this->logDebug(sprintf('cancelAction: %s', $e->getMessage()));
        }

        // Redirect to cart
        $this->_redirect('checkout/cart');
    }
}
