<template>
    <router-link :to="auth.href" class="btn p-3 w-100 my-2" :class="auth.class">
        {{ auth.text }} ({{ auth.user }})
    </router-link>
</template>

<script>
export default {
    props: ["auth"],
};
</script>
