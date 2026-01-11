<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">固定費管理</h1>
                    <p class="text-gray-600 mt-1">月額の固定費を管理できます</p>
                </div>
                <a href="{{ route('fixed-costs.create') }}"
                   class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    新規登録
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">登録数</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $countFixedCosts }}</p>
                    <p class="text-sm text-gray-500 mt-1">サービス</p>
                </div>

                <div class="bg-blue-500 rounded-lg shadow p-6 text-white">
                    <p class="text-sm mb-2">月額合計</p>
                    <p class="text-4xl font-bold">¥{{ number_format($sum) }}</p>
                    <p class="text-sm mt-1">/月</p>
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
                            <span class="text-2xl font-bold {{ $rankStyle->textClass() }}">1位</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $fixedCost->cost_name }}</span>
                        </div>
                        <p class="font-bold text-gray-800">{{ $fixedCost->amount }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $fixedCost->category }} • 毎月{{ $fixedCost->billing_day }}日
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

            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-bold text-gray-800">固定費一覧（支払日順）</h3>
                </div>
                <div class="p-4">
                    @forelse($fixedCosts as $fixedCost)
                        <div class="p-4 mb-3 bg-gray-50 rounded-lg border-l-4 border-green-500">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 mb-1">
                                        {{ $fixedCost->cost_name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $fixedCost->category }} • 毎月{{ $fixedCost->billing_day }}日
                                    </p>
                                </div>
                                <p class="text-2xl font-bold text-gray-800 mr-4">
                                    ¥{{ number_format($fixedCost->amount) }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-sm font-semibold rounded {{ $fixedCost->status->statusColor() }}">
                                    {{ $fixedCost->status->label() }}
                                </span>

                                <div class="flex gap-2">
                                    <a href="{{ route('fixed-costs.show', $fixedCost) }}"
                                    class="px-4 py-2 bg-gray-500 text-white text-sm rounded hover:bg-gray-600">
                                        詳細
                                    </a>
                                    <a href="{{ route('fixed-costs.edit', $fixedCost) }}"
                                    class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                        編集
                                    </a>
                                    <form action="{{ route('fixed-costs.destroy', $fixedCost->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                            削除
                                        </button>
                                    </form>
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
</x-app-layout>
