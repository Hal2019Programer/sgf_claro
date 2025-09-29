<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once dirname(__FILE__).'/vendor/autoload.php';
//Añadido por Juan 26-02-2021
require_once dirname(__FILE__).'/vendor/tecnickcom/tcpdf/tcpdf.php';
class GReports extends TCPDF {
	protected $con_logo;
	protected $lMargin;
	protected $tMargin;
	protected $titulo;
	protected $append_header;
	protected $groupby;
	protected $label_group;
	protected $name_group;
	protected $header_html;
	protected $headHTML;

	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=TRUE, $encoding='UTF-8', $diskcache=FALSE, $pdfa=FALSE, $logo=FALSE, $titulo=''){
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
		$this->SetCreator('Ronald E. Aybar D.');
		$this->SetAuthor('Ronald E. Aybar D.');
		$this->SetFont('helvetica');
		$this->header_html=FALSE;
		$this->headHTML='';
        $this->con_logo=$logo;
		$this->lMargin=0;
		$this->groupby=false;
		$this->label_group='';
		$this->name_group='';
		$this->tMargin=0;
		$this->append_header=false;
		$this->titulo=$titulo;
	}

	public function setTitulo($title){
		$this->SetTitle($title);
		$this->titulo=$title;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function addHeader($header){
		if(is_array($header)){ $this->append_header=$header;}
	}

	public function setHeaderHTML($content){
		if(!empty($content)){
			$this->headHTML=$content;
			$this->header_html=TRUE;
		}
	}

	public function addGroupReport($name, $label=""){
		if(!$this->groupby)
			$this->groupby=true;
		if($label!="")
			$this->label_group=$label;
		if($this->groupby && !empty($name))
			$this->name_group=$name;
	}

	public function Footer() {
        $this->SetY(-15);
        $this->SetFont('', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
	
	public function Header(){
		$this->SetFont('', 'B', 6);
		$this->writeHTMLCell($w = 0, $h = 50, $x = '', $y = 8, $this->headHTML, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = false);
	}
	
	/*
	public function Footer(){
	}
	*/
		
}
?>