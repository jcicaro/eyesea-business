<!DOCTYPE html>
<html lang="en">

<head>
	<title>
		<?php bloginfo('name'); ?>
	</title>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php acf_form_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<script>
		var WPGLOBAL = {
			ENABLE_DEBUG: "<?php echo get_option('enable_debug'); ?>" === "true" ? true : true,
			IS_HOME: "<?php echo is_home(); ?>" ? true : false,
			IS_SEARCH: "<?php echo is_search(); ?>" ? true : false,
			IS_CATEGORY: "<?php echo is_category(); ?>" ? true : false,
			IS_ARCHIVE: "<?php echo is_archive(); ?>" ? true : false,
			IS_SINGLE: "<?php echo is_single(); ?>" ? true : false,
			IS_PAGE: "<?php echo is_page(); ?>" ? true : false,
			IS_FRONT_PAGE: "<?php echo is_front_page(); ?>" ? true : false,
			SITE_URL: "<?php echo site_url(); ?>",
			TEMPLATE_URI: "<?php echo get_template_directory_uri(); ?>",
			POST_TYPE: "<?php if (is_archive()) { echo get_queried_object()->name; }  else { echo ''; }  ?>"
		};
		console.log('Test log: ', "<?php echo get_current_user_id(); ?>")
	</script>

	<?php wp_head(); ?>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
			<a class="navbar-brand" href="/">Eye Sea Studio</a>

			<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="/expense/">Expenses</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/income/">Income</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/invoice/">Invoices</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/workshop/">Workshops</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/customer/">Customers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/vendor/">Vendors</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/wp-json/sn/v1/update/all">Update Records</a>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0" method="GET" action="<?php echo esc_url(site_url('/')); ?>">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="s">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav>
	<div class="container mt-3">

		