<?php
/**
 * Sample input for bwe_sl_faq() — 7 questions, so the 7th is an "extra" (hidden behind "Show 1 more question").
 *
 * @package BWE_Gutenberg_Widget
 */

return array(
	'anchor'  => 'faq',
	'eyebrow' => 'FAQ',
	'title'   => 'Questions? <em>Answered.</em>',
	'intro'   => 'Quick answers before you get in touch.',
	'button'  => array( 'Ask a question →', '/contact/' ),
	'list_id' => 'bwex-faq-test',
	'items'   => array(
		array( 'How fast &amp; how cheap?', 'Within a day. <a href="/pricing/">See prices</a>.' ),
		array( 'Do I own the site?', 'Yes, 100%.' ),
		array( 'What&#8217;s included?', 'Design, build and launch.' ),
		array( 'WordPress or Shopify?', 'We do both.' ),
		array( 'Can you migrate?', 'Yes, with 301s.' ),
		array( 'Support after launch?', '30 days free.' ),
		array( 'Do you write copy?', 'On request · extra.' ),
	),
);
