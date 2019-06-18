<?php

class SemanticActions {

	public static function onPageImporterRegisterPageLists( array &$pageLists ) {

	$pageLists['SemanticActions'] = [

		// list of pages to create and the corresponding files to use as content
		"pages" => [
			"Template:Actionable board column" => "Template/Actionable board column",
			"Template:Actionable board row" => "Template/Actionable board row",
			"Template:Actionable board" => "Template/Actionable board",
			"Template:Actionable" => "Template/Actionable",
			"Template:Add action button" => "Template/Add action button",
			"Template:Label" => "Template/Label",
			"Template:Label button" => "Template/Label button",
			"Template:Search actions button" => "Template/Search actions button",
			"Category:Actionable" => "Category/Actionable",
			"Category:Label" => "Category/Label",
			"Category:Page required for Actionable Extension" => "Category/Page required for Actionable Extension",
			"Form:Actionable" => "Form/Actionable",
			"Form:Label" => "Form/Label",
			"Property:Action ID" => "Property/Action ID",
			"Property:Action status" => "Property/Action status",
			"Property:Alias" => "Property/Alias",
			"Property:Assigned to" => "Property/Assigned to",
			"Property:Due date" => "Property/Due date",
			"Property:Label" => "Property/Label",
			"Property:Related article" => "Property/Related article",
			"Property:Resolution" => "Property/Resolution",
			"Property:Summary" => "Property/Summary",
		],

		// the directory where all paths in your list of pages are based from
		"root" => dirname(__DIR__) . '/importPages',

		// edit summary used when PageImporter edits pages
		"comment" => "Updated with content from Extension:SemanticActions version 1.0.0"
	];

	}

	public static function onBeforePageDisplay( $out ) {

		$out->addModuleStyles( 'ext.SemanticActions.styles' );

		return true;

	}

}
