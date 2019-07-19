<?php
/**
 * Copyright © 2018 Rubic. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ecomteck\OrderComment\Plugin\Block\Checkout;
use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
class ModifyCheckoutLayoutPlugin
{
    const CONFIG_ENABLE_ORDER_COMMENT    = 'order_comment/general/enable';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Disable delivery date component in checkout page.
     *
     * @param array $jsLayout
     * @return array
     */
    private function disableOrderCommentComponent($jsLayout)
    {
        if (!$this->scopeConfig->getValue(self::CONFIG_ENABLE_ORDER_COMMENT, ScopeInterface::SCOPE_STORE)) {
            // remove order comment component at default checkout
            unset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['additional-payment-validators']['children']['order-comment-validator']);
            unset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children']['before-place-order']['children']['comment']);

            // remove order comment component at default ecomteck onestepcheckout
            unset($jsLayout['components']['checkout']['children']['sidebar']['children']['after-sidebar']['children']
                ['order-comment-validator']);
                unset($jsLayout['components']['checkout']['children']['sidebar']['children']['after-sidebar']['children']
                ['order-comment']);
        }
        return $jsLayout;
    }

    /**
     * @param LayoutProcessor $layoutProcessor
     * @param callable $proceed
     * @param array<int, mixed> $args
     * @return array
     */
    public function aroundProcess(LayoutProcessor $layoutProcessor, callable $proceed, ...$args)
    {
        $jsLayout = $proceed(...$args);
        $jsLayout = $this->disableOrderCommentComponent($jsLayout);
        return $jsLayout;
    }
}