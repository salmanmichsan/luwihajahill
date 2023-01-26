@extends('layouts.appnew')
@push('custom-header')        
<style type="text/css">
	   /**
     * bootstrap-imageupload v1.1.2
     * https://github.com/egonolieux/bootstrap-imageupload
     * Copyright 2016 Egon Olieux
     * Released under the MIT license
     */
    .imageupload {
                    margin: 20px 10px;
                }
    .imageupload.imageupload-disabled {
      cursor: not-allowed;
      opacity: 0.60;
    }
    .imageupload.imageupload-disabled > * {
      pointer-events: none;
    }
    .imageupload .panel-title {
      margin-right: 15px;
      padding-top: 8px;
    }
    .imageupload .alert {
      margin-bottom: 10px;
    }
    .imageupload .btn-file {
      overflow: hidden;
      position: relative;
    }
    .imageupload .btn-file input[type="file"] {
      cursor: inherit;
      display: block;
      font-size: 100px;
      min-height: 100%;
      min-width: 100%;
      opacity: 0;
      position: absolute;
      right: 0;
      text-align: right;
      top: 0;
    }
    .imageupload .file-tab button {
      
    }
    .imageupload .file-tab .thumbnail {
      margin-bottom: 10px;
    }
    .imageupload .url-tab {
      display: none;
    }
    .imageupload .url-tab .thumbnail {
      margin: 10px 0;
    }
</style>
@endpush
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="mt-2 mb-4">
				<div class="card">	
					<div class="container mt-4 mb-4">	

						<h2 class="text-black pb-2">Edit Home Banner</h2>
						<form method="post" action="{{Route('homebannerupdate',$data->id)}}" enctype="multipart/form-data">
							@csrf
                            <div class="imageupload panel panel-default">
                                    <div class="panel-heading clearfix">
                                        <!-- <h5 class="panel-title pull-left">Upload Image</h5> -->
                                        <label style="font-weight: 600;">Image</label>
                                        
                                    </div>
                                    <div class="file-tab panel-body">
                                        <img src="{{asset('uploads/banner/'.$data->image)}}" alt="Image preview" class="thumbnail" id="preview_img" style="max-width: 250px; max-height: 250px">
                                        <br>
                                        <label class="btn btn-default btn-file">
                                            <span>Browse</span>
                                            <!-- The file is stored here. -->
                                            <input type="file" name="image"  onchange="loadPreview(this);">
                                        </label>
                                        <button type="button" class="btn btn-default" id="remove_btn" onclick="resetFileTab();">Remove</button>
                                    </div>     
                                    @error('image')                             <br>
                                    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                                    @enderror
                                </div>
							
							<div class="form-group">
								<label for="exampleFormControlTextarea1">Caption</label>								
								<textarea class="form-control" name="caption" id="@error('caption') errorInput @enderror" rows="3">{{$data->caption}}</textarea>
                                @error('caption')
                                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                                @enderror
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="active" id="exampleCheck1" style="left :80px;" vavlue="{{$data->active}}" {{$data->active == 1 ? "checked":''}}>
								<label class="form-check-label" for="exampleCheck1">Active</label>                                
							</div>
							
							<button type="submit" class="btn btn-primary">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@push('custom-footer')
<script type="text/javascript">
function loadPreview(input, id) {
    var p_img = document.getElementById('preview_img');
    var r_btn = document.getElementById('remove_btn');    
    p_img.style.display = '';
    r_btn.style.display = '';
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
 
        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };
 
        reader.readAsDataURL(input.files[0]);
    }
 }
 function resetFileTab() {
    var p_img = document.getElementById('preview_img');
    var r_btn = document.getElementById('remove_btn');
    p_img.src = '';
    p_img.style.display = 'none';
    r_btn.style.display = 'none';
}

</script>
@endpush