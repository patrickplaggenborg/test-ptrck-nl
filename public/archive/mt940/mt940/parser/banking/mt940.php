<?php
/**
 * Mt940_banking_parser
 *
 * @category   parser
 * @package    MT940
 * @copyright  Copyright (c) 2010 Kingsquare Information Services (http://www.kingsquare.nl)
 * @license    http://opensource.org/licenses/gpl-2.0.php  Open Software License (GPLv2)
 */
class Mt940_banking_parser extends Banking_parser {

	/**
	 * Parse the given string into an array of statement_banking objects
	 * @param string $string
	 * @return array
	 */
	function parse($string) {
		if (!empty($string)) {
			// load engine
			$this->engine = Engine_mt940_banking_parser::__getInstance($string);
			if (is_a($this->engine, 'Engine_mt940_banking_parser')) {
				// parse met de engine
				return $this->engine->parse();
			}
		}
		return array();
	}
}