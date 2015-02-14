<?php
// VERSION: 3.6.x

require("CrzClient.php");
// languages
define("LC_DEFAULT",      0);
define("LC_KOREAN",       1);
define("LC_CHINESE",      2);
define("LC_JAPANESE",     3);
define("LC_ENGLISH",      4);
define("LC_UNIVERSAL",    5);
define("LC_USER0",        6);
define("LC_USER1",        7);
define("LC_USER2",        8);
define("LC_USER3",        9);
define("LC_USER4",        10);
define("LC_USER5",        11);
define("LC_USER6",        12);
define("LC_USER7",        13);
define("LC_USER8",        14);
define("LC_USER9",        15);
define("LC_DANISH",       16);
define("LC_DUTCH",        17);
define("LC_FINNISH",      18);
define("LC_FRENCH",       19);
define("LC_GERMAN",       20);
define("LC_ITALIAN",      21);
define("LC_NORWEGIAN",    22);
define("LC_PORTUGUESE",   23);
define("LC_SPANISH",      24);
define("LC_SWEDISH",      25);
define("LC_RUSSIAN",      26);
// character sets
define("CS_DEFAULT",      0);
define("CS_EUCKR",        1);
define("CS_EUCCN",        2);
define("CS_EUCJP",        3);
define("CS_UTF8",         4);
define("CS_USASCII",      5);
define("CS_BIG5",         6);
define("CS_SJIS",         7);
define("CS_USER0",        8);
define("CS_USER1",        9);
define("CS_USER2",        10);
define("CS_USER3",        11);
define("CS_USER4",        12);
define("CS_USER5",        13);
define("CS_USER6",        14);
define("CS_USER7",        15);
define("CS_USER8",        16);
define("CS_USER9",        17);
define("CS_LATIN1",       18);
define("CS_LATIN2",       19);
define("CS_LATIN3",       20);
define("CS_LATIN4",       21);
define("CS_LATIN5",       22);
define("CS_LATIN6",       23);
define("CS_LATIN7",       24);
define("CS_LATIN8",       25);
define("CS_LATIN9",       26);
define("CS_CYRILLIC",     27);
define("CS_ARABIC",       28);
define("CS_GREEK",        29);
define("CS_HEBREW",       30);
define("CS_THAI",         31);
define("CS_ENGLISH",      CS_USASCII);
define("CS_DANISH",       CS_LATIN1);
define("CS_DUTCH",        CS_LATIN1);
define("CS_FINNISH",      CS_LATIN1);
define("CS_FRENCH",       CS_LATIN1);
define("CS_GERMAN",       CS_LATIN1);
define("CS_ITALIAN",      CS_LATIN1);
define("CS_NORWEGIAN",    CS_LATIN1);
define("CS_PORTUGUESE",   CS_LATIN1);
define("CS_SPANISH",      CS_LATIN1);
define("CS_SWEDISH",      CS_LATIN1);
define("CS_RUSSIAN",      CS_CYRILLIC);
define("CS_TURKISH",      CS_LATIN5);
define("CS_NORDIC",       CS_LATIN6);
// query expand flag
//define("QEXP_K2K",     0x01);
//define("QEXP_K2E",     0x01);
//define("QEXP_E2K",     0x01);
//define("QEXP_E2E",     0x01);
//define("QEXP_TRL",     0x01);
//define("QEXP_RCM",     0x01);

//Transliterate Module
define("TRL_LANGUAGE_ENGLISH",    1);
define("TRL_LANGUAGE_KOREAN",     2);
define("TRL_LANGUAGE_MIX",        3);

//TextFilter Module
define("FILE_TYPE_AUTO",      0);
define("FILE_TYPE_HTML",      1);
define("FLT_F2F_MODE",        0);
define("FLT_B2B_MODE",        1);
define("FLT_F2B_MODE",        2);
define("FLT_B2F_MODE",        3);

class DOCRUZER
{
	function CreateHandle()
	{
		$crzClient = new CrzClient;
		$crzClient->Cleanup();
		return $crzClient;
	}
	function DestroyHandle( &$crzClient )
	{
		if($crzClient==NULL)
		{
			return;
		}
		$crzClient->Cleanup();
	}
	function GetErrorMessage( &$crzClient )
	{
		if($crzClient==NULL) {
			return "";
		}
		return $crzClient->GetMessage();
	}

