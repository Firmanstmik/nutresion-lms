<div class="login-card">
    @if($errors->any())
    <div class="err-alert">
        <i class="fas fa-exclamation-circle"></i>
        <p>{{ $errors->first() }}</p>
    </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <div class="fg">
            <label for="identity" class="fl">Nama Lengkap</label>
            <div class="fw">
                <span class="fi-ic"><i class="fas fa-user"></i></span>
                <input type="text" name="identity" required
                    value="{{ old('identity') }}"
                    placeholder="Tulis nama lengkap kamu di sini ya"
                    class="fi">
            </div>
        </div>

        <div class="fg">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <label class="fl" style="margin-bottom:0;">NISN</label>
            </div>
            <div class="fw">
                <span class="fi-ic"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" required
                    placeholder="Ketik nomor NISN kamu"
                    class="fi nisn-field" style="padding-right:40px;">
                <button type="button" class="fi-tog nisn-toggle">
                    <i class="fas fa-eye-slash eye-icon"></i>
                </button>
            </div>
        </div>

        <div class="rem-row">
            <label class="rem-lbl">
                <input type="checkbox" name="remember" class="rem-chk">
                <span class="rem-txt">Ingat Saya</span>
            </label>
            <a href="#" class="fog-lnk">Lupa NISN?</a>
        </div>

        <button type="submit" class="btn-sub">
            Mulai Belajar Sekarang!
            <i class="fas fa-arrow-right" style="font-size:11px;"></i>
        </button>
    </form>

    <hr class="dv">
    <p class="qt">"Setiap langkah kecil hari ini membawa perubahan besar di masa depan."</p>
</div>
