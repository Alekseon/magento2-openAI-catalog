/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 * @deprecated since version 2.2.0
 */
define([
    'jquery',
    'Magento_Ui/js/form/components/button',
    'uiRegistry'
], function ($, Button, registry) {
    'use strict';

    return Button.extend({
        sendQuestionToGPT: function () {
            $.ajax({
                url: this.urlForSendQuestionToGPT,
                type: 'GET',
                showLoader: true,
                success: function(data){

                    if (data.error || !data.chatgpt) {
                        window.location.reload();
                    }

                    Object.entries(data.chatgpt).forEach(entry => {
                        const [attributeCode, attributeValue] = entry;
                        registry.get('inputName = ' + 'product[' + attributeCode + ']').value(attributeValue);
                    });
                }
            });
        }
    });
});
