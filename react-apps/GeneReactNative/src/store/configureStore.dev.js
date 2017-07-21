import { createStore, applyMiddleware, compose } from 'redux';
import rootReducer from './reducers';
import { createLogger } from 'redux-logger';
import thunk from 'redux-thunk';
//import DevTools from 'devtools';
import axios from 'axios';
import axiosMiddleware from 'redux-axios-middleware';

const client = axios.create({ //all axios can be used, shown in axios documentation
  responseType: 'json'
});

const finalCreateStore = compose(
  // Middleware you want to use in development:
  applyMiddleware(thunk, axiosMiddleware(client))
  // Required! Enable Redux DevTools with the monitors you chose
  //DevTools.instrument()
)(createStore);

module.exports = function configureStore(initialState) {
  const store = finalCreateStore(rootReducer, initialState);

  // Hot reload reducers (requires Webpack or Browserify HMR to be enabled)
  if (module.hot) {
    module.hot.accept('./reducers', () =>
      store.replaceReducer(require('./reducers'))
    );
  }

  return store;
};
