/**
 * CreditAgricole Etransactions module for Magento
 *
 * Feel free to contact LicenseCompany at LicenseEmailContact for any
 * question.
 *
 * LICENSE: This source file is subject to the version 3.0 of the Open
 * Software License (OSL-3.0) that is available through the world-wide-web
 * at the following URI: http://opensource.org/licenses/OSL-3.0. If
 * you did not receive a copy of the OSL-3.0 license and are unable
 * to obtain it through the web, please send a note to
 * LicenseEmailContact so we can mail you a copy immediately.
 *
 *
 * @version   1.0.8-meqp
 * @author    LicenseAuthor
 * @copyright LicenseCopyright
 * @license   LicenseLicense
 * @link      LicenseLink
 */
/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'CreditAgricole_Etransactions/js/action/set-payment-method',
        'Magento_Checkout/js/model/full-screen-loader',
        'mage/url',
    ],
    function ($, Component, setPaymentMethodAction, fullScreenLoader, url) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'CreditAgricole_Etransactions/payment/etep_simple',
                transactionResult: ''
            },
            initObservable: function () {
                this._super()
                    .observe([
                        'billingAgreement'
                    ]);
                return this;
            },
            getCode: function () {
                return this.item.method;
            },
            getData: function () {
                return {
                    'method': this.item.method,
                    'additional_data': {
                        'cc_type': this.getCreditCardType()
                    }
                };
            },
            getCreditCardType: function () {
                return jQuery('input[name="payment[cc_type]"]:checked').val();
            },
            continueToCreditAgricole: function () {
                this.redirectAfterPlaceOrder = false;
                // this.selectPaymentMethod();
                const currentComponent = this;
                // save selected payment method in Quote
                setPaymentMethodAction(this.messageContainer).done(function () {
                    currentComponent.placeOrder();
                });
                return false;
            },
            /** Redirect to Genericclass */
            afterPlaceOrder: function (lastOrderId) {
                $.mage.cookies.set('lastOrderId', lastOrderId);
                $.mage.redirect(url.build('etep/payment/redirect/'));
            }
        });
    }
);
