<html>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
<body style="font-family:Cairo !important;direction:rtl;background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width: 500px;margin:50px auto 10px;background-color:#fff;padding: 10px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px rgb(121, 127, 129);">
    <thead>
      <tr>
        <th style="padding:10px;">
            <span style="display: block">{{ date('Y-m-d') }}</span>
            <img style="width: 200px;height: 100px;border-radius: 10px;" src="
                @if(get_setting('logo'))
                {{ asset(get_setting('logo')) }}
                @else
                {{ asset('/images/default.jpg') }}
                @endif
            " alt="logo">
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td style="padding:20px;vertical-align:top; justify-content: space-between;">
            <ul  style="list-style-type: none; margin:0;padding:0;">
                <li style="display:flex; align-items:center">
                    <h2 style="background-color:#e7e7e7;margin:0;border-radius: 10px;padding: 5px 10px;font-size: 16px;">الشركة</h2>
                    <h3 style="background: #4d4e4e;
                    color: #fff;
                    border-radius: 10px;margin:0;margin-right:10px;padding: 5px 10px;font-size:16px;">{{ $data['customer_name'] }}</h3>
                </li>
                <li style="display:flex; align-items:center; margin-top:10px">
                    <h2 style="background-color:#e7e7e7;margin:0;border-radius: 10px;padding: 5px 10px;font-size: 16px;">أسم المركب</h2>
                    <h3 style="background: #4d4e4e;
                    color: #fff;
                    border-radius: 10px;margin:0;margin-right:10px;padding: 5px 10px;font-size:16px;">{{ $data['name'] }}</h3>
                </li>
                <li style="display:flex; align-items:center; margin-top:10px">
                    <h2 style="background-color:#e7e7e7;margin:0;border-radius: 10px;padding: 5px 10px;font-size: 16px;">الحالة</h2>
                    <h3 style="background: #4d4e4e;
                    color: #fff;
                    border-radius: 10px;margin:0;margin-right:10px;padding: 5px 10px;font-size:16px;">{{ $data['status_name'] }}</h3>
                </li>
                <li style="display:flex; align-items:center; margin-top:10px">
                    <h2 style="background-color:#e7e7e7;margin:0;border-radius: 10px;padding: 5px 10px;font-size: 16px;">القسم الرئيسى</h2>
                    <h3 style="background: #4d4e4e;
                    color: #fff;
                    border-radius: 10px;margin:0;margin-right:10px;padding: 5px 10px;font-size:16px;">{{ $data['category_name'] }}</h3>
                </li>
                @if(isset($data['sub_category_name']))
                    <li style="display:flex; align-items:center; margin-top:10px">
                        <h2 style="background-color:#e7e7e7;margin:0;border-radius: 10px;padding: 5px 10px;font-size: 16px;">القسم الفرعى</h2>
                        <h3 style="background: #4d4e4e;
                        color: #fff;
                        border-radius: 10px;margin:0;margin-right:10px;padding: 5px 10px;font-size:16px;">{{ $data['sub_category_name'] }}</h3>
                    </li>
                @endif
            </ul>
        </td>
      </tr>
      @if(isset($data['details']))
        <tr>
            <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
            <p style="font-size:14px;margin:0 0 6px 0;">
                <span style="font-weight:bold;display:inline-block;min-width:150px">تفاصيل المركب</span>
                <b style="color:green;font-weight:normal;margin:0">{{ $data['details'] }}</b>
                </p>
            </td>
        </tr>
      @endif
    </tbody>
  </table>
</body>

</html>
