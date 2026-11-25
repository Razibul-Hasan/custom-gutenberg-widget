/**
 * Ready layouts of the Section block (inserter: "Section — Long text", "Section — Showcase" …). Each one starts with
 * exactly the structure the site's CSS (and scripts: the guide's contents, the screenshot tour) already style on the
 * existing pages, so a new section looks like the others right away. They are all the same Section block: switching
 * look later is the Section panel's "Section style" or the design classes.
 */
import { __ } from '@wordpress/i18n';
import { withRoles } from '../shared/part-controls';

const g = ( className, inner = [], extra = {} ) => [
	'core/group',
	{ className, ...extra },
	inner,
];
const p = ( content, className = '' ) => [
	'core/paragraph',
	className ? { content, className } : { content },
];
const h = ( level, content, extra = {} ) => [
	'core/heading',
	{ level, content, ...extra },
];
const head = ( eyebrow, title, intro = '' ) => [
	'bwe/section-head',
	{ eyebrow, title, intro, split: !! intro },
];
const buttons = ( items ) => [ 'bwe/buttons', { items } ];
const wrap = ( inner ) => [
	g( 'bwex-wrap', inner, {
		metadata: { name: __( 'Content', 'bestwebexpert' ) },
	} ),
];

const has = ( classes, list ) =>
	list.every( ( c ) => ` ${ classes || '' } `.includes( ` ${ c } ` ) );

