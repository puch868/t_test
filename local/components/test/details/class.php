<?

class CDetails extends CBitrixComponent{
	private function getItem(){
		global $APPLICATION,$CACHE_MANAGER;
		
		$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest(); 
		
		$element=$request->get('ELEMENT_ID');
		
		$cache_id = md5(serialize($arParams).'&ID='.$element);
		
		$cache_dir = "/tagged_getlist";

		$obCache = new CPHPCache;

		if($obCache->InitCache(36000, $cache_id, $cache_dir))
		{
			$this->arResult['ITEM']= $obCache->GetVars();
		}
		elseif($obCache->StartDataCache())
		{
			$CACHE_MANAGER->StartTagCache($cache_dir);
			
			$arFilter=array(
				'IBLOCK_ID'=>$arParams['IBLOCK_ID'],
				'ID'=>$element
			);
			
			$arItem = CIBlockElement::GetList(array(), $arFilter)->Fetch();
			
			$CACHE_MANAGER->RegisterTag("iblock_id_".$arItem["IBLOCK_ID"].'_'.$element);
			//_debs($arItem);
			
			$this->arResult['ITEM']=$arItem;
			
			$CACHE_MANAGER->EndTagCache();

			$obCache->EndDataCache($arItem);
		}
		$APPLICATION->setTitle($this->arResult['ITEM']['NAME']);
	}
	
	public function executeComponent()
    {
        if($this->startResultCache())
        {
			$this->getItem();
            $this->includeComponentTemplate();
        }
        return $this->arResult["Y"];
    }
}

?>