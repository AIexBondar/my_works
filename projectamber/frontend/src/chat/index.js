import React from 'react';
import ReactDOM from 'react-dom';
import { createStore, compose, applyMiddleware, combineReducers  } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';
import { Provider } from 'react-redux';
import thunk from 'redux-thunk'; // Асинхронность приложения
import "antd/dist/antd.css";
import authReducer from './store/reducers/auth';
import navReducer from './store/reducers/nav';
import messageReducer from "./store/reducers/message";
import App from './App';

// Redux — библиотека управления состоянием для приложений, написанных на JavaScript.
const composeEnhances = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose // функция расширения стора 

function configureStore() {

  const rootReducer = combineReducers({
    auth: authReducer,
    nav: navReducer,
    message: messageReducer
  });
  // Дерево состояний приложения 
  const store = createStore(rootReducer, composeWithDevTools(
   // composeEnhances(
    //Усиляет каждое действие функций
      applyMiddleware(thunk)   // https://xsltdev.ru/react/redux/middleware-usiliteli/
  ));
  

    // автоматически отражает изменение в вашем рабочем приложении при сохранении компонентов
    if (module.hot) {
      module.hot.accept('./store/reducers', () => {
        const nextRootReducer = require('./store/reducers/auth'); // Обеспечивает асинхронную загрузку модуля.
        store.replaceReducer(nextRootReducer); // Заменяет reducer, используемый в данный момент хранилищем для вычисления состояния.
      });
    }
  
    return store;
};

const store = configureStore();

const app = (
  //  Это сделает наш экземпляр хранилища доступным для всех компонентов, которые располагаются в Provider компоненте. 
    <Provider store={store}>
        <App />
    </Provider>
);


ReactDOM.render(app, document.getElementById("app"));

/*
  Ключевое различие тут в том, что state приватен и может меняться из самого компонента. 
  Props внешние и не контролируются самим компонентом.

  Что такое props? Это неизменяемый объект, предназначенный только для чтения.
*/

/*
  middleware в разрезе redux — это какая-то штука, которая слушает все dispatch и при определенных условиях делает что-то. 
  Логирует, проигрывает звуки, делает запросы к серверу,… — что-то.
*/

// https://rajdee.gitbooks.io/redux-in-russian/content/docs/Glossary.html#state

// Хуки — это технология перехвата вызовов функций в чужих процессах.