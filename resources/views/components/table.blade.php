<table
    border="1"
    style="
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 32px;
        font-size: 16px;
        color: #212529;
        font-family: notifications-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial,
                        'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
                        'Noto Color Emoji';">
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
