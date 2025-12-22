<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConviveCloud - Login</title>
    <style>
        html, body { margin:0; padding:0; min-height:100vh; background:#0a0f1a; color:#e5e7eb; font-family:'Inter', sans-serif; }
        .bg-flow {
            position:absolute; inset:0;
            background:
                radial-gradient(900px at 20% 20%, rgba(79,70,229,0.14), transparent 45%),
                radial-gradient(800px at 80% 25%, rgba(16,185,129,0.12), transparent 45%),
                radial-gradient(900px at 50% 80%, rgba(59,130,246,0.12), transparent 45%),
                #0a0f1a;
        }
        .card {
            position:relative; width:100%; max-width:520px;
            background:linear-gradient(140deg, #0f172a 0%, #0b1220 50%, #0f172a 100%);
            border:1px solid rgba(148,163,184,0.08);
            border-radius:20px;
            box-shadow:0 25px 60px rgba(0,0,0,0.45), 0 0 0 1px rgba(255,255,255,0.02);
            padding:32px;
            box-sizing:border-box;
        }
        .input {
            width:100%; padding:12px 14px; border-radius:10px;
            border:1px solid rgba(148,163,184,0.18);
            background:#0a1325; color:#e5e7eb; font-size:14px;
            outline:none; box-sizing:border-box;
        }
        .input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.15); }
        .btn {
            width:100%; padding:12px 0; border:none; border-radius:10px;
            background:linear-gradient(90deg,#6366f1,#4f46e5);
            color:#fff; font-weight:700; cursor:pointer;
            box-shadow:0 15px 30px rgba(79,70,229,0.35);
        }
        .btn:hover { filter:brightness(1.05); }
        .link { color:#93c5fd; text-decoration:none; }
        .link:hover { color:#bfdbfe; }
        .muted { color:#94a3b8; }
        .tiny { font-size:13px; }
    </style>
</head>
<body>
<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; padding:32px;">
    <div class="bg-flow"></div>

    <div class="card">
        <div style="text-align:center; margin-bottom:24px;">
            <div style="display:inline-flex; align-items:center; justify-content:center; width:78px; height:78px; border-radius:18px; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.35); margin-bottom:12px;">
                <img src="{{ asset('img/logo.png') }}" alt="ConviveCloud" style="width:200px; height:200px; object-fit:contain;">
            </div>
            <h1 style="margin:0; color:#e5e7eb; font-size:24px; font-weight:800;">ConviveCloud</h1>
            <p class="muted tiny" style="margin:4px 0 0;">Plataforma de gestión de convivencia escolar</p>
            <p class="muted tiny" style="margin:2px 0 0;">Inicia sesión para continuar</p>
        </div>

        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label for="email" class="muted tiny" style="display:block; margin-bottom:6px;">Correo institucional</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div style="margin-bottom:16px;">
                <label for="password" class="muted tiny" style="display:block; margin-bottom:6px;">Contraseña</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; color:#94a3b8; font-size:13px;">
                <label for="remember_me" style="display:inline-flex; align-items:center; gap:8px;">
                    <input id="remember_me" type="checkbox" name="remember" style="accent-color:#6366f1; width:16px; height:16px;">
                    <span>Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="link tiny" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="btn">Ingresar</button>
        </form>
    </div>
</div>
</body>
</html>
