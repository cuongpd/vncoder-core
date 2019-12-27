<div class="row">
    <div class="col-12">
        @foreach($roleData as $name => $role)
            <h3 class="sub-header">Quyền quản trị {{$name}}</h3>
            <div class="row">
                @foreach($role as $key => $items)
                    <div class="col-sm-2">
                        <div class="checkbox checkbox-success mb-2">
                            <input id="checkbox-{{$name}}-{{$key}}" type="checkbox">
                            <label for="checkbox-{{$name}}-{{$key}}"><b>{{$key}}</b></label>
                        </div>
                        @foreach($items as $item)
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="checkbox-{{$name}}-{{$key}}-{{$item}}" type="checkbox">
                            <label for="checkbox-{{$name}}-{{$key}}-{{$item}}"> {{$item}}</label>
                        </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>