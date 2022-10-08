@extends('layouts.app')

@section('title', 'Purchases')



@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item active">{{__('Purchases')}}</li>
    </ol>
@endsection

@section('content')
    <div class="container px-4 mx-auto">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="p-4">
                        <a href="{{ route('purchases.create') }}" class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">
                            Add Purchase <i class="bi bi-plus"></i>
                        </a>

                        <hr>

                        <div class="table-responsive">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
