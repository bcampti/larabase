<?php

namespace Bcampti\Larabase\Traits;

use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Support\Facades\Session;

trait KeepOnSession
{
	public abstract static function sessionKey();
    
    public function makeCurrent(): static
    {
        if ($this->isCurrent()) {
            return $this;
        }

        static::forgetCurrent();

        Session::put(static::sessionKey(), $this);

        return $this;
    }

    public static function currentId()
    {
        $currentTenant = static::current();

        if (is_null($currentTenant)) {
            throw new GenericMessage("Não foi possível identificar a organização para esta ação!");
        }

        return $currentTenant->id;
    }

    public static function current(): ?static
    {
        if (!Session::has(static::sessionKey())) {
            return null;
        }

        return Session::get(static::sessionKey());
    }

    public static function checkCurrent(): bool
    {
        return static::current() !== null;
    }

    public function isCurrent(): bool
    {
        return static::current()?->getKey() === $this->getKey();
    }

    public function forget(): static
    {
        Session::forget(static::sessionKey());
        Session::forget('id_organizacao');

        return $this;
    }

    public static function forgetCurrent()
    {
        $currentTenant = static::current();

        if (is_null($currentTenant)) {
            return null;
        }

        $currentTenant->forget();

        return $currentTenant;
    }
}