@extends('layouts.app')
@section('content')

	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="{{ url('/home') }}">Home</a></li>
				<li class="active">Error Log</li>
			</ul>
 
			
			   <div class="card">
			   	   <div class="card-header card-header-icon" data-background-color="purple">
                       <i class="material-icons">error</i>
                                </div>
                      <div class="card-content">
                        <h4 class="card-title"> Error Log </h4>
	                       
					<div class="table-responsive material-datatables">
					{!! $html->table(['class'=>'table table-striped table-no-bordered table-hover','cellspacing' => '0','width' => '100%','style' => 'width:100%']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
{!! $html->scripts() !!}

@endsection
