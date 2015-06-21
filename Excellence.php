<?php
/**
 * Excellence skin
 *
 * This is an example skin showcasing the best practices, a companion to the MediaWiki skinning
 * guide available at <https://www.mediawiki.org/wiki/Manual:Skinning>.
 *
 * The code is released into public domain, which means you can freely copy it, modify and release
 * as your own skin without providing attribution and with absolutely no restrictions. Remember to
 * change the license information if you do not intend to provide your changes on the same terms.
 *
 * @file
 * @ingroup Skins
 * @author ...
 * @license CC0 (public domain) <http://creativecommons.org/publicdomain/zero/1.0/>
 */

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Excellence',
	'namemsg' => 'skinname-excellence',
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Excellence',
	'author' => '...',
	'descriptionmsg' => 'excellence-desc',
	// When modifying this skin, remember to change the license information if you do not want to
	// waive all of your rights to your work!
	'license' => 'CC0',
);

$wgValidSkinNames['excellence'] = 'Excellence';

$wgAutoloadClasses['SkinExcellence'] = __DIR__ . '/Excellence.skin.php';
$wgMessagesDirs['Excellence'] = __DIR__ . '/i18n';

$wgResourceModules['skins.excellence'] = array(
	'styles' => array(
		'Excellence/resources/fonts/sans/stylesheet.css' => array( 'media' => 'screen' ),
		'Excellence/resources/fonts/serif/stylesheet.css' => array( 'media' => 'screen' ),
		'Excellence/resources/screen.less' => array( 'media' => 'screen' ),
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);

$wgResourceModules['skins.foobar.js'] = array(
	'scripts' => array(
		'Excellence/resources/app.js',
	),
	'dependencies' => array(
		// In this example, awesome.js needs the jQuery UI dialog stuff
		'jquery',
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
