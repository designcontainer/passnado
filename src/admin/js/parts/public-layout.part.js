/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RadioControl } from '@wordpress/components';

/**
 * Hooks
 */
import useSetting from '../hooks/use-setting.hook';

/**
 * Components
 */
import PartContainer from '../components/part-container.component';
import TransparentInput from '../components/transparent-input.component';

const PublicLayout = () => {
	const [layout, setLayout] = useSetting('passnado_message_layout');
	const [title, setTitle, titleLoading] = useSetting('passnado_message_title');
	const [text, setText, textLoading] = useSetting('passnado_message_text');
	const [login, setLogin, loginLoading] = useSetting('passnado_login_link_text');

	return (
		<PartContainer noPadding={true}>
			<RadioControl
				className="passnado-message__layout-selector"
				selected={layout}
				options={[
					{ label: 'Default', value: 'default' },
					{ label: 'Background', value: 'image' },
				]}
				onChange={(value) => setLayout(value)}
			/>
			<div className={`passnado-message passnado-message--${layout}`}>
				<div className="container">
					{!titleLoading && !textLoading && !loginLoading && (
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
