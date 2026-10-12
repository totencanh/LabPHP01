<?php
// Keep raw input unchanged at the data boundary; normalize before arithmetic.
$cleanQuantityString = trim($rawQuantity);
$quantity = (int) $cleanQuantityString;

$subtotal = $unitPrice * $quantity;
$isMember = $customerStatus === "MEMBER";
$isDiscountEligible = $isMember && ($subtotal >= MEMBER_MIN);
$discount = $isDiscountEligible ? ($subtotal * MEMBER_DISCOUNT_RATE) : 0;
$afterDiscount = $subtotal - $discount;
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM;
$serviceFee = $afterDiscount * SERVICE_RATE;
$total = ($subtotal - $discount) + $packagingFee + $serviceFee;

$hasValidQuantity = $quantity > 0;
$isKnownCustomerStatus = $isMember || ($customerStatus === "GUEST");
$canOrder = $hasValidQuantity && $productAvailable && $isKnownCustomerStatus;
$status = $canOrder ? "READY TO ORDER" : "BLOCKED";
