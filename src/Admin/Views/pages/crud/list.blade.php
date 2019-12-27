@push('menu')
    <a href="{{$linkEdit}}" title="Thêm mới">
        <button type="button" class="btn btn-primary waves-effect waves-light ma-ri-10">
            <span class="btn-label"><i class="fa fa-plus"></i></span> Thêm mới
        </button>
    </a>
@endpush
<div class="block-content-full">
    <div class="table-responsive">
        <table class="table table-striped js-table-checkable table-hover table-vcenter dataTable">
            <thead>
            <tr>
                <th class="text-center" style="width:50px;">
                    <div class="custom-control custom-checkbox d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="check-all" name="check-all">
                        <label class="custom-control-label" for="check-all"></label>
                    </div>
                </th>
                @foreach($dataField as $key)
                    @if($key == $orderBy)
                        @if($sortBy == 'asc')
                            <th class="sorting_asc"><a href="{{$pageUrl}}?orderBy={{$key}}&sortBy=desc">{{str_replace("_", " ", $key)}}</a></th>
                        @else
                            <th class="sorting_desc"><a href="{{$pageUrl}}?orderBy={{$key}}&sortBy=asc">{{str_replace("_", " ", $key)}}</a></th>
                        @endif
                    @else
                        <th class="sorting"><a href="{{$pageUrl}}?orderBy={{$key}}&sortBy=desc">{{str_replace("_", " ", $key)}}</a></th>
                    @endif
                @endforeach
                <th class="text-center pull-right" style="width: 100px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
            <tr>
                <th class="text-center">
                    <div class="custom-control custom-checkbox d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="model-{{$item->id}}" name="model[]" value="{{$item->id}}">
                        <label class="custom-control-label" for="model-{{$item->id}}"></label>
                    </div>
                </td>
                @foreach($dataField as $key)
                <td>{!! $item->$key !!}</td>
                @endforeach
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{$linkEdit}}?id={{$item->id}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                        <a href="{{$linkDelete}}?id={{$item->id}}" class="btn btn-sm btn-danger confirm-click" message="Bạn có muốn xóa bản ghi {{$item->id}}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </div>
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
    <script>
        $( document ).ready(function() {
            One.helpers(['table-tools-checkable']);
        });
    </script>
@endpush