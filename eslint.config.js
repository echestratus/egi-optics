// ESLint 9 flat config. Extends the WordPress recommended rules (via @wordpress/scripts).
const wordpress = require( '@wordpress/eslint-plugin' );

module.exports = [
	{
		ignores: [
			'node_modules/**',
			'vendor/**',
			'.wp-env/**',
			'build/**',
			'dist/**',
			'wp-content/plugins/!(egi-optics-core)/**',
			'wp-content/themes/!(egi-optics)/**',
			'**/*.min.js',
		],
	},
	...wordpress.configs.recommended,
	{
		files: [ 'wp-content/**/*.js' ],
		languageOptions: {
			ecmaVersion: 2022,
			sourceType: 'script',
			globals: {
				window: 'readonly',
				document: 'readonly',
				navigator: 'readonly',
				IntersectionObserver: 'readonly',
				URLSearchParams: 'readonly',
				requestAnimationFrame: 'readonly',
				wp: 'readonly',
			},
		},
		rules: {
			'@wordpress/no-unsafe-wp-apis': 'off',
		},
	},
	{
		files: [ 'scripts/**/*.mjs' ],
		languageOptions: {
			ecmaVersion: 2022,
			sourceType: 'module',
			globals: {
				process: 'readonly',
				console: 'readonly',
			},
		},
		rules: {
			'no-console': 'off',
		},
	},
];
