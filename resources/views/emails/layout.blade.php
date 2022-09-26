<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
</head>
<body class="app-blank">

    <div class="d-flex flex-column flex-root">
    
        <div id="#kt_app_body_content" style="background-color:#F7F2EF; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
    
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        
                        @yield("content")
                        
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                                <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">Atenciosamente, Equipe {{config('app.name')}}!</p>
                                <p style="margin-bottom:2px; color:#5E6278;">Tem alguma dúvida?</p>
                                <p style="margin-bottom:4px; color:#5E6278;">Entre em contato conosco pelo WhatsApp (45)99107-5504 ou ligue (45)3264-0991.</p>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p style="color:#5E6278;">© {{config('app.name')}}. Todos os direitos reservados.</p>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>
</html>
