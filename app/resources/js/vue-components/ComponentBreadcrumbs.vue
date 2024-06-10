<script>
export default {
    name: "ComponentBreadcrumbs",
    props: {
        breadcrumbs: {
            type: Array,
        },
    },
    // mounted() {
    //     console.log('breadcrumbs', this.breadcrumbs);
    //     console.log(this.breadcrumbs.length);
    // },
}
</script>

<template>
    <div class="breadcrumbs">
        <div class="container">
            <div class="container-content">
                <template v-for="(item, index) in this.breadcrumbs" :key="index">
                    <div v-if="index < this.breadcrumbs.length - 1" class="link parent"><a :href="item.link" :title="item.title">{{ item.title }}</a></div>
                    <div v-else class="link">{{ item.title }}</div>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.breadcrumbs {
    > .container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;

        > .container-content {
            height: 60px;
            padding: 0 60px 0 60px;
            display: flex;
            justify-content: flex-start;
            align-items: center;

            @media (max-width: $bp-xl) {
                padding: 0 20px 0 20px;
            }
            @media (max-width: $bp-ssm) {
                padding: 0 10px 0 10px;
            }

            > .link {
                color: grey;
                > a {
                    color: $color-primary-darken;
                    text-decoration: underline;
                    transition: $transition;

                    &:hover {
                        color: $color-primary;
                    }
                }
            }

            > .parent {

                &:after {
                    content: '/';
                    margin: 0 10px 0 10px;
                }
            }
        }
    }
}
</style>
