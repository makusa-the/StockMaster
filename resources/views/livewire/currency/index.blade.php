<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            <button
                class="text-blue-500 dark:text-gray-300 bg-transparent dark:bg-dark-eval-2 border border-blue-500 dark:border-gray-300 hover:text-blue-700  active:bg-blue-600 font-bold uppercase text-xs p-3 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled"
                {{ $this->selectedCount ? '' : 'disabled' }}>
                {{ __('Delete') }}
            </button>

        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <div class="my-2 my-md-0">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>
    <div wire:loading.delay>
        <div class="flex justify-center">
            <x-loading />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th class="pr-0 w-8">
                <x-input type="checkbox" class="rounded-tl rounded-bl" wire:model="selectPage" />
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">
                {{ __('Id') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('code')" :direction="$sorts['code'] ?? null">
                {{ __('Code') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('symbol')" :direction="$sorts['symbol'] ?? null">
                {{ __('Symbol') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('rate')" :direction="$sorts['rate'] ?? null">
                {{ __('Rate') }}
            </x-table.th>
            <x-table.th sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th />
        </x-slot>
        <x-slot name="tbody">
            @forelse ($currencies as $currency)
                <x-table.tr wire:key="row-{{ $currency->id }}">
                    <x-table.td class="pr-0">
                        <x-input wire:model="selected" value="{{ $currency->id }}" />
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->code }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->symbol }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->rate }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->status }}
                    </x-table.td>
                    <x-table.td class="whitespace-no-wrap row-action--icon">
                        <x-primary-button wire:click="showModal({{ $currency->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            wire:loading.attr="disabled">
                            <i class="fas fa-eye"></i>
                        </x-primary-button>

                        <x-primary-button wire:click="editModal({{ $currency->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            wire:loading.attr="disabled">
                            <i class="fas fa-edit"></i>
                        </x-primary-button>

                        <x-primary-button wire:click="confirm('delete', {{ $currency->id }})"
                            wire:loading.attr="disabled"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-trash"></i>
                        </x-primary-button>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="8">
                        <div class="flex items-center justify-center">
                            <span class="dark:text-gray-300">{{ __('No results found') }}</span>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>
    </x-table>

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $currencies->links() }}
        </div>
    </div>

    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Currency') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col">
                <div class="flex flex-col">
                    <x-label for="currency.name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" required type="text" disabled
                        wire:model.defer="currency.name" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.code" :value="__('Code')" />
                    <x-input id="code" class="block mt-1 w-full" type="text" disabled
                        wire:model.defer="currency.code" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.symbol" :value="__('Symbol')" />
                    <x-input id="symbol" class="block mt-1 w-full" type="text" disabled
                        wire:model.defer="currency.symbol" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.rate" :value="__('Rate')" />
                    <x-input id="rate" class="block mt-1 w-full" type="text" disabled
                        wire:model.defer="currency.rate" />
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-primary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-primary-button>
            </div>
        </x-slot>
    </x-modal>

    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Currency') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit.prevent="update">
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <x-label for="currency.name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" required type="text"
                            wire:model.defer="currency.name" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.code" :value="__('Code')" />
                        <x-input id="code" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.code" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.symbol" :value="__('Symbol')" />
                        <x-input id="symbol" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.symbol" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.rate" :value="__('Rate')" />
                        <x-input id="rate" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.rate" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button wire:click="$set('editModal', false)" wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-primary-button>
                    <x-primary-button wire:click="update" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </x-slot>
    </x-modal>

    <x-modal wire:click="createModal">
        <x-slot name="title">
            {{ __('Create Currency') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit.prevent="create">
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <x-label for="currency.name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" required type="text"
                            wire:model.defer="currency.name" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.code" :value="__('Code')" />
                        <x-input id="code" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.code" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.symbol" :value="__('Symbol')" />
                        <x-input id="symbol" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.symbol" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.rate" :value="__('Rate')" />
                        <x-input id="rate" class="block mt-1 w-full" type="text"
                            wire:model.defer="currency.rate" />
                    </div>
                    <div class="flex flex-col">
                        <x-label for="currency.is_default" :value="__('Is Default')" />
                        <x-input id="is_default" class="block mt-1 w-full" type="checkbox"
                            wire:model.defer="currency.is_default" />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button wire:click="$set('createModal', false)" wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-primary-button>
                    <x-primary-button wire:click="store" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>


@push('page_scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('deleteModal', currencyId => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('delete', currencyId)
                    }
                })
            })
        })
    </script>
@endpush