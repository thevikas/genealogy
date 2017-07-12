import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";

import Header from 'components/Header'
import TopNav from 'components/TopNav'
import SearchNav from 'components/TopNav/SearchNav'

import SideBar from 'components/SideBar'

import Dashboard from 'containers/Dashboard/'
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
            <Progress.Component/>
            <Header/>
            <TopNav/>
            <SearchNav/>
            <SideBar/>
            <Route exact path="/" component={Dashboard}/>
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
