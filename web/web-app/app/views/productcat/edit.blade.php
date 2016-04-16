@extends('master')

@section('content')
	
	<ul class="breadcrumb">
    	<li class="active">Product Category</li>
    	<span class="divider">/</span>
    	<li><b>Edit::{{ $_item->id }}</b></li>
  	</ul>
  <div class="col-xs-6 col-md-3">
    <ul class="nav nav-pills nav-stacked sidebarcolor">
      <li class="">{{ HTML::decode(HTML::link('/product',' All Products')) }}</li>
      <li>{{ HTML::decode(HTML::link('product/create',' Add Product')) }}</li>
            <li>{{ HTML::decode(HTML::link('productcat/index',' All Product Category')) }}</li>
      <li>{{ HTML::decode(HTML::link('productcat/create',' Add Product Category')) }}</li>

    </ul>
  </div>
  <div class="col-xs-9 col-md-9">
	{{ Form::open(array('url'=>'productcat/edit','method'=>'post')) }}

		<input type="hidden" name="id" value="{{ $_item->id }}"/>

		<input type="text" name="title" class="form-control" placeholder="Title Here" value="{{ $_item->name }}">
<br/>
		<!--<textarea placeholder="Description Here" class="form-control" name="description" rows="10">{{-- $_item->ab_desc --}}</textarea>-->
<br/>
		<input type="text" name="date" id="pick_date" value="{{ $_item->created_at }}" class="form-control">

		<br/>
	    <div style="text-align:center;">
	      <button type="submit" class="btn btn-success">Update</button>
	    </div>
	{{ Form::close() }}

	  @foreach($errors->all('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>:message</div>') as $message)
	  	{{ $message }}
	  @endforeach
</div>
@stop

@section('scripts')
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$("#menu_articlez").addClass('active');
		$("#pick_date").datepicker();
	</script>
@stop