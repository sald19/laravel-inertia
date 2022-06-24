const path = require('path')
const { BugsnagSourceMapUploaderPlugin } = require('webpack-bugsnag-plugins')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')

module.exports = {
  devtool: 'hidden-source-map',
  plugins: [
    new CleanWebpackPlugin({
      cleanStaleWebpackAssets: false,
      protectWebpackAssets: true,
      cleanOnceBeforeBuildPatterns: ['js/components/*'],
    }),
    new BugsnagSourceMapUploaderPlugin({
      apiKey: process.env.MIX_BUGSNAG_API_KEY,
      appVersion: process.env.MIX_BUGSNAG_APP_VERSION,
      publicPath: '*',
      overwrite: true,
    }),
  ],

  output: {
    chunkFilename: 'js/components/[name].js?id=[contenthash]',
  },

  resolve: {
    alias: {
      '@': path.resolve('resources/js'),
    },
  },
}
