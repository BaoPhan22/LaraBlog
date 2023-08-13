<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Cảm ơn vì bạn đã trở thành thành viên của chúng tôi, bạn hãy xác thực email để đảm bảo an toàn cho tài khoản của bạn.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Chúng tôi đã gửi mail xác thực cho bạn. Hãy kiểm tra hộp thư và xác thực bạn nhé.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Chưa nhận được mã xác thực? Gửi lại.') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>
</x-guest-layout>
