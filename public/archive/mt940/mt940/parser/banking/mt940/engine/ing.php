<?php
/**
 * Ing_engine_mt940_banking_parser
 *
 * @category   parser_engine
 * @package    MT940
 * @copyright  Copyright (c) 2010 Kingsquare Information Services (http://www.kingsquare.nl)
 * @license    http://opensource.org/licenses/gpl-2.0.php  Open Software License (GPLv2)
 */
class Ing_engine_mt940_banking_parser extends Engine_mt940_banking_parser {
	/**
	 * returns the name of the bank
	 * @return string
	 */
	function _parseStatementBank() {
		return 'ING';
	}
}