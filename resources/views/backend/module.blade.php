@extends('layouts.layout')

@section('main')
    @include('layouts.backend_sidebar')
    <div class="col-md-9 p-0">
        <div class="main">
            <div class="row no-gutters mb-1">
                <div class="col-md-8 border text-center pt-2">後臺管理區</div>
                <div class="col-md-4">
                    <a href="/logout" class="btn btn-light border py-3 text-center">管理登出</a>
                </div>
            </div>
            <div class="border w-100 p-1" style="height: 510px;overflow: auto;">
                <h5 class="text-center border-bottom py-3">
                    @if ($module != 'Total' && $module != 'Bottom')
                        <button class="btn btn-primary btn-sm float-left" id="addRow">新增</button>
                    @endif
                    {{ $header }}
                </h5>
                <table class="table text-center table-sm table-hover table-striped">
                    <thead class="table-warning">
                        <tr>
                            @isset($cols)
                                @if ($module != 'Total' && $module != 'Bottom')
                                    @foreach ($cols as $col)
                                        <td>{{ $col }}</td>
                                    @endforeach
                                @endif
                            @endisset
                        </tr>
                    </thead>
                    <tbody>
                        @isset($rows)
                            @if ($module != 'Total' && $module != 'Bottom')
                                @foreach ($rows as $row)
                                    <tr>
                                        @foreach ($row as $item)
                                            <td>
                                                @switch($item['tag'])
                                                    @case('img')
                                                        @include('layouts.img', $item)
                                                    @break
                                                    @case('button')
                                                        @include('layouts.button', $item)
                                                    @break
                                                    @case('embed')
                                                        @include('layouts.embed', $item)
                                                    @break
                                                    @case('textarea')
                                                        @include('layouts.textarea', $item)
                                                    @break
                                                    @default
                                                        {{ $item['text'] }}
                                                @endswitch
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>{{ $cols[0] }}</td>
                                    <td>{{ $rows[0]['text'] }}</td>
                                    <td>
                                        @include('layouts.button', $rows[1])
                                    </td>
                                </tr>
                            @endif
                        @endisset
                    </tbody>
                </table>
                @switch($module)
                    @case('Image')
                    @case('News')
                        {!! $paginate !!}
                        @break
                @endswitch
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $("#addRow").on('click', function() {
        // $.get('/modals/addTitle', function(modal){
        //     $("#modal").html(modal);
        //     $("#baseModal").modal("show");
        // });
        @isset($menu_id)
            axios.get('/modals/add{{ $module }}/ {{ $menu_id }}')
            .then(modal => {
                $("#modal").html(modal.data);
                $("#baseModal").modal("show");

                $("#baseModal").on('hidden.bs.modal', function() {
                    $("#baseModal").modal('dispose');
                    $("#modal").html("");
                });
            })
            .catch(error => {
                console.log(error);
            });

        @else

            axios.get('/modals/add{{ $module }}')
            .then(modal => {
                $("#modal").html(modal.data);
                $("#baseModal").modal("show");

                $("#baseModal").on('hidden.bs.modal', function() {
                    $("#baseModal").modal('dispose');
                    $("#modal").html("");
                });
            })
            .catch(error => {
                console.log(error);
            });
        @endif
    });

    $(".edit").on('click', function() {
        let id = $(this).data('id');

        axios.get(`/modals/{{ strtolower($module) }}/${id}`)
            .then(modal => {
                $("#modal").html(modal.data);
                $("#baseModal").modal("show");

                $("#baseModal").on('hidden.bs.modal', function() {
                    $("#baseModal").modal('dispose');
                    $("#modal").html("");
                });
            })
            .catch(error => {
                console.log(error);
            });
    });

    $(".delete").on('click', function() {
        // console.log($(this).data('id'));
        let check = confirm('確定要刪除嗎?');
        if (check) {
            let id = $(this).data('id');
            let _this = $(this);
            axios.delete(`/admin/{{ strtolower($module) }}/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(success => {
                    // location.reload();
                    _this.parents('tr').remove();
                    // console.log("success");
                })
                .catch(error => {
                    console.log(error);
                    console.log("error test");
                });
        }
    });

    $(".show").on('click', function() {
        let id = $(this).data('id');
        let _this = $(this);
        axios.patch(`/admin/{{ strtolower($module) }}/sh/${id}`)
        @if ($module == 'Title')
            .then(img => {
                // location.reload();
                if(_this.text() == '顯示'){
                    $(".show").each((idx, dom)=>{
                        if($(dom).text() == '隱藏'){
                            $(dom).text('顯示');
                            return false;
                        }
                    });
                    _this.text('隱藏');
                }else{
                    $(".show").text('隱藏');
                    _this.text('顯示');
                }

                $(".header img").attr("src", `http://localhost:8000/storage/${img.data}`);
            })
        @else
            .then(()=> {
                // location.reload();
                if(_this.text() == '顯示'){
                    _this.text('隱藏');
                }else{
                    _this.text('顯示');
                }
            })
        @endif
            .catch(error => {
                console.log(error);
            });
    });

    $(".sub").on('click', function(){
        let id = $(this).data('id');
        location.href = `/admin/submenu/${id}`;
    });

</script>
@endsection
