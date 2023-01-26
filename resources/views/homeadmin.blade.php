@extends('layouts.appnew')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="mt-2 mb-4">
				<div class="card">	
					<div class="container mt-2">	
						<h2 class="text-black pb-2">Welcome back, {{ Auth::user()->name }}!</h2>
						<h5 class="text-black op-7 mb-4">Yesterday I was clever, so I wanted to change the world. Today I am wise, so I am changing myself.</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>