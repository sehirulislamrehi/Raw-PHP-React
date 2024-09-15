

import React from 'react';
import {createRoot} from 'react-dom/client';
import App from './App';
import reportWebVitals from './reportWebVitals';

import { createStore } from 'redux';
import allReducer from "./reducer";
import { Provider } from 'react-redux';



// window.url = "http://localhost/font-group-assesment/backend/routes/router.php"
// window.image_path = "http://localhost/font-group-assesment/backend/"
// const myStore = createStore(allReducer)

window.url = "https://zeptoapps-backend.sehirulislamrehi.com/routes/router.php"
window.image_path = "https://zeptoapps-backend.sehirulislamrehi.com/"
const myStore = createStore(
  allReducer,
  window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
)


const rootElement = document.getElementById('root');
const root = createRoot(rootElement);


root.render(
    <Provider store={myStore}>
      <App />
    </Provider>,
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
