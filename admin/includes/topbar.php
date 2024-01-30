	<!-- Header -->
    <header class="ec-main-header" id="header">
			<nav class="navbar navbar-static-top navbar-expand-lg">
				<!-- Sidebar toggle button -->
				<button id="sidebar-toggler" class="sidebar-toggle"></button>
				<!-- search form -->
				<div class="search-form d-lg-inline-block">
					<!-- <div class="input-group">
						<input type="text" name="query" id="search-input" class="form-control"
							placeholder="search.." autofocus autocomplete="off" />
						<button type="button" name="search" id="search-btn" class="btn btn-flat">
							<i class="mdi mdi-magnify"></i>
						</button>
					</div> -->
					<div id="search-results-container">
						<ul id="search-results"></ul>
					</div>
				</div>

				<!-- navbar right -->
				<div class="navbar-right">
					<ul class="nav navbar-nav">
						<!-- User Account -->
						<li class="dropdown user-menu">
							<button class="dropdown-toggle nav-link ec-drop" data-bs-toggle="dropdown"
								aria-expanded="false">
								<img src="../assets/uploads/<?php echo $settings['logo'] ?>" class="user-image" alt="User Image" />
							</button>
							<ul class="dropdown-menu dropdown-menu-right ec-dropdown-menu">
								<!-- User image -->
								<li class="dropdown-header">
									<img src="../assets/uploads/<?php echo $settings['logo'] ?>" class="img-circle" alt="User Image" />
									<div class="d-inline-block">
										<small class="pt-1 word-break"><?php echo $_SESSION['email'];?></small>
									</div>
								</li>
								<li class="right-sidebar-in">
									<a href="settings.php"> <i class="mdi mdi-settings-outline"></i> Setting </a>
								</li>
								<li class="dropdown-footer">
									<form action="./php/logout.php" method="POST">
										<button name="submit" type="submit" class="w-100 text-start"><i class="mdi mdi-logout"></i> Log Out </button>
									</form>
								</li>
							</ul>
						</li>
						<?php 
							$_sql = 'SELECT * FROM quote WHERE notification = 0';
							$_result = mysqli_query($conn, $_sql);
							$_quote = mysqli_fetch_all($_result, MYSQLI_ASSOC);

							$quoteCount = count($_quote);
						?>
						<li class="dropdown notifications-menu custom-dropdown">
							<button class="dropdown-toggle notify-toggler custom-dropdown-toggler position-relative">
								<i class="mdi mdi-bell-outline"></i>
								<?php 
									if ($quoteCount > 0) {
										// Display the notification icon or perform other actions
										echo '<div class="notify"></div>';
									}
								?>
							</button>

							<div class="card card-default dropdown-notify dropdown-menu-right mb-0">
								<div class="card-header card-header-border-bottom px-3">
									<h2>Notifications</h2>
								</div>

								<div class="card-body px-0 py-0">
									<div class="tab-content" id="myNotifications">
										<div class="tab-pane fade show active" id="home2" role="tabpanel">
											<ul class="list-unstyled" data-simplebar style="height: 360px">
											<?php if(empty($_quote)): ?>
												<li><p class="text-center mt-3">Hooray, no new messages here!</p></li>
											<?php elseif(!empty($_quote)): ?>
											<?php foreach($_quote as $index => $item): ?>
												<li>
													<a href="quote.php?quoteId=<?php echo $item['id']?>#quote<?php echo $item['id']?>"
														class="media media-message media-notification">
														<div class="position-relative mr-3">
															<img class="rounded-circle" src="assets/img/user/u2.jpg"
																alt="Image">
														</div>
														<div class="media-body d-flex justify-content-between">
															<div class="message-contents">
																<h4 class="title"><?php echo $item['name']?></h4>
																<p class="last-msg"><?php echo $item['message']?></p>
																<!-- <span
																	class="font-size-12 font-weight-medium text-secondary">
																	<i class="mdi mdi-clock-outline"></i> 30 min
																	ago...
																</span> -->
															</div>
														</div>
													</a>
												</li>
											<?php endforeach; ?>
											<li class="text-center">
												<form id="markAllForm">
													<button type="button" class="" onclick="markAllAsRead()">Mark All as Read</button>
												</form>
											</li>
											<?php endif; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</li>
						<!-- <li class="right-sidebar-in right-sidebar-2-menu">
							<i class="mdi mdi-settings-outline mdi-spin"></i>
						</li> -->
					</ul>
				</div>
			</nav>
		</header>

		<script>
		function markAllAsRead() {
			// Send an AJAX request to the server to update notification status
			$.ajax({
				type: "POST",
				url: "php/mark_all_as_read.php",  // Change this to the actual path of your PHP file
				data: { markAll: true },
				success: function (response) {
					console.log(response);
					if(response == 'All quotes marked as read successfully.'){
						$('.notifications-menu .simplebar-content').html('<li><p class="text-center mt-3">Hooray, no new messages here!</p></li>')
					}
					
				},
				error: function (error) {
					console.log(error);
				}
			});
		}
	</script>