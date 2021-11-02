@extends('layouts.frontend')
@section('content')

<!-- ========================== Leadboard Title Section Starts =============================== -->
<section class="bg-light">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<p>All Subjects</p>
					<h2><span class="theme-cl">Leadboard</span></h2>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-6 col-sm-12">
				<center>
					<form class="form-inline addons mb-3" method="GET">
						<input class="form-control" type="search" placeholder="Search Courses" aria-label="Search"
							style="width: 90% !important;" name="p_">
						<button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
					</form>
				</center>
			</div>
		</div>

	</div>
</section>
<!-- ========================== Leadboard Title Section Ends =============================== -->

<!-- ========================== Leadboard Table Section Starts =============================== -->
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="dashboard_container">
					<div class="dashboard_container_body">
						<div class="table-responsive">
							<table class="table text-center">
								<thead class="thead-dark">
									<tr>
										<th >Serial No.</th>
										<th >Name</th>
										<th >Package Name</th>
										<th >Marks</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($leadboards as $leadboard)
									<tr class="text-left">
										<td >#{{ $leadboard->serial_number }}</td>
										<td>{{ $leadboard->user ? $leadboard->user->name : '' }}</td>
										<td>{{ $leadboard->package ? $leadboard->package->title : '' }}</td>
										<td>{{ $leadboard->points }}</td>										
									</tr>	
									@empty
									<tr>
										<td colspan="4">No data found!</td>
									</tr>								
									@endforelse
									
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<!-- ========================== Leadboard Table Section =============================== -->

@endsection
