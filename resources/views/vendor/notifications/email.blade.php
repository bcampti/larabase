@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
<p style="margin-bottom:2px;">{{ $line }}</p>

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p style="margin-bottom:2px;">{{ $line }}</p>

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
<p style="margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:400">{{ $salutation }}</p>
@else
<p style="margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:700">@lang('Regards'), {{ config('app.name') }}</p>
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
<p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
)</p>
<a href="{{$actionUrl}}" target="_blank" style="word-break: break-all; font-size: 14px;">{{$actionUrl}}</a>
@endslot
@endisset
@endcomponent
