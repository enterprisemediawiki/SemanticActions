# Semantic Actions
An action tracking system for a Semantic MediaWiki.

![Image of action board](/images/Action_board.png)

![Image of action board](/images/Action_board_table.png)

![Image of action board](/images/Action_form.png)

## Dependencies
* [MediaWiki](https://www.mediawiki.org/wiki/MediaWiki)
* [Extension:Semantic Mediawiki](https://www.mediawiki.org/wiki/Extension:Semantic_MediaWiki) 3.0+
* [Extension:Page Forms](https://www.mediawiki.org/wiki/Extension:Page_Forms)
* [Extension:Display Title](https://www.mediawiki.org/wiki/Extension:Display_Title)
* [Extension:Page Importer](https://github.com/enterprisemediawiki/PageImporter)
* [Extension:ParserFunctions](https://www.mediawiki.org/wiki/Extension:ParserFunctions)
* [Extension:Arrays](https://www.mediawiki.org/wiki/Extension:Arrays)

## Installation
SemanticActions should be loaded using wfLoadExtension:

```
wfLoadExtension('SemanticActions');
```

This extension requires some pages to be imported using [Extension:PageImporter](https://github.com/enterprisemediawiki/PageImporter).

```
php extensions/PageImporter/importPages.php
```

tbd - not sure if running update.php is required

## Configuration
By default, you can assign actions to any page in Category:Person. For example, your wiki might have a page for each person with their name as the title of the page. If you don't have such a category set up and you just use the User namespace (like "User:NotSoAwesomeSteve"), then include the following line in your LocalSettings.php to configure actions to be assigned to any page in the User namespace. Note that this configuration will which file is imported for the action form, so you'll need to ensure you import pages after setting this configuration, as described above.

```
$egSemanticActionsAssigneeValuesFrom = "User";
```

## Assumptions
This extension assumes you have a Template:Person that is used for pages about the people using your wiki. Actions can be assigned to values in Category:Person (which would be set in Template:Person).

You might want to query all open actions assigned to a person and display those on their person page. In Template:Person you'd add something like the following to do this:

```
<h2> Open Actions </h2>
''See [[Actions]] for more information.''

{{#ask: [[Category:Actionable]] [[Action status::Open]] [[Assigned to::{{FULLPAGENAME}}]]
|mainlabel=Action
|?Due date
|?Assigned to
|?Label
|?Related article
|format=table
|sort=Action ID
|order=DESC
|default = No actions
|intro = 
}}
```

## Use
Each action is saved as its own wiki page. By doing this, each action retains its history and has an associated discussion page. We can also query actions like any other content in the wiki. So actions can be queried and filtered by the status, due date, actionee, label, and related articles.

When you create an action, it is important to add related articles so the action will appear in queries.

### Action form fields
![Image of action board](/images/Action_form.png)

**Action** is the summary and title of the action. Make it specific and concise.

**Status** is either open or closed.

**Due** indicates the due date.

**Actionees** is a list of people working on the action.

**Labels** are generic descriptors intended to be used to filter actions (e.g. "Low priority", "In work", "Bug", etc).

![Image of action board](/images/Action_labels.png)

**Related articles** are literally any page in the wiki. The generic footer can be configured so actions automatically show up in the footer of the wiki page for each related article (see below for instructions on how to do this). Related articles are also used to define which actions are displayed in an action board.

**Details** is where you can more fully describe the action and add incremental progress.

**Resolution** is a field that only shows up when you mark an action as closed. Describe how the action was resolved.

### Action board
An action board (like a kanban board) can be created on any wiki page and can be configured to display any set of actions based on status, labels, and related articles.

To create an action board, use the template as shown below.

```
{{Actionable board
|Open, Closed, or All (only show actions with this Action status); default=Open
|List of Related articles (only show actions with all of these Related articles)
|List of Labels to use for columns
|True or False (do you want a column on the left that shows actions that do not have any of the labels specified for this board?); default=False
|View or Edit (do you want action links to go to the view or edit mode?)
|List of default Related articles for new actions created from links in this table
}}
```

#### Example
```
{{Actionable board
|Open
|Pump module
|In work, Risk trade, Ready for review
|True
|View
|Pump module
}}
```

![Image of action board](/images/Action_board.png)

### Traditional semantic queries
If you prefer another format, you may still use all the various results formats provided by [Semantic MediaWiki](https://www.semantic-mediawiki.org/wiki/Help:Result_formats) and [Extension:Semantic Result Formats](https://www.semantic-mediawiki.org/wiki/Extension:Semantic_Result_Formats).

For example, you can use the standard table format as shown in the example below.

```
{{#ask: [[Category:Actionable]] [[Related article::Pump module]]
|?Action status=Status
|?Assigned to
|?Due date
|?Label
|?Related article
|format=table
|limit=50
|sort=Action status
|order=DESC
}}
```

![Image of action board](/images/Action_board_table.png)

### Buttons
![Image of action board](/images/Action_search_add_buttons.png)

To add a button linking to MediaWiki advanced search, filtered to only search the Action namespace, use the following template call:

```
{{Search actions button}}
```

To add a button on a page linking to the form to add an action, use the following template call:

```
{{Add action button}}
```

It is highly recommended that you pass at least one pagename to this template call. Pagenames passed to Template:Add action button will be used to pre-populate the Related article field. This is the best way to link actions to relevant articles and to aid in filtering actions in queries. Here is an example of a button where the pages for "Beer" and "Cheese" are passed as Related articles:

```
{{Add action button|Beer,Cheese}}
```

### Sidebar link
You can customize the sidebar in MediaWiki. You may choose to add a link in your wiki's sidebar allowing users to add an action. Done right, this link will pre-populate the Related article field of the new action with the name of the page you were on.

```
{{canonicalurl:Special:FormEdit/Actionable|Actionable%5BRELATED_ARTICLE%5D={{FULLPAGENAME}}}}|Add an action
```

### Footer
If you install [Extension:Header Footer](https://www.mediawiki.org/wiki/Extension:Header_Footer), you can modify the page MediaWiki:Hf-nsfooter- to include a query to show all actions related to the page. The example code below also uses [Extension:Header Tabs](https://www.mediawiki.org/wiki/Extension:Header_Tabs), which allows you to append multiple queries formatted in different tabs.

```
__NOTOC__<br style="clear:both;" />
{{#ask: [[Category:Actionable]] [[Related article::{{PAGENAME}}]]
|mainlabel=Action
|?Action ID
|?Action status=Status
|?Due date
|?Assigned to
|?Label
|?Related article
|format=table
|sort=Action ID
|order=DESC
|intro= <h1> Actions </h1>
''See '''[https://github.com/enterprisemediawiki/SemanticActions this page]''' for more information''
}}
<headertabs/>
```
![Image of action board](/images/Action_footer.png)