const VARIATIONS = [
	{
		name: 'long-text',
		title: __(
			'Section — Long text (legal page, article)',
			'bestwebexpert'
		),
		description: __(
			'Readable text column for privacy policy, terms, refunds or any long text: headings, paragraphs, lists and tables.',
			'bestwebexpert'
		),
		icon: 'text-page',
		attributes: { classes: 'bwex-section bwex-prose' },
		innerBlocks: wrap( [
			g( 'bwex-prose__body', [
				h( 2, __( 'First heading', 'bestwebexpert' ) ),
				p(
					__(
						'Write the text here. Use headings for each topic, so readers and Google can scan it.',
						'bestwebexpert'
					)
				),
				[
					'core/list',
					{},
					[
						[
							'core/list-item',
							{
								content: __(
									'A point in a list',
									'bestwebexpert'
								),
							},
						],
						[
							'core/list-item',
							{ content: __( 'Another point', 'bestwebexpert' ) },
						],
					],
				],
			] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-prose' ] ),
	},
	{
		name: 'showcase',
		title: __(
			'Section — Showcase (reels, box builder, gallery)',
			'bestwebexpert'
		),
		description: __(
			'A header, then a wide area for a plugin block (ProductReels, ProductBoxes), a gallery, a video or a grid.',
			'bestwebexpert'
		),
		icon: 'format-gallery',
		attributes: { classes: 'bwex-section bwex-showcase' },
		innerBlocks: wrap( [
			head(
				__( 'Live demo', 'bestwebexpert' ),
				__( 'Trending <em>This Week</em>', 'bestwebexpert' )
			),
			g( 'bwex-showcase__body', [
				p(
					__(
						'Replace this with the reels, box builder, gallery or any other block.',
						'bestwebexpert'
					)
				),
			] ),
		] ),
		isActive: ( a ) =>
			has( a.classes, [ 'bwex-showcase' ] ) &&
			! has( a.classes, [ 'bwex-showcase--side' ] ),
	},
	{
		name: 'showcase-side',
		title: __( 'Section — Showcase beside text', 'bestwebexpert' ),
		description: __(
			'Text, a short price list and a button on one side; reels, a box builder or an image on the other.',
			'bestwebexpert'
		),
		icon: 'align-pull-left',
		attributes: {
			classes:
				'bwex-section bwex-showcase bwex-section--soft bwex-showcase--side',
		},
		innerBlocks: wrap( [
			g( 'bwex-showcase__grid', [
				g( 'bwex-showcase__copy', [
					head(
						__( 'Styled for you', 'bestwebexpert' ),
						__( 'Five Ways to <em>Layer Up</em>', 'bestwebexpert' )
					),
					[
						'core/list',
						{ className: 'bwex-prices' },
						[
							[
								'core/list-item',
								{
									content: __(
										'Product name <strong>$99</strong>',
										'bestwebexpert'
									),
								},
							],
							[
								'core/list-item',
								{
									content: __(
										'Another product <strong>$49</strong>',
										'bestwebexpert'
									),
								},
							],
						],
					],
					buttons( [
						{
							text: __( 'Shop the look →', 'bestwebexpert' ),
							url: '#',
							style: 'dark',
						},
					] ),
				] ),
				g( 'bwex-showcase__body', [
					p(
						__(
							'Replace this with the reels, box builder or an image.',
							'bestwebexpert'
						)
					),
				] ),
			] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-showcase--side' ] ),
	},
	{
		name: 'split',
		title: __( 'Section — Text + image', 'bestwebexpert' ),
		description: __(
			'Eyebrow, heading, a short text and a button beside a large image (like “Ten Outfits We Can’t Stop Wearing”).',
			'bestwebexpert'
		),
		icon: 'align-pull-right',
		attributes: { classes: 'bwex-section bwex-split bwex-section--soft' },
		innerBlocks: wrap( [
			g( 'bwex-split__grid', [
				g( 'bwex-split__copy', [
					g( 'bwex-eyebrow', [
						p( __( 'Small label', 'bestwebexpert' ) ),
					] ),
					g( 'bwex-h2', [
						h(
							2,
							__(
								'A Heading That Says <em>What You Get</em>',
								'bestwebexpert'
							),
							{ className: 'bwe-h2x-plain' }
						),
					] ),
					p(
						__(
							'Two or three lines that explain the offer and why it matters.',
							'bestwebexpert'
						),
						'bwex-split__lead'
					),
					buttons( [
						{
							text: __( 'See more →', 'bestwebexpert' ),
							url: '#',
							style: 'dark',
						},
					] ),
				] ),
				g( 'bwex-split__media', [
					[ 'core/image', { className: 'bwex-split__img' } ],
				] ),
			] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-split' ] ),
	},
	{
		name: 'media',
		title: __( 'Section — Big screenshot', 'bestwebexpert' ),
		description: __(
			'One large, framed screenshot or image under a hero (like the plugin pages).',
			'bestwebexpert'
		),
		icon: 'format-image',
		attributes: { classes: 'bwex-section bwex-media' },
		innerBlocks: wrap( [
			g( 'bwex-media__body', [ [ 'bwe/media', {} ] ] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-media' ] ),
	},
	{
		name: 'demo-bar',
		title: __( 'Section — Demo bar (thin dark strip)', 'bestwebexpert' ),
		description: __(
			'A thin dark strip under the hero: a label, a few links and one call to action (like the demo stores).',
			'bestwebexpert'
		),
		icon: 'minus',
		attributes: { classes: 'bwex-demobar', tagName: 'aside' },
		innerBlocks: wrap( [
			p(
				__(
					'<strong>Live demo</strong> Built with our free plugin',
					'bestwebexpert'
				),
				'bwex-demobar__label'
			),
			p(
				__(
					'<a href="#">First page</a><a href="#">Second page</a><a href="#">Third page</a>',
					'bestwebexpert'
				),
				'bwex-demobar__tabs'
			),
			p(
				__( '<a href="#">Get it free →</a>', 'bestwebexpert' ),
				'bwex-demobar__cta'
			),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-demobar' ] ),
	},
	{
		name: 'guide',
		title: __( 'Section — Guide with contents', 'bestwebexpert' ),
		description: __(
			'A long how-to with a sticky “On this page” list and numbered chapters (like the demo store guides). Good for SEO articles on a page.',
			'bestwebexpert'
		),
		icon: 'list-view',
		attributes: { classes: 'bwex-section bwex-section--soft bwex-guide' },
		innerBlocks: wrap( [
			head(
				__( 'Guide', 'bestwebexpert' ),
				__( 'How This Works, <em>Step by Step</em>', 'bestwebexpert' ),
				__(
					'A short intro to what the reader will learn.',
					'bestwebexpert'
				)
			),
			g( 'bwex-guide__grid', [
				g( 'bwex-guide__nav', [
					p(
						__( 'On this page', 'bestwebexpert' ),
						'bwex-guide__navtitle'
					),
					[
						'core/list',
						{ ordered: true, className: 'bwex-guide__toc' },
						[
							[
								'core/list-item',
								{
									content: __(
										'<a href="#chapter-1"><span>01</span>First chapter</a>',
										'bestwebexpert'
									),
								},
							],
							[
								'core/list-item',
								{
									content: __(
										'<a href="#chapter-2"><span>02</span>Second chapter</a>',
										'bestwebexpert'
									),
								},
							],
						],
					],
				] ),
				g( 'bwex-guide__body', [
					g( 'bwex-chapter', [
						p( '01', 'bwex-chapter__num' ),
						h( 2, __( 'First chapter', 'bestwebexpert' ), {
							className: 'bwex-chapter__title',
							anchor: 'chapter-1',
						} ),
						g( 'bwex-chapter__body', [
							p(
								__(
									'The chapter’s text. Add lists, tables and images as you need.',
									'bestwebexpert'
								)
							),
						] ),
					] ),
					g( 'bwex-chapter', [
						p( '02', 'bwex-chapter__num' ),
						h( 2, __( 'Second chapter', 'bestwebexpert' ), {
							className: 'bwex-chapter__title',
							anchor: 'chapter-2',
						} ),
						g( 'bwex-chapter__body', [
							p( __( 'The chapter’s text.', 'bestwebexpert' ) ),
						] ),
					] ),
				] ),
			] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-guide' ] ),
	},
	{
		name: 'tour',
		title: __( 'Section — Screenshot tour (tabs)', 'bestwebexpert' ),
		description: __(
			'Numbered tabs on one side; clicking one shows its screenshot in a browser frame (like MigrateLift’s tour). One image per tab, in the same order.',
			'bestwebexpert'
		),
		icon: 'slides',
		attributes: {
			classes: 'bwex-section bwex-section--soft bwex-tour-section',
		},
		innerBlocks: wrap( [
			head(
				__( 'Screenshots', 'bestwebexpert' ),
				__( 'See It <em>in Action</em>', 'bestwebexpert' )
			),
			g( 'bwex-tour', [
				g( 'bwex-tour__tabs', [
					g( 'bwex-tour__tab', [
						p( '01', 'bwex-tour__num' ),
						p(
							__( 'Overview', 'bestwebexpert' ),
							'bwex-tour__name'
						),
						p(
							__(
								'What this screen shows, in one line.',
								'bestwebexpert'
							),
							'bwex-tour__text'
						),
					] ),
					g( 'bwex-tour__tab', [
						p( '02', 'bwex-tour__num' ),
						p(
							__( 'Settings', 'bestwebexpert' ),
							'bwex-tour__name'
						),
						p(
							__(
								'What this screen shows, in one line.',
								'bestwebexpert'
							),
							'bwex-tour__text'
						),
					] ),
				] ),
				g( 'bwex-tour__stage', [
					g( 'bwex-tour__frame', [
						p( 'wp-admin', 'bwex-tour__bar' ),
						[ 'core/image', { className: 'bwex-tour__shot' } ],
						[ 'core/image', { className: 'bwex-tour__shot' } ],
					] ),
				] ),
			] ),
		] ),
		isActive: ( a ) => has( a.classes, [ 'bwex-tour-section' ] ),
	},
];

export default VARIATIONS.map( ( v ) => ( {
	...v,
	innerBlocks: withRoles( v.innerBlocks ),
	scope: [ 'inserter', 'transform' ],
} ) );
