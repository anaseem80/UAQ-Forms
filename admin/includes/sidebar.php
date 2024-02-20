<!-- LEFT MAIN SIDEBAR -->
<div class="ec-left-sidebar ec-bg-sidebar">
		<div id="sidebar" class="sidebar ec-sidebar-footer">

			<div class="ec-brand">
				<a href="/" title="Ekka">
					<img class="ec-brand-icon" src="../assets/uploads/<?php echo $settings['logo'] ?>" width="127" height="92" alt="" />
				</a>
			</div>

			<!-- begin sidebar scrollbar -->
			<div class="ec-navigation" data-simplebar>
				<!-- sidebar menu -->
				<ul class="nav sidebar-inner" id="sidebar-menu">


					<!-- Vendors -->
					<li>
						<a class="sidenav-item-link" href="index.php">
							<i class="mdi mdi-account-group-outline"></i>
							<span class="nav-text">Clients</span>
						</a>
					</li>

					<li>
						<a class="sidenav-item-link" href="gallery.php">
							<i class="mdi mdi-account-group-outline"></i>
							<span class="nav-text">Gellary</span>
						</a>
						<hr>
					</li>


					<!-- Category -->
					<li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-dns-outline"></i>
							<span class="nav-text">Categories</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
								<li class="">
									<a class="sidenav-item-link" href="categories.php">
										<span class="nav-text">Categories</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="subcategory.php">
										<span class="nav-text">Sub Category</span>
									</a>
								</li>
							</ul>
						</div>
					</li>

					<!-- Reviews -->
					<li>
						<a class="sidenav-item-link" href="quote.php">
							<i class="mdi mdi-star-half"></i>
							<span class="nav-text">Quotes</span>
						</a>
						<hr>
					</li>
					<li>
						<a class="sidenav-item-link" href="slider.php">
							<i class="mdi mdi-star-half"></i>
							<span class="nav-text">Sliders</span>
						</a>
						<hr>
					</li>
					<li>
						<a class="sidenav-item-link" href="services.php">
							<i class="mdi mdi-star-half"></i>
							<span class="nav-text">Services</span>
						</a>
						<hr>
					</li>
					<li>
						<a class="sidenav-item-link" href="faq.php">
							<i class="mdi mdi-star-half"></i>
							<span class="nav-text">FAQ</span>
						</a>
						<hr>
					</li>

					<!-- Brands -->

					<li>
						<a class="sidenav-item-link" href="settings.php">
							<i class="mdi mdi-settings"></i>
							<span class="nav-text">Settings</span>
						</a>
					</li>
					<!-- Authentication -->
				</ul>
			</div>
		</div>
	</div>