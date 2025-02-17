<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
            @font-face {
                font-family: "source_sans_proregular";           
                src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
                font-weight: normal;
                font-style: normal;
            }        
            body{
                margin:0px;
                padding-top:10px;
                font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
            }
            .doctitle{
                font-size:16px;
                text-align:center;
                font-weight:bold;
            }
            .contenido{
                margin:20px;
                font-size: 14px;
            }
            .txtcert{
                text-align:justify !important;
            }
            .footer{
                margin-bottom: -500px;
                margin-left:-50px;
                width:600;
            }
            .ft{
                width:1200px;
                height:290px;
                background-image: url("http://granamericasusme.co/certificadosgau/public/assets/img/footer_cert.jpg");
                background-color:red;
                display:block;
                margin-left:-65px;
                background-repeat: no-repeat;
            }
    </style>
    </head>
    <body>
        <img width="700" src="http://granamericasusme.co/certificadosgau/public/assets/img/header_payroll2.png">

        <div class="contenido">
            <p class="doctitle">GRAN AMERICAS USME S.A.S<br/>NIT.: 901353051 – 9<br/><br/><br/>CERTIFICA<br/><br/></p>
            <p class="txtcert">Que el señor (a) {{$user->name}} {{$user->last_name}}, identificado(a) con C.C. No. {{$user->document}}, labora para la compañía desde el 
                {{$register->values[1]->value_register}}, desempeñando en la actualidad el cargo de {{$register->values[2]->value_register}}, 
                con un contrato a {{$register->values[3]->value_register}}, devengando un salario básico mensual de {{$register->values[5]->value_register}} M/CTE 
                (${{$register->values[4]->value_register}}), 
                @if( strpos( $register->values[3]->value_register, "operativo" ) != FALSE )
                y una bonificación variable por resultado, de acuerdo con la calidad del servicio en la operación. 
                @endif
                Se expide a solicitud del interesado en la fecha {{$today}}.
<br/><br/>
Cualquier información adicional con gusto será suministrada en el correo electrónico johanna.casilimas@granamericasusme.co
<br/><br/>
Cordialmente,</p>
<br/><br/><br/><br/>
        <img width="210" src="http://granamericasusme.co/certificadosgau/public/assets/img/sign_cert2.png">
        <br/>
        Martha Yecenia Martínez Moyano<br/>Coordinador de nómina
        <div class="ft">
        </div>
        <!--<img class="footer" src="http://granamericasusme.co/certificadosgau/public/assets/img/footer_cert.jpg">-->
    </body>
</html>