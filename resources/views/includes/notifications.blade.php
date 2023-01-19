<script type="text/javascript">
$(function() {
    @if(Session::has('info'))
    Dashmix.helpers('jq-notify', {type: 'info', icon: 'fa fa-info-circle me-1', message: '{{ Session::get('success') }}'});
    @endif

    @if(Session::has('success'))
    Dashmix.helpers('jq-notify', {type: 'success', icon: 'fa fa-check me-1', message: '{{ Session::get('success') }}'});
    @endif

    @if(Session::has('warning'))
    Dashmix.helpers('jq-notify', {type: 'warning', icon: 'fa fa-exclamation me-1', message: '{{ Session::get('warning') }}'});
    @endif

    @if(Session::has('error'))
    Dashmix.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: '{{ Session::get('error') }}'});
    @endif

    @if($errors->any())
    @foreach($errors->all() as $error)
    Dashmix.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: '{{ $error }}'});
    @endforeach
    @endif
});
</script>