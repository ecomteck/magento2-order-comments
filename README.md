Magento 2 Module to add  a comment field above the place order button in the checkout

Setup

composer require ecomteck/magento2-order-comments

Questions & Anwsers:

Q: How to Ecomteck One Step Checkout show comments in the order confirmation email?

A: Go to admin to create new transactional email template.

On the email template content area add the variable shortcode as this:

 {{var order.getEcomteckOrderComment()}}