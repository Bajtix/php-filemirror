editAreaLoader.load_syntax["json"] = {
	'DISPLAY_NAME': 'Json'
	, 'COMMENT_SINGLE': {}
	, 'COMMENT_MULTI': {}
	, 'QUOTEMARKS': { 1: '"' }
	, 'KEYWORD_CASE_SENSITIVE': false
	, 'OPERATORS': [
		':'
	]
	, 'DELIMITERS': [
		'[', ']', '{', '}'
	]
	, 'REGEXPS': {
		'variables': {
			'search': '()(\\"\\w+\\"(?=:))()'
			, 'class': 'variables'
			, 'modifiers': 'g'
			, 'execute': 'before' // before or after
		}
	}
	, 'STYLES': {
		'QUOTESMARKS': 'color: #879EFA;'
		, 'OPERATORS': 'color: #FF00FF;'
		, 'DELIMITERS': 'color: #2B60FF;'
		, 'REGEXPS': {
			'variables': 'color: #E0BD54;'
		}
	}
};
