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
                        
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                
                                <div style="text-align:center; margin:0 15px 34px 15px">

                                    {{ $header ?? '' }}

                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                                    </div>

                                </div>

                            </td>

                        </tr>

                        <tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">

                            <td align="start" valign="start" style="padding-bottom: 10px;">

                                <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
                                    
                                    <div style="display:flex">
                                        
                                        <div>
                                            <div>
                                                {{ $subcopy ?? '' }}
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>

                            </td>

                        </tr>

                        {{ $footer ?? '' }}
                                                
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>
