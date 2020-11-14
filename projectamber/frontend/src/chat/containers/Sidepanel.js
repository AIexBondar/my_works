import React from 'react';
import axios from 'axios';
import { Spin } from 'antd';
import { LoadingOutlined } from '@ant-design/icons';
import { connect } from 'react-redux';
import Contact from '../components/Contact';
import * as authActions from '../store/actions/auth';
import * as navActions from '../store/actions/nav';
import * as messageActions from "../store/actions/message";

const antIcon = < LoadingOutlined style= {{ fontSize: '24px' }} spin/>;

// https://metanit.com/web/react/2.6.php

class Sidepanel extends React.Component {

    state = { 
        loginForm: true,
    }

    waitForAuthDetails() {
        const component = this;
        setTimeout(function() {
          if (
            component.props.token !== null &&
            component.props.token !== undefined
          ) {
            component.props.getUserChats(
              component.props.username,
              component.props.token
            );
            return;
          } else {
            console.log("waiting for authentication details...");
            component.waitForAuthDetails();
          }
        }, 100);
    }

    componentDidMount() {
        this.waitForAuthDetails();
    }


    // вызывается при обновлении объекта props. Новые значения этого объекта передаются в функции в качестве параметра
    // UNSAFE_componentWillReceiveProps(newProps) {
    //     if (newProps.token !== null && newProps.username !== null) {
    //         this.getUserChats(newProps.token, newProps.username);
    //     }
    // }

    //  вызывается непосредственно перед рендерингом компонента
    // componentDidMount() {
    //     if (this.props.token !== null && this.props.username !== null) {
    //         this.getUserChats(this.props.token, this.props.username);
    //     }
    // }

    openAddChatPopup() {
        this.props.addChat();
    }

    changeForm = () => {
        this.setState({ loginForm: !this.state.loginForm });
    };

    // getUserChats = (token, username) => {
    //     axios.defaults.headers = {
    //         "Content-Type": "application/json",
    //         Authorization: `Token ${token}`
    //     };
    //     axios.get(`http://127.0.0.1:8000/chat/?username=${username}`)
    //     .then(res => this.setState({ chats: res.data })); // AJAX запрос к адрессу http://127.0.0.1:8000/chat/?username=${username}
    // }

    authenticate = (e) => {
        e.preventDefault();
        if (this.state.loginForm) {
            this.props.login(
                e.target.username.value, 
                e.target.password.value
            );
        } else {
            this.props.signup(
                e.target.username.value, 
                e.target.email.value, 
                e.target.password.value, 
                e.target.password2.value
            );
        }
    }

    render() {
        let activeChats = this.props.chats.map(c => {
          return (
            <Contact
              key={c.id}
              name="Harvey Specter"
              picURL="http://emilcarlsson.se/assets/louislitt.png"
              status="busy"
              chatURL={`/${c.id}`}
            />
          );
        });
        return (
          <div id="sidepanel">
            <div id="profile">
              <div className="wrap">
                <img
                  id="profile-img"
                  src="http://emilcarlsson.se/assets/mikeross.png"
                  className="online"
                  alt=""
                />
                <p>Mike Ross</p>
                <i
                  className="fa fa-chevron-down expand-button"
                  aria-hidden="true"
                />
                <div id="status-options">
                  <ul>
                    <li id="status-online" className="active">
                      <span className="status-circle" /> <p>Online</p>
                    </li>
                    <li id="status-away">
                      <span className="status-circle" /> <p>Away</p>
                    </li>
                    <li id="status-busy">
                      <span className="status-circle" /> <p>Busy</p>
                    </li>
                    <li id="status-offline">
                      <span className="status-circle" /> <p>Offline</p>
                    </li>
                  </ul>
                </div>
                <div id="expanded">
                  {this.props.loading ? (
                    <Spin indicator={antIcon} />
                  ) : this.props.isAuthenticated ? (
                    <button onClick={() => this.props.logout()} className="authBtn">
                      <span>Logout</span>
                    </button>
                  ) : (
                    <div>
                      <form method="POST" onSubmit={this.authenticate}>
                        {this.state.loginForm ? (
                          <div>
                            <input
                              name="username"
                              type="text"
                              placeholder="username"
                            />
                            <input
                              name="password"
                              type="password"
                              placeholder="password"
                            />
                          </div>
                        ) : (
                          <div>
                            <input
                              name="username"
                              type="text"
                              placeholder="username"
                            />
                            <input name="email" type="email" placeholder="email" />
                            <input
                              name="password"
                              type="password"
                              placeholder="password"
                            />
                            <input
                              name="password2"
                              type="password"
                              placeholder="password confirm"
                            />
                          </div>
                        )}

                        <button type="submit">Authenticate</button>
                      </form>

                      <button onClick={this.changeForm}>Switch</button>
                    </div>
                  )}
                </div>
              </div>
            </div>
            <div id="search">
              <label htmlFor="">
                <i className="fa fa-search" aria-hidden="true" />
              </label>
              <input type="text" placeholder="Search Chats..." />
            </div>
            <div id="contacts">
              <ul>{activeChats}</ul>
            </div>
            <div id="bottom-bar">
              <button id="addChat" onClick={() => this.openAddChatPopup()}>
                <i className="fa fa-user-plus fa-fw" aria-hidden="true" />
                <span>Create chat</span>
              </button>
              <button id="settings">
                <i className="fa fa-cog fa-fw" aria-hidden="true" />
                <span>Settings</span>
              </button>
            </div>
          </div>
        );
      }
    }

const mapStateToProps = state => {
    return {
        isAuthenticated: state.token !== null,
        loading: state.loading,
        token: state.token,
        username: state.username,
        chats: state.message.chats
    }
}

const mapDispatchToProps = dispatch => {
  return {
    login: (userName, password) => dispatch(actions.authLogin(userName, password)),
    logout: () => dispatch(actions.logout()),
    signup: (username, email, password1, password2) => dispatch(actions.authSignup(username, email, password1, password2)),
    addChat: () => dispatch(navActions.openAddChatPopup()),
    getUserChats: (username, token) => dispatch(messageActions.getUserChats(username, token))
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(Sidepanel);