	function SetOption( &$crzClient, $nOpt, $nVal )
	{
		if( $crzClient == NULL ) {
			return;
		}
		$crzClient->SetOption( $nOpt, $nVal );
	}

	function SetSearchOption_Cluster( &$crzClient,
		$nMaxCluster, $nMaxRecordToCluster, $fieldList,
		$prevTitle, $nPrevTitle, $keyList, $nFlag )
	{
		if( $crzClient == NULL ) {
			return;
		}
		$crzClient->SetClusterCondition( $nMaxCluster, $nMaxRecordToCluster,
			$fieldList, $prevTitle, $keyList, $nFlag );
	}

	function SetSearchOption_RelatedTerm( &$crzClient, $nRelatedTerms )
	{
		if( $crzClient == NULL ) {
			return;
		}
		$crzClient->SetRelatedTermCondition( $nRelatedTerms );
	}

	function SetSearchOption_TimeOut( &$crzClient, $nTimeOutSec )
	{
		if( $crzClient == NULL ) {
			return;
		}
		$crzClient->SetTimeOut( $nTimeOutSec );
	}

	function SetSearchOption_ExpandQuery( &$crzClient, $query, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		$crzClient->SetExpandQueryCondition( $query, $nFlag );
	}

	function SubmitQuery( &$crzClient, $saddr, $port,
		$authCode, $logInfo, $scn,
		$whereClause, $sortingClause, $highlight,
		$nStartOffset, $nRecordCount, $nLanguage, $nCharset )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		$rc = $crzClient->SubmitQuery( $saddr, $port, $authCode, $logInfo, $scn,
			$whereClause, $sortingClause, $highlight,
			$nStartOffset, $nRecordCount, $nLanguage, $nCharset );
		return $rc;
	}

	function Insert(
		&$crzClient, $serviceAddr, $fullTableName,
		$fieldName, $fieldData, $numFields,
		$language, $charset, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->Insert( $serviceAddr, $fullTableName,
			$fieldName, $fieldData, $numFields,
			$language, $charset, $nFlag );
	}

	function Delete(
		&$crzClient, $serviceAddr, $fullTableName, $expr,
		$language, $charset, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->Delete( $serviceAddr,
			$fullTableName, $expr, $language, $charset, $nFlag);
	}

	function Update(
		&$crzClient, $serviceAddr, $fullTableName, $expr,
		$fieldName, $fieldData, $numFields,
		$language, $charset, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->Update( $serviceAddr,
			$fullTableName, $expr,
			$fieldName, $fieldData, $numFields,
			$language, $charset, $nFlag );
	}

	function GetResult_TotalCount( &$crzClient )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetTotalCount();
	}

	function GetResult_RowSize( &$crzClient )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetRowSize();
	}

	function GetResult_ColumnSize( &$crzClient )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetColumnSize();
	}

	function GetResult_ColumnName( &$crzClient, &$colName, $colSize )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetColumnName( $colName, $colSize );
	}

	function GetResult_Row( &$crzClient, &$fieldData, $nRowNo )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetRow( $fieldData, $nRowNo );
	}

	function GetResult_ROWID( &$crzClient, &$rowID, &$score )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetRecordNoArray( $rowID, $score );
	}

	function GetResult_Cluster( &$crzClient, &$title,
		&$class_record_no, &$rec_cnt_per_class )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetClusters( $title, $class_record_no, $rec_cnt_per_class );
	}

	function GetResult_RelatedTerm( &$crzClient, &$recWord )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetRelatedTerms( $recWord );
	}

	function GetResult_SearchTime( &$crzClient )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetSearchTime();
	}

	function GetResult_ExpandQuery( &$crzClient, &$words, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetExpandQuery( $words, $nFlag );
	}

	function GetResult_ExpandQuery_Count( &$crzClient, $nFlag )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetExpandQueryCount( $nFlag );
	}

	function SetAuthCode( &$crzClient, $authcode )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->SetAuthCode( $authcode );
	}

	function SetLog( &$crzClient, $log )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->SetLog( $log );
	}

	function GetQueryAttribute( &$crzClient,
			$serviceAddr, &$attr_count, &$attr_name,
			&$lb_op, &$lb_val, &$ub_op, &$ub_val,
			&$remained_str,
			$query, $max_attr_count, $domain )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetQueryAttribute(
			$serviceAddr, $attr_count, $attr_name,
			$lb_op, $lb_val, $ub_op, $ub_val,
			$remained_str,
			$query, $max_attr_count, $domain );
	}

	function CompleteKeyword( &$crzClient,
			$serviceAddr, &$nKwd, &$kwd_list, &$cnv_str,
			$max_kwd_count, $seed_str, $nFlag, $nDomainNo )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->CompleteKeyword(
			$serviceAddr, $nKwd, $kwd_list, $rank=NULL, $tag=NULL, $num=NULL, $cnv_str,
			$max_kwd_count, $seed_str, $nFlag, $nDomainNo );
	}

	// 2006.09.25 추가
	function CompleteKeyword2( &$crzClient,
			$serviceAddr, &$nKwd, &$kwd_list, &$rank, &$tag, &$num, &$cnv_str,
			$max_kwd_count, $seed_str, $nFlag, $nDomainNo )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		
		return $crzClient->CompleteKeyword(
			$serviceAddr, $nKwd, $kwd_list, $rank, $tag, $num, $cnv_str,
			$max_kwd_count, $seed_str, $nFlag, $nDomainNo );
	}

	function SpellCheck( &$crzClient,
			$serviceAddr, &$out_count, &$out_word, $max_out_count, $in_word )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
	
		return $crzClient->SpellCheck(
			$serviceAddr, $out_count, $out_word, $max_out_count, $in_word );
	}

