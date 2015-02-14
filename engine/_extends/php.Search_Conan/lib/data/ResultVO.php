<?php
class ResultVO {
    	
	var $total;
    
   	var $rows;
    
    	var $cols;

    	var $scores;

    	var $rowIds;
    
    	var $fdata;	
    
	function setTotal($p_total){
		$this->total = $p_total;
	}

	function getTotal(){
		return $this->total;
	}

	function setRows($p_rows){
		$this->rows = $p_rows;
	}

	function getRows(){
		return $this->rows;
	}
	
	function setCols( $p_cols ){
		$this->cols = $p_cols;
	}

	function getCols(){
		return $this->cols;
	}
	
	function setScores( $p_scores ){
		$this->scores = $p_scores;
	}

	function getScores(){
		return $this->scores;
	}
	
	function setRowIds($p_rowIds){
		$this->rowIds = $p_rowIds;
	}

	function getRowIds(){
		return $this->rowIds;
	}
	
	function setFdata($p_fdata ,$p_row, $p_col){
		$this->fdata[$p_row][$p_col] = $p_fdata;
	}

	function getFdata(){
		return $this->fdata;
	}
}
?>
