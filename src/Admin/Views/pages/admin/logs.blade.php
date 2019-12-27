<div class="block">
    <div class="block-content block-content-full">
    @if ($logs === null)
        <div>
            Log file >50M, please download it.
        </div>
    @else
        <div class="table-responsive">
            @if($current_file)
                @push('menu')
                <div class="button-list pr-xl-4">
                    <a href="{{$logs_url}}?dl={{$logs_data}}" class="btn btn-s-md btn-primary"><i class="fa fa-download"></i> Download Logs</a>
                    <a id="clean-log" href="{{$logs_url}}?clean={{$logs_data}}" class="btn btn-s-md btn-info"><i class="fa fa-refresh"></i> Clean Data</a>
                    <a id="delete-log" href="{{$logs_url}}?del={{$logs_data}}" class="btn btn-s-md btn-danger"><i class="fa fa-recycle"></i> Delete Logs</a>

                    @if(count($files) > 1)
                        <a id="delete-all-log" href="{{$logs_url}}?delall=true{{ ($current_folder) ? '&f=' . encrypt($current_folder) : '' }}" class="btn btn-s-md btn-danger"><span class="fa fa-trash"></span> Delete all logs</a>
                    @endif
                </div>
                @endpush
            @endif
            <table id="logData" class="table table-striped b-t text-sm" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                <thead>
                <tr>
                    @if ($standardFormat)
                        <th>Level</th>
                        <th>Context</th>
                        <th>Date</th>
                    @else
                        <th>Line number</th>
                    @endif
                    <th>Content</th>
                </tr>
                </thead>
                <tbody>

                @foreach($logs as $key => $log)
                    <tr data-display="stack{{{$key}}}">
                        @if ($standardFormat)
                            <td class="nowrap text-{{{$log['level_class']}}}">
                                <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                            </td>
                            <td class="text">{{$log['context']}}</td>
                        @endif
                        <td class="date">{{{$log['date']}}}</td>
                        <td class="text" onclick="loadStackInfo('stack_{{{$key}}}');">
                            @if ($log['stack']) <span class="fa fa-search"></span> @endif {{{$log['text']}}}
                            @if (isset($log['in_file']))
                                <br/>{{{$log['in_file']}}}
                            @endif
                            @if ($log['stack'])
                                <div class="stack stack-info" id="stack_{{{$key}}}" style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
    </div>
</div>

@push('footer')
    <script>
        function loadStackInfo(stack_id){
            $("#"+stack_id).toggle();
        }
        $(document).ready(function () {
            $('#logData').DataTable({
                "lengthMenu": [20],
                "bLengthChange": false,
                "searching": false,
                "ordering": false
            });
            $('#delete-log, #clean-log, #delete-all-log').click(function () {
                return confirm('Bạn có muốn xóa Logs không?');
            });
        });
    </script>
@endpush