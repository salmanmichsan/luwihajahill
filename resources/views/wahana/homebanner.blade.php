@extends('layouts.appnew')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="mt-2 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="container">
							<div class="row">
								<a class="btn btn-dark" style="margin-left: auto;" href="{{Route('wahanacreate')}}">Create</a>	
							</div>	
						</div>
						
						
						<div class="table-responsive mt-4 mb-2">
							<table id="banner-table" class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Image</th>
										<th>Name</th>
										<th>Category</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
							
							
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>

@endsection
@push('custom-footer')        
    <script type="text/javascript">
    @if(session()->has('success'))

	$(document).ready(function(){
		
		$.notify({
			// options
				message: '{{session('success')}}'
			},{
				// settings
				type: 'info', 
				delay: 2000
			});
		
	});
	@endif
	$(function() {
        $('#banner-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Route('getwahanadata')}}",
            columns: [
            {data: 'id', name: 'id'},
            {data: 'img', name: 'img'},
            {data: 'name', name: 'name'},
            {data: 'category', name: 'category'},
            {data: 'action', name: 'action'}
        ]
        });
    });
</script>
@endpush