import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	BlockControls,
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	ToolbarButton,
	ToolbarGroup,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

const BLANK = {
	text: '<strong>New point.</strong> Explain it in a sentence or two.',
	wrap: '',
};

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const { title, items } = attributes;
	const list = Array.isArray( items ) ? items : [];
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const setItems = ( next ) => setAttributes( { items: next } );
	const move = ( index, to ) => {
		if ( to < 0 || to >= list.length ) {
			return;
		}
		const next = [ ...list ];
		const [ item ] = next.splice( index, 1 );
		next.splice( to, 0, item );
		setItems( next );
	};
	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						label={ __( 'Add a point', 'bestwebexpert' ) }
						onClick={ () => setItems( [ ...list, { ...BLANK } ] ) }
					>
						{ __( '+ Add point', 'bestwebexpert' ) }
					</ToolbarButton>
				</ToolbarGroup>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Points', 'bestwebexpert' ) }>
					<p style={ { marginTop: 0, color: '#757575' } }>
						{ __(
							'Edit the text on the page (start with a bold name). Order and remove points here.',
							'bestwebexpert'
						) }
					</p>
					{ list.map( ( item, index ) => (
						<div
							key={ index }
							style={ {
								display: 'flex',
								alignItems: 'center',
								gap: 4,
								marginBottom: 8,
							} }
						>
							<span
								style={ {
									flex: 1,
									overflow: 'hidden',
									textOverflow: 'ellipsis',
									whiteSpace: 'nowrap',
								} }
							>
								{ String( item.text || '' ).replace(
									/<[^>]+>/g,
									''
								) }
							</span>
							<Button
								size="small"
								label={ __( 'Move up', 'bestwebexpert' ) }
								disabled={ index === 0 }
								onClick={ () => move( index, index - 1 ) }
							>
								↑
							</Button>
							<Button
								size="small"
								label={ __( 'Move down', 'bestwebexpert' ) }
								disabled={ index === list.length - 1 }
								onClick={ () => move( index, index + 1 ) }
							>
								↓
							</Button>
							<Button
								size="small"
								isDestructive
								label={ __( 'Remove', 'bestwebexpert' ) }
								onClick={ () =>
									setItems(
										list.filter( ( _, i ) => i !== index )
									)
								}
							>
								✕
							</Button>
						</div>
					) ) }
					<Button
						variant="secondary"
						onClick={ () => setItems( [ ...list, { ...BLANK } ] ) }
					>
						{ __( '+ Add a point', 'bestwebexpert' ) }
					</Button>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div
				{ ...useBlockProps( {
					className: [
						'wp-block-group elementor-element elementor-element-fc1d409 e-con-full bwex-cost e-flex e-con e-child',
						className,
					]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ css && <style>{ css }</style> }
				<div className="wp-block-group elementor-element elementor-element-b452c35 bwex-cost__title elementor-widget elementor-widget-heading">
					<RichText
						tagName="h3"
						className="elementor-heading-title elementor-size-default"
						value={ title }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
						placeholder={ __( 'Heading', 'bestwebexpert' ) }
						allowedFormats={ [ 'core/italic' ] }
					/>
				</div>
				<div className="wp-block-group elementor-element elementor-element-0fee8c3 e-con-full bwex-cost__grid e-flex e-con e-child">
					{ list.map( ( item, index ) => (
						<div
							key={ index }
							className={
								'wp-block-group ' +
								( item.wrap ||
									'elementor-element elementor-widget elementor-widget-text-editor' )
							}
						>
							<RichText
								tagName="p"
								className="wp-block-paragraph"
								value={ item.text }
								onChange={ ( value ) =>
									setItems(
										list.map( ( it, i ) =>
											i === index
												? { ...it, text: value }
												: it
										)
									)
								}
								placeholder={ __(
									'Bold name. Then the explanation.',
									'bestwebexpert'
								) }
								allowedFormats={ [
									'core/bold',
									'core/italic',
									'core/link',
								] }
							/>
						</div>
					) ) }
				</div>
				{ isSelected && list.length === 0 && (
					<Button
						variant="secondary"
						onClick={ () => setItems( [ { ...BLANK } ] ) }
					>
						{ __( '+ Add a point', 'bestwebexpert' ) }
					</Button>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
