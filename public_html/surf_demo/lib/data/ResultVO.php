<?
 /** 검색결과 Value Object.
 * @author KONAN Technology
 * @since 2010.04.01
 * @version 1.0
 */
Class ResultVO{
    //총 검색결과 수
    var $total;
    
    //검색결과로 가져온 레코드 수
    var $rows;
    
    //검색결과 필드수
    var $cols;

    //score : int[] 배열
    var $scores;

    //rowID : int[] 배열
    var $rowIds;
    
    //검색결과 레코드 : String[][] 배열
    var $fdata;	
    
	function setTotal( $p_total ){
		$this->total = $p_total;
	}

	function getTotal(){
		return $this->total;
	}

	function setRows( $p_rows ){
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
	
	function setRowIds( $p_rowIds ){
		$this->rowIds = $p_rowIds;
	}

	function getRowIds(){
		return $this->rowIds;
	}
	
	function setFdata( $p_fdata ,$p_row, $p_col ){
		$this->fdata[$p_row][$p_col] = $p_fdata;
	}

	function getFdata(){
		return $this->fdata;
	}
}
?>
