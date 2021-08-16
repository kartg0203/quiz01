@extends('layouts.layout')

@section('main')
    <div class="col-md-3">
        <menus :menus="menus" :total="site.total"></menus>
    </div>
    <div class="col-md-6">
        <div class="main">
            <marquee>@{{ site . ads }}</marquee>
            {{-- <div class="marquee">
                <h4>@{{ site . ads }}</h4>
            </div> --}}
            @yield('center')
        </div>
    </div>
    <div class="col-md-3">
        <div class="right">
            <login-btn :auth="auth"></login-btn>
            {{-- @isset($images)
                @foreach ($images as $image) --}}
            <images :images="images" title="校園風情"></images>
            {{-- @endforeach
            @endisset --}}

        </div>
    </div>
@endsection

{{-- @section('script')
    <script>
        // $(".menu").hover(
        //     function() {
        //         $(this).children('.subs').show();
        //     },
        //     function() {
        //         $(this).children('.subs').hide();
        //     }
        // );

        /*
                let num = $(".img").length;
                let p = 0;
                $(".img").each((idx, dom) => {
                    if (idx < 3) {
                        $(dom).show();
                    }
                });

                $(".up, .down").click(function() {
                    $(".img").hide();
                    // console.log($(this));
                    switch ($(this).attr('class')) {
                        case 'up':
                            p = (p > 0) ? --p : p;
                            break;
                        case 'down':
                            p = (p < num - 3) ? ++p : p;
                            break;
                    }

                    $(".img").each((idx, dom) => {
                        if (idx >= p && idx <= p + 2) {
                            $(dom).show();
                        }
                    });
                }); */

        // $(".mv").eq(0).show();
        // let mvNum = $(".mv").length;
        // let now = 0;
        // setInterval(() => {
        //     $(".mv").hide();
        //     ++now;
        //     $(".mv").eq(now % mvNum).show();
        // }, 3000);

        /*         $(".new").hover(function() {
                        $(this).children('div').show();
                    },
                    function() {
                        $(this).children('div').hide();
                    }); */

        const app = {
            data() {
                // 這樣寫也可以
                // const hello =  "阿囉哈";
                const adstr = '{{ $ads }}';
                const bottom = '{{ $bottom }}';
                const titleImg = "{{ asset('storage/' . $title->img) }}";
                const title = '{{ $title->text }}';
                const total = {{ $total }};
                // 如果不加JSON.parse的話那就會變成字串
                const menus = JSON.parse('{!! $menus !!}');
                const images = JSON.parse('{!! $images !!}');
                const ip = 0;
                const mvims = JSON.parse('{!! $mvims !!}');
                const newss = JSON.parse('{!! $news !!}');
                @isset($more)
                    const more = '{{ $more }}';
                @endisset
                return {
                    // hello,
                    adstr,
                    bottom,
                    titleImg,
                    title,
                    total,
                    menus,
                    images,
                    ip,
                    mvims,
                    newss,
                    @isset($more)
                        more,
                    @endisset

                }
            },
            methods: {
                switchImg(type) {
                    switch (type) {
                        case 'up':
                            this.ip = (this.ip > 0) ? --this.ip : this.ip;
                            break;
                        case 'down':
                            // console.log(this.images.length);
                            this.ip = (this.ip < this.images.length - 3) ? ++this.ip : this.ip;
                            break;
                    }
                    this.images.map((img, idx) => {
                        if (idx >= this.ip && idx <= this.ip + 2) {
                            img.show = true;
                        } else {
                            img.show = false;
                        }
                        return img;
                    });
                }
            },
            mounted() {
                // this.switchImg('up');
                let m = 1;
                setInterval(() => {
                    this.mvims.map((mv, idx) => {
                        /* if(idx == m){
                            mv.show = true;
                        }else{
                            mv.show = false;
                        } */
                        mv.show = (idx == m) ? true : false;
                        return mv;
                    });

                    m = (m + 1) % this.mvims.length;
                }, 3000);
            },
        }

        Vue.createApp(app).mount("#app");

    </script>
@endsection --}}
