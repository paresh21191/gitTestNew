@extends('auth.layouts')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('products.store') }}" method="POST">
    	@csrf

                                <div class="col-xs-12 col-lg-12 col-12">
                                    <div class="form-group mb-3">
                                     <strong>Category:</strong>
                                                            <select name="category_id" id="category_id" class="form-control category_id"  >
                                            <option value="">Select category</option>
                                            @foreach($Category as $key => $value)
                                                <option  value="{{ $value->id }}" {{ old('category_id') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @foreach($errors->get('category_id') as $error)
                                            <span class="text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
		            <input type="text" name="name" class="form-control" placeholder="Name">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Price:</strong>
		            <input type="text" name="price" class="form-control" placeholder="Price">
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>QTY:</strong>
                    <input type="text" name="qty" class="form-control" placeholder="Qty">
                </div>
            </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>


    </form>


<p class="text-center text-primary"><small>PracticeCode by TEST.com</small></p>
@endsection