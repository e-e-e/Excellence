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
		$skindir = "/w/skins/Excellence";
		$page_title = "NPEA: " . htmlentities($this->getSkin()->getTitle()->getText());
		if ($this->getSkin()->getTitle()->isMainPage()) {
			$page_title = "The National Program for Excellence in the Arts";
		}
		$current_page = $_SERVER['REQUEST_URI'];
		$hue = rand(0, 360);
		$light = "hsl({$hue},96%,76%)";
		$dark = "hsl({$hue},95%,44%)";

		$out->addHeadItem('npea-background', <<<FONT
		<style type="text/css">
			html, body {
				background-color: {$light};
			}
			div#bg-color {
				pointer-events: none;
				width: 100%;
				height: 100%;
				position: fixed;	
				top: 0;
				left: 0;
				z-index:0;
				background: @lightblue; /* Old browsers */
				background: -moz-linear-gradient(45deg, {$light} 0%, {$dark} 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,{$light}), color-stop(100%,{$dark})); /* Chrome,Safari4+ */
			  background: -webkit-linear-gradient(45deg, {$light} 0%,{$dark} 100%); /* Chrome10+,Safari5.1+ */
			  background: -o-linear-gradient(45deg, {$light} 0%,{$dark} 100%); /* Opera 11.10+ */
			  background: -ms-linear-gradient(45deg, {$light} 0%,{$dark} 100%); /* IE10+ */
			  background: linear-gradient(45deg, {$light} 0%,{$dark} 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$light}', endColorstr='{$dark}',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
			}
		</style>
FONT
		);

		$out->addHeadItem('npea-fonts', <<<FONT
		<link rel="stylesheet" type="text/css" href="{$skindir}/resources/fonts/sans/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="{$skindir}/resources/fonts/serif/stylesheet.css">
FONT
		);
		$out->addModuleScripts(array('skins.excellence.js'));
		if ($this->getSkin()->getTitle()->isMainPage()) {
			$out->addHeadItem('npea-canonical', '<link rel="canonical" href="http://www.npea.org.au" />');
		}
		$out->addHeadItem('npea-metadata', <<<META
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta property="og:title" content="{$page_title}"/>
	<meta property="og:type"   content="website" />
  <meta property="og:url"    content="http://www.npea.org.au{$current_page}" />
  <meta property="og:image"  content="http://www.npea.org.au/logo.png" />
  <meta property="og:description" content="A counter-factual wiki where the artistic community are collectively defining 'Excellence' in the Arts." />
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
				<?php $mainpage_href = htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ); ?>
				<div id="header-title">
					<div id="p-logo"><a
						role="banner"
						href="<?php echo $mainpage_href; ?>"
						<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>
					>
						<img
							src="<?php $this->text( 'logopath' ) ?>"
							alt="<?php $this->text( 'sitename' ) ?>"
						/>
					</a></div>
					<div id='title'><h1><a href="/Nationalism">National</a> <a href="<?php echo $mainpage_href; ?>">Program</a> <a href="<?php echo $mainpage_href; ?>">For</a> <a href="/Excellence">Excellence</a> <a href="<?php echo $mainpage_href; ?>">in</a> <a href="<?php echo $mainpage_href; ?>">the</a> <a href="<?php echo $mainpage_href; ?>">Arts</a></h1></div>
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
