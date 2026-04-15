<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->incrementAttempts();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {


            throw ValidationException::withMessages([
                'email' => 'Correo electrónico o contraseña incorrectos.',
            ]);
        }

        $this->clearAttempts();
    }

    /**
     * Verifica si el usuario ha excedido los intentos permitidos
     */
    public function ensureIsNotRateLimited(): void
    {
        $maxAttempts = 3;      // Intentos máximos
        $decayMinutes = 5;     // Minutos de bloqueo

        $attempts = $this->getAttempts();

        if ($attempts <= $maxAttempts) {
            return;
        }

        event(new Lockout($this));

        // 👇 CALCULAR EL TIEMPO RESTANTE MANUALMENTE
        $minutesLeft = $decayMinutes;  // Mostrar el tiempo configurado

        throw ValidationException::withMessages([
            'email' => "Demasiados intentos fallidos. Por favor, espera {$minutesLeft} minuto(s) antes de intentar nuevamente.",
        ]);
    }

    /**
     * Incrementa el contador de intentos fallidos
     */
    protected function incrementAttempts(): void
    {
        $key = $this->throttleKey();
        $decayMinutes = 5;     // Tiempo de bloqueo en minutos

        $attempts = Cache::get($key, 0);
        $attempts++;

        Cache::put($key, $attempts, now()->addMinutes($decayMinutes));
    }

    /**
     * Obtiene el número de intentos fallidos
     */
    protected function getAttempts(): int
    {
        return Cache::get($this->throttleKey(), 0);
    }

    /**
     * Limpia los intentos fallidos
     */
    protected function clearAttempts(): void
    {
        Cache::forget($this->throttleKey());
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return 'login_attempts_' . Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
