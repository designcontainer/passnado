/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RadioControl, Button } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

/**
 * Components
 */
import PartContainer from '../components/part-container.component';
import TransparentInput from '../components/transparent-input.component';
import ColorPickerModal from '../components/color-picker-modal.component';

const PublicLayout = () => {
	useEffect(async () => {
		try {
			const settings = new wp.api.models.Settings();
			const response = await settings.fetch();
			setLayout(response.passnado_message_layout);
			setTitle(response.passnado_message_title);
			setText(response.passnado_message_text);
			setLogin(response.passnado_login_link_text);
			setColor(response.passnado_message_color);
		} catch (error) {
			setError(error);
		} finally {
			setLoading(false);
		}
	}, []);

	const [loading, setLoading] = useState(true);
	const [error, setError] = useState('');
	// Settings
	const [layout, setLayout] = useState('');
	const [title, setTitle] = useState('');
	const [text, setText] = useState('');
	const [login, setLogin] = useState('');
	const [color, setColor] = useState('');

	const saveSettings = () => {
		new wp.api.models.Settings({
			passnado_message_layout: layout,
			passnado_message_title: title,
			passnado_message_text: text,
			passnado_login_link_text: login,
			passnado_message_color: color,
		}).save();
	};

	return (
		<PartContainer noPadding={true}>
			<div className="passnado-message__layout-nav">
				<RadioControl
					selected={layout}
					options={[
						{ label: 'Default', value: 'default' },
						{ label: 'Background', value: 'image' },
					]}
					onChange={(value) => setLayout(value)}
				/>
				<Button
					isPrimary={true}
					isSmall={true}
					text={__('Save', 'passnado')}
					onClick={() => saveSettings()}
				/>
			</div>
			<div className={`passnado-message passnado-message--${layout}`}>
				<ColorPickerModal color={color} onChange={(value) => setColor(value)} />
				<style>{`.passnado-message{--passnado-message-color: ${color}}`}</style>
				<div className="container">
					{!loading && (
						<section className="content">
							<h1>
								<TransparentInput
									value={title}
									onChange={(e) => setTitle(e.target.value)}
									placeholder={__('Add a text', 'passnado')}
								/>
							</h1>

							<p>
								<TransparentInput
									value={text}
									onChange={(e) => setText(e.target.value)}
									placeholder={__('Add a text', 'passnado')}
								/>
							</p>
							<div className="button">
								<TransparentInput
									value={login}
									onChange={(e) => setLogin(e.target.value)}
									placeholder={__('Add a text', 'passnado')}
									white={true}
								/>
							</div>
						</section>
					)}
				</div>
			</div>
		</PartContainer>
	);
};
export default PublicLayout;
