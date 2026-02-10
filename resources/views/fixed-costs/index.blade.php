<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="md:text-2xl lg:text-3xl font-bold text-gray-800">固定費</h1>
                    <p class="text-gray-600 mt-1">月額の固定費を管理できます</p>
                </div>
                <a href="{{ route('fixed-costs.create') }}"
                   class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <x-heroicon-o-plus class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">登録数</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $countFixedCosts }}</p>
                    <p class="text-sm text-gray-500 mt-1">サービス</p>
                </div>

                <div class="bg-blue-600 rounded-lg shadow p-6 text-white">
                    <p class="text-sm mb-2">月額合計</p>
                    <p class="text-4xl font-bold">¥{{ number_format($sumFixedCost) }}</p>
                    <p class="text-right text-sm mt-1">/月</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">アクティブ</p>
                    <p class="text-4xl font-bold text-green-500">{{ $countActiveFixedCosts }}</p>
                    <p class="text-sm text-gray-500 mt-1">有効サービス</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">TOP3 高額固定費</h2>

                @if($rankFixedCostByAmount->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  @foreach($rankFixedCostByAmount as $index => $fixedCost)
                   @php
                    $rankStyle = App\Enums\RankStyle::fromIndex($index);
                   @endphp
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 {{ $rankStyle->borderColor() }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-2xl font-bold {{ $rankStyle->textClass() }}">{{ $index + 1 }}位</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $fixedCost->cost_name }}</span>
                        </div>
                        <p class="font-bold text-gray-800">¥{{ number_format($fixedCost->amount) }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="{{ $fixedCost->category->CategoryColor() }}">{{ $fixedCost->category->label() }}</span> • 毎月{{ $fixedCost->billing_day }}日
                        </p>
                    </div>
                   @endforeach
                </div>
                @else
                   <div class="text-center py-8 text-gray-500">
                      登録されているサブスクはありません。
                   </div>
                @endif
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 h-[550px]">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden flex-1 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800">支出分析</h2>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-purple-100 text-purple-800">管理画面</span>
                    </div>
                    <div class="flex-1 flex flex-col justify-center items-center min-h-[400px] py-8">
                        @if($chartData)
                            <div
                                id="fixedCostChart"
                                class="w-full max-w-full h-full"
                                data-series='@json($chartData["series"])'
                                data-labels='@json($chartData["labels"])'
                            ></div>
                        @else
                            <div class="text-center space-y-2">
                                @if(!$income)
                                    <p class="text-gray-500 text-lg italic">所持金を登録してください</p>
                                    <p class="text-sm text-gray-500 italic">グラフを表示するには収入情報が必要です</p>
                                @elseif($income->amount < $sumFixedCost)
                                    <p class="text-gray-500 text-lg italic">支出が所持金を上回ってます:(</p>
                                    <p class="text-sm text-gray-500 italic">収入額を見直すか、固定費を削減してください</p>
                                @else
                                    <p class="text-gray-500 text-lg italic">固定費データがありません</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow flex flex-col h-full overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            固定費一覧（支払日順）
                        </h3>
                    </div>
                    <div class="p-4 overflow-y-auto">
                        @forelse($fixedCosts as $fixedCost)
                            <div class="p-4 mb-3 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-800 mb-1">
                                            {{ $fixedCost->cost_name }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="{{ $fixedCost->category->CategoryColor() }}">{{ $fixedCost->category->label() }}</span> • 毎月{{ $fixedCost->billing_day }}日
                                        </p>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-800 mr-4">
                                        ¥{{ number_format($fixedCost->amount) }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="inline-block relative group">
                                        <div class="text-gray-500 hover:text-blue-700 transition duration-300 ease-in-out z-20">
                                            <x-heroicon-o-ellipsis-horizontal-circle class="w-6 h-6" />
                                        </div>
                                        <div class="absolute left-full top-0 flex items-center gap-2 pl-2 opacity-0 group-hover:opacity-100 translate-x-[-10px] group-hover:translate-x-0 transition duration-300">
                                            <form
                                                class="flex items-center"
                                                action="{{ route('fixed-costs.destroy', $fixedCost->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('本当に削除しますか？');">
                                                @csrf
                                                @method('DELETE')
                                               <button type="submit" class="hover:text-red-500">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                               </button>
                                            </form>
                                            <a href="{{ route('fixed-costs.edit', $fixedCost) }}" class="flex items-center hover:text-blue-500">
                                                <x-heroicon-o-pencil-square class="w-5 h-5" />
                                            </a>
                                            <a href="{{ route('fixed-costs.show', $fixedCost) }}"  class="flex items-center hover:text-green-500">
                                                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                                            </a>
                                        </div>
                                    </div>

                                   <div class="flex items-center gap-2">
                                        @if($fixedCost->memo)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                <x-heroicon-o-check class="w-4 h-4" />
                                                メモ
                                            </span>
                                        @endif

                                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full {{ $fixedCost->status->statusColor() }}">
                                            {{ $fixedCost->status->label() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                登録されている固定費はありません
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</x-app-layout>
