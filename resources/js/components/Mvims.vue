<template>
    <div class="mvims" style="height: 265px">
        <div
            class="mv text-center"
            v-for="mvim in mvims"
            v-show="mvim.show"
            :key="mvim.id"
        >
            <img :src="mvim.img" alt="" class="mx-auto" />
        </div>
    </div>
</template>

<script>
import { onMounted } from "vue";
export default {
    props: ["mvims"],
    setup(props) {
        onMounted(() => {
            let m = 1;
            setInterval(() => {
                props.mvims.map((mv, idx) => {
                    /* if(idx == m){
                            mv.show = true;
                        }else{
                            mv.show = false;
                        } */
                    mv.show = idx == m ? true : false;
                    return mv;
                });

                m = (m + 1) % props.mvims.length;
            }, 3000);
        });
    },
};
</script>
