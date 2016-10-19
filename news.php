<?php
	
	include_once("config.php");
	
	// Boostrapping
	include_once("vendor/simplepie/autoloader.php");
	
	
	// Grab incoming post/get parameters from Slack
	$command = isset($_REQUEST['command']) ? $_REQUEST['command'] : null;
	$feed = isset($_REQUEST['text']) && !empty($_REQUEST['text']) ? $_REQUEST['text'] : 'topstories';
	$incoming_token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;

	if ($incoming_token === $token) {
		
		if ($feed == "all") {
			$feed = "topstories";
		}
		
		if ($feed == "help") {
			
			$fields = array();
			$fields[0]['title'] = 'topstories';
			$fields[0]['value'] = 'Top Stories';
			$fields[0]['short'] = true;
			$fields[1]['title'] = 'business';
			$fields[1]['value'] = 'Business stories';
			$fields[1]['short'] = true;
			$fields[2]['title'] = 'canada';
			$fields[2]['value'] = 'Stories about Canada';
			$fields[2]['short'] = true;
			$fields[3]['title'] = 'offbeat';
			$fields[3]['value'] = 'Offbeat &amp; Colorful stories';
			$fields[3]['short'] = true;
			$fields[4]['title'] = 'politics';
			$fields[4]['value'] = 'Stories about Politics';
			$fields[4]['short'] = true;
			$output = array();
			$output['text'] = "The /news command brings back the 5 most current news items from CBC News.";
			$output['attachments'] = array();
			$output['attachments'][] = array(
					'title' => 'Categories',
					'text' => 'The following categories are available. Use /news [category] to get news items specific to the category.',
					'fields' => $fields,
				);
						
			$json = json_encode($output);
		
			// print the output!		
			header("Content-type: application/json");
			print $json;

		} else {
	
			switch($feed) {
				case 'topstories':
				default:
					$category = "Top Stories";
					break;
				case 'canada':
					$category = "Canada";
					break;
				case 'business':
					$category = "Business";
					break;
				case 'politics':
					$category = "Politics";
					break;
				case 'offbeat':
					$category = "Offbeat";
					break;
				case 'world':
					$category = "World";
					break;
				case 'technology':
					$category = "Technology & Science";
					break;
			}
		
			$rssfeed = "http://www.cbc.ca/cmlink/rss-{$feed}";
			$feed = new SimplePie();
			$feed->set_feed_url($rssfeed);
			$feed->set_item_limit(5);
			$success = $feed->init();
			$feed->handle_content_type();
			
			
	
			// fetch the feed.
			$i = 0;
			$return = array();
			foreach ($feed->get_items() as $item) {
				if ($i > 4) {
					continue;
				}
				$return[$i]['fallback'] = strip_tags($item->get_content());
				$return[$i]['title'] = $item->get_title();
				$return[$i]['title_link'] = $item->get_permalink();
				$return[$i]['text'] = strip_tags($item->get_content());
						
				$i++;
			}
			
			// build the return message.	
			$output = array(
				'text' => 'These are the 5 most current news items from CBC in the ' . $category . ' category.',
				'attachments' => $return,
			);
			
			$json = json_encode($output);
	
			// print the output!		
			header("Content-type: application/json");
			print $json;
		}
	}