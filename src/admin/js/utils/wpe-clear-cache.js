import axios from 'axios';

/**
 * Get the nonce that WP Engine sets.
 *
 * @returns string
 */
const getWpeNonce = async () => {
	let nonce = null;
	try {
		const res = await axios.get('/wp-admin/admin.php?page=wpengine-common');
		nonce = res.data
			.match(/<input type="hidden" id="_wpnonce" name="_wpnonce" value="(.+)">/)[1]
			.split('"')[0];
	} catch (error) {
		console.error(error);
	}
	return nonce;
};

/**
 * Clear WP Engine cache.
 *
 * @returns void
 */
const wpeClearCache = async () => {
	const nonce = await getWpeNonce();
	if (!nonce) return;
	if (!document.querySelector('#wpe-common-js-extra')) return;

	try {
		let formData = new FormData();
		formData.append('_wpnonce', nonce);
		formData.append('purge-all', 'Purge All Caches');
		fetch('/wp-admin/admin.php?page=wpengine-common', {
			body: formData,
			method: 'POST',
		});
	} catch (error) {
		console.error(error);
	}
};

export default wpeClearCache;
