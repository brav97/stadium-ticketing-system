<?php
// This script and data application were generated by AppGini 5.75
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/FANS.php");
	include("$currDir/FANS_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('FANS');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "FANS";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`FANS`.`ID`" => "ID",
		"`FANS`.`Name`" => "Name",
		"`FANS`.`phone`" => "phone",
		"`FANS`.`id_no`" => "id_no"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`FANS`.`ID`',
		2 => 2,
		3 => '`FANS`.`phone`',
		4 => '`FANS`.`id_no`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`FANS`.`ID`" => "ID",
		"`FANS`.`Name`" => "Name",
		"`FANS`.`phone`" => "phone",
		"`FANS`.`id_no`" => "id_no"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`FANS`.`ID`" => "ID",
		"`FANS`.`Name`" => "Name",
		"`FANS`.`phone`" => "Phone",
		"`FANS`.`id_no`" => "Id no"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`FANS`.`ID`" => "ID",
		"`FANS`.`Name`" => "Name",
		"`FANS`.`phone`" => "phone",
		"`FANS`.`id_no`" => "id_no"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`FANS` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 0;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 0;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 0;
	$x->AllowPrintingDV = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "FANS_view.php";
	$x->RedirectAfterInsert = "FANS_view.php?SelectedID=#ID#";
	$x->TableTitle = "FANS";
	$x->TableIcon = "resources/table_icons/teamwork.png";
	$x->PrimaryKey = "`FANS`.`ID`";

	$x->ColWidth   = array(  150, 150, 150);
	$x->ColCaption = array("Name", "Phone", "Id no");
	$x->ColFieldName = array('Name', 'phone', 'id_no');
	$x->ColNumber  = array(2, 3, 4);

	// template paths below are based on the app main directory
	$x->Template = 'templates/FANS_templateTV.html';
	$x->SelectedTemplate = 'templates/FANS_templateTVS.html';
	$x->TemplateDV = 'templates/FANS_templateDV.html';
	$x->TemplateDVP = 'templates/FANS_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `FANS`.`ID`=membership_userrecords.pkValue and membership_userrecords.tableName='FANS' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `FANS`.`ID`=membership_userrecords.pkValue and membership_userrecords.tableName='FANS' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`FANS`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: FANS_init
	$render=TRUE;
	if(function_exists('FANS_init')){
		$args=array();
		$render=FANS_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: FANS_header
	$headerCode='';
	if(function_exists('FANS_header')){
		$args=array();
		$headerCode=FANS_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: FANS_footer
	$footerCode='';
	if(function_exists('FANS_footer')){
		$args=array();
		$footerCode=FANS_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>