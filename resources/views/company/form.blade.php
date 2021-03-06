@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset("css/firststyle.css") }}" >
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="">

                    @if($company->exists)
                    <img class="card-img-top" src="{{asset('company_logos/'.$company->logo)}}"
                         alt="{{$company->logo.' logo'}}">
                    <h1 class="text-center">Edit {{$company->name}}</h1>
                    @else
                        <h1 class="text-center">Create New Company</h1>
                    @endif

                    {{--<div class="card-body">--}}
                    {{--<h5 class="card-title">--}}
                    {{--<a href="{{url('companies/'.$company->id)}}">{{$company->name}}</a>--}}
                    {{--</h5>--}}
                    {{--{{Form::model($company, ['route' => ['companies.edit', $company->id], 'files' => true])}}--}}

                    {{--{{Form::close()}}--}}
                    {{--</div>--}}

                    <div class="card-body">

                        {{Form::model($company, ['route' => $route, 'files' => true, 'method' => $method])}}

                        <div class="form-group row yeni">
                            {{Form::label('name', 'Name: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('name', null, ['class' => 'form-control']) }}
                            </div>
                            {{--Name validation--}}
                            @if($errors->has('name'))
                                <div class="btn btn-danger col-sm-3">
                                    {{$errors->first('name')}}
                                </div>
                            @endif
                        </div>

                        <div class="form-group row yeni">
                            {{Form::label('email', 'E-Mail Address: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('email', null, ['class' => 'form-control']) }}
                            </div>
                            {{--Mail validation--}}
                            @if($errors->has('email'))
                                <div class="btn btn-danger col-sm-3">
                                    {{$errors->first('email')}}
                                </div>
                            @endif
                        </div>

                        <div class="form-group row yeni">
                            {{Form::label('phone', 'Telephone Number: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('phone', null, ['class' => 'form-control'])}}
                            </div>
                        </div>


                        <div class="form-group row yeni">
                            {{Form::label('website', 'Web Site: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('website', null, ['class' => 'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row yeni">
                            {{Form::label('address', 'Address: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::textarea('address', null, ['class' => 'form-control'])}}
                            </div>
                            {{--Address validation--}}
                            @if($errors->has('address'))
                                <div class="alert alert-danger col-sm-3">
                                    {{$errors->first('address')}}
                                </div>
                            @endif
                        </div>

                        {{--<div class="form-group row yeni">--}}
                        {{--{{Form::label('logo', 'Company Logo: ', ['class' => 'col-sm-3 col-form-label'])}}--}}
                        {{--<div class="col-sm-7">--}}
                        {{--{{Form::file('logo')}}--}}
                        {{--</div>--}}
                        {{--Company logo validation--}}
                        {{--@if($errors->has('logo'))--}}
                        {{--<div class="alert alert-danger">--}}
                        {{--{{$errors->first('address')}}--}}
                        {{--</div>--}}
                        {{--@endif--}}
                        {{--</div>--}}


                        <div class="form-group row yeni">
                            {{Form::label('logo', 'Company Logo: ', ['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::file('logo')}}
                            </div>
                            {{--Company logo validation--}}
                            @if($errors->has('logo'))
                                <div class="alert alert-danger col-sm-3">
                                    {{$errors->first('logo')}}
                                </div>
                            @endif
                        </div>


                        <div class="form-group row yeni">
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-6">
                                {{Form::submit('Save Company', ['class' => 'btn btn-success'])}}
                            </div>
                        </div>
                        {{Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
