@extends('layouts.app')

@section('title', 'Create Purchase')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">{{__('Purchases')}}</a></li>
        <li class="breadcrumb-item active">{{__('Add')}}</li>
    </ol>
@endsection

@section('content')
    <div class="container px-4 mx-auto mb-4">
        <div class="row">
            <div class="col-12">
                <livewire:search-product/>
            </div>
        </div>

        <div class="row mt-4">
            <div class="w-full px-4">
                <div class="card">
                    <div class="p-4">
                        @include('utils.alerts')
                        <form id="purchase-form" action="{{ route('purchases.store') }}" method="POST">
                            @csrf

                            <div class="flex flex-wrap -mx-1">
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="reference">Reference <span class="text-red-500">*</span></label>
                                        <input type="text" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="reference" required readonly value="PR">
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="from-group">
                                        <div class="mb-4">
                                            <label for="supplier_id">Supplier <span class="text-red-500">*</span></label>
                                            <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="supplier_id" id="supplier_id" required>
                                                @foreach(\App\Models\Supplier::all() as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="from-group">
                                        <div class="mb-4">
                                            <label for="date">Date <span class="text-red-500">*</span></label>
                                            <input type="date" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:product-cart :cartInstance="'purchase'"/>

                            <div class="flex flex-wrap -mx-1">
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="status">Status <span class="text-red-500">*</span></label>
                                        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="status" id="status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Ordered">Ordered</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="from-group">
                                        <div class="mb-4">
                                            <label for="payment_method">Payment Method <span class="text-red-500">*</span></label>
                                            <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="paid_amount">Amount Paid <span class="text-red-500">*</span></label>
                                        <div class="input-group">
                                            <input id="paid_amount" type="text" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="paid_amount" required>
                                            <div class="input-group-append">
                                                <button id="getTotalAmount" class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"></textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">
                                    Create Purchase <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#paid_amount').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#getTotalAmount').click(function () {
                $('#paid_amount').maskMoney('mask', {{ Cart::instance('purchase')->total() }});
            });

            $('#purchase-form').submit(function () {
                var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                $('#paid_amount').val(paid_amount);
            });
        });
    </script>
@endpush