<?php
/**
 * Skin file for the Excellence skin.
 *
 * @file
 * @ingroup Skins
 */

/**
 * SkinTemplate class for the Excellence skin
 *
 * @ingroup Skins
 */
class SkinExcellence extends SkinTemplate {
	public $skinname = 'excellence', $stylename = 'Excellence',
		$template = 'ExcellenceTemplate', $useHeadElement = true;

	/**
     * Initializes output page and sets up skin-specific parameters
     * @param $out OutputPage object to initialize
     */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		// solves a problem with Resource loader not loading fonts correctly on IE.
		//should probably make relative with getcwd() to get current file directory
		//$filepath = $this->text('stylepath') +'/' + $this->text('stylename');
		$skindir = $wgStylePath.'/'. $this->stylename;
		$out->addHeadItem('npea-fonts', <<<FONT
		<link rel="stylesheet" type="text/css" href="{$skindir}/resources/fonts/sans/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="{$skindir}/resources/fonts/serif/stylesheet.css">
FONT
		);
		$out->addModuleScripts(array('skins.excellence.js'));
		$out->addHeadItem('npea-metadata', <<<META
	<meta property="og:title" content="The National Programme for Excellence in the Arts"/>
	<meta property="og:type"   content="website" />
  <meta property="og:url"    content="www.npea.org.au/{$_SERVER['REQUEST_URI']}" />
  <meta property="og:image"  content="/logo.png" />
  <meta property="og:description" content="Up-to-date information about the Australian National Programme for Excellence in the Arts." />
META
		);

	}

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface', 'skins.excellence'
		) );
	}
}

/**
 * BaseTemplate class for the Excellence skin
 *
 * @ingroup Skins
 */
class ExcellenceTemplate extends BaseTemplate {
	/**
	 * Outputs a single sidebar portlet of any kind.
	 */
	private function outputPortlet( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<div
			role="navigation"
			class="mw-portlet"
			id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>
		>
			<h3>
				<?php
				if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?>
			</h3>

			<?php
			if ( is_array( $box['content'] ) ) {
				echo '<ul>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				echo '</ul>';
			} else {
				echo $box['content'];
			}?>
		</div>
		<?php
	}

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		global $wgUser;

		$this->html( 'headelement' ) ?>
		<div id="bg-color"></div>
		<div id="mw-wrapper">
			<div id="header">
			<!-- LOGIN AND SEARCH OPTIONS -->
				<?php 
					$this->outputPortlet( array(
						'id' => 'p-personal',
						'headerMessage' => 'personaltools',
						'content' => $this->getPersonalTools(),
					) );
				?>
				<div id='searchbox'>
					<form
						action="<?php $this->text( 'wgScript' ) ?>"
						role="search"
						class="mw-portlet"
						id="p-search"
					>
						<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />

						<h3><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h3>

						<?php echo $this->makeSearchInput( array( "id" => "searchInput" ) ) ?>
						<?php echo $this->makeSearchButton( 'go' ) ?>

					</form>
				</div>
				<!-- MAIN TITLE HEADER -->
				<div id="header-title">
					<div id="p-logo"><a
						role="banner"
						href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>"
						<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>
					>
						<img
							src="<?php $this->text( 'logopath' ) ?>"
							alt="<?php $this->text( 'sitename' ) ?>"
						/>
					</a></div>
					<div id='title'><h1>National Programme For Excellence in the Arts</h1></div>
				</div>
				<!-- HEARDER MAIN NAV MENU -->
				<div id="mw-navigation">
					<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

					<?php

					foreach ( $this->getSidebar() as $boxName => $box ) {
						$this->outputPortlet( $box );
					}

					?>
				</div>

			</div>


			<div class="mw-body" role="main">
				<?php if ( $this->data['sitenotice'] ) { ?>
					<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
				<?php } ?>

				<?php if ( $this->data['newtalk'] ) { ?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
				<?php } ?>

				<h1 class="firstHeading">
					<span dir="auto"><?php $this->html( 'title' ) ?></span>
				</h1>
				
				<div class='user-actions'> 
					<!-- include page actions etc if user is logged in -->
					<?php

					$this->outputPortlet( array(
						'id' => 'p-namespaces',
						'headerMessage' => 'namespaces',
						'content' => $this->data['content_navigation']['namespaces'],
					) );

					if ( !$wgUser->isAnon() ) {
						
						$this->outputPortlet( array(
							'id' => 'p-views',
							'headerMessage' => 'views',
							'content' => $this->data['content_navigation']['views'],
						) );

						$this->outputPortlet( array(
							'id' => 'p-variants',
							'headerMessage' => 'variants',
							'content' => $this->data['content_navigation']['variants'],
						) );
						
						$this->outputPortlet( array(
							'id' => 'p-actions',
							'headerMessage' => 'actions',
							'content' => $this->data['content_navigation']['actions'],
						) );

					}

					?>
				</div>

				<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>

				<div class="mw-body-content">
					<div id="contentSub">
						<?php if ( $this->data['subtitle'] ) { ?>
							<p><?php $this->html( 'subtitle' ) ?></p>
						<?php } ?>
						<?php if ( $this->data['undelete'] ) { ?>
							<p><?php $this->html( 'undelete' ) ?></p>
						<?php } ?>
					</div>

					<?php $this->html( 'bodytext' ) ?>

					<?php $this->html( 'catlinks' ) ?>

					<?php $this->html( 'dataAfterContent' ); ?>

				</div>
			</div>

			<div id="mw-footer">
				<?php foreach ( $this->getFooterLinks() as $category => $links ) { ?>
					<ul role="contentinfo">
						<?php foreach ( $links as $key ) { ?>
							<li><?php $this->html( $key ) ?></li>
						<?php } ?>
					</ul>
				<?php } ?>

				<ul role="contentinfo">
					<?php foreach ( $this->getFooterIcons( 'icononly' ) as $blockName => $footerIcons ) { ?>
						<li>
							<?php
							foreach ( $footerIcons as $icon ) {
								echo $this->getSkin()->makeFooterIcon( $icon );
							}
							?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<?php $this->printTrail() ?>
		</body></html>

		<?php
	}
}
