<?php
// This file is generated. Do not modify it manually.
return array(
	'about' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/about',
		'title' => 'About (text + card)',
		'category' => 'bestwebexpert',
		'icon' => 'id',
		'description' => 'Text on one side (small label, heading, lead and more text), a card on the other (title, checklist, button). For "about me", author and guideline sections. Every look setting is in the Styles tab.',
		'keywords' => array(
			'about',
			'author',
			'story',
			'founder',
			'checklist',
			'split',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Who you’ll be talking to'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Hi, I’m Razibul Hasan. <em>Nice to Meet You.</em>'
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'lead' => array(
				'type' => 'string',
				'default' => ''
			),
			'more' => array(
				'type' => 'array',
				'default' => array(
					
				),
				'items' => array(
					'type' => 'string'
				)
			),
			'cardTitle' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'about'
			),
			'classes' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-element-84190b5 e-con-full bwex-section bwex-section--soft bwex-about e-flex e-con e-child'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Text / card widths',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Text 7/12, card 5/12 (site)',
						'value' => 'minmax(0, 7fr) minmax(0, 5fr)'
					),
					array(
						'label' => 'Half and half',
						'value' => 'minmax(0, 1fr) minmax(0, 1fr)'
					),
					array(
						'label' => 'Text 2/3, card 1/3',
						'value' => 'minmax(0, 2fr) minmax(0, 1fr)'
					),
					array(
						'label' => 'Text 5/12, card 7/12',
						'value' => 'minmax(0, 5fr) minmax(0, 7fr)'
					),
					array(
						'label' => 'One column (card under the text)',
						'value' => 'minmax(0, 1fr)'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-about__grid',
						'prop' => 'grid-template-columns',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between text and card',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__grid',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'cardFirst',
				'label' => 'Card on the left (wide screens)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'order',
						'valueMap' => array(
							'true' => '-1'
						),
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'align',
				'label' => 'Card height',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Top (site)',
						'value' => 'start'
					),
					array(
						'label' => 'Centred',
						'value' => 'center'
					),
					array(
						'label' => 'Same height as the text',
						'value' => 'stretch'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-about__grid',
						'prop' => 'align-items'
					)
				)
			),
			array(
				'key' => 'leadColor',
				'label' => 'Colour',
				'panel' => 'Lead text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__lead p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'leadSize',
				'label' => 'Size',
				'panel' => 'Lead text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__lead p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'leadLink',
				'label' => 'Link colour',
				'panel' => 'Lead text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__lead a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreColor',
				'label' => 'Colour',
				'panel' => 'More text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__text',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreSize',
				'label' => 'Size',
				'panel' => 'More text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__text',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'moreLink',
				'label' => 'Link colour',
				'panel' => 'More text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__text a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardBorderWidth',
				'label' => 'Border width',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'border-width'
					),
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'border-style',
						'fixed' => 'solid'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Card',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .bwex-h3 .elementor-heading-title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .bwex-h3 .elementor-heading-title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTitleWeight',
				'label' => 'Title weight',
				'panel' => 'Card',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .bwex-h3 .elementor-heading-title',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'listText',
				'label' => 'Text colour',
				'panel' => 'Checklist',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li',
						'prop' => 'color'
					),
					array(
						'sel' => ' .bwex-checks li a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'listHover',
				'label' => 'Link colour on hover',
				'panel' => 'Checklist',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li a:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'listMark',
				'label' => 'Mark colour (+)',
				'panel' => 'Checklist',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li::before',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'listSize',
				'label' => 'Text size',
				'panel' => 'Checklist',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'listLines',
				'label' => 'Line colour',
				'panel' => 'Checklist',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-about__card .elementor-button',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-about__card .elementor-button:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnFull',
				'label' => 'Full width',
				'panel' => 'Button',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-about__card .elementor-button',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					)
				)
			)
		)
	),
	'buttons' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/buttons',
		'title' => 'Buttons',
		'category' => 'bestwebexpert',
		'icon' => 'button',
		'description' => 'One or more buttons in the site\'s look: lime, outline, dark, light (for dark backgrounds) or an underlined text link. Each opens in a new tab or gets nofollow when you want; alignment and full-width buttons can differ on desktop, tablet and phone.',
		'keywords' => array(
			'button',
			'buttons',
			'link',
			'cta',
			'call to action',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'align' => array(
				'type' => 'string',
				'default' => ''
			),
			'alignTablet' => array(
				'type' => 'string',
				'default' => ''
			),
			'alignMobile' => array(
				'type' => 'string',
				'default' => ''
			),
			'stackMobile' => array(
				'type' => 'boolean',
				'default' => false
			),
			'fullMobile' => array(
				'type' => 'boolean',
				'default' => false
			),
			'size' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'example' => array(
			'attributes' => array(
				'items' => array(
					array(
						'text' => 'Claim my free audit →',
						'url' => '#',
						'style' => 'primary'
					),
					array(
						'text' => 'See pricing',
						'url' => '#',
						'style' => 'outline'
					)
				)
			),
			'viewportWidth' => 700
		),
		'bweStyleMap' => array(
			array(
				'key' => 'gap',
				'label' => 'Space between buttons',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'marginBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-bottom'
					)
				)
			),
			array(
				'key' => 'marginTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link:is(:hover, :focus-visible)',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .wp-block-button__link:is(:hover, :focus-visible)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text colour on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link:is(:hover, :focus-visible)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnHeight',
				'label' => 'Height',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'height'
					)
				)
			),
			array(
				'key' => 'btnPadding',
				'label' => 'Side padding',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'padding-left'
					),
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'padding-right'
					)
				)
			),
			array(
				'key' => 'btnFontSize',
				'label' => 'Text size',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnSpacing',
				'label' => 'Letter spacing',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'letter-spacing'
					)
				)
			),
			array(
				'key' => 'btnCase',
				'label' => 'All capitals',
				'panel' => 'Buttons',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'UPPERCASE',
						'value' => 'uppercase'
					),
					array(
						'label' => 'As typed',
						'value' => 'none'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'text-transform'
					)
				)
			)
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'contact-form' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/contact-form',
		'title' => 'Contact form section',
		'category' => 'bestwebexpert',
		'icon' => 'email-alt',
		'description' => 'Small label, heading and intro beside a Contact Form 7 form in its card. Pick the form in the sidebar; every look setting (layout, card, fields, buttons) is in the Styles tab.',
		'keywords' => array(
			'contact',
			'form',
			'enquiry',
			'pitch',
			'contact form 7',
			'cf7',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Send a message'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Tell Me About Your Project. <em>I’ll Do the Rest.</em>'
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'intro' => array(
				'type' => 'string',
				'default' => 'A few lines is plenty. Every enquiry with a website link gets a free mini audit: three quick wins for speed, SEO and sales.'
			),
			'note' => array(
				'type' => 'string',
				'default' => ''
			),
			'form' => array(
				'type' => 'string',
				'default' => ''
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'form'
			),
			'classes' => array(
				'type' => 'string',
				'default' => 'bwex-section bwex-wfu-form'
			),
			'cardClasses' => array(
				'type' => 'string',
				'default' => 'bwe-home bwe-services bwe-contact bwe-form-card'
			),
			'scope' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Text / form widths',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Text 1/3, form 2/3',
						'value' => 'minmax(0, 1fr) minmax(0, 2fr)'
					),
					array(
						'label' => 'Text 2/5, form 3/5',
						'value' => 'minmax(0, 2fr) minmax(0, 3fr)'
					),
					array(
						'label' => 'Half and half',
						'value' => 'minmax(0, 1fr) minmax(0, 1fr)'
					),
					array(
						'label' => 'Text 3/5, form 2/5',
						'value' => 'minmax(0, 3fr) minmax(0, 2fr)'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-wfu-form__grid',
						'prop' => 'grid-template-columns',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between text and form',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wfu-form__grid',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'formFirst',
				'label' => 'Form on the left (wide screens)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'order',
						'valueMap' => array(
							'true' => '-1'
						),
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'stickyText',
				'label' => 'Text stays in view while scrolling (wide screens)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-wfu-form__aside',
						'prop' => 'position',
						'valueMap' => array(
							'true' => 'sticky'
						),
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introLink',
				'label' => 'Link colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-wfu-form__aside a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Form card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Form card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardBorderWidth',
				'label' => 'Border width',
				'panel' => 'Form card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'border-width'
					),
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'border-style',
						'fixed' => 'solid'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Form card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Form card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Form card',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwe-form-card',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'labelColor',
				'label' => 'Label colour',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 label',
						'prop' => 'color'
					),
					array(
						'sel' => ' .bwe-cf7__choices legend',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'labelSize',
				'label' => 'Label size',
				'panel' => 'Fields',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 label',
						'prop' => 'font-size'
					),
					array(
						'sel' => ' .bwe-cf7__choices legend',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'fieldBg',
				'label' => 'Field background',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control:is(.wpcf7-text, .wpcf7-email, .wpcf7-tel, .wpcf7-url, .wpcf7-select, .wpcf7-textarea)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'fieldBorder',
				'label' => 'Field border',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control:is(.wpcf7-text, .wpcf7-email, .wpcf7-tel, .wpcf7-url, .wpcf7-select, .wpcf7-textarea)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'fieldText',
				'label' => 'Field text',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control:is(.wpcf7-text, .wpcf7-email, .wpcf7-tel, .wpcf7-url, .wpcf7-select, .wpcf7-textarea)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'fieldPlaceholder',
				'label' => 'Placeholder text',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control::placeholder',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'fieldFocus',
				'label' => 'Border when typing',
				'panel' => 'Fields',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control:is(.wpcf7-text, .wpcf7-email, .wpcf7-tel, .wpcf7-url, .wpcf7-select, .wpcf7-textarea):focus',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'fieldRadius',
				'label' => 'Field corner radius',
				'panel' => 'Fields',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-form-control:is(.wpcf7-text, .wpcf7-email, .wpcf7-tel, .wpcf7-url, .wpcf7-select, .wpcf7-textarea)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'choiceBg',
				'label' => 'Background',
				'panel' => 'Choice buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'choiceText',
				'label' => 'Text',
				'panel' => 'Choice buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'choiceBorder',
				'label' => 'Border',
				'panel' => 'Choice buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'choiceOnBg',
				'label' => 'Selected choice: background',
				'panel' => 'Choice buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label:has(input:checked)',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label:has(input:checked)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'choiceOnText',
				'label' => 'Selected choice: text',
				'panel' => 'Choice buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-list-item label:has(input:checked)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Send button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Send button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Send button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Send button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Send button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnFull',
				'label' => 'Full width',
				'panel' => 'Send button',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7 .wpcf7-submit',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					)
				)
			),
			array(
				'key' => 'noteColor',
				'label' => 'Note under the button',
				'panel' => 'Send button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-cf7__note',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'cost-panel' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/cost-panel',
		'title' => 'Cost explainer',
		'category' => 'bestwebexpert',
		'icon' => 'editor-help',
		'description' => 'A heading and short explainer points (start each with a bold name). Add, remove or move points.',
		'keywords' => array(
			'cost',
			'price',
			'explainer',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'default' => 'How much does a website really cost? (The honest answer)'
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Background',
				'panel' => 'Box',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'radius',
				'label' => 'Corner radius',
				'panel' => 'Box',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'padding',
				'label' => 'Inner space',
				'panel' => 'Box',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Box',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Heading colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__title h3',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Heading size',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__title h3',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'pointColor',
				'label' => 'Point name colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'label' => 'Text size',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Points',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cost__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between points',
				'panel' => 'Points',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'iconBg',
				'label' => 'Icon circle colour',
				'panel' => 'Points',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid > .elementor-widget::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideIcons',
				'label' => 'Hide the icons',
				'panel' => 'Points',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-cost__grid > .elementor-widget::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			)
		)
	),
	'cta' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/cta',
		'title' => 'Call to action',
		'category' => 'bestwebexpert',
		'icon' => 'megaphone',
		'description' => 'The dark closing box ("Ready when you are"): small label, heading, text, two buttons, the live-chat line (its link opens the chat) and a small note. Every look setting is in the Styles tab.',
		'keywords' => array(
			'cta',
			'call to action',
			'closing',
			'contact',
			'ready',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Ready when you are'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Still Scrolling? <em>That’s a Sign.</em>'
			),
			'lead' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn1Text' => array(
				'type' => 'string',
				'default' => 'Claim my free audit →'
			),
			'btn1Url' => array(
				'type' => 'string',
				'default' => '/contact/'
			),
			'btn2Text' => array(
				'type' => 'string',
				'default' => 'See pricing'
			),
			'btn2Url' => array(
				'type' => 'string',
				'default' => '/pricing/'
			),
			'showBtn2' => array(
				'type' => 'boolean',
				'default' => true
			),
			'btn1NewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'btn2NewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'chat' => array(
				'type' => 'string',
				'default' => 'Prefer to chat? I\'m on <strong>live chat 24/7</strong>. <a href="/contact/">Start a chat →</a>'
			),
			'showChat' => array(
				'type' => 'boolean',
				'default' => true
			),
			'note' => array(
				'type' => 'string',
				'default' => 'No pressure. No sales pitch. Just honest advice.'
			),
			'showNote' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideDecor',
				'general' => true,
				'label' => 'Hide background decorations (glow, grid)',
				'panel' => 'Background',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' p.bwe-eyebrow::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwe-final__box > h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' p.bwe-eyebrow',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' p.bwe-eyebrow',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' p.bwe-eyebrow::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' p.bwe-eyebrow::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > .bwe-lead',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > .bwe-lead',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box > .bwe-lead',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'boxBg',
				'label' => 'Background',
				'panel' => 'Box',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'boxBorder',
				'label' => 'Border colour',
				'panel' => 'Box',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'boxRadius',
				'label' => 'Corner radius',
				'panel' => 'Box',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'boxPadding',
				'label' => 'Inner space',
				'panel' => 'Box',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'btn1Bg',
				'label' => 'Background',
				'panel' => 'Main button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btn1Text',
				'label' => 'Text colour',
				'panel' => 'Main button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btn1Border',
				'label' => 'Border colour',
				'panel' => 'Main button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btn1Radius',
				'label' => 'Corner radius',
				'panel' => 'Main button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btn1Size',
				'label' => 'Text size',
				'panel' => 'Main button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btn1HoverBg',
				'label' => 'Background on hover',
				'panel' => 'Main button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btn1HoverText',
				'label' => 'Text on hover',
				'panel' => 'Main button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btn2Bg',
				'label' => 'Background',
				'panel' => 'Second button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btn2Text',
				'label' => 'Text colour',
				'panel' => 'Second button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btn2Border',
				'label' => 'Border colour',
				'panel' => 'Second button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btn2Radius',
				'label' => 'Corner radius',
				'panel' => 'Second button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btn2Size',
				'label' => 'Text size',
				'panel' => 'Second button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btn2HoverBg',
				'label' => 'Background on hover',
				'panel' => 'Second button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btn2HoverText',
				'label' => 'Text on hover',
				'panel' => 'Second button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--ghost .wp-block-button__link:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chatColor',
				'label' => 'Text colour',
				'panel' => 'Chat line & note',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__chat',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chatLink',
				'label' => 'Link colour',
				'panel' => 'Chat line & note',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__chat a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chatDot',
				'label' => 'Dot colour',
				'panel' => 'Chat line & note',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__dot',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'noteColor',
				'label' => 'Note colour',
				'panel' => 'Chat line & note',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-final__note',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'faq' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/faq',
		'title' => 'FAQ',
		'category' => 'bestwebexpert',
		'icon' => 'editor-help',
		'description' => 'FAQ section: heading and "ask a question" button on one side, numbered questions on the other (add, remove or move them; mark some as hidden until "Show more"). Questions also feed the FAQ schema.',
		'keywords' => array(
			'faq',
			'questions',
			'accordion',
			'answers',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'FAQ'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Frequently Asked <em>Questions</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => false
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'faq'
			),
			'headElementId' => array(
				'type' => 'string',
				'default' => 'b4093ad'
			),
			'askText' => array(
				'type' => 'string',
				'default' => 'Ask a question →'
			),
			'askUrl' => array(
				'type' => 'string',
				'default' => '/contact/'
			),
			'askNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showAsk' => array(
				'type' => 'boolean',
				'default' => true
			),
			'toggleText' => array(
				'type' => 'string',
				'default' => ''
			),
			'listId' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Questions',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Questions',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Questions',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__item:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__q',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Questions',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__q',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__a :is(p, li)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Questions',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__a :is(p, li)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'numColor',
				'label' => 'Number colour',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__n',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'hideNum',
				'label' => 'Hide the numbers',
				'panel' => 'Questions',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__n',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'iconColor',
				'label' => 'Plus icon colour',
				'panel' => 'Questions',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__icon',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'itemGap',
				'label' => 'Space between questions',
				'panel' => 'Questions',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'introWidthSide',
				'label' => 'Left column width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-faq__grid',
						'prop' => 'grid-template-columns',
						'tpl' => '{v} minmax(0, 1fr)',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle):hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-btn .elementor-button, .bwex-faq__toggle):hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'faq-item' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/faq-item',
		'title' => 'FAQ question',
		'category' => 'bestwebexpert',
		'icon' => 'editor-help',
		'description' => 'One numbered FAQ question with its answer. Click the question to open the answer.',
		'keywords' => array(
			'faq',
			'question',
			'accordion',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'n' => array(
				'type' => 'string',
				'default' => '01'
			),
			'question' => array(
				'type' => 'string',
				'default' => ''
			),
			'extra' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'gap' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/gap',
		'title' => 'Gap / divider',
		'category' => 'bestwebexpert',
		'icon' => 'image-flip-vertical',
		'description' => 'Empty space between blocks, with its own height on desktop, tablet and phone — optionally with a divider line (solid, dashed or dotted; colour, thickness and length).',
		'keywords' => array(
			'gap',
			'space',
			'spacer',
			'divider',
			'separator',
			'line',
			'hr',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'line' => array(
				'type' => 'boolean',
				'default' => false
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'example' => array(
			'attributes' => array(
				'line' => true
			),
			'viewportWidth' => 600
		),
		'bweStyleMap' => array(
			array(
				'key' => 'height',
				'label' => 'Height (desktop)',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'height',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'heightTablet',
				'label' => 'Height (tablet)',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'height',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'heightMobile',
				'label' => 'Height (phone)',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'height',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'lineColor',
				'label' => 'Line colour',
				'panel' => 'Line',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '::before',
						'prop' => 'border-top-color'
					)
				)
			),
			array(
				'key' => 'lineWidth',
				'label' => 'Line thickness',
				'panel' => 'Line',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '::before',
						'prop' => 'border-top-width'
					)
				)
			),
			array(
				'key' => 'lineLength',
				'label' => 'Line length',
				'panel' => 'Line',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '::before',
						'prop' => 'width'
					)
				)
			),
			array(
				'key' => 'lineStyle',
				'label' => 'Line style',
				'panel' => 'Line',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Solid',
						'value' => 'solid'
					),
					array(
						'label' => 'Dashed',
						'value' => 'dashed'
					),
					array(
						'label' => 'Dotted',
						'value' => 'dotted'
					)
				),
				'rules' => array(
					array(
						'sel' => '::before',
						'prop' => 'border-top-style'
					)
				)
			),
			array(
				'key' => 'lineAlign',
				'label' => 'Line position',
				'panel' => 'Line',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => '0 auto 0 0'
					),
					array(
						'label' => 'Centre',
						'value' => '0 auto'
					),
					array(
						'label' => 'Right',
						'value' => '0 0 0 auto'
					)
				),
				'rules' => array(
					array(
						'sel' => '::before',
						'prop' => 'margin'
					)
				)
			)
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/grid',
		'title' => 'Grid / columns',
		'category' => 'bestwebexpert',
		'icon' => 'grid-view',
		'description' => 'Put any blocks side by side: 1–6 columns, with their own number on tablet and phone; for two columns pick a ratio (2:1, 3:2 …) for text + image layouts. Optionally every item becomes a card (white, soft, dark or outlined). Use it for card rows, feature grids, text beside a screenshot, logos and more.',
		'keywords' => array(
			'grid',
			'columns',
			'cards',
			'split',
			'layout',
			'row',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'columns' => array(
				'type' => 'number',
				'default' => 3
			),
			'columnsTablet' => array(
				'type' => 'number',
				'default' => 2
			),
			'columnsMobile' => array(
				'type' => 'number',
				'default' => 1
			),
			'ratio' => array(
				'type' => 'string',
				'default' => ''
			),
			'valign' => array(
				'type' => 'string',
				'default' => ''
			),
			'cards' => array(
				'type' => 'string',
				'default' => ''
			),
			'reverseMobile' => array(
				'type' => 'boolean',
				'default' => false
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'bweStyleMap' => array(
			array(
				'key' => 'gap',
				'label' => 'Space between items',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'gapTablet',
				'label' => 'Space between items (tablet)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'gapMobile',
				'label' => 'Space between items (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'marginBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-bottom'
					)
				)
			),
			array(
				'key' => 'maxWidth',
				'label' => 'Maximum width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'max-width'
					),
					array(
						'sel' => '',
						'prop' => 'margin-left',
						'fixed' => 'auto'
					),
					array(
						'sel' => '',
						'prop' => 'margin-right',
						'fixed' => 'auto'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardPaddingMobile',
				'label' => 'Inner space (phone)',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'padding',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => '0 18px 40px -24px rgba(11,13,12,.3)'
					),
					array(
						'label' => 'Deep',
						'value' => '0 30px 60px -30px rgba(11,13,12,.45)'
					)
				),
				'rules' => array(
					array(
						'sel' => ' > *',
						'prop' => 'box-shadow'
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border colour on hover',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > *:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > * :is(h2, h3, h4, h5, h6)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > * :is(h2, h3, h4, h5, h6)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > * :is(p, li)',
						'prop' => 'color'
					)
				)
			)
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'guide' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/guide',
		'title' => 'Guide / checklist',
		'category' => 'bestwebexpert',
		'icon' => 'list-view',
		'description' => 'Numbered guide or checklist section: heading (italic = highlight), intro, step cards (add, remove or move them; numbers update by themselves) and a button. Choose items per row for desktop, tablet and phone, centre or left-align the header, and centre an incomplete last row. Every look setting is in the Styles tab.',
		'keywords' => array(
			'guide',
			'checklist',
			'steps',
			'how to',
			'tips',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Hiring guide'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'How to Choose the <em>Right Expert</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => false
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'guide'
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'headAlign' => array(
				'type' => 'string',
				'default' => 'center'
			),
			'lastRow' => array(
				'type' => 'string',
				'default' => 'center'
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'btnStyle' => array(
				'type' => 'string',
				'default' => 'fill'
			),
			'note' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'btnAlign' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'fullWidth',
				'label' => 'Full width (content uses the whole screen width)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					)
				)
			),
			array(
				'key' => 'sidePadding',
				'label' => 'Side space',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'padding-inline'
					)
				)
			),
			array(
				'key' => 'sidePaddingMobile',
				'label' => 'Side space (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'padding-inline',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Items per row (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwe-guide-cols'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwe-guide-cols-t'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwe-guide-cols-m'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between items',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwe-guide-gap'
					)
				)
			),
			array(
				'key' => 'headGap',
				'label' => 'Space under the heading',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'margin-bottom'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideDecor',
				'general' => true,
				'label' => 'Hide background decorations (glow, grid)',
				'panel' => 'Background',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro',
						'prop' => 'max-width'
					),
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width',
						'fixed' => 'none'
					)
				)
			),
			array(
				'key' => 'introFull',
				'label' => 'Full-width intro text',
				'panel' => 'Intro',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro',
						'prop' => 'max-width',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwex-intro',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					),
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Steps',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__text p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'numColor',
				'label' => 'Number colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'numSize',
				'label' => 'Number size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'hideNum',
				'label' => 'Hide the numbers',
				'panel' => 'Steps',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'iconTile',
				'label' => 'Icon box colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item::after',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideIcons',
				'label' => 'Hide the icons',
				'panel' => 'Steps',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'cardMinHeight',
				'label' => 'Card minimum height',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__list > li',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'cardTextAlign',
				'label' => 'Text inside the cards',
				'panel' => 'Steps',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Button background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__foot :is(.elementor-button, .wp-block-button__link)',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-guide__foot :is(.elementor-button, .wp-block-button__link)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnColor',
				'label' => 'Button text',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__foot :is(.elementor-button, .wp-block-button__link)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Button corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__foot :is(.elementor-button, .wp-block-button__link)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnTop',
				'label' => 'Space above the button',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__foot',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'noteColor',
				'label' => 'Note colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-guide__note',
						'prop' => 'color'
					)
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'intro' => 'Five things to check before you hire anyone.',
				'btnText' => 'Read the full guide →'
			),
			'innerBlocks' => array(
				array(
					'name' => 'bwe/step',
					'attributes' => array(
						'title' => 'Review their work',
						'text' => 'Look for live websites and real projects.'
					)
				),
				array(
					'name' => 'bwe/step',
					'attributes' => array(
						'title' => 'Check their skills',
						'text' => 'Make sure they know the tools your project needs.'
					)
				),
				array(
					'name' => 'bwe/step',
					'attributes' => array(
						'title' => 'Agree the scope',
						'text' => 'Get the deliverables and timeline in writing.'
					)
				)
			)
		)
	),
	'hero' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/hero',
		'title' => 'Hero',
		'category' => 'bestwebexpert',
		'icon' => 'cover-image',
		'description' => 'The big dark hero at the top of a page: heading (italic = highlight), text, two buttons and the scroll cue, with its entrance animation. Every look setting is in the Styles tab. Optional kicker line above the heading, buttons that open in a new tab, and numbered jump links (01 Carousel, 02 Stories …).',
		'keywords' => array(
			'hero',
			'header',
			'banner',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'kicker' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'lead' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn1Text' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn1Url' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn1NewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'btn2Text' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn2Url' => array(
				'type' => 'string',
				'default' => ''
			),
			'btn2NewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showBtn2' => array(
				'type' => 'boolean',
				'default' => true
			),
			'scrollText' => array(
				'type' => 'string',
				'default' => 'Scroll'
			),
			'scrollUrl' => array(
				'type' => 'string',
				'default' => '#services'
			),
			'showScroll' => array(
				'type' => 'boolean',
				'default' => true
			),
			'jumpLinks' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'facts' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'modifiers' => array(
				'type' => 'string',
				'default' => 'bwe-section bwe-hero bwe-hero--no-visual bwe-hero--paper bwex-hero bwe-hero--night'
			),
			'animate' => array(
				'type' => 'boolean',
				'default' => true
			),
			'animSpeed' => array(
				'type' => 'number',
				'default' => 1
			),
			'animDelay' => array(
				'type' => 'number',
				'default' => 0
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'textAlign',
				'label' => 'Text alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__copy',
						'prop' => 'text-align'
					),
					array(
						'sel' => ' .bwe-hero__copy',
						'prop' => 'align-items',
						'valueMap' => array(
							'left' => 'flex-start',
							'center' => 'center',
							'right' => 'flex-end'
						)
					),
					array(
						'sel' => ' .bwe-actions',
						'prop' => 'justify-content',
						'valueMap' => array(
							'left' => 'flex-start',
							'center' => 'center',
							'right' => 'flex-end'
						)
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__copy',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'kickerColor',
				'label' => 'Line above the title: colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-kicker',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'kickerSize',
				'label' => 'Line above the title: size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-kicker',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeTablet',
				'label' => 'Size (tablet)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'font-size',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'titleLetterSpacing',
				'label' => 'Letter spacing',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'letter-spacing'
					)
				)
			),
			array(
				'key' => 'titleWidth',
				'label' => 'Title width',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'max-width'
					),
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'margin-inline',
						'fixed' => 'auto'
					)
				)
			),
			array(
				'key' => 'titleBalance',
				'label' => 'Even out the title lines',
				'panel' => 'Heading',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title',
						'prop' => 'text-wrap',
						'valueMap' => array(
							'true' => 'balance'
						)
					)
				)
			),
			array(
				'key' => 'highlightNoWrap',
				'label' => 'Keep the highlight on one line',
				'panel' => 'Heading',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'white-space',
						'valueMap' => array(
							'true' => 'nowrap'
						)
					)
				)
			),
			array(
				'key' => 'highlightLinesMobile',
				'label' => 'Phones: underline each line of the highlight',
				'panel' => 'Heading',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'inline'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'white-space',
						'valueMap' => array(
							'true' => 'normal'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'linear-gradient(var(--bwex-hero-line-c,var(--bwe-accent,#c8ff3d)),var(--bwex-hero-line-c,var(--bwe-accent,#c8ff3d)))'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'background-size',
						'valueMap' => array(
							'true' => '100% var(--bwex-hero-line-h,.07em)'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'background-position',
						'valueMap' => array(
							'true' => '0 100%'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'background-repeat',
						'valueMap' => array(
							'true' => 'no-repeat'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => '-webkit-box-decoration-break',
						'valueMap' => array(
							'true' => 'clone'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'box-decoration-break',
						'valueMap' => array(
							'true' => 'clone'
						),
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwe-hero__title em::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						),
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'accent',
				'label' => 'Highlight colour (italic words, underline, main button)',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwex-hero-line-c'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-hero__title em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'leadSize',
				'label' => 'Size',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-lead',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'leadSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-lead',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'leadColor',
				'label' => 'Colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-lead',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'leadWidth',
				'label' => 'Width',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-lead',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'btn1Bg',
				'label' => 'Main button background',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btn1Color',
				'label' => 'Main button text',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn--primary .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btn2Color',
				'label' => 'Second button text',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-hero__btn2 .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btn2Border',
				'label' => 'Second button border',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-hero__btn2 .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-btn .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'scrollColor',
				'label' => 'Colour',
				'panel' => 'Scroll-down arrow',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-scroll',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'media' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/media',
		'title' => 'Image / screenshot',
		'category' => 'bestwebexpert',
		'icon' => 'format-image',
		'description' => 'An image or screenshot in the site\'s frame (plain, rounded, screenshot with shadow, or a browser window). Responsive sizes (srcset), alt text and lazy loading are done for you; turn on "Above the fold" for a hero image. Optional caption and link; width and shape per device in the Styles tab.',
		'keywords' => array(
			'image',
			'picture',
			'photo',
			'screenshot',
			'media',
			'figure',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'id' => array(
				'type' => 'number',
				'default' => 0
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'alt' => array(
				'type' => 'string',
				'default' => ''
			),
			'caption' => array(
				'type' => 'string',
				'default' => ''
			),
			'size' => array(
				'type' => 'string',
				'default' => 'large'
			),
			'frame' => array(
				'type' => 'string',
				'default' => ''
			),
			'barText' => array(
				'type' => 'string',
				'default' => ''
			),
			'ratio' => array(
				'type' => 'string',
				'default' => ''
			),
			'fit' => array(
				'type' => 'string',
				'default' => 'cover'
			),
			'align' => array(
				'type' => 'string',
				'default' => 'center'
			),
			'link' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'priority' => array(
				'type' => 'boolean',
				'default' => false
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'bweStyleMap' => array(
			array(
				'key' => 'maxWidth',
				'label' => 'Width',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'maxWidthTablet',
				'label' => 'Width (tablet)',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'max-width',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'maxWidthMobile',
				'label' => 'Width (phone)',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'max-width',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'ratioTablet',
				'label' => 'Shape (tablet)',
				'panel' => 'Size',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Original',
						'value' => 'auto'
					),
					array(
						'label' => '16:9',
						'value' => '16/9'
					),
					array(
						'label' => '4:3',
						'value' => '4/3'
					),
					array(
						'label' => '1:1',
						'value' => '1/1'
					),
					array(
						'label' => '3:4',
						'value' => '3/4'
					)
				),
				'rules' => array(
					array(
						'sel' => ' img',
						'prop' => 'aspect-ratio',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'ratioMobile',
				'label' => 'Shape (phone)',
				'panel' => 'Size',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Original',
						'value' => 'auto'
					),
					array(
						'label' => '16:9',
						'value' => '16/9'
					),
					array(
						'label' => '4:3',
						'value' => '4/3'
					),
					array(
						'label' => '1:1',
						'value' => '1/1'
					),
					array(
						'label' => '3:4',
						'value' => '3/4'
					)
				),
				'rules' => array(
					array(
						'sel' => ' img',
						'prop' => 'aspect-ratio',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'marginBottom',
				'label' => 'Space below',
				'panel' => 'Size',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-bottom'
					)
				)
			),
			array(
				'key' => 'radius',
				'label' => 'Corner radius',
				'panel' => 'Frame',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(img, .bwe-gw-media__frame)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'borderColor',
				'label' => 'Border colour',
				'panel' => 'Frame',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwe-gw-media__frame, img)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'shadow',
				'label' => 'Shadow',
				'panel' => 'Frame',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => '0 18px 40px -24px rgba(11,13,12,.35)'
					),
					array(
						'label' => 'Deep',
						'value' => '0 40px 80px -40px rgba(11,13,12,.45)'
					)
				),
				'rules' => array(
					array(
						'sel' => ' :is(.bwe-gw-media__frame, img)',
						'prop' => 'box-shadow'
					)
				)
			),
			array(
				'key' => 'captionColor',
				'label' => 'Caption colour',
				'panel' => 'Caption',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' figcaption',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'captionSize',
				'label' => 'Caption size',
				'panel' => 'Caption',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' figcaption',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'captionAlign',
				'label' => 'Caption alignment',
				'panel' => 'Caption',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' figcaption',
						'prop' => 'text-align'
					)
				)
			)
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'plans' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/plans',
		'title' => 'Price plans',
		'category' => 'bestwebexpert',
		'icon' => 'columns',
		'description' => 'A row of price plan cards: add, remove or move plans; mark one as featured.',
		'keywords' => array(
			'pricing',
			'plans',
			'packages',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Columns (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between plans',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'marginBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-bottom'
					)
				)
			)
		)
	),
	'platform-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/platform-card',
		'title' => 'Platform card',
		'category' => 'bestwebexpert',
		'icon' => 'id-alt',
		'description' => 'One platform / package card: image, chip, linked title, text, service list, price and button, with an optional badge. Its own colours can differ from the other cards (Styles tab).',
		'keywords' => array(
			'platform',
			'package',
			'pack',
			'card',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/platforms'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'wrapClasses' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-widget elementor-widget-bwex-platform-card'
			),
			'imageId' => array(
				'type' => 'number',
				'default' => 0
			),
			'imageUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'imageAlt' => array(
				'type' => 'string',
				'default' => ''
			),
			'chip' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'price' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'badge' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Card background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'border',
				'label' => 'Card border',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'chipBg',
				'label' => 'Tag background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipColor',
				'label' => 'Tag text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chipDot',
				'label' => 'Tag dot',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Title',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-h3 .elementor-heading-title',
						'prop' => 'color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-h3 .elementor-heading-title a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__text p',
						'prop' => 'color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'listBg',
				'label' => 'Service pills',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-checks a',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'listText',
				'label' => 'Service pill text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-checks :is(li, a)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'amountColor',
				'label' => 'Price amount',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__price strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Button background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'background-color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Button text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Button on hover',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'badgeBg',
				'label' => 'Badge background',
				'panel' => 'Badge',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-pc-badge',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'badgeColor',
				'label' => 'Badge text',
				'panel' => 'Badge',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-pc-badge',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'platforms' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/platforms',
		'title' => 'Platform cards',
		'category' => 'bestwebexpert',
		'icon' => 'columns',
		'description' => 'A grid of platform / package cards (image, chip, title, text, service list, price, button). Add a card for a new pack; every look setting is in the Styles tab.',
		'keywords' => array(
			'platform',
			'package',
			'pack',
			'cards',
			'pricing',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'classes' => array(
				'type' => 'string',
				'default' => 'bwex-plats bwex-plats--3'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Cards per row',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'step' => 1,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Cards per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'step' => 1,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Cards per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'step' => 1,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between cards',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'hideLines',
				'label' => 'Hide the lines above and below',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'border-block-width',
						'valueMap' => array(
							'true' => '0'
						)
					)
				)
			),
			array(
				'key' => 'linesColor',
				'label' => 'Line colour',
				'panel' => 'Layout',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'border-block-color'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardBorderWidth',
				'label' => 'Border width',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'border-width'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Card',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardHoverLift',
				'label' => 'Lift on hover',
				'panel' => 'Card',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card',
						'prop' => 'transition',
						'valueMap' => array(
							'true' => 'transform .3s ease, box-shadow .3s ease, border-color .3s ease'
						)
					),
					array(
						'sel' => ' > .elementor-widget-bwex-platform-card:hover',
						'prop' => 'transform',
						'valueMap' => array(
							'true' => 'translateY(-6px)'
						)
					)
				)
			),
			array(
				'key' => 'hideImages',
				'label' => 'Hide the images',
				'panel' => 'Image',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__img',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'imageRatio',
				'label' => 'Shape',
				'panel' => 'Image',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Wide 16:9',
						'value' => '16 / 9'
					),
					array(
						'label' => '16:10',
						'value' => '16 / 10'
					),
					array(
						'label' => '3:2',
						'value' => '3 / 2'
					),
					array(
						'label' => '4:3',
						'value' => '4 / 3'
					),
					array(
						'label' => 'Square',
						'value' => '1 / 1'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__img img',
						'prop' => 'aspect-ratio'
					)
				)
			),
			array(
				'key' => 'imageRadius',
				'label' => 'Corner radius',
				'panel' => 'Image',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__img',
						'prop' => 'border-radius'
					),
					array(
						'sel' => ' .bwex-plat__img img',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'imageBg',
				'label' => 'Background behind the image',
				'panel' => 'Image',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__img',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipColor',
				'label' => 'Text colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chipBg',
				'label' => 'Background',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipBorder',
				'label' => 'Border colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'chipDot',
				'label' => 'Dot colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideChipDot',
				'label' => 'Hide the dot',
				'panel' => 'Small tag',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'color'
					),
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleHover',
				'label' => 'Colour on hover',
				'panel' => 'Title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title a:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Title',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'label' => 'Size',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__text p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'listText',
				'label' => 'Text colour',
				'panel' => 'Service list',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks :is(li, a)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'listBg',
				'label' => 'Pill background',
				'panel' => 'Service list',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks a',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'listBorder',
				'label' => 'Pill border',
				'panel' => 'Service list',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks a',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'listRadius',
				'label' => 'Pill corner radius',
				'panel' => 'Service list',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks a',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'listSize',
				'label' => 'Text size',
				'panel' => 'Service list',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks :is(li, a)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'listHoverBg',
				'label' => 'Pill background on hover',
				'panel' => 'Service list',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks a:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'listHoverText',
				'label' => 'Text colour on hover',
				'panel' => 'Service list',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks a:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'priceColor',
				'label' => 'Text colour',
				'panel' => 'Price',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'priceSize',
				'label' => 'Text size',
				'panel' => 'Price',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'amountColor',
				'label' => 'Amount colour (bold part)',
				'panel' => 'Price',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'amountSize',
				'label' => 'Amount size',
				'panel' => 'Price',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price strong',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHeight',
				'label' => 'Height',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'height'
					)
				)
			),
			array(
				'key' => 'btnFull',
				'label' => 'Full width',
				'panel' => 'Button',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					),
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text colour on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'price-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/price-card',
		'title' => 'Price card',
		'category' => 'bestwebexpert',
		'icon' => 'tag',
		'description' => 'One price card: chip, linked title, text, price rows, "from" price and button. Its own colours can differ from the other cards (Styles tab).',
		'keywords' => array(
			'price',
			'pricing',
			'card',
			'services',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/price-section'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'wrapClasses' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-widget elementor-widget-bwex-platform-card'
			),
			'cardId' => array(
				'type' => 'string',
				'default' => ''
			),
			'chip' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'titleUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'price' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Card background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'border',
				'label' => 'Card border',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'chipBg',
				'label' => 'Tag background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipColor',
				'label' => 'Tag text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chipDot',
				'label' => 'Tag dot',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__chip::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Title',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-h3 .elementor-heading-title',
						'prop' => 'color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-h3 .elementor-heading-title a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowService',
				'label' => 'Price rows: service',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-prx__svc',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowNote',
				'label' => 'Price rows: turnaround',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-prx__svc small',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowAmount',
				'label' => 'Price rows: price',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-prx__amt',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowLines',
				'label' => 'Price rows: lines',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwe-prx__list',
						'prop' => 'border-top-color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwe-prx__list li',
						'prop' => 'border-bottom-color'
					)
				)
			),
			array(
				'key' => 'fromColor',
				'label' => '"From" price',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'fromAmount',
				'label' => '"From" amount',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-plat__price strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Button background',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'background-color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Button text',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Button on hover',
				'panel' => 'This card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ':not(#bwe-pc) .bwex-btn .elementor-button:hover',
						'prop' => 'border-color'
					)
				)
			)
		)
	),
	'price-list' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/price-list',
		'title' => 'Price list',
		'category' => 'bestwebexpert',
		'icon' => 'money-alt',
		'description' => 'Service price rows: service and turnaround on the left, price on the right.',
		'keywords' => array(
			'pricing',
			'prices',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'price-plan' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/price-plan',
		'title' => 'Price plan',
		'category' => 'bestwebexpert',
		'icon' => 'tag',
		'description' => 'One price plan card: badge, name, price (italic = small text), description, feature list and button.',
		'keywords' => array(
			'plan',
			'price',
			'package',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/plans'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'name' => array(
				'type' => 'string',
				'default' => ''
			),
			'price' => array(
				'type' => 'string',
				'default' => ''
			),
			'desc' => array(
				'type' => 'string',
				'default' => ''
			),
			'featured' => array(
				'type' => 'boolean',
				'default' => false
			),
			'badge' => array(
				'type' => 'string',
				'default' => 'Most popular'
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => '/contact/'
			),
			'btnNewTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'btnStyle' => array(
				'type' => 'string',
				'default' => 'auto'
			),
			'wrapClasses' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-widget elementor-widget-bwex-pricing-plan'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Background',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'border',
				'label' => 'Border colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'radius',
				'label' => 'Corner radius',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'padding',
				'label' => 'Inner space',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'nameColor',
				'label' => 'Name colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan h3',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'priceColor',
				'label' => 'Price colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'priceSize',
				'label' => 'Price size',
				'panel' => 'Text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__price',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-plan__desc, .bwex-checks li)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'checkColor',
				'label' => 'Tick colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-checks li::before',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'badgeBg',
				'label' => 'Badge background',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__badge',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'badgeColor',
				'label' => 'Badge text',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__badge',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .wp-block-button__link:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'price-row' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/price-row',
		'title' => 'Price row',
		'category' => 'bestwebexpert',
		'icon' => 'tag',
		'description' => 'One service with its turnaround, price and unit.',
		'keywords' => array(
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/price-list'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'service' => array(
				'type' => 'string',
				'default' => ''
			),
			'note' => array(
				'type' => 'string',
				'default' => ''
			),
			'amount' => array(
				'type' => 'string',
				'default' => ''
			),
			'unit' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'price-section' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/price-section',
		'title' => 'Price list section',
		'category' => 'bestwebexpert',
		'icon' => 'money-alt',
		'description' => 'Service prices section: heading and price cards (chip, title, text, price rows, "from" price, button). Add, remove or move cards; 2 or 3 cards per row and every colour are in the Styles tab.',
		'keywords' => array(
			'pricing',
			'prices',
			'services',
			'fixes',
			'price list',
			'cards',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Fixes &amp; services'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Every WordPress &amp; Shopify Price. <em>One Page.</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => 'Support, fixes, speed, security, migrations and new builds. Pick the job, see the starting price and how long it usually takes.'
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'prices'
			),
			'classes' => array(
				'type' => 'string',
				'default' => 'bwe-scope--bwe-prx'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Cards per row',
				'panel' => 'Cards layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '2 per row',
						'value' => '2'
					),
					array(
						'label' => '3 per row',
						'value' => '3'
					)
				),
				'rules' => array(
					
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Cards per row (tablet)',
				'panel' => 'Cards layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '1 per row',
						'value' => '1'
					),
					array(
						'label' => '2 per row',
						'value' => '2'
					),
					array(
						'label' => '3 per row',
						'value' => '3'
					)
				),
				'rules' => array(
					
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Cards per row (phone)',
				'panel' => 'Cards layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '1 per row',
						'value' => '1'
					),
					array(
						'label' => '2 per row',
						'value' => '2'
					)
				),
				'rules' => array(
					
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between cards',
				'panel' => 'Cards layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats',
						'prop' => 'gap'
					),
					array(
						'sel' => ' .bwex-plats',
						'prop' => '--bwe-ps-gap'
					)
				)
			),
			array(
				'key' => 'hideLines',
				'label' => 'Hide the lines above and below',
				'panel' => 'Cards layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats',
						'prop' => 'border-block-width',
						'valueMap' => array(
							'true' => '0'
						)
					)
				)
			),
			array(
				'key' => 'linesColor',
				'label' => 'Line colour (around and between cards)',
				'panel' => 'Cards layout',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats',
						'prop' => 'border-block-color'
					),
					array(
						'sel' => ' .bwex-plats',
						'prop' => '--bwe-ps-line'
					)
				)
			),
			array(
				'key' => 'hideDividers',
				'label' => 'Hide the lines between cards',
				'panel' => 'Cards layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats',
						'prop' => '--bwe-ps-line-w',
						'valueMap' => array(
							'true' => '0px'
						)
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardBorderWidth',
				'label' => 'Border width',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'border-width'
					),
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'border-style',
						'fixed' => 'solid'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plats > .elementor-widget-bwex-platform-card:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'chipColor',
				'label' => 'Text colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'chipBg',
				'label' => 'Background',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipBorder',
				'label' => 'Border colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'chipDot',
				'label' => 'Dot colour',
				'panel' => 'Small tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideChipDot',
				'label' => 'Hide the dot',
				'panel' => 'Small tag',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__chip::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Size',
				'panel' => 'Card title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTitleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Card title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Colour',
				'panel' => 'Card title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title',
						'prop' => 'color'
					),
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleHover',
				'label' => 'Colour on hover',
				'panel' => 'Card title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h3 .elementor-heading-title a:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Colour',
				'panel' => 'Card text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Size',
				'panel' => 'Card text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__text p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'rowService',
				'label' => 'Service colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__svc',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowLinkHover',
				'label' => 'Service link on hover',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__svc a:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowNote',
				'label' => 'Turnaround colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__svc small',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowAmount',
				'label' => 'Price colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__amt',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowUnit',
				'label' => 'Unit colour (/ fix, / site)',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__amt em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowLines',
				'label' => 'Line colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__list',
						'prop' => 'border-top-color'
					),
					array(
						'sel' => ' .bwe-prx__list li',
						'prop' => 'border-bottom-color'
					)
				)
			),
			array(
				'key' => 'rowSize',
				'label' => 'Service text size',
				'panel' => 'Price rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__list li',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'rowAmountSize',
				'label' => 'Price size',
				'panel' => 'Price rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__amt',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'rowSpace',
				'label' => 'Row height (space above and below)',
				'panel' => 'Price rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-prx__list li',
						'prop' => 'padding-top'
					),
					array(
						'sel' => ' .bwe-prx__list li',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'fromColor',
				'label' => 'Text colour',
				'panel' => '"From" price',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'fromAmount',
				'label' => 'Amount colour (bold part)',
				'panel' => '"From" price',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'fromSize',
				'label' => 'Text size',
				'panel' => '"From" price',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plat__price',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnFull',
				'label' => 'Full width',
				'panel' => 'Button',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					),
					array(
						'sel' => ' .bwex-btn .elementor-button',
						'prop' => 'width',
						'valueMap' => array(
							'true' => '100%'
						)
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text colour on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-btn .elementor-button:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'pricing' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/pricing',
		'title' => 'Pricing',
		'category' => 'bestwebexpert',
		'icon' => 'money-alt',
		'description' => 'Pricing section: heading, then price plans, the starting-prices card and the cost explainer (each can be removed, moved or added again). Every look setting is in the Styles tab.',
		'keywords' => array(
			'pricing',
			'plans',
			'prices',
			'packages',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Pricing'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Transparent Pricing. <em>Zero</em> Surprise Invoices.'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'pricing'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'headElementId' => array(
				'type' => 'string',
				'default' => '15dc625'
			),
			'more' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'planBg',
				'label' => 'Background',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'background-color'
					)
				),
				'general' => true
			),
			array(
				'key' => 'planBorder',
				'label' => 'Border colour',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'planRadius',
				'label' => 'Corner radius',
				'panel' => 'Plan cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'planName',
				'label' => 'Plan name colour',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan h3',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'planPrice',
				'label' => 'Price colour',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__price',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'planPriceSize',
				'label' => 'Price size',
				'panel' => 'Plan cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__price',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'planText',
				'label' => 'Text colour',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-plan__desc, .bwex-checks li)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'featuredBg',
				'label' => 'Featured plan background',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan--featured',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'badgeBg',
				'label' => 'Badge background',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__badge',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'badgeColor',
				'label' => 'Badge text',
				'panel' => 'Plan cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan__badge',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-plan .wp-block-button__link:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'process' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/process',
		'title' => 'How it works',
		'category' => 'bestwebexpert',
		'icon' => 'editor-ol',
		'description' => 'How-it-works section: heading and numbered steps (add, remove or move them; numbers update by themselves). Every look setting is in the Styles tab.',
		'keywords' => array(
			'process',
			'steps',
			'how it works',
			'timeline',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'How it works'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Launch in as Little as 21 Days. <em>Here’s Exactly How.</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => false
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'process'
			),
			'headElementId' => array(
				'type' => 'string',
				'default' => '60e9620'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideDecor',
				'general' => true,
				'label' => 'Hide background decorations (glow, grid)',
				'panel' => 'Background',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => ' .bwex-num',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Columns (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => ' .bwex-num',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Columns (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => ' .bwex-num',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-num',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-num :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between items',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Steps',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__text p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'numColor',
				'label' => 'Number colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'numSize',
				'label' => 'Number size',
				'panel' => 'Steps',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'hideNum',
				'label' => 'Hide the numbers',
				'panel' => 'Steps',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__n',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'iconTile',
				'label' => 'Icon box colour',
				'panel' => 'Steps',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item::after',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideIcons',
				'label' => 'Hide the icons',
				'panel' => 'Steps',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-num__item::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			)
		)
	),
	'product-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/product-card',
		'title' => 'Product card',
		'category' => 'bestwebexpert',
		'icon' => 'archive',
		'description' => 'One product card: picture (animated mockup, your image or none), tag, name, text, demo links and a button.',
		'keywords' => array(
			'product',
			'plugin',
			'card',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/products'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'art' => array(
				'type' => 'string',
				'default' => 'reels'
			),
			'imageUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'imageId' => array(
				'type' => 'number',
				'default' => 0
			),
			'imageAlt' => array(
				'type' => 'string',
				'default' => ''
			),
			'imageFit' => array(
				'type' => 'string',
				'default' => 'cover',
				'enum' => array(
					'cover',
					'contain',
					'fill',
					'none',
					'scale-down'
				)
			),
			'imagePosition' => array(
				'type' => 'string',
				'default' => 'center center'
			),
			'imagePadding' => array(
				'type' => 'number',
				'default' => 0
			),
			'tag' => array(
				'type' => 'string',
				'default' => ''
			),
			'name' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'linksLabel' => array(
				'type' => 'string',
				'default' => 'Live demos'
			),
			'links' => array(
				'type' => 'string',
				'default' => ''
			),
			'showLinks' => array(
				'type' => 'boolean',
				'default' => true
			),
			'btnText' => array(
				'type' => 'string',
				'default' => ''
			),
			'btnUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'wrapClasses' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-widget elementor-widget-bwex-plugin-card'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Background',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'border',
				'label' => 'Border colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'radius',
				'label' => 'Corner radius',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'tagColor',
				'label' => 'Tag colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__tag',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'nameColor',
				'label' => 'Name colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'label' => 'Demo links colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__links a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'artHeight',
				'label' => 'Picture height',
				'panel' => 'Picture',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-work__art',
						'prop' => 'height'
					)
				)
			),
			array(
				'key' => 'artBg',
				'label' => 'Picture background',
				'panel' => 'Picture',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-work__art',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'product-mockup' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/product-mockup',
		'title' => 'Plugin mockup',
		'category' => 'bestwebexpert',
		'icon' => 'smartphone',
		'description' => 'The animated plugin mockup from the product cards (ProductReels phone, ProductBoxes box builder, MigrateLift move), on its own: use it under a hero or in a Big screenshot section.',
		'keywords' => array(
			'mockup',
			'animation',
			'plugin',
			'productreels',
			'productboxes',
			'migratelift',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'art' => array(
				'type' => 'string',
				'default' => 'boxes',
				'enum' => array(
					'reels',
					'boxes',
					'lift'
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'products' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/products',
		'title' => 'Our products',
		'category' => 'bestwebexpert',
		'icon' => 'products',
		'description' => 'Products section: heading, product cards (animated mockup or your own image, tag, name, text, demo links, button; add, remove or move them) and a line under them. Every look setting is in the Styles tab.',
		'keywords' => array(
			'products',
			'plugins',
			'cards',
			'portfolio',
			'work',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Our products'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'We Don’t Just Build Sites. <em>We Ship Plugins.</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'work'
			),
			'more' => array(
				'type' => 'string',
				'default' => ''
			),
			'showMore' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Columns (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Columns (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-cards :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between items',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-cards',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__body',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Product cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-card',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__title',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__text p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__text p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'tagColor',
				'label' => 'Tag colour',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__tag',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardLinks',
				'label' => 'Demo links colour',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__links a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'artHeight',
				'label' => 'Picture height',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-work__art',
						'prop' => 'height'
					)
				)
			),
			array(
				'key' => 'artRadius',
				'label' => 'Picture corner radius',
				'panel' => 'Product cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwe-work__art',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'artBg',
				'label' => 'Picture background',
				'panel' => 'Product cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwe-work__art',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Card buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Card buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Card buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Card buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Card buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Card buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Card buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-card__btn:hover',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreColor',
				'label' => 'Colour',
				'panel' => 'Line under the cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-more p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreLink',
				'label' => 'Link colour',
				'panel' => 'Line under the cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-more a',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'section' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/section',
		'title' => 'Section',
		'category' => 'bestwebexpert',
		'icon' => 'align-wide',
		'description' => 'A page section: pick White, Soft or Dark — or one of the ready layouts in the inserter (long text, showcase, text + image, big screenshot, demo bar, guide with contents, screenshot tour) — add any blocks inside and style everything in the Styles tab: space (desktop, tablet, phone), width, background, small label, heading, intro, text, cards and buttons.',
		'keywords' => array(
			'section',
			'band',
			'container',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'tagName' => array(
				'type' => 'string',
				'default' => 'section'
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'classes' => array(
				'type' => 'string',
				'default' => 'bwex-section'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopTablet',
				'label' => 'Space above (tablet)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'paddingBottomTablet',
				'label' => 'Space below (tablet)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-wrap, .bwe-final__box)',
						'prop' => 'max-width'
					),
					array(
						'sel' => ' > :not(.bwex-wrap, .bwe-final__box, style)',
						'prop' => 'max-width'
					),
					array(
						'sel' => ' > :not(.bwex-wrap, .bwe-final__box, style)',
						'prop' => 'margin-left',
						'fixed' => 'auto'
					),
					array(
						'sel' => ' > :not(.bwex-wrap, .bwe-final__box, style)',
						'prop' => 'margin-right',
						'fixed' => 'auto'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Text alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-head, .bwex-headw, .bwex-h2, .bwex-intro, .bwe-final__box, h2.wp-block-heading, h2.wp-block-heading ~ p)',
						'prop' => 'text-align'
					),
					array(
						'sel' => ' .wp-block-buttons',
						'prop' => 'justify-content',
						'valueMap' => array(
							'left' => 'flex-start',
							'center' => 'center',
							'right' => 'flex-end'
						)
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideDecor',
				'general' => true,
				'label' => 'Hide background decorations (glow, grid)',
				'panel' => 'Background',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => '::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box',
						'prop' => 'background-image',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					),
					array(
						'sel' => ' .bwe-final__box::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' :is(.bwex-eyebrow p, p.bwe-eyebrow)::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading) em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p:not(.bwex-eyebrow p, .bwe-eyebrow))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(a:not(.wp-block-button__link, .elementor-button, .bwex-card__btn, .bwex-svc__tile))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p:not(.bwex-eyebrow p, .bwe-eyebrow))',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-eyebrow p, p.bwe-eyebrow)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-eyebrow p, p.bwe-eyebrow)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-eyebrow p, p.bwe-eyebrow)::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-eyebrow p, p.bwe-eyebrow)::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading)',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading)',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading)',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading) em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-intro p, .bwex-about__lead p, .bwe-final__box > .bwe-lead, h2.wp-block-heading + p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-intro p, .bwex-about__lead p, .bwe-final__box > .bwe-lead, h2.wp-block-heading + p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card, .bwex-plan, .bwex-about__card, .bwex-vt, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card, .bwex-plan, .bwex-about__card, .bwex-vt, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column)',
						'prop' => 'border-color'
					),
					array(
						'sel' => ' .wp-block-columns > .wp-block-column',
						'prop' => 'border',
						'tpl' => '1px solid {v}'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card, .bwex-plan, .bwex-about__card, .bwex-vt, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card__body, .bwex-plan, .bwex-about__card, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column)',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card, .bwex-plan, .bwex-about__card, .bwex-vt, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column)',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Card title colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__name, .bwex-who__list strong, .bwex-card__title, .bwex-plat h3, .bwex-plan h3, .bwex-about__card h3, .bwex-faq__q, .bwex-num__title, .bwex-vt__who strong, .wp-block-column :is(h3, h4))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Card text colour',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__text, .bwex-who__list span, .bwex-card__text, .bwex-plat__text, .bwex-plan__desc, .bwex-about__card li, .bwex-faq__a p, .bwex-num__text p, .bwex-vt__who, .wp-block-column p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list > li, .bwex-who__list a, .bwex-plat, .bwex-card, .bwex-plan, .bwex-about__card, .bwex-vt, .bwex-pricenote, .bwex-faq__item, .bwex-num__item, .wp-block-columns > .wp-block-column):hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Buttons',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Buttons',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn):hover',
						'prop' => 'background-color'
					)
				)
			)
		)
	),
	'section-head' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/section-head',
		'title' => 'Section header',
		'category' => 'bestwebexpert',
		'icon' => 'heading',
		'description' => 'Small label, heading (italic = lime highlight) and an optional intro beside or under it.',
		'keywords' => array(
			'heading',
			'title',
			'eyebrow',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'service-tile' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/service-tile',
		'title' => 'Service tile',
		'category' => 'bestwebexpert',
		'icon' => 'screenoptions',
		'description' => 'One linked service: tag, name, short text and arrow.',
		'keywords' => array(
			'service',
			'tile',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/services'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'icon' => array(
				'type' => 'string',
				'default' => 'wordpress'
			),
			'platform' => array(
				'type' => 'string',
				'default' => 'wp'
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'tag' => array(
				'type' => 'string',
				'default' => ''
			),
			'name' => array(
				'type' => 'string',
				'default' => ''
			),
			'desc' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'services' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/services',
		'title' => 'Services',
		'category' => 'bestwebexpert',
		'icon' => 'grid-view',
		'description' => 'Services band: small label, heading (italic = highlight), intro and a grid of linked service tiles. Every look setting is in the Styles tab.',
		'keywords' => array(
			'services',
			'cards',
			'grid',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'lead' => array(
				'type' => 'string',
				'default' => ''
			),
			'more' => array(
				'type' => 'string',
				'default' => ''
			),
			'showMore' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'services'
			),
			'modifiers' => array(
				'type' => 'string',
				'default' => 'bwex-section bwex-section--dark bwex-svc-band'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Columns (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Columns (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-svc__grid :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between tiles',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__grid',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'sectionBg',
				'label' => 'Background',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'accent',
				'label' => 'Highlight colour (italic words, hover, arrows)',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Small label (above the heading)',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Heading',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__title h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'leadColor',
				'label' => 'Intro text',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__lead p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreColor',
				'label' => 'Bottom line',
				'panel' => 'Colours',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-more',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__title h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__title h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__title h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'tileBg',
				'label' => 'Background',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'tileBorder',
				'label' => 'Border colour',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'tileRadius',
				'label' => 'Corner radius',
				'panel' => 'Tiles',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'tilePadding',
				'label' => 'Inner space',
				'panel' => 'Tiles',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'tileHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'tileHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tile:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'nameColor',
				'label' => 'Name colour',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__name',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'nameSize',
				'label' => 'Name size',
				'panel' => 'Tiles',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__name',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'descColor',
				'label' => 'Text colour',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__desc',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'tagColor',
				'label' => 'Tag text',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tag',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'tagBg',
				'label' => 'Tag background',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__tag',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'arrowColor',
				'label' => 'Arrow colour',
				'panel' => 'Tiles',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__arrow',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'hideArrow',
				'label' => 'Hide the arrows',
				'panel' => 'Tiles',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-svc__arrow',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			)
		)
	),
	'spec-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/spec-card',
		'title' => 'Feature card',
		'category' => 'bestwebexpert',
		'icon' => 'id-alt',
		'description' => 'One spec card: a name, a short text and an optional tag.',
		'keywords' => array(
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/spec-list',
			'bwe/why-us'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'name' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'chip' => array(
				'type' => 'string',
				'default' => ''
			),
			'clickable' => array(
				'type' => 'boolean',
				'default' => true
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'newTab' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'spec-list' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/spec-list',
		'title' => 'Feature cards',
		'category' => 'bestwebexpert',
		'icon' => 'screenoptions',
		'description' => 'A grid of feature cards (name, short text and an optional tag).',
		'keywords' => array(
			'cards',
			'features',
			'benefits',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'attributes' => array(
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Items per row (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			)
		)
	),
	'starting-prices' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/starting-prices',
		'title' => 'Starting prices',
		'category' => 'bestwebexpert',
		'icon' => 'tickets-alt',
		'description' => 'Starting-prices card: a label, linked "service — from $X" rows (add, remove or move them), a note and a link to every price.',
		'keywords' => array(
			'prices',
			'pricing',
			'from',
			'cost',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'label' => array(
				'type' => 'string',
				'default' => 'Starting prices'
			),
			'showLabel' => array(
				'type' => 'boolean',
				'default' => true
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					array(
						'label' => 'WordPress website',
						'price' => 'from $250',
						'url' => '/pricing/#wordpress-prices'
					),
					array(
						'label' => 'Shopify store',
						'price' => 'from $250',
						'url' => '/pricing/#shopify-prices'
					),
					array(
						'label' => 'WooCommerce store',
						'price' => 'from $400',
						'url' => '/pricing/#wordpress-prices'
					)
				)
			),
			'note' => array(
				'type' => 'string',
				'default' => 'You’ll get a fixed, written quote after your free strategy call.'
			),
			'showNote' => array(
				'type' => 'boolean',
				'default' => true
			),
			'allText' => array(
				'type' => 'string',
				'default' => 'See every plan and price →'
			),
			'allUrl' => array(
				'type' => 'string',
				'default' => '/pricing/'
			),
			'showAll' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'bg',
				'label' => 'Background',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'border',
				'label' => 'Border colour',
				'panel' => 'Card',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'radius',
				'label' => 'Corner radius',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'padding',
				'label' => 'Inner space',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'marginTop',
				'label' => 'Space above',
				'panel' => 'Card',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'labelColor',
				'label' => 'Label colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__label',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'noteColor',
				'label' => 'Note colour',
				'panel' => 'Text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__note',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Price rows',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Columns (phone)',
				'panel' => 'Price rows',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-pricenote__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'rowBg',
				'label' => 'Background',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list a',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'rowBorder',
				'label' => 'Border colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list a',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'rowRadius',
				'label' => 'Corner radius',
				'panel' => 'Price rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list a',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'rowLabel',
				'label' => 'Service colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list span',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowPrice',
				'label' => 'Price colour',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'rowHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Price rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__list a:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnBg',
				'label' => 'Background',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnText',
				'label' => 'Text colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'btnBorder',
				'label' => 'Border colour',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'btnRadius',
				'label' => 'Corner radius',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'btnSize',
				'label' => 'Text size',
				'panel' => 'Button',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'btnHoverBg',
				'label' => 'Background on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a:hover',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'btnHoverText',
				'label' => 'Text on hover',
				'panel' => 'Button',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-pricenote__all a:hover',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'step' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/step',
		'title' => 'Step',
		'category' => 'bestwebexpert',
		'icon' => 'marker',
		'description' => 'One numbered step. The number follows the step\'s position.',
		'keywords' => array(
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/steps',
			'bwe/process',
			'bwe/guide'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'n' => array(
				'type' => 'string',
				'default' => '01'
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'reveal' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'steps' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/steps',
		'title' => 'Numbered steps',
		'category' => 'bestwebexpert',
		'icon' => 'editor-ol',
		'description' => 'How-it-works steps: big outlined numbers, a title and a short text.',
		'keywords' => array(
			'process',
			'steps',
			'how it works',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'modifiers' => array(
				'type' => 'string',
				'default' => 'bwex-num--row bwex-num--dark'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Items per row (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			)
		)
	),
	'testimonials' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/testimonials',
		'title' => 'Testimonials',
		'category' => 'bestwebexpert',
		'icon' => 'format-video',
		'description' => 'Testimonials section: heading, video testimonials (paste a YouTube or Shorts link; add, remove or move them) and a line with review links. Every look setting is in the Styles tab.',
		'keywords' => array(
			'testimonials',
			'reviews',
			'video',
			'youtube',
			'proof',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Testimonials'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Here’s What <em>Our Customers Say</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'testimonials'
			),
			'more' => array(
				'type' => 'string',
				'default' => ''
			),
			'showMore' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'columns',
				'label' => 'Columns (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Columns (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Columns (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 2,
				'rules' => array(
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'gap',
				'label' => 'Space between items',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-quotes',
						'prop' => 'gap'
					)
				)
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Video cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Video cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Video cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-vt',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt__who strong',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Video cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt__who strong',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt__who',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Video cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-vt__who',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'videoRadius',
				'label' => 'Video corner radius',
				'panel' => 'Video cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-vt__video, .bwex-yt, .bwex-yt img)',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'playBg',
				'label' => 'Play button colour',
				'panel' => 'Video cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-yt__play',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'moreColor',
				'label' => 'Colour',
				'panel' => 'Review links line',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-more',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'moreSize',
				'label' => 'Size',
				'panel' => 'Review links line',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-more',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'moreLink',
				'label' => 'Link colour',
				'panel' => 'Review links line',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-more a',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'video-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/video-card',
		'title' => 'Video testimonial',
		'category' => 'bestwebexpert',
		'icon' => 'video-alt3',
		'description' => 'One video testimonial: a YouTube / Shorts link (shown as a fast click-to-play thumbnail) and who it is from.',
		'keywords' => array(
			'video',
			'testimonial',
			'youtube',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/testimonials'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'who' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'who-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/who-card',
		'title' => 'Audience card',
		'category' => 'bestwebexpert',
		'icon' => 'id',
		'description' => 'One linked card: title, short text and a platform tag.',
		'keywords' => array(
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/who-list'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'tag' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php'
	),
	'who-list' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/who-list',
		'title' => 'Who we build for',
		'category' => 'bestwebexpert',
		'icon' => 'groups',
		'description' => 'Linked cards for the kinds of businesses you work with.',
		'keywords' => array(
			'audience',
			'cards',
			'industries',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'attributes' => array(
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Items per row (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => '',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			)
		)
	),
	'why-us' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/why-us',
		'title' => 'Why us',
		'category' => 'bestwebexpert',
		'icon' => 'yes-alt',
		'description' => 'Why-us section: small label, heading (italic = highlight), intro, a list of feature cards (add, remove or move them) and a line under them. Every look setting is in the Styles tab.',
		'keywords' => array(
			'why us',
			'features',
			'spec',
			'benefits',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Why BestWebExpert'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'What Makes Us <em>The Right Partner</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => ''
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'spec'
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'aside' => array(
				'type' => 'string',
				'default' => ''
			),
			'showAside' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'tone' => array(
				'type' => 'string',
				'default' => 'soft'
			),
			'headWrap' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'columns',
				'label' => 'Items per row (desktop)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 6,
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'columnsTablet',
				'label' => 'Items per row (tablet)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 4,
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'columnsMobile',
				'label' => 'Items per row (phone)',
				'panel' => 'Layout',
				'control' => 'range',
				'min' => 1,
				'max' => 3,
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'grid-template-columns',
						'tpl' => 'repeat({v}, minmax(0, 1fr))',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'mobile'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'oneRow',
				'label' => 'All items on one row (desktop, while they fit)',
				'panel' => 'Layout',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'display',
						'fixed' => 'grid',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list',
						'prop' => 'grid-template-columns',
						'fixed' => 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'grid-column',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list > *',
						'prop' => 'width',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'white-space',
						'fixed' => 'normal',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'height',
						'fixed' => 'auto',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'min-height',
						'fixed' => '40px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-top',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'padding-bottom',
						'fixed' => '8px',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'text-align',
						'fixed' => 'center',
						'media' => 'desktop'
					),
					array(
						'sel' => ' .bwex-spec__list :is(.wp-block-button__link, .elementor-button, .bwex-card__btn)',
						'prop' => 'line-height',
						'fixed' => '1.3',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => '',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => '',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => '',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => '',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'lineColor',
				'label' => 'Divider lines',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :is(.bwex-spec__list, .bwex-spec__list > li)',
						'prop' => 'border-color'
					)
				),
				'general' => true
			),
			array(
				'key' => 'cardBg',
				'label' => 'Background',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'cardBorder',
				'label' => 'Border colour',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardRadius',
				'label' => 'Corner radius',
				'panel' => 'Spec cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'cardPadding',
				'label' => 'Inner space',
				'panel' => 'Spec cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li',
						'prop' => 'padding'
					)
				)
			),
			array(
				'key' => 'cardShadow',
				'label' => 'Shadow',
				'panel' => 'Spec cards',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'None',
						'value' => 'none'
					),
					array(
						'label' => 'Soft',
						'value' => 'soft'
					),
					array(
						'label' => 'Strong',
						'value' => 'strong'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li',
						'prop' => 'box-shadow',
						'valueMap' => array(
							'none' => 'none',
							'soft' => '0 18px 40px -28px rgba(17, 17, 17, .35)',
							'strong' => '0 28px 60px -24px rgba(17, 17, 17, .55)'
						)
					)
				)
			),
			array(
				'key' => 'cardHoverBorder',
				'label' => 'Border on hover',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list > li:hover',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'cardTitleColor',
				'label' => 'Title colour',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__name',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTitleSize',
				'label' => 'Title size',
				'panel' => 'Spec cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__name',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'cardTextColor',
				'label' => 'Text colour',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__text',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'cardTextSize',
				'label' => 'Text size',
				'panel' => 'Spec cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__text',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'nameWidth',
				'label' => 'Name column width',
				'panel' => 'Spec cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => '',
						'prop' => '--bwex-spec-name'
					)
				)
			),
			array(
				'key' => 'chipBg',
				'label' => 'Tag background',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list code',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'chipColor',
				'label' => 'Tag text',
				'panel' => 'Spec cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list code',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'hideChip',
				'label' => 'Hide the tags',
				'panel' => 'Spec cards',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__list code',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'asideColor',
				'label' => 'Colour',
				'panel' => 'Line under the cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__aside',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'asideSize',
				'label' => 'Size',
				'panel' => 'Line under the cards',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__aside',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'asideLink',
				'label' => 'Link colour',
				'panel' => 'Line under the cards',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-spec__aside a',
						'prop' => 'color'
					)
				)
			)
		)
	),
	'work' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/work',
		'title' => 'Selected work',
		'category' => 'bestwebexpert',
		'icon' => 'portfolio',
		'description' => 'Portfolio list: heading and numbered projects (screenshot, title, tag, text, link). On desktop a row shows its screenshot on hover. Add, remove or move projects; every look setting is in the Styles tab.',
		'keywords' => array(
			'portfolio',
			'work',
			'projects',
			'case studies',
			'showcase',
			'best web expert',
			'bwe'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => 'Selected work'
			),
			'showEyebrow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Work You Can <em>Open Right Now</em>'
			),
			'intro' => array(
				'type' => 'string',
				'default' => 'Every project here is live. Open one and try the real thing, on desktop or phone.'
			),
			'showIntro' => array(
				'type' => 'boolean',
				'default' => true
			),
			'split' => array(
				'type' => 'boolean',
				'default' => true
			),
			'headingId' => array(
				'type' => 'string',
				'default' => ''
			),
			'sectionId' => array(
				'type' => 'string',
				'default' => 'work'
			),
			'wrapClasses' => array(
				'type' => 'string',
				'default' => 'elementor-element elementor-widget elementor-widget-bwex-work'
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'bweIcon' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'paddingTop',
				'label' => 'Space above',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'padding-top'
					)
				)
			),
			array(
				'key' => 'paddingBottom',
				'label' => 'Space below',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'paddingTopMobile',
				'label' => 'Space above (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'padding-top',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'paddingBottomMobile',
				'label' => 'Space below (phone)',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'padding-bottom',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'contentWidth',
				'label' => 'Content width',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-wrap',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'minHeight',
				'label' => 'Minimum height',
				'panel' => 'Layout',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'min-height'
					)
				)
			),
			array(
				'key' => 'textAlign',
				'label' => 'Heading alignment',
				'panel' => 'Layout',
				'control' => 'select',
				'options' => array(
					array(
						'label' => 'Left',
						'value' => 'left'
					),
					array(
						'label' => 'Centre',
						'value' => 'center'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-head',
						'prop' => 'text-align'
					)
				)
			),
			array(
				'key' => 'bgColor',
				'label' => 'Background colour',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'bgImage',
				'label' => 'Background image',
				'panel' => 'Background',
				'control' => 'image',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'background-image',
						'tpl' => 'url(\'{v}\')'
					),
					array(
						'sel' => ' .bwex-work',
						'prop' => 'background-size',
						'fixed' => 'cover'
					),
					array(
						'sel' => ' .bwex-work',
						'prop' => 'background-position',
						'fixed' => 'center'
					),
					array(
						'sel' => ' .bwex-work',
						'prop' => 'background-repeat',
						'fixed' => 'no-repeat'
					)
				)
			),
			array(
				'key' => 'overlay',
				'label' => 'Overlay colour (use transparency)',
				'panel' => 'Background',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'box-shadow',
						'tpl' => 'inset 0 0 0 100vmax {v}'
					)
				)
			),
			array(
				'key' => 'accent',
				'general' => true,
				'label' => 'Highlight colour (italic words, lines, tags)',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => '--bwex-accent'
					),
					array(
						'sel' => ' .bwex-work',
						'prop' => '--bwe-accent'
					),
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'background-image',
						'tpl' => 'linear-gradient({v}, {v})'
					)
				)
			),
			array(
				'key' => 'textColor',
				'general' => true,
				'label' => 'Text colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work',
						'prop' => 'color'
					),
					array(
						'sel' => ' :where(p)',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'linkColor',
				'general' => true,
				'label' => 'Link colour',
				'panel' => 'Colours & text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' :where(p a, li a:not(.wp-block-button__link))',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textSize',
				'general' => true,
				'label' => 'Text size',
				'panel' => 'Colours & text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' :where(p)',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowColor',
				'label' => 'Colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'eyebrowSize',
				'label' => 'Size',
				'panel' => 'Small label (above the heading)',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'eyebrowChip',
				'label' => 'Icon box colour',
				'panel' => 'Small label (above the heading)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'background-color'
					)
				)
			),
			array(
				'key' => 'hideEyebrowIcon',
				'label' => 'Hide the icon',
				'panel' => 'Small label (above the heading)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-eyebrow p::before',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'titleSize',
				'label' => 'Size',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'titleSizeMobile',
				'label' => 'Size (phone)',
				'panel' => 'Heading',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-size',
						'media' => 'mobile'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleWeight',
				'label' => 'Weight',
				'panel' => 'Heading',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'titleLineHeight',
				'label' => 'Line height',
				'panel' => 'Heading',
				'control' => 'range',
				'min' => 0.8,
				'max' => 1.6,
				'step' => 0.01,
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2',
						'prop' => 'line-height'
					)
				)
			),
			array(
				'key' => 'highlightText',
				'label' => 'Highlighted words colour',
				'panel' => 'Heading',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-h2 h2 em',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introColor',
				'label' => 'Colour',
				'panel' => 'Intro',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'introSize',
				'label' => 'Size',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'introWidth',
				'label' => 'Max width',
				'panel' => 'Intro',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-intro p',
						'prop' => 'max-width'
					)
				)
			),
			array(
				'key' => 'rowLines',
				'label' => 'Line colour',
				'panel' => 'Rows',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__grid',
						'prop' => 'border-bottom-color'
					),
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'border-top-color'
					)
				)
			),
			array(
				'key' => 'hideRowLines',
				'label' => 'Hide the lines',
				'panel' => 'Rows',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__grid',
						'prop' => 'border-bottom-width',
						'valueMap' => array(
							'true' => '0'
						)
					),
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'border-top-width',
						'valueMap' => array(
							'true' => '0'
						)
					)
				)
			),
			array(
				'key' => 'rowSpace',
				'label' => 'Row height (space above and below)',
				'panel' => 'Rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'padding-top'
					),
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'padding-bottom'
					)
				)
			),
			array(
				'key' => 'listTop',
				'label' => 'Space above the list',
				'panel' => 'Rows',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__grid',
						'prop' => 'margin-top'
					)
				)
			),
			array(
				'key' => 'noFade',
				'label' => 'Don’t fade the other rows on hover',
				'panel' => 'Rows',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__grid:hover .bwex-work__item',
						'prop' => 'opacity',
						'valueMap' => array(
							'true' => '1'
						)
					)
				)
			),
			array(
				'key' => 'numColor',
				'label' => 'Colour',
				'panel' => 'Number',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__num',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'numHover',
				'label' => 'Colour on hover',
				'panel' => 'Number',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item:is(:hover, :focus-within) .bwex-work__num',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'numSize',
				'label' => 'Size',
				'panel' => 'Number',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__num',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'hideNum',
				'label' => 'Hide the numbers',
				'panel' => 'Number',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__num',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'workTitleColor',
				'label' => 'Colour',
				'panel' => 'Project title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'workTitleHover',
				'label' => 'Colour on hover',
				'panel' => 'Project title',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item:is(:hover, :focus-within) .bwex-work__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'workTitleSize',
				'label' => 'Size (desktop)',
				'panel' => 'Project title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__title',
						'prop' => 'font-size',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'workTitleSizeMobile',
				'label' => 'Size (tablet and phone)',
				'panel' => 'Project title',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__title',
						'prop' => 'font-size',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'workTitleWeight',
				'label' => 'Weight',
				'panel' => 'Project title',
				'control' => 'select',
				'options' => array(
					array(
						'label' => '400 Regular',
						'value' => '400'
					),
					array(
						'label' => '500 Medium',
						'value' => '500'
					),
					array(
						'label' => '600 Semibold',
						'value' => '600'
					),
					array(
						'label' => '700 Bold',
						'value' => '700'
					),
					array(
						'label' => '800 Extra bold',
						'value' => '800'
					)
				),
				'rules' => array(
					array(
						'sel' => ' .bwex-work__title',
						'prop' => 'font-weight'
					)
				)
			),
			array(
				'key' => 'workTextColor',
				'label' => 'Colour',
				'panel' => 'Project text',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__text',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'workTextSize',
				'label' => 'Size',
				'panel' => 'Project text',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__text',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'tagColor',
				'label' => 'Colour',
				'panel' => 'Tag',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__tag',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'tagSize',
				'label' => 'Size',
				'panel' => 'Tag',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__tag',
						'prop' => 'font-size'
					)
				)
			),
			array(
				'key' => 'arrowColor',
				'label' => 'Arrow colour',
				'panel' => 'Arrow (desktop)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item::after',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'arrowBorder',
				'label' => 'Circle border',
				'panel' => 'Arrow (desktop)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item::after',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'arrowHoverBg',
				'label' => 'Circle on hover',
				'panel' => 'Arrow (desktop)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item:is(:hover, :focus-within)::after',
						'prop' => 'background-color'
					),
					array(
						'sel' => ' .bwex-work__item:is(:hover, :focus-within)::after',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'arrowHoverColor',
				'label' => 'Arrow on hover',
				'panel' => 'Arrow (desktop)',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item:is(:hover, :focus-within)::after',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'hideArrow',
				'label' => 'Hide the arrow',
				'panel' => 'Arrow (desktop)',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item::after',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						)
					)
				)
			),
			array(
				'key' => 'previewWidth',
				'label' => 'Width of the hover preview',
				'panel' => 'Screenshot',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__shot',
						'prop' => 'width',
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'shotRadius',
				'label' => 'Corner radius',
				'panel' => 'Screenshot',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__shot',
						'prop' => 'border-radius'
					)
				)
			),
			array(
				'key' => 'shotBorder',
				'label' => 'Border colour',
				'panel' => 'Screenshot',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__shot',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'thumbWidth',
				'label' => 'Thumbnail width (tablet and phone)',
				'panel' => 'Screenshot',
				'control' => 'unit',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'grid-template-columns',
						'tpl' => '{v} minmax(0, 1fr)',
						'media' => 'tablet'
					)
				)
			),
			array(
				'key' => 'hidePreview',
				'label' => 'No hover preview (desktop)',
				'panel' => 'Screenshot',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__shot',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						),
						'media' => 'desktop'
					)
				)
			),
			array(
				'key' => 'hideThumbs',
				'label' => 'No thumbnails on tablet and phone',
				'panel' => 'Screenshot',
				'control' => 'toggle',
				'rules' => array(
					array(
						'sel' => ' .bwex-work__shot',
						'prop' => 'display',
						'valueMap' => array(
							'true' => 'none'
						),
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-work__item',
						'prop' => 'grid-template-columns',
						'valueMap' => array(
							'true' => 'minmax(0, 1fr)'
						),
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-work__meta',
						'prop' => 'grid-column',
						'valueMap' => array(
							'true' => '1'
						),
						'media' => 'tablet'
					),
					array(
						'sel' => ' .bwex-work__text',
						'prop' => 'grid-column',
						'valueMap' => array(
							'true' => '1'
						),
						'media' => 'tablet'
					)
				)
			)
		)
	),
	'work-item' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'bwe/work-item',
		'title' => 'Project',
		'category' => 'bestwebexpert',
		'icon' => 'format-image',
		'description' => 'One project in Selected work: screenshot, number, title, tag and text, all linking to the project.',
		'keywords' => array(
			'portfolio',
			'project',
			'work',
			'best web expert',
			'bwe'
		),
		'parent' => array(
			'bwe/work'
		),
		'textdomain' => 'bestwebexpert',
		'attributes' => array(
			'num' => array(
				'type' => 'string',
				'default' => ''
			),
			'imageId' => array(
				'type' => 'number',
				'default' => 0
			),
			'imageUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'imageAlt' => array(
				'type' => 'string',
				'default' => ''
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'newTab' => array(
				'type' => 'boolean',
				'default' => false
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'tag' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'bweStyle' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'editorScript' => 'bwe-gw-editor',
		'render' => 'file:./render.php',
		'bweStyleMap' => array(
			array(
				'key' => 'numColor',
				'label' => 'Number',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi) .bwex-work__num',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleColor',
				'label' => 'Title',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi) .bwex-work__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'titleHover',
				'label' => 'Title on hover',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi):is(:hover, :focus-within) .bwex-work__title',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'tagColor',
				'label' => 'Tag',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi) .bwex-work__tag',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'textColor',
				'label' => 'Text',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi) .bwex-work__text',
						'prop' => 'color'
					)
				)
			),
			array(
				'key' => 'arrowHoverBg',
				'label' => 'Arrow circle on hover',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi):is(:hover, :focus-within)::after',
						'prop' => 'background-color'
					),
					array(
						'sel' => ':not(#bwe-wi):is(:hover, :focus-within)::after',
						'prop' => 'border-color'
					)
				)
			),
			array(
				'key' => 'shotBg',
				'label' => 'Screenshot background',
				'panel' => 'This project',
				'control' => 'color',
				'rules' => array(
					array(
						'sel' => ':not(#bwe-wi) .bwex-work__shot',
						'prop' => 'background-color'
					)
				)
			)
		)
	)
);
