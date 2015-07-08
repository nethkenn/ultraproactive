@extends('member.layout')
@section('content')
<div class="encashment genealogy">
	<div class="header">Choose Tree you'd like to see
		<select class="form-control input-sm">
			<option>Binary Genealogy</option>
		</select>
		<span class="pull-right">Number of Downlines: 3</span>
	</div>
	<div class="body para">
		<div class="tree">
			<ul>
				<li>
					<a href="#">Parent</a>
					<ul>
						<li>
							<a href="#">Child</a>
							<ul>
								<li>
									<a href="#">Grand Child</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">Child</a>
							<ul>
								<li><a href="#">Grand Child</a></li>
								<li>
									<a href="#">Grand Child</a>
									<ul>
										<li>
											<a href="#">Great Grand Child</a>
										</li>
										<li>
											<a href="#">Great Grand Child</a>
										</li>
										<li>
											<a href="#">Great Grand Child</a>
										</li>
									</ul>
								</li>
								<li><a href="#">Grand Child</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/genealogy.css">
@endsection