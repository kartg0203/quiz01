<div class="modal fade" id="baseModal" tabindex="-1" aria-labelledby="ModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            @isset($method)
                @method($method)
            @endisset
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCenter">{{ $modal_header }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="m-auto">
                        <tbody>
                            @isset($modal_body)
                                @foreach ($modal_body as $row)
                                    <tr>
                                        <td class="text-rigth">{{ $row['label'] }}</td>
                                        <td>
                                            @switch($row['tag'])
                                                @case('input')
                                                    @include('layouts.input', $row)
                                                @break
                                                @case('textarea')
                                                    @include('layouts.textarea', $row)
                                                @break
                                                @case('img')
                                                    @include('layouts.img', $row)
                                                @break
                                                @case('embed')
                                                    @include('layouts.embed', $row)
                                                @break
                                                @default
                                                {{ $row['text'] }}
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary">重置</button>
                    <button type="submit" class="btn btn-primary">儲存</button>
                </div>
            </div>
        </form>
    </div>
</div>
