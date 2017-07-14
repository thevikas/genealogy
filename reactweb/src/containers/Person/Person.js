import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";

export default class Person extends Component {
  render() {
    return (
          <div className="container-fluid">
          	Person Page
          </div>
    );
  }
}

/*
<Sidebox person={person} actions={actions}/>
<Route exact path="/" component={Dashboard}/>
<Footer/>
*/
/*
App.propTypes = {
  person: PropTypes.object.isRequired,
  actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
  return {
    person: state.person
  };
}

function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(PActions, dispatch)
  };
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(App);
*/
