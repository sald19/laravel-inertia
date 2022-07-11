import './bootstrap'
import './icons'

import { createApp, h } from 'vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createInertiaApp, usePage } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Bugsnag from '@bugsnag/js'
import BugsnagPluginVue from '@bugsnag/plugin-vue'

const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

Bugsnag.start({
  apiKey: import.meta.env.VITE_BUGSNAG_API_KEY,
  appVersion: import.meta.env.VITE_BUGSNAG_APP_VERSION,
  plugins: [new BugsnagPluginVue()],
  onError: (event) => {
    const user = usePage().props.value.auth.user
    console.log('user', user)
    if (user) {
      event.setUser(user.id, user.email, user.name)
    }
  },
})

const bugsnagVue = Bugsnag.getPlugin('vue')

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue')
    ),
  setup({ el, app, props, plugin }) {
    const vueApp = createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(bugsnagVue)
      .mixin({ methods: { route } })
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)

    return vueApp
  },
})

InertiaProgress.init({ color: '#4B5563' })
