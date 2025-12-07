<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado - {{ $certificado->actividad->nombre }}</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .certificado-container {
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            background: #fff;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            box-sizing: border-box;
            background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" fill="%239C92AC" fill-opacity="0.05" fill-rule="evenodd"/%3E%3C/svg%3E');
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1a202c;
            font-size: 48px;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin: 0;
            border-bottom: 2px solid #ed8936;
            display: inline-block;
            padding-bottom: 10px;
        }
        .content {
            text-align: center;
            color: #4a5568;
        }
        .text-certifica {
            font-size: 24px;
            margin-bottom: 20px;
            font-style: italic;
        }
        .participant-name {
            font-size: 42px;
            font-weight: bold;
            color: #2d3748;
            margin: 20px 0;
            text-transform: uppercase;
        }
        .activity-name {
            font-size: 32px;
            font-weight: bold;
            color: #4c51bf;
            margin: 10px 0;
        }
        .details {
            font-size: 20px;
            margin-top: 20px;
            line-height: 1.6;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .dates {
            font-weight: bold;
            color: #2b6cb0;
        }
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            width: 250px;
            border-top: 1px solid #718096;
            margin-bottom: 10px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 18px;
            color: #2d3748;
        }
        .signature-role {
            font-size: 14px;
            color: #718096;
        }
        .validation-code {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-family: monospace;
            font-size: 12px;
            color: #a0aec0;
        }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #4c51bf;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }
        .print-btn:hover {
            background: #434190;
        }
        @media print {
            body { 
                background: none; 
                display: block;
                height: 100%;
            }
            .certificado-container {
                width: 100%;
                height: 100%;
                box-shadow: none;
                page-break-after: always;
                padding: 0;
                margin: 0;
            }
            .print-btn {
                display: none;
            }
            @page {
                size: landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="certificado-container">
        <div class="header">
            <h1>Certificado de Participación</h1>
        </div>
        
        <div class="content">
            <p class="text-certifica">Se otorga el presente certificado a:</p>
            
            <div class="participant-name">
                {{ $certificado->user->name }}
            </div>
            
            <p>Por haber participado y aprobado satisfactoriamente en la actividad:</p>
            
            <div class="activity-name">
                {{ $certificado->actividad->nombre }}
            </div>
            
            <div class="details">
                Realizada en modalidad <strong>{{ $certificado->actividad->modalidad }}</strong>
                <br>
                Desde <span class="dates">{{ $certificado->actividad->fecha_inicio->format('d/m/Y') }}</span>
                hasta <span class="dates">{{ $certificado->actividad->fecha_fin->format('d/m/Y') }}</span>
                <br>
                Con una duración total de <strong>{{ $certificado->horas_certificadas }} horas</strong>.
            </div>
        </div>

        <div class="footer">
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-name">Organizador del Evento</div>
                <div class="signature-role">Firma Autorizada</div>
            </div>
            
            <div class="signature">
                <!-- QR Placeholder -->
                <div style="width: 100px; height: 100px; background: #e2e8f0; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; color: #a0aec0; font-size: 10px;">
                    QR CODE
                </div>
                <div class="signature-role">Verificar Autenticidad</div>
            </div>
        </div>

        <div class="validation-code">
            Cód: {{ $certificado->codigo_validacion }}
        </div>
    </div>

    <button onclick="window.print()" class="print-btn">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M19,8H5C3.34,8 2,9.34 2,11V17H6V21H18V17H22V11C22,9.34 20.66,8 19,8M16,19H8V14H16V19M19,12C18.45,12 18,11.55 18,11C18,10.45 18.45,10 19,10C19.55,10 20,10.45 20,11C20,11.55 19.55,12 19,12M18,3H6V7H18V3Z" />
        </svg>
        Imprimir Certificado
    </button>
</body>
</html>
