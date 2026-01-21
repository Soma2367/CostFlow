<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">管理画面</h1>
                    <p class="text-gray-600 mt-1"></p>
                </div>

                <div class="flex">
                        <div>収入</div>
                        <div>
                            @if($income->isEmpty())
                              ¥0
                            @else
                              ¥{{ number_format($income->first()->amount) }}
                            @endif
                        </div>
                </div>

                <x-income-modal />
            </div>
        </div>
    </div>
</x-app-layout>
