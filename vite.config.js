import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

import { BugsnagSourceMapUploaderPlugin } from 'vite-plugin-bugsnag'

export default defineConfig((command, mode) => {
  const env = loadEnv(mode, process.cwd(), '')
  const isProd = env.APP_ENV === 'production'
  console.log({ isProd })

  return {
    plugins: [
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
      }),
      vue({
        template: {
          transformAssetUrls: {
            // The Vue plugin will re-write asset URLs, when referenced
            // in Single File Components, to point to the Laravel web
            // server. Setting this to `null` allows the Laravel plugin
            // to instead re-write asset URLs to point to the Vite
            // server instead.
            base: null,

            // The Vue plugin will parse absolute URLs and treat them
            // as absolute paths to files on disk. Setting this to
            // `false` will leave absolute URLs un-touched so they can
            // reference assets in the public directly as expected.
            includeAbsolute: false,
          },
        },
      }),

      BugsnagSourceMapUploaderPlugin({
        apiKey: env.VITE_BUGSNAG_API_KEY,
        appVersion: env.VITE_BUGSNAG_APP_VERSION,
        overwrite: true,
      }),
    ],

    resolve: {
      alias: {
        '@': '/resources/js',
      },
    },

    devtool: 'hidden-source-map',

    output: {
      chunkFilename: 'js/components/[name].js?id=[contenthash]',
    },
    // output: {
    //   chunkFilename: 'js/components/[name].js',
    // },
  }
})
