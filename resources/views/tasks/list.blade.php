<table>
    @foreach($task as $data)
    @php
        $endTime = \Carbon\Carbon::parse($data->created_at);
        $timeleft = $endTime->diffForHumans();
    @endphp
    <tr>
        <td class="status-checkbox"><input type="checkbox" name="status" id="status" data-value="{{$data->status}}" data-id="{{$data->id}}"  @if($data->status == '1') checked @endif></td>
        <td style="padding-left: 10px;"> {{$data->name ?? ''}}</td>
        <td style="padding-left: 100px;">{{$timeleft}}</td>
        <td style="padding-left: 200%;" class="icon-dlt"><i class="material-icons" data-id="{{ $data->id }}">delete</i></td>
    </tr>
    @endforeach
</table>
