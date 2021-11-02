@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">

				<div class="breadcrumbs-wrap">
					<h1 class="breadcrumb-title">{!! $page->title !!}</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Page</li>
						</ol>
					</nav>
				</div>

			</div>
		</div>
	</div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Privacy Start ================================== -->
<section class="gray">

	<div class="container">

		<!-- row Start -->
		<div class="row">

			<div class="col-lg-12 col-md-12">
				<div class="prc_wrap">

					<div class="prc_wrap_header">
						<h4 class="property_block_title">{!! $page->title !!}</h4>
					</div>

					<div class="prc_wrap-body">
						{!! $page->content !!}
					</div>

				</div>

			</div>


		</div>
		<!-- /row -->

	</div>

</section>
<!-- ============================ Privacy End ================================== -->
@endsection