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

export default class SearchNav extends Component {

  render() {
    return (
        <div id="search">
          <input type="text" placeholder="Search here..."/>
          <button type="submit" className="tip-bottom" title="Search"><i
            className="icon-search icon-white"></i></button>
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
