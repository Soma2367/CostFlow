<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">サブスク詳細</h1>
                <p class="text-gray-600 mt-1">サブスクリプションの詳細情報</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <div class="mb-4">
                    <label class="text-sm text-gray-600 font-semibold block mb-2">サービス名</label>
                    <p class="text-2xl font-bold text-gray-800">{{ $fixedCost->cost_name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-600 font-semibold block mb-2">月額料金（円）</label>
                        <p class="text-2xl font-bold text-gray-800">¥{{ number_format($fixedCost->amount) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 font-semibold block mb-2">支払日</label>
                        <p class="text-2xl font-bold text-gray-800">毎月{{ $fixedCost->billing_day }}日</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-600 font-semibold block mb-2">カテゴリー</label>
                    <p class="text-base text-gray-800">{{ $fixedCost->category }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-600 font-semibold block mb-2">ステータス</label>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded">
                        {{ $fixedCost->status->label() }}
                    </span>
                </div>

                @if($fixedCost->memo)
                    <div class="mb-4">
                        <label class="text-sm text-gray-600 font-semibold block mb-2">メモ</label>
                        <div class="bg-gray-100 rounded p-3 border border-gray-300">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $fixedCost->memo }}</p>
                        </div>
                    </div>
                @endif

                <div class="pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-500 space-y-1">
                        <p>登録日: {{ $fixedCost->created_at->format('Y年m月d日 H:i') }}</p>
                        <p>更新日: {{ $fixedCost->updated_at->format('Y年m月d日 H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('fixed-costs.edit', $fixedCost) }}"
                class="flex-1 flex items-center justify-center text-white bg-blue-500 py-3 px-8 rounded-lg hover:bg-blue-600 font-semibold">
                    編集する
                </a>
                <form action="{{ route('fixed-costs.destroy', $fixedCost) }}"
                    method="POST"
                    class="flex-1"
                    onclick="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center justify-center text-white bg-red-500 py-3 px-8 rounded-lg hover:bg-red-600 font-semibold">
                        削除する
                    </button>
                </form>
            </div>

            <div class="mt-4">
                <a href="{{ route('fixed-costs.index') }}"
                   class="block text-center text-gray-700 bg-gray-200 py-3 px-8 rounded-lg hover:bg-gray-300 font-semibold">
                    一覧に戻る
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
