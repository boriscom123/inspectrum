<script>
export default {
    name: "ComponentAdminUserReviews",
    data: function () {
        return {
            active_navigation: false,
        };
    },
    mounted() {
        console.log("ComponentAdminUserReviews mounted.");
        console.log("active_navigation", this.active_navigation);
        this.emitter.on("active_navigation", (data) => {
            this.active_navigation = data.active_navigation;
            console.log(data);
        });
    },
}
</script>

<template>
    <div v-if="this.active_navigation === 'user-reviews'">
        Отзывы пользователей
    </div>
</template>

<style scoped lang="scss">

</style>
