@extends('emails.layout')

@section('content')
<tr>
    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
        
        <div style="text-align:center; margin:0 15px 34px 15px">
        
            <div style="margin-bottom: 10px">
                <a href="{{route('home')}}" rel="noopener" target="_blank">
                    <img alt="Logo" src="{{asset('assets/media/email/logo.svg')}}" style="height: 35px">
                </a>
            </div>
        
            <div style="margin-bottom: 15px">
                <img alt="Logo" src="{{asset('assets/media/email/icon-positive-vote-1.svg')}}">
            </div>
        
            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Ola {{$userInvitation->name}}, seja bem vindo ao {{config('app.name')}}!</p>
                <p style="margin-bottom:2px; color:#7E8299">Para ativar a sua conta clique no botão "Verificar E-mail".</p>
                <p style="margin-bottom:2px; color:#7E8299">Se você não criou a conta, favor desconsiderar este e-mail.</p>
            </div>

            <a href="{{$url}}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Verificar E-mail</a>
        
        </div>

    </td>

</tr>

<tr style="display: flex; justify-content: center; margin:0 60px 15px 60px">

    <td align="start" valign="start" style="padding-bottom: 10px;">

        <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
            
            <div style="display:flex">
                
                <div>
                    <div>
                        <p style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Verificar E-mail</p>
                        <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">
                            Se você estiver com problemas para clicar no botão "Verificar E-mail", copie e cole o URL abaixo em seu navegador da web:
                        </p>
                        <a href="{{$url}}" target="_blank" style="word-break: break-all; font-size: 14px;">{{$url}}</a>
                    </div>
                </div>
            </div>
            
        </div>

    </td>

</tr>
@endsection