require("./bootstrap");

import { createApp } from 'vue';
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
import Marquee from './components/Marquee.vue';
import Images from './components/Images.vue';
import Menus from './components/Menus.vue';
import loginBtn from './components/loginBtn.vue';
import router from './router.js';

const app = {
    components: { 'marquee': Marquee, 'images': Images, 'menus': Menus, 'login-btn': loginBtn, },
    data() {
        // 這樣寫也可以
        // const hello =  "阿囉哈";
        // const adstr = '{{ $ads }}';
        // const bottom = '{{ $bottom }}';
        // const titleImg = "{{ asset('storage/' . $title->img) }}";
        // const title = '{{ $title->text }}';
        // const total = {{ $total }};

        // const site = JSON.parse('{!! json_encode($site) !!}');
        // // 如果不加JSON.parse的話那就會變成字串
        // const menus = JSON.parse('{!! $menus !!}');
        // const images = JSON.parse('{!! json_encode($images) !!}');
        // // const ip = 0;
        // const mvims = JSON.parse('{!! $mvims !!}');
        // const newss = JSON.parse('{!! json_encode($news) !!}');
        return {
            // hello,
            // adstr,
            // bottom,
            // titleImg,
            // title,
            // total,
            menus: null,
            images: null,
            // ip ,
            mvims: null,
            // news: null,
            site: null,
            auth: null,
            show: false,
        };
    },
    created() {
        axios
            .get("/api")
            .then((res) => {
                // console.log(res.data);
                this.site = res.data.site;
                this.menus = res.data.menus;
                this.images = res.data.images;
                // this.news = res.data.news;
                this.mvims = res.data.mvims;
                this.auth = res.data.auth;
                this.show = true;
            })
            .catch((error) => {
                console.log("error=>" + error);
            });
    },
    mounted() {
        // this.switchImg('up');
    },
};

createApp(app).use(router).mount("#app");
