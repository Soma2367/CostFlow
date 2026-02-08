<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 flex md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="md:text-2xl lg:text-3xl font-bold text-gray-800">管理画面</h1>
                    <p class="md:text-xl text-gray-600 mt-1">収支のバランスと内訳を管理します</p>
                </div>

                <div class="flex items-center gap-3">
                    @if($income)
                      <x-income-modal :income="$income"/>
                    @else
                      <x-income-modal />
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
                <div class="lg:col-span-2 space-y-6 flex flex-col">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-purple-500">
                            <p class="text-sm text-gray-600 mb-1">サブスク合計</p>
                            <p class="text-3xl font-bold text-purple-600">¥{{ number_format($sumSubsc) }}</p>
                            <p class="text-sm mt-1 text-right">/月</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-blue-500">
                            <p class="text-sm text-gray-600 mb-1">固定費合計</p>
                            <p class="text-3xl font-bold text-blue-600">¥{{ number_format($sumFixedCost) }}</p>
                            <p class="text-sm mt-1 text-right">/月</p>
                        </div>
                        <div class="bg-blue-600 rounded-xl shadow-md p-5 text-white">
                            <p class="text-sm opacity-90 mb-1">総支出額</p>
                            <p class="text-3xl font-bold">¥{{ number_format($totalExpense) }}</p>
                            @php
                                $holdings = $income ? $income->amount : 0;
                                $percentage = $holdings > 0 ? min(round(($totalExpense / $holdings) * 100, 1), 100) : 0;
                            @endphp
                            <div class="mt-3">
                                <div class="flex justify-between text-xs mb-1">
                                    <span>収入充当率</span>
                                    <span>{{ $percentage }}%</span>
                                </div>
                                <div class="w-full bg-blue-400/50 rounded-full h-1.5">
                                    <div class="bg-white rounded-full h-1.5"  style="width: {{ $percentage }}%" ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden flex-1 flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-800">支出分析</h2>
                            <div class="text-sm font-medium px-2.5 py-0.5 rounded bg-purple-100 text-purple-800 flex">
                                <p class="mr-2">所持金</p>
                                <p>¥{{ $income ? number_format($income->amount) : '0' }}</p>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex justify-center items-center min-h-[350px]">
                            @if($adminData)
                                <div id="adminChart"
                                     class="w-full"
                                     data-series='@json($adminData["series"])'
                                     data-labels='@json($adminData["labels"])'>
                                </div>
                            @elseif(!$income)
                                <p class="text-gray-400 italic">所持金を登録してください</p>
                            @elseif($income->amount < $totalExpense)
                                <p class="text-gray-400 italic">支出が収入を上回ってます:(</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-6 h-full">
                    <div class="bg-white rounded-xl shadow-sm flex flex-col flex-1 min-h-0">
                        <div class="px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-xl z-10">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                サブスク
                            </h3>
                        </div>
                        <div class="p-4 overflow-y-auto flex-1">
                            @forelse($subscItems as $item)
                                <a href="{{ route('subscriptions.show', $item) }}" class="block p-3 mb-2 bg-gray-50 hover:bg-purple-50 rounded-lg transition-colors border border-transparent hover:border-purple-100">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-800 truncate text-sm">{{ $item->subscription_name }}</p>
                                            <p class="text-xs text-gray-500">毎月{{ $item->billing_day }}日</p>
                                        </div>
                                        <p class="font-bold text-gray-800 text-right ml-2 text-sm">¥{{ number_format($item->amount) }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="h-full flex items-center justify-center">
                                    <p class="text-sm text-gray-400">データなし</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm flex flex-col flex-1 min-h-0">
                        <div class="px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-xl z-10">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                固定費
                            </h3>
                        </div>
                        <div class="p-4 overflow-y-auto flex-1">
                            @forelse($fixedCostItems as $item)
                                <a href="{{ route('fixed-costs.show', $item) }}" class="block p-3 mb-2 bg-gray-50 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-800 truncate text-sm">{{ $item->cost_name }}</p>
                                            <p class="text-xs text-gray-500">毎月{{ $item->billing_day }}日</p>
                                        </div>
                                        <p class="font-bold text-gray-800 text-right ml-2 text-sm">¥{{ number_format($item->amount) }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="h-full flex items-center justify-center">
                                    <p class="text-sm text-gray-400">データなし</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