// 2006.02.09 추가
	function RecommendKeyword( &$crzClient,
			$serviceAddr, &$out_count, &$out_str,
			$max_out_count, $in_str, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		
		return $crzClient->RecommendKeyword(
			$serviceAddr, $out_count, $out_str, $max_out_count, $in_str, $domain_no );
	}

// 2006.01.25 추가
	function Select( &$crzClient, $serviceAddr,
		$scn, $whereClause, $sortingClause, $highlight,
		$nStartOffset, $nRecordCount, $nLanguage, $nCharset )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		$rc = $crzClient->Select( $serviceAddr,
			$scn, $whereClause, $sortingClause, $highlight,
			$nStartOffset, $nRecordCount, $nLanguage, $nCharset );
		return $rc;
	}

// 2006.03.17 추가
	function GetPopularKeyword( &$crzClient,
			$serviceAddr, &$out_count, &$out_str,
			$max_out_count, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetPopularKeyword(
			$serviceAddr, $out_count, $out_str, $out_tag=NULL, $max_out_count, $domain_no );
	}

// 2006.09.25 추가
	function GetPopularKeyword2( &$crzClient,
			$serviceAddr, &$out_count, &$out_str, &$out_tag,
			$max_out_count, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetPopularKeyword(
			$serviceAddr, $out_count, $out_str, $out_tag, $max_out_count, $domain_no );
	}

// 2006.09.27 추가
	function AnchorText( &$crzClient, $serviceAddr,
			&$out_text, $in_text, $tag_scheme, $option, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->AnchorText(
			$serviceAddr, $out_text, $in_text, $tag_scheme, $option, $domain_no );
	}

// 2006.09.27
	function GetSynonymList( &$crzClient, $serviceAddr,
			&$term_count, &$synonym_count, &$synonym_list,
			$max_term_count, $in_str, $opt_part_exp, $opt_morph_exp,
			$nLanguage, $nCharset, $compound_level, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetSynonymList(
						$serviceAddr, $term_count, $synonym_count, $synonym_list,
						$max_term_count, $in_str, $opt_part_exp, $opt_morph_exp,
						$nLanguage, $nCharset, $compound_level, $domain_no );
	}

// 2006.09.27
	function ExtractKeyword( &$crzClient, $serviceAddr,
			&$out_keyword_count, &$out_keyword,
			$max_keyword_count, $link_name, $input_text,
			$nOption, $nLanguage, $nCharset, $compound_level )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->ExtractKeyword(
						$serviceAddr, $out_keyword_count, $out_keyword,
						$max_keyword_count, $link_name, $input_text,
						$nOption, $nLanguage, $nCharset, $compound_level );
	}

// 구현 안됨
	function SetClientLogLocation( &$crzClient, $path, $nOption1, $nOption2 )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		//return $crzClient->SetClientLogLocation( $path, $nOption1, $nOption2 );
		return -1;
	}

