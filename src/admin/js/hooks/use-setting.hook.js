/**
 * WordPress dependencies
 */
import { useState, useEffect } from '@wordpress/element';

const useSetting = (key) => {
	const getSavedSetting = async (key) => {
		try {
			const settings = new wp.api.models.Settings();
			const response = await settings.fetch();
			setData(response[key]);
		} catch (error) {
			setError(error);
		} finally {
			setLoading(false);
		}
	};

	const [data, setData] = useState(() => getSavedSetting(key));
	const [loading, setLoading] = useState(true);
	const [error, setError] = useState(true);

	useEffect(() => {
		if (loading) return;

		new wp.api.models.Settings({
			[key]: data,
		}).save();
	}, [data]);

	return [data, setData, loading, error];
};

export default useSetting;
