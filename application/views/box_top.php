<div id="top">
	<div class="top_child">
		<div id="wrap-menu-top" class="left">
			<ul class="inav">
				<?php
            //Check permission for setting module
            $check_setting =  true;
            
				if (!empty($arMenu)) {
					foreach ($arMenu as $key=>$menu) {
						$arMenu[$key]['active'] = 0;
					}
					foreach ($arMenu as $key=>$menu) {
						$alias = trim($menu['alias']);
						$uri = trim($this->uri->segment($menu['controller_segment']));
						if ($alias != '') {
							if (strpos('F'.$alias, '|')) {
								$temp = explode('|', $alias);
								if (in_array($uri, $temp)) {
									$arMenu[$key]['active'] = 1;
									break;
								}
							} else {
								if ($alias == $uri) {
									$arMenu[$key]['active'] = 1;
									break;
								}
							}
						}
					}
					
					foreach ($arMenu as $m) {
						if ($m['alias'] == 'setting') {
						   $check_setting =  true;
                     continue;
						}
						$class = '';
						if ($m['active'] == 1) $class = 'active';
						print '<li class="'. $class .'"><a href="'. $m['href'] .'">'. $m['name'] .'</a></li>';
					}
				}
            if ($check_setting) {
               ?>
               <li class="li-setting <?php print ($this->uri->segment(1) == 'setting') ? 'active' : ''; ?>">
   					<a class="setting" href="<?php print base_url() . 'setting/permission'; ?>">Cài đặt</a>
   				</li>
               <?
            }
				?>
				<li class="li-account">
					<a href="<?php print base_url() . 'home/logout'; ?>" style="text-decoration: underline;">Đăng xuất</a>
				</li>
				<li class="li-account-name">
					<span style="color: white;">Hi! <b><?php print $this->session->userdata('user_name'); ?></b></span>
				</li>
			</ul>
		</div>
	</div>
</div>




