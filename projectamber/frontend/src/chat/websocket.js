import { SOCKET_URL } from "./settings";

class WebSocketService {
  static instance = null;
  callbacks = {};


  /*
    Протокол WebSocket («веб-сокет»), описанный в спецификации RFC 6455, 
    обеспечивает возможность обмена данными между браузером и сервером через постоянное соединение. 
    Данные передаются по нему в обоих направлениях в виде «пакетов», 
    без разрыва соединения и дополнительных HTTP-запросов.

    https://learn.javascript.ru/websocket#peredacha-dannyh


    https://learn.javascript.ru/websocket#ogranichenie-skorosti -- Буфферизация при ограничение скорости 
  */


  static getInstance() {
    if (!WebSocketService.instance) {
      WebSocketService.instance = new WebSocketService();
    }
    return WebSocketService.instance;
  }

  constructor() {
    this.socketRef = null;
  }

  // Подключение к сокету 
  connect(chatUrl) {
    const path = `${SOCKET_URL}/ws/chat/${chatUrl}/`;
    this.socketRef = new WebSocket(path); // Открываем WebSocket соединение 
    this.socketRef.onopen = () => {       // Есть подключение 
      console.log('WebSocket open');
    };
    this.socketRef.onmessage = e => {     // Получены данные с базы
      this.socketNewMessage(e.data);
    };
    this.socketRef.onerror = e => {       // Упс, ошибочка
      console.log(e.message);
    };
    this.socketRef.onclose = () => {      // Проход закрыт (Соеденение закрыто)
      console.log("WebSocket closed let's reopen");
      this.connect();
    };
  }

  // Отключение 
  disconnect() {
    this.socketRef.close();
  }

  // Отправка сообщение 
  socketNewMessage(data) {
    const parsedData = JSON.parse(data);  // Перевод данных в JSON
    const command = parsedData.command;   // Команда с данных JSON
    if (Object.keys(this.callbacks).length === 0) { // Если путо - выходим
      return;
    }
    if (command === 'messages') {   // Взять все сообщения
      this.callbacks[command](parsedData.messages); // callback функция
    }
    if (command === 'new_message') {  // Отправить сообщение
      this.callbacks[command](parsedData.message);  // callback функция
    }
  }

  fetchMessages(username, chatId) { // Взять сообщения
    this.sendMessage({ 
      command: 'fetch_messages', 
      username: username, 
      chatId: chatId 
    });
  }

  newChatMessage(message) {       // Отправить данные
    this.sendMessage({ 
      command: 'new_message', 
      from: message.from, 
      message: message.content,
      chatId: message.chatId
    }); 
  }
  // callback функции 
  addCallbacks(messagesCallback, newMessageCallback) {
    this.callbacks['messages'] = messagesCallback;
    this.callbacks['new_message'] = newMessageCallback;
  }
  

  // Метод WebSocket .send() может отправлять и текстовые и бинарные данные.
  sendMessage(data) {
    try {
      this.socketRef.send(JSON.stringify({ ...data })); // Отправка данных
    }
    catch(err) {
      console.log(err.message);
    }  
  }

  state() {
    return this.socketRef.readyState; // JavaScript свойство readyState объекта XMLHttpRequest возвращает состояние объекта XMLHttpRequest. https://basicweb.ru/javascript/js_xmlhttprequest_readystate.php
  }

}

const WebSocketInstance = WebSocketService.getInstance();

export default WebSocketInstance;