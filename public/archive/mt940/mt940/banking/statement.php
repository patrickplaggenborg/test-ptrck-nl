<?php
/**
 * Transaction_Banking
 *
 * @category   MT940
 * @package    MT940
 * @copyright  Copyright (c) 2010 Kingsquare Information Services (http://www.kingsquare.nl)
 * @license    http://opensource.org/licenses/gpl-2.0.php  Open Software License (GPLv2)
 */
class Statement_Banking {
	var $bank = '';
	var $account = '';
	var $transactions = array();
	var $startPrice = 0;
	var $endPrice = 0;
	var $timestamp = 0;
	var $number = '';

	function setBank($var) { $this->bank = (string) $var; }
	function setAccount($var) { $this->account = (string) $var; }
	function setTransactions($transactions) { $this->transactions = (array) $transactions; }
	function setStartPrice($var) { $this->startPrice = (int) $var; }
	function setEndPrice($var) { $this->endPrice = (int) $var; }
	function setTimestamp($var) { $this->timestamp = (int) $var; }
	function setNumber($var) { $this->number = (string) $var; }

	function getBank() { return $this->bank; }
	function getAccount() { return $this->account; }
	function getTransactions() { return $this->transactions; }
	function getStartPrice() { return $this->startPrice; }
	function getEndPrice() { return $this->endPrice; }
	function getTimestamp($format = 'U') { return date($format, $this->timestamp); }
	function getNumber() { return $this->number; }

	function addTransaction($transaction) { $this->transactions[] = $transaction; }
	function getDeltaPrice() { return ($this->getStartPrice() - $this->getEndPrice()); }
	
	function getMatchCount() {
		$matchCount = 0;
		foreach ($this->getTransactions() as $transaction) {
			$matchCount += count($transaction->getInvoiceIds());
		}
		return $matchCount;
	}

}