<!doctype html>
            <html>
              <head>
                <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300&display=swap" rel="stylesheet">
                <title>Email</title>
              </head>
              <body>
                <table style="font-family: Fira Sans, sans-serif !important;margin: 0 auto;text-align: center;width: 550px;background: #0f0f0f;border-radius: 10px;padding: 20px 0px 0px;border: none;border-spacing: 0px; margin-top: 140px;">
                    <tbody>
                        <tr>
                            <td><a href="{{ $details['website_link'] }}"><img src="{{$details['application_logo']}}"></a></td>
                        </tr>
                        <tr style="font-size: 40px; font-weight: bold; color: #fff;">
                            <td style="padding-top: 30px;">Thank you!</td>
                        </tr>
                        <tr style="font-size: 20px; color: #fff; font-weight: bold;">
                            <td style="padding-top: 8px;">Hi {{$details['name']}} !</td>
                        </tr>
                        <tr>
                        <td style="color: #fff; padding-top: 8px; padding-bottom: 40px;">Thank you for contacting us! We look forward to being able to assist you.
                         </td>
                        </tr>
                        <tr>
                            <td style="background: #f2b155; padding: 18px 20px; color: #0f0f0f;border-radius: 0px 0px 10px 10px;">{{$details['copyright']}}</td>
                        </tr>
                    </tbody>
                </table>
              </body>
            </html>