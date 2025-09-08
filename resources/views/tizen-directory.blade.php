<!DOCTYPE html>
<html>
<head>
    <title>Index of /Tizen/</title>
    <style>
        body { font-family: monospace; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Index of /Tizen/</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Last Modified</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr>
                <td><a href="{{ $file['url'] }}">{{ $file['name'] }}</a></td>
                <td>{{ number_format($file['size']) }}</td>
                <td>{{ $file['last_modified'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
