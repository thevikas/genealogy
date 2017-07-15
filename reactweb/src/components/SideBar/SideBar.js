import React, { Component } from 'react';
import {Link} from 'react-router-dom';
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
            <li className="active"><Link to="/"><i className="icon icon-home"></i> <span>Dashboard</span></Link> </li>
            <li><Link to="/people"><i className="icon icon-pencil"></i> <span>People</span></Link></li>
            <li> <a href="charts.html"><i className="icon icon-signal"></i> <span>Charts &amp; graphs</span></a> </li>
            <li> <a href="/events"><i className="icon icon-signal"></i> <span>Events</span></a> </li>
            <li> <a href="charts.html"><i className="icon icon-signal"></i> <span>Recent Updates</span></a> </li>
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
