@if (session('message'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <i class="icon-ban-circle"></i><strong>Message!</strong> {{session('message')}}
    </div>
@endif