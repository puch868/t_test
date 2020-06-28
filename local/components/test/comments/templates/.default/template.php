<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<hr>
<div class="comment-add">
	<form method="post">
		<input name="comment-object" type="hidden" placeholder="Имя" value="<?=$arResult['OBJECT'];?>">
		<input name="comment-name" type="text" placeholder="Имя">
		<textarea name="comment-text" placeholder="Комментарий"></textarea>
		<input type="submit" name="comment-add" value="Отправить">
	</form>
</div>
<hr>
<div class="comments-block">
	<?foreach($arResult['ITEMS'] as $arItem):?>
		<div class="comment-block">
			<div class="comment-title"><span><?=$arItem['NAME'];?></span> <span><?=$arItem['DATE_CREATE']?></span></div>
			<div class="comment-desc"><?=$arItem['PREVIEW_TEXT'];?></div>
		</div>
	<?endforeach;?>
</div>