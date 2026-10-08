@include('themes.basic.includes.meta-tags')
<title>{{ pageTitle($__env) }}</title>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BJHXLQ7CVP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BJHXLQ7CVP');
</script>
<link rel="icon" type="image/x-icon" href="{{ asset($themeSettings->general->favicon) }}">
<meta name="monetag" content="846465d6d88928e7437ec9affb8177b0">
<meta name="643be41f477a57ae399bff35cf2ac42801063aae" content="643be41f477a57ae399bff35cf2ac42801063aae" />
<meta name="profiton-domain-verification" content="0683038ab082e2da0970a8266ba1d93ddb8294b19919b85a3efcb48dfb703a47" />