// 2007.05.02 추가
	function Search( &$crzClient, $serviceAddr,
		$scn, $whereClause, $sortClause, $searchWords, $logInfo,
		$startOffset, $count, $language, $charset )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		$rc = $crzClient->Search( $serviceAddr,
			$scn, $whereClause, $sortClause, $searchWords, $logInfo,
			$startOffset, $count, $language, $charset );
		return $rc;
	}

// 2007.06.27 추가
	function GetRealTimePopularKeyword( &$crzClient,
			$serviceAddr, &$out_count, &$out_str, &$out_tag,
			$max_out_count, $opt_online, $domain_no )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetRealTimePopularKeyword(
			$serviceAddr, $out_count, $out_str, $out_tag, $max_out_count, $opt_online, $domain_no );
	}

// 2007.07.25 추가
	function GetResult_GroupBy( &$crzClient,
			&$out_group_count, &$out_key_count, &$out_group_key_val, &$out_group_size,
			$max_group_count)
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetResultGroupBy(
			$out_group_count, $out_key_count, $out_group_key_val, $out_group_size,
			$max_group_count);
	}

// 2007.10.01 추가
	function GetResult_ROWID2( &$crzClient,
			&$out_rowid_count, &$out_table_no,
			&$out_link_name, &$out_volume_name, &$out_table_name, &$out_rowid, &$out_score,
			$max_rowid_count)
	{
		if ( $crzClient == NULL) {
			return -1;
		}
		return $crzClient->GetROWID2(
			$out_rowid_count, $out_table_no,
			$out_link_name, $out_volume_name, $out_table_name, $out_rowid, $out_score,
			$max_rowid_count);
	}

	function CensorSearchWords ( &$crzClient,
			$serviceAddr, &$out_censored_word_count, &$out_censored_word,
			$max_censor_word_count, $search_words, $domain_no)
	{
		if ( $crzClient == NULL) {
			return -1;
		}
		return $crzClient->CensorSearchWords (
			$serviceAddr, $out_censored_word_count, $out_censored_word,
			$max_censor_word_count, $search_words, $domain_no);
	}

	function Transliterate ( &$crzClient,
			$serviceAddr, &$out_transliterated_word_count, &$out_transliterated_word,
			$max_transliterate_word_count, $search_words, $target_language, $domain_no)
	{
		if ( $crzClient == NULL) {
			return -1;
		}
		return $crzClient->Transliterate (
			$serviceAddr, $out_transliterated_word_count, $out_transliterated_word,
			$max_transliterate_word_count, $search_words, $target_language, $domain_no);
	}

	function FilterText ( &$crzClient,
			$serviceAddr, &$out_text_size, &$out_text,
			$in_doc_buf_size, $in_doc_buf,
			$out_file_name, $in_file_name,
			$doc_type, $run_mode, $domain_no)
	{
		if ( $crzClient == NULL) {
			return -1;
		}

		return $crzClient->FilterText (
			$serviceAddr, $out_text_size, $out_text,
			$in_doc_buf_size, $in_doc_buf,
			$out_file_name, $in_file_name,
			$doc_type, $run_mode, $domain_no);
	}
	
	function PutCache ( &$crzClient,
			$serviceAddr, $in_key_size, $in_key,
			$in_data_size, $in_data,
			$in_priority_key, $domain_no)
	{
		if ( $crzClient == NULL) {
			return -1;
		}

		return $crzClient->PutCache (
			$serviceAddr, $in_key_size, $in_key,
			$in_data_size, $in_data,
			$in_priority_key, $domain_no);
	}
	
	function GetCache ( &$crzClient,
			$serviceAddr, &$out_hit_flag,
			&$out_data_size, &$out_data,
			$in_key_size, $in_key,
			$domain_no)
	{
		if ( $crzClient == NULL) {
			return -1;
		}

		return $crzClient->GetCache (
			$serviceAddr, $out_hit_flag,
			$out_data_size, $out_data,
			$in_key_size, $in_key,
			$domain_no);
	}

	// 2009.12.14 추가
	function GetResult_Matchfield( &$crzClient, &$matchfield )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetMatchfieldArray( $matchfield );
	}

	function GetResult_UserKeyIndex( &$crzClient, &$userkey_index )
	{
		if( $crzClient == NULL ) {
			return -1;
		}
		return $crzClient->GetUserKeyIndexArray( $userkey_index );
	}

}

?>

