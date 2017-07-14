import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";

export default class Dashboard extends Component {
  render() {
    return (
          <div className="container-fluid">
            <div className="quick-actions_homepage">
              <ul className="quick-actions">
                <li className="bg_lb"> <a href="index.html"> <i className="icon-dashboard"></i> <span className="label label-important">20</span> Person </a> </li>
                <li className="bg_lg span3"> <a href="charts.html"> <i className="icon-signal"></i> Charts </a> </li>
                <li className="bg_ly"> <a href="widgets.html"> <i className="icon-inbox"></i><span className="label label-success">101</span> Events </a> </li>
                <li className="bg_lo"> <a href="tables.html"> <i className="icon-th"></i> Totaram </a> </li>                
              </ul>
            </div>

            <hr/>
            <div className="row-fluid">
              <div className="span6">
                <div className="widget-box">
                  <div className="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span className="icon"><i className="icon-chevron-down"></i></span>
                    <h5>Recent Updates</h5>
                  </div>
                  <div className="widget-content nopadding collapse in" id="collapseG2">
                    <ul className="recent-posts">
                      <li>
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"/> </div>
                        <div className="article-post"> <span className="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                          <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                        </div>
                      </li>                      
                      <li>
                        <button className="btn btn-warning btn-mini">View All</button>
                      </li>
                    </ul>
                  </div>
                </div>
                <div className="widget-box">
                  <div className="widget-title"> <span className="icon"><i className="icon-ok"></i></span>
                    <h5>Events</h5>
                  </div>
                  <div className="widget-content">
                    <div className="todo">
                      <ul>
                        <li className="clearfix">
                          <div className="txt"> Today we celebrate the theme <span className="date badge badge-info">08.03.2013</span> </div>
                          <div className="pull-right"> <a className="tip" href="#" title="Edit Task"><i className="icon-pencil"></i></a> <a className="tip" href="#" title="Delete"><i className="icon-remove"></i></a> </div>
                        </li>
                        <li className="clearfix">
                          <div className="txt"> Manage all the orders <span className="date badge badge-important">12.03.2013</span> </div>
                          <div className="pull-right"> <a className="tip" href="#" title="Edit Task"><i className="icon-pencil"></i></a> <a className="tip" href="#" title="Delete"><i className="icon-remove"></i></a> </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>                               
              </div>              
            </div>
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
