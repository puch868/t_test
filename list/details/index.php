<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');?>
<?$APPLICATION->IncludeComponent(
	"test:details", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"IMG_W" => "200",
		"IMG_H" => "100"
	),
	false
);?>
<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>