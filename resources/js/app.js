import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/vue3";
import NavHeader from "./Layouts/navHeader.vue";

createInertiaApp({
    // add title for global access //
    title: (title) => `Lara-Vue-App ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        // return pages[`./Pages/${name}.vue`]; //add a NavHeader layout
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || NavHeader;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            // add Head and Link for global access //
            .component("Head", Head)
            .component("Link", Link)
            // add Head and Link for global access //
            .mount(el);
    },
});
