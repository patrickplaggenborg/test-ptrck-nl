<?php
/**
 * Transaction_Banking
 * 
 * @category   MT940
 * @package    MT940
 * @copyright  Copyright (c) 2010 Kingsquare Information Services (http://www.kingsquare.nl)
 * @license    http://opensource.org/licenses/gpl-2.0.php  Open Software License (GPLv2)
 */
class Transaction_Banking {
	var $account = '';
	var $accountName = '';
	var $price = 0;
	var $debitcredit = '';
	var $description = '';
	var $valueTimestamp = 0;
	var $entryTimestamp = 0;
	var $transactionCode = '';
	
	// setters
	function setAccount($var) { $this->account = (string) $var; }
	function setAccountName($var) { $this->accountName = (string) $var; }
	function setPrice($var) { $this->price = (string) $var; }
	function setDebitCredit($var) { $this->debitcredit = (string) $var; }
	function setDescription($var) { $this->description = (string) $var; }
	function setValueTimestamp($var) { $this->valueTimestamp = (int) $var; }
	function setEntryTimestamp($var) { $this->entryTimestamp = (int) $var; }
	function setTransactionCode($var) { $this->transactionCode = (string) $var; }

	// getters
	function getAccount() { return $this->account; }
	function getAccountName() { return $this->accountName; }
	function getPrice() { return $this->price; }
	function getDebitCredit() { return $this->debitcredit; }
	function getDescription() { return $this->description; }
	function getValueTimestamp($format = 'U') { return date($format, $this->valueTimestamp); }
	function getEntryTimestamp($format = 'U') { return date($format, $this->entryTimestamp); }
	function getTransactionCode() { return $this->transactionCode; }

	// public
	function isDebit() { return ($this->getDebitCredit() == 'D'); }
	function isCredit() { return ($this->getDebitCredit() == 'C'); }
}