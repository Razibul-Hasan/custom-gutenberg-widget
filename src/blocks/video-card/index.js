import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { INLINE } from '../shared/section-parts';
import metadata from './block.json';

// Same pattern as BestWebExpert Home's bwe_vt_youtube_id().
const youtubeId = ( url ) => {
	const m = String( url || '' ).match(
		/(?:youtube(?:-nocookie)?\.com\/(?:shorts\/|embed\/|live\/|watch\?(?:.*&)?v=)|youtu\.be\/)([A-Za-z0-9_-]{11})/
	);
	return m ? m[ 1 ] : '';
};

const THUMBS = [ 'oardefault', 'oar2', 'hqdefault' ];
const nextThumb = ( img, id ) => {
	const now = THUMBS.findIndex( ( t ) => img.src.endsWith( `/${ t }.jpg` ) );
	if ( now > -1 && now < THUMBS.length - 1 ) {
		img.src = `https://i.ytimg.com/vi/${ id }/${ THUMBS[ now + 1 ] }.jpg`;
	}
};

function Edit( { attributes, setAttributes } ) {
	const { url, who } = attributes;
	const id = youtubeId( url );
	return (
		<div { ...useBlockProps( { className: 'wp-block-group bwex-vt' } ) }>
			<InspectorControls>
				<PanelBody title={ __( 'Video', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'YouTube link', 'bestwebexpert' ) }
						help={ __(
							'Paste a Shorts link (youtube.com/shorts/…), a watch link or a youtu.be link. The page shows a fast thumbnail; the player loads on click.',
							'bestwebexpert'
						) }
						value={ url }
						onChange={ ( value ) =>
							setAttributes( { url: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<figure className="bwex-vt__video">
				{ id ? (
					<span className="bwex-yt">
						<img
							src={ `https://i.ytimg.com/vi/${ id }/oardefault.jpg` }
							// Same fallback as the live page: YouTube answers a missing portrait thumbnail with a
							// 120px placeholder (or an error) → try oar2, then the normal hqdefault.
							onLoad={ ( event ) =>
								event.currentTarget.naturalWidth <= 120 &&
								nextThumb( event.currentTarget, id )
							}
							onError={ ( event ) =>
								nextThumb( event.currentTarget, id )
							}
							style={ {
								width: '100%',
								height: '100%',
								objectFit: 'cover',
							} }
							alt=""
							width="1080"
							height="1920"
						/>
						<span
							className="bwex-yt__play"
							aria-hidden="true"
						></span>
					</span>
				) : (
					<span
						className="bwex-yt"
						style={ {
							display: 'flex',
							alignItems: 'center',
							justifyContent: 'center',
							aspectRatio: '9 / 16',
							padding: 16,
							textAlign: 'center',
							background: '#1a1a1c',
							color: '#9a9a92',
						} }
					>
						{ url
							? __(
									'Not a YouTube link — it will show as a normal video player.',
									'bestwebexpert'
								)
							: __(
									'Paste a YouTube link in the block settings →',
									'bestwebexpert'
								) }
					</span>
				) }
			</figure>
			<RichText
				tagName="p"
				className="bwex-vt__who wp-block-paragraph"
				value={ who }
				onChange={ ( value ) => setAttributes( { who: value } ) }
				placeholder={ __(
					'Client name (bold) · business, project',
					'bestwebexpert'
				) }
				allowedFormats={ INLINE }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
