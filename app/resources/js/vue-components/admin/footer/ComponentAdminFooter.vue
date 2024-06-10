<script>
export default {
    name: "ComponentAdminFooter"
}
</script>

<template>
    <footer class="admin-panel-footer">
        <div>
            Разработка: <a href="https://github.com/boriscom123">@ByNextPr</a>
        </div>
    </footer>
</template>

<style scoped lang="scss">
.admin-panel-footer {
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(27, 37, 59, 1);

    > div {
        color: silver;
        margin: 0 0 0 350px;

        > a {
            color: silver;
            transition: $transition;

            &:hover {
                color: white;
            }
        }
    }
}
</style>
