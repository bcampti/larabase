<?php

namespace Bcampti\Larabase\Traits;

trait HasStatus
{
    public static function bootHasStatus()
    {
        static::creating(function($model)
		{
            if( is_empty($model->status) )
			{
				$model->status = static::STATUS_ATIVO;
			}
        });
    }

    public function setStatusAttribute($value)
	{
		if (!is_empty($value))
		{
			if (in_array($value, ['on', 'true', '1', static::STATUS_ATIVO]))
			{
				$this->attributes['status'] = static::STATUS_ATIVO;
			}
			else if (in_array($value, ['off', 'false', '0', static::STATUS_INATIVO]))
			{
				$this->attributes['status'] = static::STATUS_INATIVO;
			}
			else
			{
				$this->attributes['status'] = $value;
			}
		}
		else
		{
			$this->attributes['status'] = null;
		}
	}

    public function isAtivo()
	{
		return !empty($this->status) && $this->status == static::STATUS_ATIVO;
	}
}