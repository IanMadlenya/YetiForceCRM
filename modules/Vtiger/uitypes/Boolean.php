<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

class Vtiger_Boolean_UIType extends Vtiger_Base_UIType
{

	/**
	 * Function to get the DB Insert Value, for the current field type with given User Value
	 * @param mixed $value
	 * @param \Vtiger_Record_Model $recordModel
	 * @return mixed
	 */
	public function getDBValue($value, $recordModel = false)
	{
		if ($value === 'on' || (int) $value === 1) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Verification of data
	 * @param string $value
	 * @param bool $isUserFormat
	 * @return null
	 * @throws \App\Exceptions\SaveRecord
	 */
	public function validate($value, $isUserFormat = false)
	{
		if ($this->validate || empty($value)) {
			return;
		}
		if (!in_array($value, [0, 1, '1', '0', 'on'])) {
			throw new \App\Exceptions\SaveRecord('ERR_ILLEGAL_FIELD_VALUE||' . $this->get('field')->getFieldName() . '||' . $value, 406);
		}
		$this->validate = true;
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($value, $record = false, $recordInstance = false, $rawText = false)
	{
		if ($value === 1 || $value === '1' || strtolower($value) === 'on' || strtolower($value) === 'yes' || true === $value) {
			return Vtiger_Language_Handler::getTranslatedString('LBL_YES', $this->get('field')->getModuleName());
		} else if ($value === 0 || $value === '0' || strtolower($value) === 'off' || strtolower($value) === 'no' || false === $value) {
			return Vtiger_Language_Handler::getTranslatedString('LBL_NO', $this->get('field')->getModuleName());
		}
		return \App\Purifier::encodeHtml($value);
	}

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return string - Template Name
	 */
	public function getTemplateName()
	{
		return 'uitypes/Boolean.tpl';
	}

	public function getListSearchTemplateName()
	{
		return 'uitypes/BooleanFieldSearchView.tpl';
	}
}
