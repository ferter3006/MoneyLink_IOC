<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Informe Mensual de Sala</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        .header-moneylink {
            max-width: 900px;
            margin: 32px auto 32px auto;
            padding: 24px 0 16px 0;
            border-radius: 12px;
            background: #2dce89;
            text-align: center;
            color: #fff;
        }
        .header-moneylink-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .header-moneylink-title {
            font-size: 2.2em;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .header-moneylink-subtitle {
            font-size: 1em;
            font-weight: normal;
            margin-top: 6px;
            letter-spacing: 1px;
        }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 32px;
        }

        h1 {
            color: #2d6a4f;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #555;
            margin-bottom: 24px;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            background: #e9f5ec;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 32px;
        }

        .summary-item {
            text-align: center;
            flex: 1;
        }

        .summary-item:not(:last-child) {
            border-right: 1px solid #cce3d6;
        }

        .summary-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #40916c;
        }

        .summary-label {
            color: #555;
            font-size: 14px;
        }

        .section-title {
            font-size: 20px;
            color: #2d6a4f;
            margin-top: 32px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: #40916c;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f0f7f4;
        }

        .footer {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-top: 24px;
        }

        .user-role {
            font-size: 13px;
            color: #888;
            background: #e9f5ec;
            border-radius: 6px;
            padding: 2px 8px;
            margin-left: 8px;
        }

        .balance-positive {
            color: #40916c;
            font-weight: bold;
        }

        .balance-negative {
            color: #d90429;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header-moneylink">        
        <div class="header-moneylink-title">Money-Link</div>
        <div class="header-moneylink-subtitle">Tu app de gestión financiera colaborativa</div>
    </div>
    <div class="container">
        <h1>Informe de Sala: {{ $sala->name }}</h1>
        <div class="subtitle">Fecha: {{ $mes }}/{{ $año }}</div>

        <table style="width:100%; margin-bottom:32px; text-align:center;">
            <tr>
                <th>Ingresos</th>
                <th>Gastos</th>
                <th>Balance</th>
                <th>Objetivo Común</th>
            </tr>
            <tr>
                <td><span class="summary-value">{{ number_format($sala->ingresos, 2) }}</span></td>
                <td><span class="summary-value">{{ number_format($sala->gastos, 2) }}</span></td>
                <td><span class="summary-value {{ $sala->balance >= 0 ? 'balance-positive' : 'balance-negative' }}">{{ number_format($sala->balance, 2) }}</span></td>
                <td><span class="summary-value">{{ $sala->objetivo }}</span></td>
            </tr>
        </table>

        <div class="section-title">Usuarios en la Sala</div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sala->usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario['name'] }}</td>
                        <td><span class="user-role">{{ $usuario['sala_role'] }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Tiquets del Mes</div>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Ingreso/Gasto</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sala->tiquets as $tiquet)
                    <tr>
                        <td>{{ $tiquet['user_name'] }}</td>
                        <td>{{ $tiquet['category_name'] }}</td>
                        <td>{{ $tiquet['description'] }}</td>
                        <td>{{ $tiquet['es_ingreso'] ? 'Ingreso' : 'Gasto' }}</td>
                        <td>{{ number_format($tiquet['amount'], 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($tiquet['created_at'])->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Informe generado el {{ date('d/m/Y') }} &mdash; MoneyLink IOC
        </div>
    </div>
</body>

</html>