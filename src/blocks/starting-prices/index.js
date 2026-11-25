import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { AttrText, AttrToggle, ItemsPanel } from '../shared/section-parts';
import metadata from './block.json';

function Edit( { attributes, setAttributes, clientId } ) {
	const { label, items, note, allText, showLabel, showNote, showAll } =
		attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const list = Array.isArray( items ) ? items : [];
	const setItem = ( index, key, value ) =>
		setAttributes( {
			items: list.map( ( item, i ) =>
				i === index ? { ...item, [ key ]: value } : item
			),
		} );
	const props = { attributes, setAttributes };
	return (
		<>
			<InspectorControls>
				<ItemsPanel
					title={ __( 'Price rows', 'bestwebexpert' ) }
					items={ list }
					fields={ [
						{
							key: 'label',
							label: __( 'Service', 'bestwebexpert' ),
						},
						{ key: 'price', label: __( 'Price', 'bestwebexpert' ) },
						{ key: 'url', label: __( 'Link', 'bestwebexpert' ) },
					] }
					blank={ {
						label: __( 'New service', 'bestwebexpert' ),
						price: __( 'from $0', 'bestwebexpert' ),
						url: '/pricing/',
					} }
					addLabel={ __( '+ Add a price row', 'bestwebexpert' ) }
					onChange={ set( 'items' ) }
				/>
				<PanelBody
					title={ __( 'Card', 'bestwebexpert' ) }
					initialOpen={ false }
				>
					<AttrToggle
						label={ __( 'Show the label', 'bestwebexpert' ) }
						name="showLabel"
						{ ...props }
					/>
					<AttrToggle
						label={ __( 'Show the note', 'bestwebexpert' ) }
						name="showNote"
						{ ...props }
					/>
					<AttrToggle
						label={ __(
							'Show the "every price" link',
							'bestwebexpert'
						) }
						name="showAll"
						{ ...props }
					/>
					{ showAll !== false && (
						<AttrText
							label={ __(
								'"Every price" link goes to',
								'bestwebexpert'
							) }
							name="allUrl"
							{ ...props }
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div
				{ ...useBlockProps( {
					className: [ 'wp-block-group bwex-pricenote', className ]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ css && <style>{ css }</style> }
				{ showLabel !== false && (
					<RichText
						tagName="p"
						className="bwex-pricenote__label wp-block-paragraph"
						value={ label }
						onChange={ set( 'label' ) }
						placeholder={ __( 'Label', 'bestwebexpert' ) }
						allowedFormats={ [] }
						disableLineBreaks
					/>
				) }
				<ul className="wp-block-list bwex-pricenote__list">
					{ list.map( ( item, index ) => (
						<li key={ index }>
							{ /* eslint-disable-next-line jsx-a11y/anchor-is-valid -- no href while editing (it can't navigate); the link is edited in the sidebar. */ }
							<a>
								<RichText
									tagName="span"
									value={ item.label }
									onChange={ ( v ) =>
										setItem( index, 'label', v )
									}
									placeholder={ __(
										'Service',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>{ ' ' }
								<RichText
									tagName="strong"
									value={ item.price }
									onChange={ ( v ) =>
										setItem( index, 'price', v )
									}
									placeholder={ __(
										'from $0',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</a>
						</li>
					) ) }
				</ul>
				{ showNote !== false && (
					<RichText
						tagName="p"
						className="bwex-pricenote__note wp-block-paragraph"
						value={ note }
						onChange={ set( 'note' ) }
						placeholder={ __( 'Note', 'bestwebexpert' ) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
				) }
				{ showAll !== false && (
					<p className="bwex-pricenote__all wp-block-paragraph">
						{ /* eslint-disable-next-line jsx-a11y/anchor-is-valid -- no href while editing (it can't navigate); the link is edited in the sidebar. */ }
						<a>
							<RichText
								tagName="span"
								value={ allText }
								onChange={ set( 'allText' ) }
								placeholder={ __(
									'See every price →',
									'bestwebexpert'
								) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
						</a>
					</p>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
