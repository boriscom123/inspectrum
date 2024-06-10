<script>
import {useToast} from "vue-toastification";

export default {
    name: "componentAbout",
    props: [
        'app_env',
        'app_version',
    ],
    data: function () {
        return {
            show_console: false,
            component_app_version: 0,
        };
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    mounted() {
        this.component_app_version = this.app_version;

        if (this.show_console) {
            console.log('componentAbout');
            console.log('app_env', this.app_env);
            console.log('app_version', this.app_version);
        }
    },
    methods: {
        showToast: function () {
            this.toast.info("I'm an info toast!");
            this.toast.success("My toast success", {timeout: 2000});
            this.toast.error("My toast error");
        },
        update_version_number: function () {
            this.toast.info('Обновляем отображение текущей версии');
            let v_main = this.component_app_version.slice(0, 4);
            let v_current = this.component_app_version.slice(4);
            let v_updated = Number(v_current);
            v_updated++;
            v_updated = String(v_updated);
            this.component_app_version = v_main + v_updated;
        },
    },
}
</script>

<template>
    <div class="site-version" @click="update_version_number()">Version: {{ this.component_app_version }}</div>
</template>

<style scoped lang="scss">
.site-version {
    color: silver;
    font-size: 0.5rem;
}
</style>
