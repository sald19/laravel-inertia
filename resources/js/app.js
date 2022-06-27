import './bootstrap'
import './icons'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Bugsnag from '@bugsnag/js'
import BugsnagPluginVue from '@bugsnag/plugin-vue'
import { usePage } from '@inertiajs/inertia-vue3'

const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

Bugsnag.start({
  apiKey: process.env.MIX_BUGSNAG_API_KEY,
  appVersion: process.env.MIX_BUGSNAG_APP_VERSION,
  plugins: [new BugsnagPluginVue()],
  onError: (event) => {
    console.log(event)
    console.log('usePage().props', usePage().props)

    const user = usePage().props.value.auth.user
    if (user) {
      event.setUser(user.id, user.email, user.name)
    }
  },
})

const bugsnagVue = Bugsnag.getPlugin('vue')

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => require(`./Pages/${name}.vue`),
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
