@props(['income' => null])

@php
  $isEdit = $income !== null;
  $action = $isEdit ? route('income.update', ['income' => $income->id]) : route('income.store');
@endphp

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = true"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white rounded-md transition flex items-center gap-2"
    >
        @if($isEdit)
            <x-heroicon-o-pencil class="w-4 h-4" />
        @else
            <x-heroicon-o-plus class="w-4 h-4" />
        @endif
    </button>

    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 z-40"
        style="display: none;"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        @click.stop
        class="absolute top-full right-0 mt-2 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-lg shadow-lg w-80 border border-gray-200">
            <div class="px-5 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">収入登録</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ $action }}" class="p-5">
                @csrf
                @if($isEdit)
                  @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">収入額</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">¥</span>
                        <input
                            type="number"
                            name="amount"
                            placeholder="300000"
                            required
                            value="{{ old('amount', $income?->amount) }}"
                            class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="flex gap-2">
                    <button
                        type="button"
                        @click="open = false"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50"
                    >
                        キャンセル
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-800 text-white rounded-md"
                    >
                        {{ $isEdit ? '更新' : '登録' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
