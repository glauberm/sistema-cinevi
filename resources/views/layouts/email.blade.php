<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html
    lang="pt-BR"
    xmlns="http://www.w3.org/1999/xhtml"
    xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office"
>
    <head> </head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="x-apple-disable-message-reformatting" />
        <!--[if !mso]><!-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--<![endif]-->
        <style type="text/css">
            * {
                text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
                -moz-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }

            html {
                height: 100%;
                width: 100%;
            }

            body {
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                mso-line-height-rule: exactly;
            }

            div[style*='margin: 16px 0'] {
                margin: 0 !important;
            }

            table,
            td {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }

            img {
                border: 0;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
            }

            strong {
                font-weight: bold;
            }

            a:hover {
                color: currentColor;
                text-decoration: none;
            }

            .ReadMsgBody,
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
        </style>

        <!--[if gte mso 9]>
            <style type="text/css">
                li {
                    text-indent: -1em;
                }
                table td {
                    border-collapse: collapse;
                }
            </style>
        <![endif]-->

        <title>
            @yield('title')
        </title>

        @yield('head')

        <!-- content -->
        <!--[if gte mso 9
            ]><xml>
                <o:OfficeDocumentSettings>
                    <o:AllowPNG /> <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
            </xml><!
        [endif]-->
    </head>
    <body style="
        background-color: #ffffff;
        margin: 0;
        width: 100%;
        padding: 0;
    ">
        <table style="
            width: 100%;
            background-color: #ffffff;
            margin: 0;"
            border="0"
            align="left"
            bgcolor="#FFFFFF"
            role="presentation"
            width="100%"
            cellpadding="0"
            cellspacing="0"
        >
            <tr>
                <td style="
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue',
                        Arial, 'Noto Sans', Roboto, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
                        'Segoe UI Symbol', 'Noto Color Emoji';
                    line-height: 20px;
                    color: #222222;
                    font-size: 14px;"
                    align="left"
                    width="100%"
                    valign="top"
                >
                    @yield('body')
                </td>
            </tr>
        </table>
        <div style="
            display: none;
            white-space: nowrap;
            font-size: 15px;
            line-height: 0;
        ">
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        </div>
    </body>
</html>
