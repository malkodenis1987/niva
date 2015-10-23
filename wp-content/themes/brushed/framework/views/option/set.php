<div id="fb-root"></div>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/ro_RO/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<div class="wrap">
	<h2><?php echo $set->get_title(); ?></h2>
	<div id="vp-wrap" class="vp-wrap">
		<div style="float: left;" id="vp-option-panel"class="vp-option-panel <?php echo ($set->get_layout() === 'fixed') ? 'fixed-layout' : 'fluid-layout' ; ?>">
			<div class="vp-left-panel">
				<div id="vp-logo" class="vp-logo" style="background-color: #C38686;">
					<h2 style="margin-top: -27px;margin-bottom: -5px;">BRUSHED</h2>
				</div>
				<div id="vp-menus" class="vp-menus">
					<ul class="vp-menu-level-1">
						<?php foreach ($set->get_menus() as $menu): ?>
							<?php $menus          = $set->get_menus(); ?>
							<?php $is_first_lvl_1 = $menu === reset($menus); ?>
							<?php if ($is_first_lvl_1): ?>
								<li class="vp-current">
							<?php else: ?>
								<li>
							<?php endif; ?>
							<?php if ($menu->get_menus()): ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-dropdown vp-menu-dropdown">
							<?php else: ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
						<?php endif; ?>
							<?php
							$icon = $menu->get_icon();
							$font_awesome = VP_Util_Res::is_font_awesome($icon);
							if ($font_awesome !== false):
								VP_Util_Text::print_if_exists($font_awesome, '<i class="fa %s"></i>');
							else:
								VP_Util_Text::print_if_exists(VP_Util_Res::img($icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
							endif;
							?>
							<span><?php echo $menu->get_title(); ?></span>
							</a>
							<?php if ($menu->get_menus()): ?>
								<ul class="vp-menu-level-2">
									<?php foreach ($menu->get_menus() as $submenu): ?>
										<?php $submenus = $menu->get_menus(); ?>
										<?php if ($is_first_lvl_1 and $submenu === reset($submenus)): ?>
											<li class="vp-current">
										<?php else: ?>
											<li>
										<?php endif; ?>
										<a href="#<?php echo $submenu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
											<?php
											$sub_icon = $submenu->get_icon();
											$font_awesome = VP_Util_Res::is_font_awesome($sub_icon);
											if ($font_awesome !== false):
												VP_Util_Text::print_if_exists($font_awesome, '<i class="fa %s"></i>');
											else:
												VP_Util_Text::print_if_exists(VP_Util_Res::img($sub_icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
											endif;
											?>
											<span><?php echo $submenu->get_title(); ?></span>
										</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="vp-right-panel">
				<form id="vp-option-form" class="vp-option-form vp-js-option-form" method="POST">
					<div id="vp-submit-top" class="vp-submit top">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php _e('Save Changes', 'vp_textdomain'); ?>" />
							<p class="vp-js-save-loader save-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php _e('Saving Now', 'vp_textdomain'); ?></p>
							<p class="vp-js-save-status save-status" style="display: none;"></p>
						</div>
					</div>
					<?php foreach ($set->get_menus() as $menu): ?>
						<?php $menus = $set->get_menus(); ?>
						<?php if ($menu === reset($menus)): ?>
							<?php echo $menu->render(array('current' => 1)); ?>
						<?php else: ?>
							<?php echo $menu->render(array('current' => 0)); ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<div id="vp-submit-bottom" class="vp-submit bottom">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php _e('Save Changes', 'vp_textdomain'); ?>" />
							<p class="vp-js-save-loader save-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php _e('Saving Now', 'vp_textdomain'); ?></p>
							<p class="vp-js-save-status save-status" style="display: none;"></p>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="vp-copyright" class="vp-copyright">
			<p><?php printf(__('Powered By <a target="_blank" rel="nofollow" href="http://premiumwpstore.com/">Premium WordPress Themes</a>', 'brushed'), VP_VERSION); ?></p>
		</div>
		<div style="margin-left: 15px;" class="fb-like" data-href="https://www.facebook.com/premiumwpstore" data-width="300" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
		<h4 style="margin-left: 875px;font-family: cursive;font-size: 14px;font-weight: bold;}">Our advice, try Premium Wordpress Themes from our partners:</h4>
		<div id="partners">
			<a href="http://www.elegantthemes.com/<?php echo "affiliates/idevaffiliate.php?id=1"; ?>2916_5_1_18" target="_blank"><img style="border:0px; margin-left: 15px;" src="http://www.elegantthemes.com/affiliates/banners/divi_300x250.jpg" width="300" height="250" alt="Divi WordPress Theme"></a>
			<a href="http://teslathemes.com/<?php echo "amember/aff/go/zsergiuz93/"; ?>?i=37" target="_blank"><img style="margin-left: 15px; margin-top: 10px;" src="http://teslathemes.com/amember/file/get/path/.banners.525ce731e9f72/i/4413" border=0 alt="300x250 V2" width="300" height="250"></a>
			<a href="http://themefuse.com/<?php echo "amember/aff/go?r=45703&"; ?>i=40" target="_blank"><img style="margin-left: 15px; margin-top: 10px;" src="http://themefuse.com/amember/file/get/path/.banners.505789704a63d/i/45703" border=0 alt="300x250" width="300" height="250"></a>
			<a href="http://themify.me/<?php echo "member/go.php?r=30629&"; ?>i=b9" target="_blank"><img style="margin-left: 15px; margin-top: 10px;" src="http://themify.me/banners/themify-300x250_1.jpg" border=0 alt="Themify WordPress Themes" ></a>
		</div>


	</div>
</div>