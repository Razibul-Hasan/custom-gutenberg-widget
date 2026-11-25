<?php
/**
 * Sample input for bwe_sl_cards(): three cards, the middle one without a chip, entities in names.
 *
 * @package BWE_Gutenberg_Widget
 */

return array(
	'anchor'  => 'why',
	'eyebrow' => 'Why us',
	'title'   => 'Six Lines We <em>Check</em>',
	'intro'   => 'Every site, every time.',
	'items'   => array(
		array( 'Speed &amp; Core Web Vitals', 'Pages feel instant on a mid-range phone.', 'CWV: pass' ),
		array( 'Mobile-first', 'Laid out for thumbs first.' ),
		array( 'Owner&#8217;s rights', 'You own <a href="/terms-of-service/">everything</a>.', '100% yours' ),
	),
	'foot'    => 'Want this checked? <a href="/contact/">Get a free audit →</a>',
);
