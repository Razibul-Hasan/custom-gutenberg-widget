import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import {
	AttrText,
	AttrToggle,
	INLINE,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

function Edit( { attributes, setAttributes, clientId } ) {
	const {
		eyebrow,
		showEyebrow,
		title,
		lead,
		showBtn2,
		chat,
		showChat,
		note,
		showNote,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const look = useSectionLook(
		metadata,
		attributes,
		clientId,
		' p.bwe-eyebrow::before'
	);
	const props = { attributes, setAttributes };
	const button = ( cls, key, placeholder ) => (
		<div className={ `wp-block-button ${ cls }` }>
			<RichText
				tagName="div"
				className="wp-block-button__link wp-element-button"
				value={ attributes[ key ] }
				onChange={ set( key ) }
				placeholder={ placeholder }
				allowedFormats={ [] }
				disableLineBreaks
			/>
		</div>
	);
	return (
		<>
			<SectionSettings { ...props } head={ false }>
				<AttrToggle
					label={ __( 'Show the small label above the heading', 'bestwebexpert' ) }
					name="showEyebrow"
					{ ...props }
				/>
				<AttrText
					label={ __( 'Main button link', 'bestwebexpert' ) }
					name="btn1Url"
					{ ...props }
				/>
				<AttrToggle
					label={ __(
						'Open the main button in a new tab',
						'bestwebexpert'
					) }
					name="btn1NewTab"
					{ ...props }
				/>
				<AttrToggle
					label={ __( 'Show second button', 'bestwebexpert' ) }
					name="showBtn2"
					{ ...props }
				/>
				{ showBtn2 !== false && (
					<>
						<AttrText
							label={ __(
								'Second button link',
								'bestwebexpert'
							) }
							name="btn2Url"
							{ ...props }
						/>
						<AttrToggle
							label={ __(
								'Open the second button in a new tab',
								'bestwebexpert'
							) }
							name="btn2NewTab"
							{ ...props }
						/>
					</>
				) }
				<AttrToggle
					label={ __(
						'Show the live-chat line (its link opens the chat)',
						'bestwebexpert'
					) }
					name="showChat"
					{ ...props }
				/>
				<AttrToggle
					label={ __( 'Show the small note', 'bestwebexpert' ) }
					name="showNote"
					{ ...props }
				/>
			</SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div
				{ ...useBlockProps( {
					className:
						'wp-block-group elementor-element elementor-element-f672073 elementor-widget elementor-widget-bwex-cta',
				} ) }
			>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<div className="wp-block-group bwe-home bwex bwex-ctaw">
						<section
							className={ [
								'wp-block-group bwe-section bwe-final',
								look.className,
							]
								.filter( Boolean )
								.join( ' ' ) }
							data-bwe-anchor={
								attributes.sectionId || undefined
							}
						>
							<div className="wp-block-group bwe-final__box">
								{ showEyebrow !== false && (
									<div className="wp-block-group bwex-cta__eyebrow">
										<RichText
											tagName="p"
											className="bwe-eyebrow wp-block-paragraph"
											value={ eyebrow }
											onChange={ set( 'eyebrow' ) }
											placeholder={ __( 'Small label',
												'bestwebexpert'
											) }
											allowedFormats={ [] }
											disableLineBreaks
										/>
									</div>
								) }
								<RichText
									tagName="h2"
									className="wp-block-heading"
									value={ title }
									onChange={ set( 'title' ) }
									placeholder={ __(
										'Heading — make words italic to highlight them',
										'bestwebexpert'
									) }
									allowedFormats={ [ 'core/italic' ] }
								/>
								<RichText
									tagName="p"
									className="bwe-lead wp-block-paragraph"
									value={ lead }
									onChange={ set( 'lead' ) }
									placeholder={ __(
										'Short text',
										'bestwebexpert'
									) }
									allowedFormats={ INLINE }
								/>
								<div className="wp-block-group bwe-actions">
									{ button(
										'bwe-btn bwe-btn--primary',
										'btn1Text',
										__( 'Main button', 'bestwebexpert' )
									) }
									{ showBtn2 !== false &&
										button(
											'bwe-btn bwe-btn--ghost',
											'btn2Text',
											__(
												'Second button',
												'bestwebexpert'
											)
										) }
								</div>
								{ showChat !== false && (
									<ChatLine
										value={ chat }
										onChange={ set( 'chat' ) }
									/>
								) }
								{ showNote !== false && (
									<RichText
										tagName="p"
										className="bwe-final__note wp-block-paragraph"
										value={ note }
										onChange={ set( 'note' ) }
										placeholder={ __(
											'Small note',
											'bestwebexpert'
										) }
										allowedFormats={ [
											'core/bold',
											'core/italic',
										] }
									/>
								) }
							</div>
						</section>
					</div>
				</div>
			</div>
		</>
	);
}

/**
 * Live-chat line as the site prints it (BestWebExpert Home's bwe_bm_paragraph()): green dot, the text in a span,
 * then the link as a button. The attribute keeps one HTML string ("text <a …>link</a>"); its text and its link
 * label are edited separately here. Without a link at the end it stays one plain field.
 *
 * @param {Object}   props
 * @param {string}   props.value    Chat line HTML.
 * @param {Function} props.onChange Receives the new HTML.
 */
function ChatLine( { value, onChange } ) {
	const html = value || '';
	const m = /^([\s\S]*?)\s*(<a\b[^>]*>)([\s\S]*?)<\/a>\s*$/.exec( html );
	if ( ! m ) {
		return (
			<RichText
				tagName="p"
				className="bwe-final__chat"
				value={ html }
				onChange={ onChange }
				placeholder={ __(
					'Chat line — add a link; it opens the live chat',
					'bestwebexpert'
				) }
				allowedFormats={ INLINE }
			/>
		);
	}
	const [ , text, open, label ] = m;
	const href = ( /\bhref="([^"]*)"/.exec( open ) || [] )[ 1 ] || '#';
	return (
		<p className="bwe-final__chat bwe-gw-chat">
			<span className="bwe-final__dot" aria-hidden="true"></span>
			<RichText
				tagName="span"
				value={ text }
				onChange={ ( v ) =>
					onChange( v + ' ' + open + label + '</a>' )
				}
				placeholder={ __( 'Chat line', 'bestwebexpert' ) }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
			/>{ ' ' }
			<RichText
				tagName="a"
				href={ href }
				onClick={ ( event ) => event.preventDefault() }
				value={ label }
				onChange={ ( v ) => onChange( text + ' ' + open + v + '</a>' ) }
				placeholder={ __( 'Start a chat →', 'bestwebexpert' ) }
				allowedFormats={ [] }
				disableLineBreaks
			/>
		</p>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
