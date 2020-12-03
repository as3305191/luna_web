<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends MY_Base_Controller {

	function __construct() {
		parent::__construct();

	}

	public function index() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', '中文');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');
	}


}
?>
