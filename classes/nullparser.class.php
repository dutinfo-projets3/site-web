<?php
class NullParser {

	public static function addDefinitions($parser){
		$builder = new JBBCode\CodeDefinitionBuilder('i', '{param}');
		$parser->addCodeDefinition($builder->build());

		$builder = new JBBCode\CodeDefinitionBuilder('u', '{param}');
		$parser->addCodeDefinition($builder->build());

		$builder = new JBBCode\CodeDefinitionBuilder('b', '{param}');
		$parser->addCodeDefinition($builder->build());

		// @TODO: Réparer ça
		// Ajouter d'autres codes
		$builder = new JBBCode\CodeDefinitionBuilder('color', '{param}');
		$parser->addCodeDefinition($builder->build());
	}

}
