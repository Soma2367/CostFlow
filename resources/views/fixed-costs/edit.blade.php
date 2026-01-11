<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">固定費編集</h1>
                <p class="text-gray-600 mt-1">既存の固定費を編集しましょう</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('fixed-costs.update', $fixedCost) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="flex flex-wrap -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="cost_name" class="leading-7 text-sm text-gray-600 font-semibold">サービス名 <span class="text-red-500">*</span></label>
                                <input type="text" id="cost_name" name="cost_name" required
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    placeholder="例: Netflix, Spotify"
                                    value="{{ old('cost_name', $fixedCost->cost_name) }}">
                            </div>
                        </div>

                        <div class="p-2 w-1/2">
                            <div class="relative">
                                <label for="amount" class="leading-7 text-sm text-gray-600 font-semibold">月額料金（円） <span class="text-red-500">*</span></label>
                                <input type="number" id="amount" name="amount" required min="0"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    placeholder="1000"
                                    value="{{ old('amount', $fixedCost->amount) }}">
                            </div>
                        </div>

                        <div class="p-2 w-1/2">
                            <div class="relative">
                                <label for="billing_day" class="leading-7 text-sm text-gray-600 font-semibold">支払日 <span class="text-red-500">*</span></label>
                                <select id="billing_day" name="billing_day" required
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <option value="">選択してください</option>
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ (int) old('billing_day', $fixedCost->billing_day) === $i ? 'selected' : '' }}>
                                            毎月{{ $i }}日
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="category" class="leading-7 text-sm text-gray-600 font-semibold">カテゴリー<span class="text-red-500">*</span></label>
                                <input type="text" id="category" name="category" required
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    placeholder="例: エンタメ、趣味"
                                    value="{{ old('category', $fixedCost->category) }}">
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="status" class="leading-7 text-sm text-gray-600 font-semibold">ステータス <span class="text-red-500">*</span></label>
                                <select id="status" name="status" required
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach($statuese as $status)
                                        <option value="{{ $status->value }}"
                                            {{ old('status', $fixedCost->status->value) === $status->value ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="memo" class="leading-7 text-sm text-gray-600 font-semibold">メモ</label>
                                <textarea id="memo" name="memo"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                    placeholder="メモや補足情報を入力できます">{{ old('memo', $fixedCost->memo) }}</textarea>
                            </div>
                        </div>

                        <div class="p-2 w-full flex gap-3">
                            <button type="submit"
                                class="flex-1 text-white bg-blue-500 border-0 py-3 px-8 focus:outline-none hover:bg-blue-600 rounded-lg text-lg font-semibold">
                                更新する
                            </button>
                            <a href="{{ route('fixed-costs.index') }}"
                                class="flex-1 text-center text-gray-700 bg-gray-200 border-0 py-3 px-8 hover:bg-gray-300 rounded-lg text-lg font-semibold">
                                キャンセル
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
