<div class="block">
    <div class="block-content block-content-full">
        <form method="POST" action="">
            @csrf
            <div class="row">
                @foreach($modelData as $key => $item)
                    @if($item['type'] == 'hidden')
                        <input type="hidden" name="{{$key}}" value="{{ $item['value']}}">
                    @endif
                    @if($item['type'] == 'text')
                        <div class="col-xs-12 col-sm-6 col-lg-6">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <input type="text" class="form-control @isset($item['maxlength']) js-maxlength @endif @error($key) is-invalid @enderror" @isset($item['maxlength']) maxlength="{{$item['maxlength']}}" @endisset id="input-{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}" value="{{ old($key , $item['value'])}}">
                            @error($key)
                            <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    @if($item['type'] == 'photo')
                        <div class="col-xs-12 col-sm-12 col-lg-10">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error($key) is-invalid @enderror" id="{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}" value="{{ old($key , $item['value'])}}">
                                <div class="input-group-append">
                                    <a href="{{filemanager($key)}}" class="iframe-btn">
                                    <button type="button" class="btn btn-success"><i class="fa fa-images"></i> Chọn Ảnh</button>
                                    </a>
                                </div>
                                @error($key)
                                <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    @if($item['type'] == 'file')
                        <div class="col-xs-12 col-sm-12 col-lg-10">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error($key) is-invalid @enderror" id="{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}" value="{{ old($key , $item['value'])}}">
                                <div class="input-group-append">
                                    <a href="{{filemanager($key)}}" class="iframe-btn">
                                        <button type="button" class="btn btn-success"><i class="fa fa-images"></i> Chọn File</button>
                                    </a>
                                </div>
                                @error($key)
                                <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    @if($item['type'] == 'select2')
                        <div class="col-xs-12 col-sm-6  col-lg-4">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <select class="js-select2 form-control @error($key) is-invalid @enderror" id="input-{{$key}}" name="{{$key}}" style="width: 100%;" data-placeholder="Choose one..">
                                @foreach($item['data'] as $k => $v)
                                <option value="{{$k}}" @if($k == old($key , $item['value'])) selected @endif>{{$v}}</option>
                                @endforeach
                            </select>
                            @error($key)
                            <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    @if($item['type'] == 'number')
                        <div class="col-xs-12 col-sm-6  col-lg-3">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <input type="number" class="form-control @isset($item['maxlength']) js-maxlength @endif @error($key) is-invalid @enderror" @isset($item['maxlength']) maxlength="{{$item['maxlength']}}" @endisset id="input-{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}" value="{{ old($key , $item['value'])}}">
                            @error($key)
                            <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    @if($item['type'] == 'textarea')
                        <div class="col-xs-12 col-sm-12 col-lg-10">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <textarea class="form-control @isset($item['maxlength']) js-maxlength @endif @error($key) is-invalid @enderror" @isset($item['maxlength']) maxlength="{{$item['maxlength']}}" @endisset id="input-{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}">{!! old($key , $item['value']) !!}</textarea>
                            @error($key)
                            <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    @if($item['type'] == 'editor')
                        <div class="col-xs-12 col-sm-12 col-lg-10">
                            <label for="input-{{$key}}" class="col-form-label">{{$item['name']}}</label>
                            <textarea class="form-control tinymce-editor @error($key) is-invalid @enderror" id="{{$key}}" placeholder="{{$item['name']}}" name="{{$key}}" rows="20">{!! old($key , $item['value']) !!}</textarea>
                            @error($key)
                            <div class="invalid-feedback"><i class="fa fa-exclamation-triangle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 pt-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light submit-fixed">
                        <span class="btn-label"><i class="fas fa-sync fa-spin"></i></span> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('footer')
    <script>jQuery(function(){ One.helpers(['select2','maxlength']); });</script>
@endpush