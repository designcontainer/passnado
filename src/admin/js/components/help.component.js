const { __ } = wp.i18n;
const { Dashicon } = wp.components;

const Help = (props) => {
	return (
		<div className="passnado-help">
			{props.icon !== false && <Dashicon icon="info-outline" />}
			<i>{props.children}</i>
		</div>
	);
};

export default Help;
