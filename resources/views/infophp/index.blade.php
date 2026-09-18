<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Info PHP</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f5f5f5; margin: 0; padding: 24px; color: #1f2933; }
        .container { max-width: 960px; margin: 0 auto; }
        h1 { margin-top: 0; }
        .card { background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .card h2 { margin-top: 0; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { text-align: left; padding: 8px 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        th { width: 240px; color: #52606d; }
        .badge { display: inline-block; background: #eef2ff; color: #3730a3; border-radius: 4px; padding: 2px 8px; margin: 2px; font-size: 12px; font-family: monospace; }
        code { background: #f0f0f0; border-radius: 4px; padding: 1px 6px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Info PHP</h1>

        <div class="card">
            <h2>Runtime</h2>
            <table>
                <tr><th>PHP Version</th><td><code>{{ $phpVersion }}</code></td></tr>
                <tr><th>Operating System</th><td>{{ $phpOs }}</td></tr>
                <tr><th>SAPI</th><td>{{ $phpSapi }}</td></tr>
                <tr><th>Binary</th><td><code>{{ $phpBinary }}</code></td></tr>
            </table>
        </div>

        <div class="card">
            <h2>Loaded Extensions ({{ count($extensions) }})</h2>
            <p>
                @foreach($extensions as $extension)
                    <span class="badge">{{ $extension }}</span>
                @endforeach
            </p>
        </div>

        <div class="card">
            <h2>Key ini Settings</h2>
            <table>
                @foreach($iniSettings as $key => $value)
                    <tr><th>{{ $key }}</th><td><code>{{ $value }}</code></td></tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>