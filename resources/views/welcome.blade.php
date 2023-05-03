<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JS Tracker</title>
</head>

<body>
    <script>
        var App = {
            conversionType: '',
            // Defining the convertion type
            conversion: function(type) {
                this.conversionType = type;
            },
            // Adding track function with param `trackingConfigObj`
            track: function(trackingConfigObj) {
                var queryParams = {
                    cid: trackingConfigObj.campaignId,
                    crid: trackingConfigObj.creativeId,
                    bid: trackingConfigObj.browserId,
                    did: trackingConfigObj.deviceId,
                    cip: trackingConfigObj.clientIp,
                    conv: this.getConversionCode(this.conversionType)
                };
                var queryString = this.buildQueryString(queryParams);
                // generating image link
                var img = new Image();
                img.src = 'http://127.0.0.1:8000/track?' + queryString;
                img.height = 0;
                img.width = 0;
                document.body.appendChild(img);
            },
            // getting code, default = 'imp'
            getConversionCode: function(type) {
                var conversionCodes = {
                    post_impression: 'imp',
                    post_click: 'clk'
                };
                return conversionCodes[type] || 'imp';
            },
            // building query param
            buildQueryString: function(params) {
                var queryString = '';
                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        queryString += encodeURIComponent(key) + '=' + encodeURIComponent(params[key]) + '&';
                    }
                }
                return queryString.slice(0, -1);
            }
        }
    </script>
    <!-- do not edit below this line -->
    <script>
        App.conversion("post_impression");
        // should support more potential conversion types e.g. post_impression, post_click
    </script>
    <!--
      config of track (trackingConfigObj) method should be mapped to url query parameters e.g.
      campaignId -> cid
      creativeId -> crid
      browserId -> bid
      deviceId -> did
      clientIp -> cip
      conv -> ??? (comes from App.conversion type param, where “post_impression” -> “imp”, …)
    -->
    <script>
        App.track({
            campaignId: 4235,
            creativeId: 23423,
            browserId: 5,
            deviceId: 8,
            clientIp: '78.60.201.201'
        });
    </script>
</body>

</html>
