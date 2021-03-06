<?php

/**
 * Plugin Name: Example Gateway For WPSmartPay
 * Plugin URI: https://wpsmartpay.com
 * Description: This is an example gateway plugin for WPSmartPay
 * Author: WPSmartPay
 * Author URI: https://wpsmartpay.com
 * Version: 1.0
 * Text Domain: smartpay-example-gateway
 * Domain Path: /languages
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// define plugin url
define("SMARTPAY_EXAMPLE_GATEWAY_PLUGIN", plugin_dir_url(__FILE__));

// register your gateway in smartpay gateways
add_filter('smartpay_gateways', 'register_gateway');

// show your gateway name on SmartPay settings
add_filter('smartpay_get_available_payment_gateways', 'register_to_available_gateway_on_setting');

// add you gateway name/label on Payment section for settings
add_filter('smartpay_settings_sections_gateways', 'gateway_section', 110);

//add your gateway settings, it will show on corresponding gateway_section
add_filter('smartpay_settings_gateways', 'gateway_settings', 110);

// process/charge payment using your gateway
// named it to exact with your gateway -- just change the gateway label
add_action('smartpay_example_ajax_process_payment', 'ajax_process_payment');

// process the subscription payment
add_action('smartpay_example_subscription_process_payment', 'subscription_process_payment', 10, 2);

// refund and cancel subscription when change the status to cancel
add_action('smartpay_update_payment_status', 'payment_refund_and_subscription_cancel', 10, 3);

// cancel only subscription
add_action('smartpay_update_subscription_status', 'subscription_cancel', 10, 3);

// process your payment webhooks
add_action('init', 'process_webhook');


/**
 * register your gateway
 * @param array $gateways
 * @return array
 */
function register_gateway(array $gateways = array()): array
{
    // check the gateway exist or not
    $gateways['example'] = array(
        'admin_label'       => 'Example Gateway',
        'checkout_label'    => 'Example Gateway',
        'gateway_icon'      =>  SMARTPAY_EXAMPLE_GATEWAY_PLUGIN.'assets/example.jpg', // 120px*38px(width x height)
    );
    return $gateways;
}

/**
 * Register for gateway activation on SmartPay Settings
 * @param array $availableGateways
 * @return array
 */
function register_to_available_gateway_on_setting(array $availableGateways = array()): array
{
    $availableGateways['example'] = array(
        'label' => 'Example Gateway'
    );
    return $availableGateways;
}

/**
 * @param array $sections
 * @return array
 */
function gateway_section(array $sections = array()): array
{
    $sections['example'] = __('Example Gateway', 'smartpay-example-gateway');
    return $sections;
}

/**
 * add your settings/configuration for your gateway
 * @param array $settings
 * @return array
 */
function gateway_settings(array $settings): array
{
    $gateway_settings = array(
        array(
            'id'    => 'example_gateway_settings',
            'name'  => '<h4 class="text-uppercase text-info my-1">' . __('Example Gateway Settings', 'smartpay-example-gateway') . '</h4>',
            'desc'  => __('Configure your Example Payment Gateway Settings', 'smartpay-pro'),
            'type'  => 'header'
        ),
        array(
            'id'   => 'example_gateway_test_api_key',
            'name'  => __('Test Api Key', 'smartpay-example-gateway'),
            'desc'  => __('Enter your test api key, found in your Developers > API keys', 'smartpay-example-gateway'),
            'type'  => 'text',
        ),

        array(
            'id'   => 'example_gateway_live_api_key',
            'name'  => __('Live Api Key', 'smartpay-example-gateway'),
            'desc'  => __('Enter your live api key, found in your Developers > API keys', 'smartpay-example-gateway'),
            'type'  => 'text',
        ),
    );

    return array_merge($settings, ['example' => $gateway_settings]);
}

/**
 * payment processor
 * @param $payment_data
 * @return void
 */
function ajax_process_payment($payment_data){
    dd($payment_data);
    // process the payments
    // do not need to return anything
}

/**
 * cancel the subscription when refunded
 * @param $payment
 * @param $newStatus
 * @param $oldStatus
 * @return void
 */
function payment_refund_and_subscription_cancel($payment, $newStatus, $oldStatus){
    // do staff refund and subscription cancel
}

/**
 * cancel the subscription
 * @param $subscription
 * @param $newStatus
 * @param $oldStatus
 * @return void
 */
function subscription_cancel($subscription, $newStatus, $oldStatus){
    // subscription cancel
}

/**
 * Process the webhook for the payments
 * @return void
 */
function process_webhook(){
    // process webhook
}

