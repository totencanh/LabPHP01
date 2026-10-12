<?php
// Basic one-file version: raw input, type evidence, calculations and receipt.
const CURRENCY = "VND";
const MEMBER_DISCOUNT_RATE = 0.05;
const MEMBER_MIN = 120000;
const PACKAGING_FEE_PER_ITEM = 2000;
const SERVICE_RATE = 0.04;

$productName = "Salt Coffee";
$unitPrice = 45000;
$rawQuantity = " 3 ";
$customerStatus = "MEMBER";
$productAvailable = true;
$orderNote = null;

$cleanQuantityString = trim($rawQuantity);
$quantity = (int) $cleanQuantityString;
$subtotal = $unitPrice * $quantity;
$isMember = $customerStatus === "MEMBER";
$isDiscountEligible = $isMember && $subtotal >= MEMBER_MIN;
$discount = $isDiscountEligible ? $subtotal * MEMBER_DISCOUNT_RATE : 0;
$afterDiscount = $subtotal - $discount;
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM;
$serviceFee = $afterDiscount * SERVICE_RATE;
$total = ($subtotal - $discount) + $packagingFee + $serviceFee;
$hasValidQuantity = $quantity > 0;
$canOrder = $hasValidQuantity && $productAvailable && ($isMember || $customerStatus === "GUEST");
$status = $canOrder ? "READY TO ORDER" : "BLOCKED";

$receipt = "SmartCafe | " . $productName . PHP_EOL;
$receipt .= "Quantity: " . $quantity . PHP_EOL;
$receipt .= "Subtotal: " . $subtotal . " " . CURRENCY . PHP_EOL;
$receipt .= "Discount: " . $discount . " " . CURRENCY . PHP_EOL;
$receipt .= "Packaging: " . $packagingFee . " " . CURRENCY . PHP_EOL;
$receipt .= "Service: " . $serviceFee . " " . CURRENCY . PHP_EOL;
$receipt .= "Total: " . $total . " " . CURRENCY . PHP_EOL;
$receipt .= "Status: " . $status . PHP_EOL;

echo "RAW/CAST TYPE EVIDENCE\n";
echo "rawQuantity: "; var_dump($rawQuantity);
echo "cleanQuantityString: "; var_dump($cleanQuantityString);
echo "quantity: "; var_dump($quantity);
echo "customerStatus: "; var_dump($customerStatus);
echo "productAvailable: "; var_dump($productAvailable);
echo "orderNote: "; var_dump($orderNote);
echo "\n" . $receipt;
