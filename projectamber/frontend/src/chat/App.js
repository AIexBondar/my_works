import React from "react";
import { connect } from "react-redux";
import { BrowserRouter as Router } from "react-router-dom";
import BaseRouter from "./routes";
import Sidepanel from "./containers/Sidepanel";
import Profile from "./containers/Profile";
import AddChatModal from "./containers/Popup";
import * as actions from "./store/actions/auth";
import * as navActions from "./store/actions/nav";
import * as messageActions from "./store/actions/message";
import WebSocketInstance from "./websocket";
import "../../static/css/chat/style.css";

// Все в реакте это компонент и они обычно принимают форму JavaScript классов.
class App extends React.Component {


    /*
    Метод componentDidMount() запускается после того, как компонент отрендерился в DOM
    */
    componentDidMount() {
        this.props.onTryAutoSignup();
    }
    constructor(props) {
        super(props);
        WebSocketInstance.addCallbacks(
          this.props.setMessages.bind(this),
          this.props.addMessage.bind(this)
        );
    }

    render() {
        return(
            <Router>
                <div id="frame">
                    <Sidepanel />
                    <div className="content">
                        <AddChatModal 
                            idVisible = {this.props.showAddChatPopup}
                            close={() => this.props.closeAddChatPopup()} />
                        <Profile />
                        <BaseRouter />
                    </div>
                </div>
            </Router>
        );
    }
}
  

const mapStateToProps = state => {
    return {
        showAddChatPopup: state.nav.showAddChatPopup,
        authenticated: state.auth.token
    };
};

/*
    Oпределяем функции mapStateToProps() для чтения состояния и mapDispatchToProps() для передачи события
*/
const mapDispatchToProps = dispatch => {
    return {
        onTryAutoSignup: () => dispatch(actions.authCheckState()),
        closeAddChatPopup: () => dispatch(navActions.closeAddChatPopup()),
        addMessage: message => dispatch(messageActions.addMessage(message)),
        setMessages: messages => dispatch(messageActions.setMessages(messages))
    }
}
/*
    Этот декоратор принимает на вход 2 функции.
    Он возвращает функцию, в которую мы передаем наш компонент App. 

     API react-redux connect() используется для создания компонентов-контейнеров, которые подключены к хранилищу Redux
*/
export default connect(mapStateToProps, mapDispatchToProps)(App);