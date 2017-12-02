<?php

class Parser {

	private static $instance;

	private function __construct(){ }

	public static function getInstance(){
		if (Parser::$instance == null){
			Parser::$instance = new JBBCode\Parser();
			Parser::$instance->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

			$builder = new JBBCode\CodeDefinitionBuilder('center', '<div class="text-center">{param}</div>');
			Parser::$instance->addCodeDefinition($builder->build());

			$builder = new JBBCode\CodeDefinitionBuilder('s', '<span style="text-decoration: line-through">{param}</span>');
			Parser::$instance->addCodeDefinition($builder->build());

			$builder = new JBBCode\CodeDefinitionBuilder('size', '<span style="font-size: {option}px">{param}</span>');
			$builder->setUseOption(true);
			Parser::$instance->addCodeDefinition($builder->build());
		}
		return Parser::$instance;
	}

	public static function parse(News $news, bool $markup){
		if ($markup){
			$news->setDescription(Parser::getInstance()->parse($news->getDescription())->getAsHtml());
		} else {
			$news->setDescription(Parser::getInstance()->parse($news->getDescription())->getAsText());
		}
	}
}
