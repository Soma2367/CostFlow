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
                    <x-heroicon-o-plus class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-600 mb-2">登録数</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $countSubscriptions }}</p>
                    <p class="text-sm text-gray-500 mt-1">サービス</p>
                </div>

                <div class="bg-blue-600 rounded-lg shadow p-6 text-white">
                    <p class="text-sm mb-2">月額合計</p>
                    <p class="text-4xl font-bold">¥{{ number_format($sum) }}</p>
                    <p class="text-right text-sm mt-1">/月</p>
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
                            <span class="text-2xl font-bold {{ $rankStyle->textClass() }}">{{ $index + 1 }}位</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $subscription->subscription_name }}</span>
                        </div>
                        <p class="font-bold text-gray-800">¥{{ number_format($subscription->amount) }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="{{ $subscription->category->CategoryColor() }}">{{ $subscription->category->label()}}</span> • 毎月{{ $subscription->billing_day }}日
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

             <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden flex-1 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800">支出分析</h2>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-purple-100 text-purple-800">管理画面</span>
                    </div>
                    <div class="p-6 flex-1 flex justify-center items-center min-h-[350px]">
                        @if($chartData)
                          <div
                                id="subScriptionChart"
                                class="w-full"
                                data-series='@json($chartData["series"])'
                    data-labels='@json($chartData["labels"])'
                           >
                           </div>
                        @else
                           <p class="text-gray-400 italic">データが不足しています</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow flex flex-col max-h-[500px]">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                            サブスク一覧（支払日順）
                        </h3>
                    </div>
                    <div class="p-4 overflow-y-auto">
                        @forelse($subscriptions as $subscription)
                            <div class="p-4 mb-3 bg-gray-50 rounded-lg border-l-4 border-purple-500">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-800 mb-1">
                                            {{ $subscription->subscription_name }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $subscription->category->label() }} • 毎月{{ $subscription->billing_day }}日
                                        </p>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-800 mr-4">
                                        ¥{{ number_format($subscription->amount) }}
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
                                                action="{{ route('subscriptions.destroy', $subscription) }}"
                                                method="POST"
                                                onsubmit="return confirm('本当に削除しますか？');">
                                                @csrf
                                                @method('DELETE')
                                               <button type="submit" class="hover:text-red-500">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                               </button>
                                            </form>
                                            <a href="{{ route('subscriptions.edit', $subscription) }}" class="flex items-center hover:text-blue-500">
                                                <x-heroicon-o-pencil-square class="w-5 h-5" />
                                            </a>
                                            <a href="{{ route('subscriptions.show', $subscription) }}"  class="flex items-center hover:text-green-500">
                                                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                                            </a>
                                        </div>
                                    </div>

                                     <div class="flex items-center gap-2">
                                        @if($subscription->memo)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                <x-heroicon-o-check class="w-4 h-4" />
                                                メモ
                                            </span>
                                        @endif

                                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full {{ $subscription->status->statusColor() }}">
                                            {{ $subscription->status->label() }}
                                        </span>
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
    </div>
</x-app-layout>
