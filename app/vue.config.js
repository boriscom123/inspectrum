const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
    transpileDependencies: true,
    publicPath: '/public/',
    outputDir: "public/dist",
    assetsDir: '../',
    filenameHashing: false,
    runtimeCompiler: true,
    pages: {
        index: {
            // точка входа для страницы
            entry: './resources/js/app.js'
        }
    },
    css: {
        sourceMap: true,
        extract: true,
        loaderOptions: {
            scss: {
                additionalData: `@import "./resources/scss/_variables.scss";`
            }
        }
    },
    // удаление плагинов webpack связанных с HTML
    chainWebpack: config => {
        config.plugins.delete('html')
        config.plugins.delete('preload')
        config.plugins.delete('prefetch')
    }
})
