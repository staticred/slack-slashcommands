# slack-slashcommands
This builds a couple of slack commands for custom integration. 

##/siteup [domain]##

This is based on [David McCreath's tutorial](https://github.com/mccreath/isitup-for-slack/blob/master/docs/TUTORIAL.md) for building a slash command in Slack (see also the [Medium article](https://slackhq.com/a-beginner-s-guide-to-your-first-bot-97e5b0b7843d#.a6oti0ce7))

##/news [topic]##

This slash command returns the 5 most recent news articles from CBC News' RSS feeds. You can use the following after the `/news` command to filter the results:

* `/news help` - provides a bit more help for the command
* `/news business` - Business news
* `/news canada` - News about Canada
* `/news offbeat` - Quirky news
* `/news politics` - News about politics
* `/news technology` - Science & Technology news
* `/news topstories` - Returns the top stories (default)
* `/news world` - Returns news from around the World

These are brought back from the CBC's RSS feeds, which are listed here:
	
	http://www.cbc.ca/rss/
	
NOTE: Additional RSS feeds can be brought back in the slash command by using the specific RSS feed. For example, if you wanted curling news, you would type `/news sports-curling`
