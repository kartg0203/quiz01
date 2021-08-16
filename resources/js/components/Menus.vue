<template>
    <div class="menu">
        <div class="text-center py-2 border-bottom my-1">主選單區</div>
        <ul class="list-group">
            <li
                class="list-group-item list-group-item-aciton position-relative menu bg-warning"
                v-for="menu in menus"
                :key="menu.id"
                @mouseover="menu.show = true"
                @mouseleave="menu.show = false"
            >
                <router-link :to="menu.href">{{ menu.text }}</router-link>
                <ul
                    class="list-group position-absolute subs"
                    style="width: 75%; left: 120px; z-index: 99"
                    v-if="menu.subs.length > 0"
                    v-show="menu.show"
                >
                    <li
                        class="list-group-item lsit-group-item-action bg-success py-1"
                        v-for="sub in menu.subs"
                        :key="sub.id"
                    >
                        <router-link :to="sub.href" class="text-light">{{
                            sub.text
                        }}</router-link>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="viewer">進佔總人數： {{ total }}</div>
    </div>
</template>

<script>
export default {
    props: ["menus", "total"],
};
</script>
