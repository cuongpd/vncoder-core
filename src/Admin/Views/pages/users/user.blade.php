<div class="block-content-full">
    <div class="table-responsive">
        @push('menu')
            @if($linkCreate)
                <a href="{{$linkCreate}}" title="Thêm mới">
                    <button type="button" class="btn btn-primary waves-effect waves-light ma-ri-10">
                        <span class="btn-label"><i class="fa fa-plus"></i></span> Thêm mới
                    </button>
                </a>
            @endif
            @if($linkExport)
                <a href="{{$linkExport}}" title="Export">
                    <button type="button" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-file-export"></i></span> Export
                    </button>
                </a>
            @endif
        @endpush
        <table class="table table-striped js-table-checkable table-hover table-vcenter" id="table-query">
            <thead>
            <tr>
                <th width="20">
                    <div class="custom-control custom-checkbox d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="check-all" name="check-all">
                        <label class="custom-control-label" for="check-all"></label>
                    </div>
                </th>
                <th>Avatar</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Info</th>
                <th width="120">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox d-inline-block">
                            <input type="checkbox" class="custom-control-input" id="user-{{$item->id}}" name="users[]" value="{{$item->id}}">
                            <label class="custom-control-label" for="user-{{$item->id}}"></label>
                        </div>
                    </td>
                    <td><img src="{{$item->avatar_url}}" style="height:40px;width:40px;"></td>
                    <td>{!! $item->name !!}</td>
                    <td>{!! $item->email !!}</td>
                    <td>{!! $item->role_name !!}</td>
                    <td>{!! $item->phone !!}</td>
                    <td>
                        <a href="{{$linkEdit}}?id={{$item->id}}" title="Edit"><i class="fa fa-edit fa-2x text-info"></i></a>
                        @if($item->status > 0)
                            <a href="{{$linkLock}}?id={{$item->id}}" title="Lock User" class="confirm-click" message="Bạn có muốn khóa user {{$item->name}}"><i class="fa fa-unlock-alt fa-2x text-danger"></i></a>
                        @else
                            <a href="{{$linkUnlock}}?id={{$item->id}}" title="Unlock User" class="confirm-click" message="Xác nhận mở khóa cho user : {{$item->name}}"><i class="fa fa-lock fa-2x text-primary"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="block-content">
    {!! $data->appends(request()->except('page'))->links('admin::core.paginate.bootstrap') !!}
</div>
@push('footer')
    <script>jQuery(function(){ One.helpers(['table-tools-checkable']); });</script>
@endpush