## About SmartPay Example Gateway Plugin
This is an example payment gateway plugin for WPSmartPay. Now, WPSmartPay allow you to integrate the custom payment gateway integration that mean you can integrate your local/global payment gateway on WPSmartPay with simple steps.

### How to Integrate
WPSmartPay provides actions and filters to take the payments from the customer using your payment gateway. 
Two types of hooks are available,
1. filters (register necessary setting)
2. actions to process the payments

### Register the necessary Settings
Add the following filters to register your payment gateway settings
1. register your payment gateway into SmartPay gateways
```php
add_filter('smartpay_gateways', 'register_gateway');
```
In the callback function
```php
function register_gateway(array $gateways = array()): array
{
    // check the gateway exist or not
    $gateways['example'] = array(
        'admin_label'       => 'Example Gateway',
        'checkout_label'    => 'Example Gateway',
        'gateway_icon'      => 'example.png',
    );
    return $gateways;
}
```
2. show your gateway name on SmartPay settings
```php
add_filter('smartpay_get_available_payment_gateways', 'register_to_available_gateway_on_setting');
```
In the callback function
```php
function register_to_available_gateway_on_setting(array $availableGateways = array()): array
{
    $availableGateways['example'] = array(
        'label' => 'Example Gateway'
    );
    return $availableGateways;
}
```

3.  add you gateway name/label on Payment section for settings
```php
add_filter('smartpay_settings_sections_gateways', 'gateway_section', 110);
```
In the callback function
```php
function gateway_section(array $sections = array()): array
{
    $sections['example'] = __('Example Gateway', 'smartpay-example-gateway');
    return $sections;
}
```

4. add your gateway settings, it will show on corresponding gateway_section
```php
add_filter('smartpay_settings_gateways', 'gateway_settings', 110);
```
In the callback function
```php
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
        // add more field if you need to make a transaction
    );
    return array_merge($settings, ['example' => $gateway_settings]);
}
```
Above filters will register your gateway on SmartPay. Now, you will need to perform few action to process the payments.

### Actions to process the payments 
Add the following actions to process the payments using your gateway

1. Process the payment, when your payment gateway is selected, then this action will be triggerred by WPSmartPay
```php
add_action('smartpay_example_ajax_process_payment', 'ajax_process_payment');
```
> [N. B] - replace the example with your gateway id, in this case it is an 'example'

In the callback function
```php
function ajax_process_payment($payment_data){
    // process the payments
}
```

As similar WPSmartPay have number of action hooks to process/update the payments through your gateway

2. For the subscription/recurring payment

>[N. B] - For recurring payment and processing subscription, you must have WPSmartPay Pro installed.
```php
add_action('smartpay_example_subscription_process_payment', 'subscription_process_payment', 10, 2);
```
> [N. B] - replace the example from the hook with your gateway id, in this case it is an 'example'

2. For payment status change/update
```php
add_action('smartpay_update_payment_status', 'on_payment_completed', 10, 3);
```

3. Also, for subscription status change/update
```php
add_action('smartpay_update_subscription_status', 'on_payment_paused', 10, 3);
```

4. For webhook implementation or processing the webhook
```php
add_action('init', 'process_webhook');
```

All done, you have integrated your payment gateway for WPSmartPay and take the payments using your payment gateway.
For more details, please visit our custom payment gateway [documentation](https://docs.wpsmartpay.com/en/).
