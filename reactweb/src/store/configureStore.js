/**
 * Based on the current environment variable, we need to make sure
 * to exclude any DevTools-related code from the production builds.
 * The code is envify'd - using 'DefinePlugin' in Webpack.
 */

let loadedStore = null;

if (process.env.NODE_ENV === 'production') {
    console.log('loading configStore in PROD');
    loadedStore = require('./configureStore.prod');
} else {
    console.log('loading configStore in DEV');
    loadedStore = require('./configureStore.dev');
}

export const configureStore = loadedStore;
