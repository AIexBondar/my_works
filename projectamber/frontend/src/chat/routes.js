import React from "react";
import { Route } from "react-router-dom";
import Hoc from './hoc/hoc';

import Chat from "./containers/Chat";

/*
    Каждый Router создает объект history 
  который хранит путь к текущему location[1] и 
  перерисовывает интерфейс сайта когда происходят 
  какие то изменения пути.

  <Route/> компонент это главный строительный блок React Router'а. 
  В том случае если вам нужно рендерить элемент в зависимости от pathname URL'ов, то следует использовать компонент <Route/>

  <Route /> принимает path в виде prop который описывает определенный путь и сопоставляется с location.pathname. 

  Когда location.pathname это '/', prop path не совпадает
  Когда location.pathname это '/roster' или '/roster/2', prop path совпадает
  Если установлен exact prop. Совпадает только строгое сравнение '/roster', но не
  '/roster/2'

  component — React компонент. Когда роут удовлетворяется сопоставление в path, 
  то он возвращает переданный component (используя функцию React.createElement).
*/

const BaseRouter = () => (
  <Hoc>
    <Route exact path="/:chatID/" component={Chat} />
  </Hoc>
);

export default BaseRouter;
