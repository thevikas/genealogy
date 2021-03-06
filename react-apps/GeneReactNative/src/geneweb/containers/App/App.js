import React, { Component, PropTypes } from 'react';
import {BrowserRouter, Route, Link} from 'react-router-dom';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import DevTools from 'libs/DevTools';

import TopNav from 'webcomponents/TopNav'
import Header from 'webcomponents/Header'
import SearchNav from 'webcomponents/TopNav/SearchNav'
import SideBar from 'webcomponents/SideBar'
import Breadcrumb from 'webcomponents/Breadcrumb'
import Footer from 'webcomponents/Footer'

import Dashboard from 'webcontainers/Dashboard/'
import People from 'webcontainers/People/'
import PersonView from 'webcontainers/PersonView/'
/*import ReactDOM from 'react-dom';
import Progress from "react-progress-2";



*/
/*
import People from 'containers/People/'
import NewPerson from 'containers/People/NewPerson/'
import PersonView from 'containers/People/PersonView/'
import PersonEdit from 'containers/People/PersonEdit/'
import PersonProject from 'containers/People/PersonProject/'

import Projects from 'containers/Projects/'
import NewProject from 'containers/Projects/NewProject/'
import ProjectEdit from 'containers/Projects/Edit/'
import ProjectView from 'containers/Projects/ProjectView/'
import GanttView from 'containers/Projects/GanttView/'

import Updates from 'containers/Updates/'
import NewUpdate from 'containers/Updates/NewUpdate/'
import NewXLSUpdate from 'containers/Updates/NewXLSUpdate/'
import UpdateView from 'containers/Updates/UpdateView/'

import ProfilePic from 'views/ProfilePic/'
import Sidebox from 'views/Sidebox/'
import Footer from 'views/Footer/'
*/

//import DevTools from 'libs/DevTools';

//import * as PActions from 'store/actions';

//var rb = require('react-bootstrap');

export default class App extends Component {
  render() {
    return (
        <BrowserRouter>
            <xyz>
            <TopNav/>
            <SearchNav/>
            <SideBar/>
            <div id="content">
            <Breadcrumb/>
            <Route exact path="/" component={Dashboard}/>
            <Route exact path="/people" component={People}/>
            <Route path="/people/view/:personid" component={PersonView}/>
            </div>
            <Footer/>
            {1 && <DevTools />}
            </xyz>
        </BrowserRouter>
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
