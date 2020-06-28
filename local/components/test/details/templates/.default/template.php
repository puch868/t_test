<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="item-block">
	<div class="item-img"><img width="<?=$arParams['IMG_W'];?>px;"  height="<?=$arParams['IMG_H'];?>px" src="<?=CFile::getPath($arResult['ITEM']['DETAIL_PICTURE']);?>" ></div>
	<div class="item-desc"><?=$arResult['ITEM']['DETAIL_TEXT']?></div>
</div>
