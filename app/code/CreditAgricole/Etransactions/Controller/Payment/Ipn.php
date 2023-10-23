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

class Ipn extends \CreditAgricole\Etransactions\Controller\Payment
{
    public function execute()
    {
        try {
            $creditagricole = $this->getCreditagricole();

            // Retrieves params
            $params = $creditagricole->getParams(true);
            if ($params === false) {
                return $this->_404();
            }

            // Load order
            $order = $this->_getOrderFromParams($params);
            if (is_null($order) || is_null($order->getId())) {
                return $this->_404();
            }

            // IP not allowed
            // $config = $this->getConfig();
            // $allowedIps = explode(',', $config->getAllowedIps());
            // $remoteAddress = $this->objectManager->create('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
            // $currentIp = $remoteAddress->getRemoteAddress();
            // if (!in_array($currentIp, $allowedIps)) {
            //     $message = $this->__('IPN call from %s not allowed.', $currentIp);
            //     $order->addStatusHistoryComment($message);
            //     $order->save();
            //     $this->logFatal(sprintf('Order %s: (IPN) %s', $order->getIncrementId(), $message));
            //     $message = 'Access denied to %s';
            //     throw new \LogicException('Access denied to '.$currentIp);
            // }

            // Call payment method
            $method = $order->getPayment()->getMethodInstance();
            $res = $method->onIPNCalled($order, $params);
        } catch (\Exception $e) {
            $message = sprintf('(IPN) Exception %s (%s %d).', $e->getMessage(), $e->getFile(), $e->getLine());
            $this->logFatal($message);
            header('Status: 500 Error', true, 500);
        }
    }
}
