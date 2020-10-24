import { InertiaApp } from '@inertiajs/inertia-svelte'

const app = document.getElementById('app')

new InertiaApp({
  target: app,
  props: {
    initialPage: JSON.parse(app.dataset.page),
    resolveComponent: name => require(`./Pages/${name}.svelte`).default,
  },
})