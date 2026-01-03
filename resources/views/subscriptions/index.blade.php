<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">サブスク管理</h1>
                    <p class="text-gray-600 mt-1">月額のサブスクリプションサービスを管理できます</p>
                </div>
                <a href="{{ route('subscriptions.create') }}"
                   class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    新規登録
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">登録数</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $countSubscriptions }}</p>
                    <p class="text-sm text-gray-500 mt-1">サービス</p>
                </div>

                <div class="bg-blue-500 rounded-lg shadow p-6 text-white">
                    <p class="text-sm mb-2">月額合計</p>
                    <p class="text-4xl font-bold">¥{{ number_format($sum) }}</p>
                    <p class="text-sm mt-1">/月</p>
                </div>


                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">アクティブ</p>
                    <p class="text-4xl font-bold text-green-500">{{ $countActiveSubscriptions }}</p>
                    <p class="text-sm text-gray-500 mt-1">有効サービス</p>
                </div>
            </div>


            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">TOP3 高額サブスク</h2>

                @if($rankSubscByAmount->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  @foreach($rankSubscByAmount as $index => $subscription)
                   @php
                    $rankStyle = App\Enums\RankStyle::fromIndex($index);
                   @endphp
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 {{ $rankStyle->borderColor() }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-2xl font-bold {{ $rankStyle->textClass() }}">1位</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $subscription->subscription_name }}</span>
                        </div>
                        <p class="font-bold text-gray-800">{{ $subscription->amount }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $subscription->category }} • 毎月{{ $subscription->billing_day }}日
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
                    <h3 class="text-lg font-bold text-gray-800">サブスク一覧（支払日順）</h3>
                </div>
                <div class="p-4">
                    @forelse($subscriptions as $subscription)
                        <div class="p-4 mb-3 bg-gray-50 rounded-lg border-l-4 border-green-500">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 mb-1">
                                        {{ $subscription->subscription_name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $subscription->category }} • 毎月{{ $subscription->billing_day }}日
                                    </p>
                                </div>
                                <p class="text-2xl font-bold text-gray-800 mr-4">
                                    ¥{{ number_format($subscription->amount) }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-sm font-semibold rounded
                                    @if($subscription->status->value === 'active')
                                        bg-green-100 text-green-700
                                    @elseif($subscription->status->value === 'paused')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-600
                                    @endif">

                                    @if($subscription->status->value === 'active')
                                        アクティブ
                                    @elseif($subscription->status->value === 'paused')
                                        一時停止中
                                    @else
                                        停止中
                                    @endif
                                </span>

                                <div class="flex gap-2">
                                    <a href="{{ route('subscriptions.show', $subscription) }}"
                                    class="px-4 py-2 bg-gray-500 text-white text-sm rounded hover:bg-gray-600">
                                        詳細
                                    </a>
                                    <a href="{{ route('subscriptions.edit', $subscription) }}"
                                    class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                        編集
                                    </a>
                                    <form action="{{ route('subscriptions.destroy', $subscription) }}"
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
                            登録されているサブスクはありません
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
