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
 * @version   1.0.8-meqp
 * @author    E-Transactions <support@e-transactions.fr>
 * @copyright 2012-2021 E-Transactions
 * @license   http://opensource.org/licenses/OSL-3.0
 * @link      http://www.e-transactions.fr/
 */

namespace CreditAgricole\Etransactions\Model\Payment;

class Financial extends AbstractPayment
{
    const CODE = 'etep_financial';
    const XML_PATH = 'payment/etep_financial/cctypes';

    protected $_code = self::CODE;
    protected $_hasCctypes = true;
    protected $_allowManualDebit = true;
    protected $_allowDeferredDebit = true;
    protected $_allowRefund = true;

    public function toOptionArray()
    {
        $result = [];
        $configPath = $this->getConfigPath();
        $cards = $this->_getConfigValue($configPath);
        if (!empty($cards)) {
            foreach ($cards as $code => $card) {
                $result[] = [
                    'label' => __($card['label']),
                    'value' => $code,
                ];
            }
        } else {
            //            $result[] = array(
            //                'label' => __('CB'),
            //                'value' => 'CB',
            //            );
            //            $result[] = array(
            //                'label' => __('Visa'),
            //                'value' => 'VISA',
            //            );
            //            $result[] = array(
            //                'label' => __('Mastercard'),
            //                'value' => 'EUROCARD_MASTERCARD',
            //            );
            //            $result[] = array(
            //                'label' => __('E-Carte Bleue'),
            //                'value' => 'E_CARD',
            //            );
        }
        return $result;
    }
}
