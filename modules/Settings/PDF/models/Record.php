<?php

/**
 * Record Class for PDF Settings
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Maciej Stencel <m.stencel@yetiforce.com>
 */
class Settings_PDF_Record_Model extends Settings_Vtiger_Record_Model
{

	public function getId()
	{
		return $this->get('pdfid');
	}

	public function getName()
	{
		return $this->get('summary');
	}

	public function get($key)
	{
		return parent::get($key);
	}

	public function getEditViewUrl()
	{
		return 'index.php?module=PDF&parent=Settings&view=Edit&record=' . $this->getId();
	}

	public function getModule()
	{
		return $this->module;
	}

	public function setModule($moduleName)
	{
		$this->module = Vtiger_Module_Model::getInstance($moduleName);
		return $this;
	}

	/**
	 * Function to get the list view actions for the record
	 * @return <Array> - Associate array of Vtiger_Link_Model instances
	 */
	public function getRecordLinks()
	{

		$links = array();

		$recordLinks = array(
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_EDIT_RECORD',
				'linkurl' => $this->getEditViewUrl(),
				'linkicon' => 'glyphicon glyphicon-pencil'
			),
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_DELETE_RECORD',
				'linkurl' => 'javascript:Vtiger_List_Js.deleteRecord(' . $this->getId() . ');',
				'linkicon' => 'glyphicon glyphicon-trash'
			)
		);
		foreach ($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}

		return $links;
	}

	public static function getCleanInstance($moduleName)
	{
		$pdf = new self;
		$data = [
			'pdfid' => '',
			'module_name' => $moduleName,
			'summary' => 'qweasdas',
			'cola' => '',
			'colb' => '',
			'colc' => '',
			'cold' => '',
		];
		$pdf->setData($data);
		return $pdf;
	}

	public function save()
	{
		$db = PearDatabase::getInstance();

		if (!$this->getId()) {
			$params = [
				'module_name' => $this->get('module_name'), 'summary' => $this->get('summary'), 'cola' => $this->get('cola'),
				'colb' => $this->get('colb'), 'colc' => $this->get('colc'), 'cold' => $this->get('cold')
			];
			$db->insert('a_yf_pdf', $params);

			$this->set('pdfid', $db->getLastInsertID());

			return $this->get('pdfid');
		}
	}
}
