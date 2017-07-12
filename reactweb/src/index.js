import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import App from './containers/App';
//import configureStore from './store/configureStore.dev';

//const store = configureStore();

render(
    <App />,
  document.getElementById('container_body')
);
