<!-- LEFT MAIN SIDEBAR -->
<div class="ec-left-sidebar ec-bg-sidebar">
		<div id="sidebar" class="sidebar ec-sidebar-footer">

			<div class="ec-brand">
				<a href="index.php" title="Ekka">
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

					<!-- Products -->
					<!-- <li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-palette-advanced"></i>
							<span class="nav-text">Products</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="products" data-parent="#sidebar-menu">
								<li class="">
									<a class="sidenav-item-link" href="product-add.html">
										<span class="nav-text">Add Product</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="product-list.html">
										<span class="nav-text">List Product</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="product-grid.html">
										<span class="nav-text">Grid Product</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="product-detail.html">
										<span class="nav-text">Product Detail</span>
									</a>
								</li>
							</ul>
						</div>
					</li> -->

					<!-- Orders -->
					<!-- <li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-cart"></i>
							<span class="nav-text">Orders</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
								<li class="">
									<a class="sidenav-item-link" href="new-order.html">
										<span class="nav-text">New Order</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="order-history.html">
										<span class="nav-text">Order History</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="order-detail.html">
										<span class="nav-text">Order Detail</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="invoice.html">
										<span class="nav-text">Invoice</span>
									</a>
								</li>
							</ul>
						</div>
					</li> -->

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

					<!-- Brands -->
					<!-- <li>
						<a class="sidenav-item-link" href="brand-list.html">
							<i class="mdi mdi-tag-faces"></i>
							<span class="nav-text">Brands</span>
						</a>
						<hr>
					</li> -->
					<li>
						<a class="sidenav-item-link" href="settings.php">
							<i class="mdi mdi-settings"></i>
							<span class="nav-text">Settings</span>
						</a>
					</li>
					<!-- Authentication -->
					<!-- <li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-login"></i>
							<span class="nav-text">Authentication</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="authentication" data-parent="#sidebar-menu">
								<li class="">
									<a href="sign-in.html">
										<span class="nav-text">Sign In</span>
									</a>
								</li>
								<li class="">
									<a href="sign-up.html">
										<span class="nav-text">Sign Up</span>
									</a>
								</li>
							</ul>
						</div>
					</li> -->

					<!-- Icons -->
					<!-- <li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-diamond-stone"></i>
							<span class="nav-text">Icons</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="icons" data-parent="#sidebar-menu">
								<li class="">
									<a class="sidenav-item-link" href="material-icon.html">
										<span class="nav-text">Material Icon</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="font-awsome-icons.html">
										<span class="nav-text">Font Awsome Icon</span>
									</a>
								</li>
								<li class="">
									<a class="sidenav-item-link" href="flag-icon.html">
										<span class="nav-text">Flag Icon</span>
									</a>
								</li>
							</ul>
						</div>
					</li> -->

					<!-- Other Pages -->
					<!-- <li class="has-sub">
						<a class="sidenav-item-link" href="javascript:void(0)">
							<i class="mdi mdi-image-filter-none"></i>
							<span class="nav-text">Other Pages</span> <b class="caret"></b>
						</a>
						<div class="collapse">
							<ul class="sub-menu" id="otherpages" data-parent="#sidebar-menu">
								<li class="has-sub">
									<a href="404.html">404 Page</a>
								</li>
							</ul>
						</div>
					</li> -->
				</ul>
			</div>
		</div>
	</div>