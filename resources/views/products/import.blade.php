@extends('layouts.app')

@section('title', 'Products Import')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Import
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                            {{ session('status')}}
                            </div>
                        @endif
                    
                        <form action="import" method="POST" enctype="multipart/form-data">
                        {{$errors->first('file')}}
                        @csrf
                            <div class="form-group">
                                <input type="file" name="file" />
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                        <hr />
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                @if(!empty($productFailures))
                                <p>Products Import Result. Fails to import {{ count($productFailures) }} item(s).</p>
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">Row Number</th>
                                    <th scope="col">Error Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productFailures as $failure)
                                    <tr>
                                        <td>{{ $failure->row() }}</td>
                                        <td>{{ $failure->errors()[0] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                @endif
                                </div>
                                <div class="col">
                                @if(!empty($categotyFailure))
                                    <p>Category Import Result. Fails to import {{ count($categotyFailure) }} item(s).</p>
                                    <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col">Row Number</th>
                                        <th scope="col">Error Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categotyFailure as $failure)
                                        <tr>
                                            <td>{{ $failure->row() }}</td>
                                            <td>{{ $failure->errors()[0] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection