@extends('auth.layouts')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Category</h2>
            </div>
            <div class="pull-right">
                @can('categorys-create')
                <a class="btn btn-success" href="{{ route('categoryss.create') }}"> Create New categorys</a>
                @endcan
            </div>
        </div>
    </div>

    <a class="btn btn-success" href="{{ route('categoryCreate') }}"> Create New Category</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
        </tr>
	    @foreach ($categorys as $cates)
	    <tr>

	        <td>{{ $cates->name }}</td>
	    </tr>
	    @endforeach
    </table>


<p class="text-center text-primary"><small>PracticeCode by TEST.com</small></p>
@endsection