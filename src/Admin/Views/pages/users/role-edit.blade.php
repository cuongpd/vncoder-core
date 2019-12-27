<div class="block">
    <div class="block-content block-content-full">
        <form class="form-horizontal p-x-xs vncoder-form" action="" method="POST" autocomplete="off">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{$data->id}}" />
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label">Tên quyền</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}">
                    <span class="help-block m-b-none">Đặt tên cho quyền quản trị</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label">Mô tả</label>
                    <textarea type="text" class="form-control" id="description" name="description" required="required">{{$data->description}}</textarea>
                    <span class="help-block m-b-none">Mô tả chức năng của quyền quản trị</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button class="btn btn-danger" type="submit"><i class="fa fa-send"></i> Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>