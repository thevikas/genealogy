import React, { Component } from 'react';
//import MessageItem from './MessageItem/'
//import axios from 'axios';
import {Link} from 'react-router-dom';
//import * as APIConfig from 'APIConfig';
//import Gravatar from 'react-gravatar'
//For installing redux on this component
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
//import * as PActions from 'store/actions';
//redux ends

export default class TopNav extends Component {

    // Lifecycle method
    componentDidMount() {
        console.log("TopNav is loading Updates!")
        //this.props.actions.loadUpdates();
    }

  render() {
    return (
        <div id="user-nav" className="navbar navbar-inverse">
          <ul className="nav">
            <li  className="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" className="dropdown-toggle"><i className="icon icon-user"></i>  <span className="text">Welcome User</span><b className="caret"></b></a>
              <ul className="dropdown-menu">
                <li><a href="#"><i className="icon-user"></i> My Profile</a></li>
                <li className="divider"></li>
                <li><a href="#"><i className="icon-check"></i> My Tasks</a></li>
                <li className="divider"></li>
                <li><a href="login.html"><i className="icon-key"></i> Log Out</a></li>
              </ul>
            </li>
            <li className="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" className="dropdown-toggle"><i className="icon icon-envelope"></i> <span className="text">Messages</span> <span className="label label-important">5</span> <b className="caret"></b></a>
              <ul className="dropdown-menu">
                <li><a className="sAdd" title="" href="#"><i className="icon-plus"></i> new message</a></li>
                <li className="divider"></li>
                <li><a className="sInbox" title="" href="#"><i className="icon-envelope"></i> inbox</a></li>
                <li className="divider"></li>
                <li><a className="sOutbox" title="" href="#"><i className="icon-arrow-up"></i> outbox</a></li>
                <li className="divider"></li>
                <li><a className="sTrash" title="" href="#"><i className="icon-trash"></i> trash</a></li>
              </ul>
            </li>
            <li className=""><a title="" href="#"><i className="icon icon-cog"></i> <span className="text">Settings</span></a></li>
            <li className=""><a title="" href="login.html"><i className="icon icon-share-alt"></i> <span className="text">Logout</span></a></li>
          </ul>
        </div>
    )
  }
}
/*
TopNav.propTypes = {
    person: PropTypes.object.isRequired,
    actions: PropTypes.object.isRequired,
    messages: PropTypes.array.isRequired
};

function mapStateToProps(state) {
    console.log("mapStateToProps topnav",state.updates)
    return {person: state.person, messages: state.updates};
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(PActions, dispatch)
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(TopNav);
*/
