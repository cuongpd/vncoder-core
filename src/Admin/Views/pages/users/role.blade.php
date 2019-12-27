<div class="block">
    <div class="block-content block-content-full">
        @push('menu')
            <a href="{{$link_add}}" title="Create new user" class="pull-right">
                <button type="button" class="btn btn-primary waves-effect waves-light">
                    <span class="btn-label"><i class="fa fa-plus"></i></span> Thêm mới
                </button>
            </a>
            <a href="{{$link_add}}" title="Create new user" class="pull-right">
                <button type="button" class="btn btn-primary waves-effect waves-light">
                    <span class="btn-label"><i class="fa fa-plus"></i></span> Thêm mới
                </button>
            </a>
        @endpush
        <table class="table table-striped b-t text-sm">
            <thead>
            <tr>
                <th width="20"><input type="checkbox"></th>
                <th width="100">Role</th>
                <th width="200">Description</th>
                <th>Permission</th>
                <th width="120">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td><input type="checkbox" value="{{$item->id}}"></td>
                    <td><b>{{$item->name}}</b></td>
                    <td>{{$item->description}}</td>
                    <td>
                        @if($item->id == 1)
                            User có toàn quyền quản trị!
                        @else
                        {{$item->permission}}
                        @endif
                    </td>
                    <td>
                        <a href="{{$link_edit}}?id={{$item->id}}" title="Chỉnh sửa quyền"><i class="fa fa-edit text-success"></i></a>
                        <a href="{{$link_permission}}?id={{$item->id}}" title="Cập nhật quyền"><i class="fa fa-shield-alt text-primary"></i></a>
                        <a href="{{$link_delete}}?id={{$item->id}}" title="Xóa quyền" class="vn-delete"><i class="fa fa-trash text-primary"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>