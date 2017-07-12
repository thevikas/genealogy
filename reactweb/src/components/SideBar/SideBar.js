import React, { Component } from 'react';
//import MessageItem from './MessageItem/'
//import axios from 'axios';
//import {Link} from 'react-router-dom';
//import * as APIConfig from 'APIConfig';
//import Gravatar from 'react-gravatar'
//For installing redux on this component
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';
//import PropTypes from 'prop-types';
//import * as PActions from 'store/actions';
//redux ends

export default class SideBar extends Component {

  render() {
    return (
        <div id="sidebar"><a href="#" className="visible-phone"><i className="icon icon-home"></i> Dashboard</a>
          <ul>
            <li className="active"><a href="index.html"><i className="icon icon-home"></i> <span>Dashboard</span></a> </li>
            <li> <a href="charts.html"><i className="icon icon-signal"></i> <span>Charts &amp; graphs</span></a> </li>
            <li> <a href="widgets.html"><i className="icon icon-inbox"></i> <span>Widgets</span></a> </li>
            <li><a href="tables.html"><i className="icon icon-th"></i> <span>Tables</span></a></li>
            <li><a href="grid.html"><i className="icon icon-fullscreen"></i> <span>Full width</span></a></li>
            <li className="submenu"> <a href="#"><i className="icon icon-th-list"></i> <span>Forms</span> <span className="label label-important">3</span></a>
              <ul>
                <li><a href="form-common.html">Basic Form</a></li>
                <li><a href="form-validation.html">Form with Validation</a></li>
                <li><a href="form-wizard.html">Form with Wizard</a></li>
              </ul>
            </li>
            <li><a href="buttons.html"><i className="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
            <li><a href="interface.html"><i className="icon icon-pencil"></i> <span>Eelements</span></a></li>
            <li className="submenu"> <a href="#"><i className="icon icon-file"></i> <span>Addons</span> <span className="label label-important">5</span></a>
              <ul>
                <li><a href="index2.html">Dashboard2</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="calendar.html">Calendar</a></li>
                <li><a href="invoice.html">Invoice</a></li>
                <li><a href="chat.html">Chat option</a></li>
              </ul>
            </li>
            <li className="submenu"> <a href="#"><i className="icon icon-info-sign"></i> <span>Error</span> <span className="label label-important">4</span></a>
              <ul>
                <li><a href="error403.html">Error 403</a></li>
                <li><a href="error404.html">Error 404</a></li>
                <li><a href="error405.html">Error 405</a></li>
                <li><a href="error500.html">Error 500</a></li>
              </ul>
            </li>
            <li className="content"> <span>Monthly Bandwidth Transfer</span>
              <div className="progress progress-mini progress-danger active progress-striped">
                <div style={{width: 77 + "%"}} className="bar"></div>
              </div>
              <span className="percent">77%</span>
              <div className="stat">21419.94 / 14000 MB</div>
            </li>
            <li className="content"> <span>Disk Space Usage</span>
              <div className="progress progress-mini active progress-striped">
                <div style={{width: 87 + "%"}} className="bar"></div>
              </div>
              <span className="percent">87%</span>
              <div className="stat">604.44 / 4000 MB</div>
            </li>
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
