<script type="text/javascript" src="{{url('js/core.min.js')}}?v=1.2"></script>
<script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' }});</script>
<script type="text/javascript" src="{{url('js/app.min.js')}}?v={{TIME_NOW}}"></script>
{!! $extraFooterJS !!}
{!! $extraFooter !!}
@stack('footer')
@if (session('message'))
<script>
    $(document).ready(function () {
        One.helpers('notify', {type: 'success', icon: 'fa fa-check mr-1', message: '{{session("message")}}'});
    });
</script>
@endif