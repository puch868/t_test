<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("SORT" => "ASC"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}



$arComponentParameters = array(
	
	"PARAMETERS" => array(
		
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => 'IBlock Type',
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => 'IBlock',
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"IMG_W" => array(
			"PARENT" => "BASE",
			"NAME" => 'Picture width',
			"TYPE" => "STRING",
			"VALUES" => '100',
		),
		"IMG_H" => array(
			"PARENT" => "BASE",
			"NAME" => 'Picture height',
			"TYPE" => "STRING",
			"VALUES" => '100',
		),
	),
);

?>
