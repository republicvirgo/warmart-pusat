@extends('layouts.app')

@section('content')

		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="{{ url('/home') }} ">Home</a></li>
					<li><a href="{{ url('/stoking-center') }}">Stoking Center</a></li>
					<li class="active">Edit Stoking Center</li>
				</ul>

		 <div class="card">
			   	   <div class="card-header card-header-icon" data-background-color="purple">
                       <i class="material-icons">shopping_basket</i>
                                </div>
                      <div class="card-content">
                         <h4 class="card-title"> Stoking Center </h4>
                      
						{!! Form::model($stokingcenter, ['url' => route('stoking-center.update', $stokingcenter->id), 'method' => 'put', 'files'=>'true','class'=>'form-horizontal']) !!}
							@include('stoking_center._form')
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
@endsection