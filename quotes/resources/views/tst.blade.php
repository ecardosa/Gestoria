<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Presupuesto Assessoria Barceló, {{$quota->empresa->nomEmpresa}}
    </title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .title {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">
    <div style="width: 80%; margin: 0 auto; padding: 20px;">
        <div style="margin-bottom: 40px;" class="title">
        
            <img src="{{ $logo }}"
            alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
            <div style="margin-bottom: 20px; display: flex; flex-direction: column; width: auto;">
                <p style="margin: 0; font-weight: bold; font-size: 18px;">Assessoria Barceló</p>
                <p style="margin: 0;">Passeig Nou, 9 2-C, 17600,<br>Figueres (GIRONA)</p>
                <p style="margin: 0;">972509812</p>
            </div>
        </div>
        <div style="margin-bottom: 20px; margin-top: 400px; display: flex; flex-direction: column; align-items: center;">
            <h1 style="margin: 0 0 20px; font-size: 24px; font-weight: bold; text-align: center;">
                Presupuesto de prestación de servicios profesionales
            </h1>
            <h2 style="margin: 0 0 20px; font-size: 20px; font-style: italic; text-align: center;">
                {{$quota->empresa->nomEmpresa}}
            </h2>
            <p style="margin: 0; font-size: 16px; text-align: center; color: #333;">
                Propuesta de prestación de servicios profesionales, incluyendo servicios de asesoría, gestión fiscal, mercantil y laboral.
            </p>
        </div>

        <div style="page-break-before: always;"></div>

        <div style="margin-bottom: 20px;">
            <p>
                Después de haber prestado nuestros servicios a la empresa {{$quota->empresa->nomEmpresa}} y de acuerdo con su petición, detallamos los servicios ofrecidos y los nuevos honorarios según la nueva situación laboral de la empresa.
            </p>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed;">
    <thead>
        <tr>
            <th style="width: 40%; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f5f5f5;">Concepto</th>
            <th style="width: 20%; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f5f5f5;">Tipo</th>
            <th style="width: 20%; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f5f5f5;">Unidades</th>
            <th style="width: 20%; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f5f5f5;">Precio</th>
            <th style="width: 20%; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f5f5f5;">Total</th>
        </tr>
    </thead>
            <tbody>
                @foreach ($quota->empresa->registro_concepto as $registro)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{$registro->concepto->nombreConceptoLargo}}</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                    {{ optional($registro->concepto->tipoConcepto)->nombreTipo ?? 'Sin tipo' }}

                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                        {{$registro->unidades}}
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                        {{$registro->concepto->precio}}€
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                        {{$registro->concepto->precio * $registro->unidades}}€
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            <p>
                La cuota mensual resultante de todas las prestaciones indicadas que se realizarán con la nueva situación laboral de la empresa sería de: 
                <strong>
                    {{$quota->empresa->registro_concepto->sum(function($registro){
                        return $registro->concepto->precio * $registro->unidades;
                    })}}€
                </strong>
            </p>

            <p>
                Y, la utilización del programa de la aplicación guay de la Emma, incluyendo las áreas de contabilidad, financiera, analítica y laboral sería de:
            </p>
            <p>
                - Primer acceso: <strong>€50.00</strong>
            </p>
            <p>
                - Por cada acceso extra: <strong>€1M</strong>
            </p>
            <p>Los honorarios no incluyen IVA</p>
        </div>

        <div class="footer" style="margin-top: 20px; display: flex; justify-content: space-between; flex-direction: column; gap: 20px;">
            <p>
                Figueres, a {{$date = date('d \d\e\l m \d\e\l Y')}}
            </p>
            <p>
                Atentamente, {{$user->name}} de Assessoria Barceló
            </p>
            <p>
                {{$quota->empresa->nomEmpresa}}
            </p>

            <p style="margin-top: 20px; font-size: 14px; color: #333; line-height: 1.5;">
                Nota importante: La aceptación de este presupuesto implica la posterior formalización de un contrato de servicios. En dicho contrato se detallarán aspectos como la duración del servicio, posibles variaciones anuales de servicio y precio, impuestos aplicables, forma de pago, y cláusulas de protección de datos conforme a la normativa vigente.
            </p>
        </div>
    </div>
</body>
</html>
