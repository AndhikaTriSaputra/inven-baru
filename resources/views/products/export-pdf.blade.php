export-pdf.blade.php

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Products - PDF</title>
        <style>
            body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial, "Apple Color Emoji", "Segoe UI Emoji"; color:#111827; }
            .container { max-width: 900px; margin: 24px auto; }
            h1 { font-size: 22px; margin: 0 0 16px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #e5e7eb; padding: 8px 10px; font-size: 12px; }
            th { background: #f9fafb; text-align: left; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Products</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ ucfirst($r->type) }}</td>
                            <td>{{ $r->brand }}</td>
                            <td>{{ $r->unit }}</td>
                            <td>{{ $r->category }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </body>
</html>