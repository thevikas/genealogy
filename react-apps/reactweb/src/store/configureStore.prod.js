import { createStore, applyMiddleware, compose } from 'redux';
import rootReducer from 'store/reducers';
import thunk from 'redux-thunk';
import axios from 'axios';
import axiosMiddleware from 'redux-axios-middleware';

const client = axios.create({ //all axios can be used, shown in axios documentation
  responseType: 'json'
});

const finalCreateStore = compose(
  applyMiddleware(thunk,axiosMiddleware(client))
)(createStore);

module.exports = function configureStore(initialState) {
  return finalCreateStore(rootReducer, initialState);
};
