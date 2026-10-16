<x-guest-layout>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <div class="checkbox-row" style="margin-bottom:18px;">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin:0;">Remember me</label>
        </div>

        <div class="row">
            <a href="{{ route('register') }}" class="link">Create account</a>
            <button type="submit" class="btn" style="width:auto;padding:10px 24px;">Log in</button>
        </div>
    </form>
</x-guest-layout>
