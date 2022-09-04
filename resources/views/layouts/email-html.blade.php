@extends('layouts.email')

@section('title', $title)

@section('body')
    <div style="
        max-width: 480px;
        margin: 8px auto 24px;
        text-align: center
    ">
        <div style=" margin: 0 16px">
            <h1 style="
                font-family: notifications-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial,
                        'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
                        'Noto Color Emoji';
                font-size: 16px;
                line-height: 1.2;
                font-size: 18px;
                font-weight: normal;
            ">
                <img
                    style="color: #ecd000"
                    src="{{ asset(mix('images/favicon.png')) }}"
                    alt="Departamento de Cinema e Vídeo da UFF"
                    width="128"
                    height="128"
                />
            </h1>

            <br />

            @foreach ($paragraphs as $paragraph)
                <p style="
                    font-family: notifications-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial,
                        'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
                        'Noto Color Emoji';
                    font-size: 16px;
                    line-height: 1.5;
                    color: #212529;
                ">
                    {{ $paragraph }}
                </p>
            @endforeach
            
            @yield('content')

            <p style="
                font-family: notifications-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial,
                        'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
                        'Noto Color Emoji';
                font-size: 16px;
                line-height: 1.5;
                text-align: center;
                font-size: 21px;
                margin: 32px 0;
            ">
                <a style="
                    display: inline-block;
                    background-color: #006989;
                    color: #fff;
                    border-radius: 4px;
                    text-decoration: none;"
                    href="{{ $url }}"
                >
                    <span style="
                        margin: 10px 16px;
                        font-size: 21px;
                        color: #fff;
                        display: inline-block
                    ">
                        {{ $urlText }}
                    </span>
                </a>
            </p>

            <p style="
                font-family: notifications-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial,
                        'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
                        'Noto Color Emoji';
                line-height: 1.5;
                text-align: center;
            ">
                <small style="
                    font-size: 13px;
                    color: #7a828a;
                ">
                    Esse é um email automático, por favor não o responda.
                </small>
            </p>
        </div>
    </div>
@endsection
