import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import AppLayout from "@/layouts/AppLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => appName + (title ? ` - ${title}` : ''),
    resolve: name => {
        const page = resolvePageComponent(`./views/${name}.vue`, import.meta.glob('./views/**/*.vue'))
        page.then(page => {
            if (page.default.layout === undefined && !name.startsWith('Auth/') && name !== 'Welcome') {
                page.default.layout = AppLayout
            }
        })
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
