<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<link rel="shortcut icon" href="{{url('images/favicon.ico')}}">
<title>{{$metaData->title}}</title>
<meta name='description' content='VnCoder CMS'/>
<meta name="robots" content="nofollow"/>
<meta name="copyright" content="VnCoder"/>
<base href="{{$metaData->baseUrl}}">
<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap&subset=vietnamese" rel="stylesheet">
{!! $extraHeaderCSS !!}
<link href="{{url('css/style.min.css')}}?v={{TIME_NOW}}" rel="stylesheet" type="text/css" />
<script>const BASE_URL = '{{$metaData->baseUrl}}', CURRENT_URL = '{{url()->current()}}', TIME_NOW = '{{TIME_NOW}}',
        FILE_MANAGER_URL = '{{BASE_URL.'manager/'}}', FILE_MANAGER_KEY = '{{FILE_MANAGER_KEY}}';</script>
{!! $extraHeader !!}
{!! $extraHeaderJS !!}