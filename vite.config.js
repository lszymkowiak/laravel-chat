import fs from 'fs'
import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import {resolve} from 'path'

export default defineConfig({
    server: detectServerConfig(),
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
})

function detectServerConfig() {
    let env = loadEnv('DEV', process.cwd(), 'VITE_')
    let host = env.VITE_HOST
    let keyPath = resolve(env.VITE_SSL_KEY_PATH)
    let crtPath = resolve(env.VITE_SSL_CRT_PATH)

    if (!host) {
        return {}
    }

    let config = {
        hmr: {host},
        host,
    }

    if (!fs.existsSync(keyPath) || !fs.existsSync(crtPath)) {
        return config
    }

    config.https = {
        key: fs.readFileSync(keyPath),
        cert: fs.readFileSync(crtPath),
    }

    return config
}
