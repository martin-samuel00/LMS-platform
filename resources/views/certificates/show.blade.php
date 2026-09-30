<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $certificate->certificate_code }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Inter:wght@400;500;600&family=Pinyon+Script&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #0f172a;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            font-family: 'Inter', sans-serif;
        }

        .action-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
        }
        .btn-print {
            background: #eab308;
            color: #713f12;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back {
            background: #334155;
            color: #f8fafc;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .certificate-container {
            width: 860px;
            height: 600px;
            background: #fffdfa;
            border: 12px solid #ca8a04;
            padding: 30px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .inner-border {
            border: 2px solid #ca8a04;
            height: 100%;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .cert-header {
            font-family: 'Cinzel', serif;
            font-size: 16px;
            letter-spacing: 5px;
            color: #854d0e;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .cert-title {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 3px;
            color: #1e293b;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .cert-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-top: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .student-name {
            font-family: 'Pinyon Script', cursive;
            font-size: 52px;
            color: #1e1b4b;
            border-bottom: 2px solid #e2e8f0;
            padding: 0 40px 6px;
            display: inline-block;
            margin-top: 8px;
        }

        .cert-body {
            font-size: 15px;
            color: #475569;
            max-width: 600px;
            line-height: 1.6;
            margin-top: 10px;
        }

        .cert-course {
            font-weight: 700;
            color: #0f172a;
            font-size: 18px;
            display: block;
            margin-top: 4px;
        }

        .cert-footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 24px;
            padding: 0 20px;
        }

        .sig-block {
            text-align: center;
            width: 220px;
        }
        .sig-line {
            border-top: 1.5px solid #94a3b8;
            padding-top: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }
        .sig-sub {
            font-size: 11px;
            color: #64748b;
        }

        .seal {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #713f12;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            border: 3px dashed #fff;
        }
        .seal span {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .seal strong {
            font-size: 13px;
        }

        .cert-code {
            position: absolute;
            bottom: 6px;
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 1px;
            font-family: monospace;
        }

        @media (max-width: 880px) {
            body {
                padding: 14px 8px;
                justify-content: flex-start;
            }
            .cert-viewport-wrapper {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                display: flex;
                justify-content: flex-start;
                padding-bottom: 24px;
            }
        }

        @media print {
            body { background: transparent; padding: 0; }
            .action-bar { display: none; }
            .certificate-container { box-shadow: none; width: 100%; height: 95vh; border-width: 8px; }
        }
    </style>
</head>
<body>
    <div class="action-bar">
        <a href="javascript:history.back()" class="btn-back">&larr; Go Back</a>
        <button onclick="window.print()" class="btn-print">🖨️ Print / Save as PDF</button>
    </div>

    <div class="cert-viewport-wrapper">
        <div class="certificate-container">
        <div class="inner-border">
            <div>
                <div class="cert-header">Official Recognition</div>
                <div class="cert-title">{{ $certificate->title }}</div>
                <div class="cert-subtitle">This is proudly awarded to</div>
            </div>

            <div>
                <div class="student-name">{{ $certificate->user->name }}</div>
            </div>

            <div class="cert-body">
                For outstanding dedication, performance, and successful completion of all requirements for the course:
                <span class="cert-course">{{ $certificate->classroom->name }}</span>
            </div>

            <div class="cert-footer">
                <div class="sig-block">
                    <div class="sig-line">{{ $certificate->classroom->teacher->name }}</div>
                    <div class="sig-sub">Instructor / Teacher</div>
                </div>

                <div class="seal">
                    <span>Official</span>
                    <strong>ACADEMY</strong>
                    <span>Verified</span>
                </div>

                <div class="sig-block">
                    <div class="sig-line">{{ $certificate->issued_at->format('F d, Y') }}</div>
                    <div class="sig-sub">Date of Issuance</div>
                </div>
            </div>

            <div class="cert-code">
                Verification Code: {{ $certificate->certificate_code }} &bull; Classroom: {{ $certificate->classroom->code }}
            </div>
        </div>
    </div>
    </div>
</body>
</html>
