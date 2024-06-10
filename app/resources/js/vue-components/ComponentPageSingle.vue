<script>
export default {
    name: "ComponentPageSingle",
    props: {
        page: {
            type: Array,
        },
    },
    mounted() {
        // console.log('ComponentPageSingle');
        // console.log('this.page', this.page);
    },
}
</script>

<template>
    <div v-html="this.page['text']" class="page-single"></div>
</template>

<style scoped lang="scss">

</style>
