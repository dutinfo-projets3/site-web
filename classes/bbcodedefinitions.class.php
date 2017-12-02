<?php

class BBCodeDefinitions implements CodeDefinitionSet {

	public function getCodeDefinitions(){
		return array(
			new SizeCodeDefinition(),
			new CenterCodeDefinition()
		);
	}
}

class SizeCodeDefinition extends CodeDefinition {

	public function __construct(){
		parent::__construct();
		$this->setTagName();
	}

}
