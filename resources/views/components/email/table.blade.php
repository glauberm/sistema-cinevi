<table
    border="1"
    style="
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 32px;
        font-size: 16px;
        color: #212529;
        font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;">
    <thead>
        <tr>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
