import { __ } from '@wordpress/i18n';
import { Button, ColorIndicator, ColorPicker } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

const ColorPickerModal = (props) => {
	const [open, setOpen] = useState(false);
	const [color, setColor] = useState('#247cf9');

	const saveColor = () => {
		setOpen(false);
		props.onChange(color);
	};

	return (
		<div className="color-picker-modal">
			<div className="color-picker-modal__toggle">
				<Button onClick={() => setOpen(!open)}>
					<ColorIndicator colorValue={props.color} />
					{__('Change color', 'passnado')}
				</Button>
			</div>
			{open && (
				<div className="color-picker-modal__modal">
					<ColorPicker
						color={props.color}
						onChangeComplete={(color) => setColor(color.hex)}
						disableAlpha
					/>

					<div className="passnado-button-group">
						<Button
							isPrimary={true}
							text={__('Set', 'passnado')}
							onClick={() => saveColor()}
						/>
						<Button
							isSecondary={true}
							text={__('Cancel', 'passnado')}
							onClick={() => setOpen(false)}
						/>
					</div>
				</div>
			)}
		</div>
	);
};
export default ColorPickerModal;
