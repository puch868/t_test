<?

class CTestComments extends CBitrixComponent{
	private $clear_cache=false;
	
	private function getIblock(){
		$arIblock = CIBlock::GetList(
			Array(),
			Array(
				"CODE" => 'comments',
			)
		)->fetch();



		if(!$arIblock['ID']){
			$ib=new CIBlock;
			$ib_id=$ib->add(array('IBLOCK_TYPE_ID'=>'news','SITE_ID'=>'s1','CODE'=>'comments','NAME'=>'comments'));
			
			if($ib_id>0){
				$arIblock['ID']=$ib_id;
				
			}
			
			CIBlock::SetPermission($arIblock['ID'],array('2'=>'R'));
		}

		return $arIblock['ID'];	
	}
	
	private function getComments(){
		global $CACHE_MANAGER;
		
		$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest(); 
		
		$element=$request->get('ELEMENT_ID');
		$this->arResult['OBJECT']=$element;
		
		$cache_id = md5(serialize($arParams).'&ID='.$element);
		
		$cache_dir = "/tagged_getcomments";

		$obCache = new CPHPCache;

		if(!$this->clear_cache && $obCache->InitCache(36000, $cache_id, $cache_dir))
		{
			$this->arResult['ITEMS']= $obCache->GetVars();
		}
		elseif($obCache->StartDataCache())
		{
			$CACHE_MANAGER->StartTagCache($cache_dir);
			
			$arFilter=array(
				'IBLOCK_ID'=>$this->getIblock(),
				'TAGS'=>$element,
			);

			$dbRes=CIBlockElement::GetList(array('ID'=>'DESC'), $arFilter);
			
			
			while($arItem=$dbRes->Fetch()){
				$this->arResult['ITEMS'][]=$arItem;
			}
						
			$CACHE_MANAGER->RegisterTag('comments_'.$this->getIblock().'_'.$element);
			$CACHE_MANAGER->EndTagCache();
			
			$obCache->EndDataCache($this->arResult['ITEMS']);
		}
	}
	
	private function saveComment(){
		global $CACHE_MANAGER;
		
		$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest(); 
		
		if($request->get('comment-add') 
			&& $request->get('comment-name')
			&& $request->get('comment-text')){
			$ib=new CIBlockElement;
			$ib->add(array(
				'IBLOCK_ID'=>$this->getIblock(),
				'NAME'=>$request->get('comment-name'),
				'PREVIEW_TEXT'=>$request->get('comment-text'),
				'TAGS'=>$request->get('comment-object'),
			));
			
			$CACHE_MANAGER->ClearByTag('comments_'.$this->getIblock().'_'.$request->get('comment-object'));
			
			
		}
	}
	
	public function executeComponent()
    {
        if($this->startResultCache())
        {
			$this->saveComment();
			
			$this->getComments();
			
            $this->includeComponentTemplate();
        }
        return $this->arResult["Y"];
    }
}

?>