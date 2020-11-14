import React from 'react';
import { connect } from 'react-redux';
import WebSocketInstance from '../websocket';
import Hoc from '../hoc/hoc';


class Chat extends React.Component {

	state = { message: '' };

	initialiseChat() {                          // Берем все чаты пользователя 
        this.waitForSocketConnection(() => {
          //WebSocketInstance.addCallbacks(this.setMessages.bind(this), this.addMessage.bind(this))       // Передаем функции в качестве аргументов
          WebSocketInstance.fetchMessages( // Взять сообщения
            this.props.username, 
            this.props.match.params.chatID
          );
        });
		WebSocketInstance.connect(this.props.match.params.chatID);  // https://metanit.com/web/react/4.4.php - берем данные с url
	}

    constructor(props) {
        super(props);
		this.initialiseChat();
	}
	
    waitForSocketConnection(callback) {
        const component = this;
        setTimeout(
            function () {
            if (WebSocketInstance.state() === 1) {  // Подключено успешно 
                console.log("Connection is made");  
                callback();             // Вызываем функцию из initialiseChat
                return;
            } else {
                console.log("wait for connection...");  // Если ожидаем подключения 
                component.waitForSocketConnection(callback);
            }
        }, 100);
    }
    
    // addMessage(message) {           // Добавить сообщение
    //     this.setState({ messages: [...this.state.messages, message] });
    // }
    
    // setMessages(messages) {         // вывод сообщений
    //     this.setState({ messages: messages.reverse()});
    // }
    
    messageChangeHandler = (event) =>  {    // При изменении сообщения в input
        this.setState({ message: event.target.value });
    }
    
    sendMessageHandler = (e) => {   // Отправляем сообщение
        e.preventDefault();
        const messageObject = {
            from: this.props.username,
            content: this.state.message,
            chatId: this.props.match.params.chatID
        };
        WebSocketInstance.newChatMessage(messageObject);
        this.setState({ message: '' });
    }

    renderTimestamp = timestamp => {        // Рендер время отправки 
        let prefix = ''; 
        const timeDiff = Math.round((new Date().getTime() - new Date(timestamp).getTime())/60000);
        if (timeDiff < 1) {
            prefix = 'just now...';
        } else if (timeDiff < 60 && timeDiff >= 1) { 
            prefix = `${timeDiff} minutes ago`;
        } else if (timeDiff < 24*60 && timeDiff > 60) { 
            prefix = `${Math.round(timeDiff/60)} hours ago`;
        } else if (timeDiff < 31*24*60 && timeDiff > 24*60) {
            prefix = `${Math.round(timeDiff/(60*24))} days ago`;
        } else {
            prefix = `${new Date(timestamp)}`;
        }
        return prefix
    }
    
    renderMessages = (messages) => {            // Рендеринг сообщений
        const currentUser = this.props.username;
        return messages.map((message, i, arr) => (
            <li 
                key={message.id} 
                style={{marginBottom: arr.length - 1 === i ? '300px' : '15px'}}
                className={message.author === currentUser ? 'sent' : 'replies'}>
                <img src="http://emilcarlsson.se/assets/mikeross.png" />
                <p>{message.content}
                    <br />
                    <small>
                        {this.renderTimestamp(message.timestamp)}
                    </small>
                </p>
            </li>
        ));
    }

    scrollToBottom = () => {    // Скрол вниз к последнему сообщению 
        this.messagesEnd.scrollIntoView({ behavior: "smooth" });
    }
    // вызывается сразу после рендеринга компонента в DOM
    componentDidMount() {
        this.scrollToBottom();
    }
    // вызывается сразу после обновления компонента
    componentDidUpdate() {
        this.scrollToBottom();
    }
    // вызывается при обновлении объекта props
    UNSAFE_componentWillReceiveProps(newProps) {
        if (this.props.match.params.chatID !== newProps.match.params.chatID) {
            WebSocketInstance.disconnect();
            this.waitForSocketConnection(() => {
                WebSocketInstance.fetchMessages(
                  this.props.username, 
                  newProps.match.params.chatID
                );
              });
              WebSocketInstance.connect(newProps.match.params.chatID);
        }
    }

    render() {
        const messages = this.state.messages;
        return (
            <Hoc>
                <div className="messages">
                    <ul id="chat-log">
                    { 
                        this.props.messages && 
                        this.renderMessages(this.props.messages) 
                    }
                    <div style={{ float:"left", clear: "both" }}
                        ref={(el) => { this.messagesEnd = el; }}>
                    </div>
                    </ul>
                </div>
                <div className="message-input">
                    <form onSubmit={this.sendMessageHandler}>
                        <div className="wrap">
                            <input 
                                onChange={this.messageChangeHandler}
                                value={this.state.message}
                                required 
                                id="chat-message-input" 
                                type="text" 
                                placeholder="Write your message..." />
                            <i className="fa fa-paperclip attachment" aria-hidden="true"></i>
                            <button id="chat-message-submit" className="submit">
                                <i className="fa fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </Hoc>
        );
    };
}

const mapStateToProps = state => {
    return {
        username: state.auth.username,
        messages: state.message.messages
    }
}
  
export default connect(mapStateToProps)(Chat);