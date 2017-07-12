import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";
import Breadcrumb from 'components/Breadcrumb'

export default class Dashboard extends Component {
  render() {
    return (
        <div id="content">
          <Breadcrumb/>

          <div className="container-fluid">
            <div className="quick-actions_homepage">
              <ul className="quick-actions">
                <li className="bg_lb"> <a href="index.html"> <i className="icon-dashboard"></i> <span className="label label-important">20</span> My Dashboard </a> </li>
                <li className="bg_lg span3"> <a href="charts.html"> <i className="icon-signal"></i> Charts</a> </li>
                <li className="bg_ly"> <a href="widgets.html"> <i className="icon-inbox"></i><span className="label label-success">101</span> Widgets </a> </li>
                <li className="bg_lo"> <a href="tables.html"> <i className="icon-th"></i> Tables</a> </li>
                <li className="bg_ls"> <a href="grid.html"> <i className="icon-fullscreen"></i> Full width</a> </li>
                <li className="bg_lo span3"> <a href="form-common.html"> <i className="icon-th-list"></i> Forms</a> </li>
                <li className="bg_ls"> <a href="buttons.html"> <i className="icon-tint"></i> Buttons</a> </li>
                <li className="bg_lb"> <a href="interface.html"> <i className="icon-pencil"></i>Elements</a> </li>
                <li className="bg_lg"> <a href="calendar.html"> <i className="icon-calendar"></i> Calendar</a> </li>
                <li className="bg_lr"> <a href="error404.html"> <i className="icon-info-sign"></i> Error</a> </li>

              </ul>
            </div>

            <div className="row-fluid">
              <div className="widget-box">
                <div className="widget-title bg_lg"><span className="icon"><i className="icon-signal"></i></span>
                  <h5>Site Analytics</h5>
                </div>
                <div className="widget-content" >
                  <div className="row-fluid">
                    <div className="span9">
                      <div className="chart"></div>
                    </div>
                    <div className="span3">
                      <ul className="site-stats">
                        <li className="bg_lh"><i className="icon-user"></i> <strong>2540</strong> <small>Total Users</small></li>
                        <li className="bg_lh"><i className="icon-plus"></i> <strong>120</strong> <small>New Users </small></li>
                        <li className="bg_lh"><i className="icon-shopping-cart"></i> <strong>656</strong> <small>Total Shop</small></li>
                        <li className="bg_lh"><i className="icon-tag"></i> <strong>9540</strong> <small>Total Orders</small></li>
                        <li className="bg_lh"><i className="icon-repeat"></i> <strong>10</strong> <small>Pending Orders</small></li>
                        <li className="bg_lh"><i className="icon-globe"></i> <strong>8540</strong> <small>Online Orders</small></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr/>
            <div className="row-fluid">
              <div className="span6">
                <div className="widget-box">
                  <div className="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span className="icon"><i className="icon-chevron-down"></i></span>
                    <h5>Latest Posts</h5>
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
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"/> </div>
                        <div className="article-post"> <span className="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                          <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                        </div>
                      </li>
                      <li>
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av4.jpg"/> </div>
                        <div className="article-post"> <span className="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                          <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a> </p>
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
                    <h5>To Do list</h5>
                  </div>
                  <div className="widget-content">
                    <div className="todo">
                      <ul>
                        <li className="clearfix">
                          <div className="txt"> Luanch This theme on Themeforest <span className="by label">Alex</span></div>
                          <div className="pull-right"> <a className="tip" href="#" title="Edit Task"><i className="icon-pencil"></i></a> <a className="tip" href="#" title="Delete"><i className="icon-remove"></i></a> </div>
                        </li>
                        <li className="clearfix">
                          <div className="txt"> Manage Pending Orders <span className="date badge badge-warning">Today</span> </div>
                          <div className="pull-right"> <a className="tip" href="#" title="Edit Task"><i className="icon-pencil"></i></a> <a className="tip" href="#" title="Delete"><i className="icon-remove"></i></a> </div>
                        </li>
                        <li className="clearfix">
                          <div className="txt"> MAke your desk clean <span className="by label">Admin</span></div>
                          <div className="pull-right"> <a className="tip" href="#" title="Edit Task"><i className="icon-pencil"></i></a> <a className="tip" href="#" title="Delete"><i className="icon-remove"></i></a> </div>
                        </li>
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
                <div className="widget-box">
                  <div className="widget-title"> <span className="icon"><i className="icon-ok"></i></span>
                    <h5>Progress Box</h5>
                  </div>
                  <div className="widget-content">
                    <ul className="unstyled">
                      <li> <span className="icon24 icomoon-icon-arrow-up-2 green"></span> 81% Clicks <span className="pull-right strong">567</span>
                        <div className="progress progress-striped ">
                          <div style={{width: "81%"}} className="bar"></div>
                        </div>
                      </li>
                      <li> <span className="icon24 icomoon-icon-arrow-up-2 green"></span> 72% Uniquie Clicks <span className="pull-right strong">507</span>
                        <div className="progress progress-success progress-striped ">
                          <div style={{width: "72%"}} className="bar"></div>
                        </div>
                      </li>
                      <li> <span className="icon24 icomoon-icon-arrow-down-2 red"></span> 53% Impressions <span className="pull-right strong">457</span>
                        <div className="progress progress-warning progress-striped ">
                          <div style={{width: "53%"}} className="bar"></div>
                        </div>
                      </li>
                      <li> <span className="icon24 icomoon-icon-arrow-up-2 green"></span> 3% Online Users <span className="pull-right strong">8</span>
                        <div className="progress progress-danger progress-striped ">
                          <div style={{width: "3%"}} className="bar"></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div className="widget-box">
                  <div className="widget-title bg_lo"  data-toggle="collapse" href="#collapseG3" > <span className="icon"> <i className="icon-chevron-down"></i> </span>
                    <h5>News updates</h5>
                  </div>
                  <div className="widget-content nopadding updates collapse in" id="collapseG3">
                    <div className="new-update clearfix"><i className="icon-ok-sign"></i>
                      <div className="update-done"><a title="" href="#"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</strong></a> <span>dolor sit amet, consectetur adipiscing eli</span> </div>
                      <div className="update-date"><span className="update-day">20</span>jan</div>
                    </div>
                    <div className="new-update clearfix"> <i className="icon-gift"></i> <span className="update-notice"> <a title="" href="#"><strong>Congratulation Maruti, Happy Birthday </strong></a> <span>many many happy returns of the day</span> </span> <span className="update-date"><span className="update-day">11</span>jan</span> </div>
                    <div className="new-update clearfix"> <i className="icon-move"></i> <span className="update-alert"> <a title="" href="#"><strong>Maruti is a Responsive Admin theme</strong></a> <span>But already everything was solved. It will ...</span> </span> <span className="update-date"><span className="update-day">07</span>Jan</span> </div>
                    <div className="new-update clearfix"> <i className="icon-leaf"></i> <span className="update-done"> <a title="" href="#"><strong>Envato approved Maruti Admin template</strong></a> <span>i am very happy to approved by TF</span> </span> <span className="update-date"><span className="update-day">05</span>jan</span> </div>
                    <div className="new-update clearfix"> <i className="icon-question-sign"></i> <span className="update-notice"> <a title="" href="#"><strong>I am alwayse here if you have any question</strong></a> <span>we glad that you choose our template</span> </span> <span className="update-date"><span className="update-day">01</span>jan</span> </div>
                  </div>
                </div>

              </div>
              <div className="span6">
                <div className="widget-box widget-chat">
                  <div className="widget-title bg_lb"> <span className="icon"> <i className="icon-comment"></i> </span>
                    <h5>Chat Option</h5>
                  </div>
                  <div className="widget-content nopadding collapse in" id="collapseG4">
                    <div className="chat-users panel-right2">
                      <div className="panel-title">
                        <h5>Online Users</h5>
                      </div>
                      <div className="panel-content nopadding">
                        <ul className="contact-list">
                          <li id="user-Alex" className="online"><a href=""><img alt="" src="img/demo/av1.jpg" /> <span>Alex</span></a></li>
                          <li id="user-Linda"><a href=""><img alt="" src="img/demo/av2.jpg" /> <span>Linda</span></a></li>
                          <li id="user-John" className="online new"><a href=""><img alt="" src="img/demo/av3.jpg" /> <span>John</span></a><span className="msg-count badge badge-info">3</span></li>
                          <li id="user-Mark" className="online"><a href=""><img alt="" src="img/demo/av4.jpg" /> <span>Mark</span></a></li>
                          <li id="user-Maxi" className="online"><a href=""><img alt="" src="img/demo/av5.jpg" /> <span>Maxi</span></a></li>
                        </ul>
                      </div>
                    </div>
                    <div className="chat-content panel-left2">
                      <div className="chat-messages" id="chat-messages">
                        <div id="chat-messages-inner"></div>
                      </div>
                      <div className="chat-message well">
                        <button className="btn btn-success">Send</button>
                        <span className="input-box">
                        <input type="text" name="msg-box" id="msg-box" />
                        </span> </div>
                    </div>
                  </div>
                </div>
                <div className="widget-box">
                  <div className="widget-title"><span className="icon"><i className="icon-user"></i></span>
                    <h5>Our Partner (Box with Fix height)</h5>
                  </div>
                  <div className="widget-content nopadding fix_hgt">
                    <ul className="recent-posts">
                      <li>
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"/> </div>
                        <div className="article-post"> <span className="user-info">John Deo</span>
                          <p>Web Desginer &amp; creative Front end developer</p>
                        </div>
                      </li>
                      <li>
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"/> </div>
                        <div className="article-post"> <span className="user-info">John Deo</span>
                          <p>Web Desginer &amp; creative Front end developer</p>
                        </div>
                      </li>
                      <li>
                        <div className="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av4.jpg"/> </div>
                        <div className="article-post"> <span className="user-info">John Deo</span>
                          <p>Web Desginer &amp; creative Front end developer</p>
                        </div>
                        </li>
                    </ul>
                  </div>
                </div>
                <div className="accordion" id="collapse-group">
                  <div className="accordion-group widget-box">
                    <div className="accordion-heading">
                      <div className="widget-title"> <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse"> <span className="icon"><i className="icon-magnet"></i></span>
                        <h5>Accordion Example 1</h5>
                        </a> </div>
                    </div>
                    <div className="collapse in accordion-body" id="collapseGOne">
                      <div className="widget-content"> It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </div>
                    </div>
                  </div>
                  <div className="accordion-group widget-box">
                    <div className="accordion-heading">
                      <div className="widget-title"> <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse"> <span className="icon"><i className="icon-magnet"></i></span>
                        <h5>Accordion Example 2</h5>
                        </a> </div>
                    </div>
                    <div className="collapse accordion-body" id="collapseGTwo">
                      <div className="widget-content">And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.</div>
                    </div>
                  </div>
                  <div className="accordion-group widget-box">
                    <div className="accordion-heading">
                      <div className="widget-title"> <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse"> <span className="icon"><i className="icon-magnet"></i></span>
                        <h5>Accordion Example 3</h5>
                        </a> </div>
                    </div>
                    <div className="collapse accordion-body" id="collapseGThree">
                      <div className="widget-content"> Waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just </div>
                    </div>
                  </div>
                </div>
                <div className="widget-box collapsible">
                  <div className="widget-title"> <a data-toggle="collapse" href="#collapseOne"> <span className="icon"><i className="icon-arrow-right"></i></span>
                    <h5>Toggle, Open by default, </h5>
                    </a> </div>
                  <div id="collapseOne" className="collapse in">
                    <div className="widget-content"> This box is opened by default, paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </div>
                  </div>
                  <div className="widget-title"> <a data-toggle="collapse" href="#collapseTwo"> <span className="icon"><i className="icon-remove"></i></span>
                    <h5>Toggle, closed by default</h5>
                    </a> </div>
                  <div id="collapseTwo" className="collapse">
                    <div className="widget-content"> This box is now open </div>
                  </div>
                  <div className="widget-title"> <a data-toggle="collapse" href="#collapseThree"> <span className="icon"><i className="icon-remove"></i></span>
                    <h5>Toggle, closed by default</h5>
                    </a> </div>
                  <div id="collapseThree" className="collapse">
                    <div className="widget-content"> This box is now open </div>
                  </div>
                </div>
                <div className="widget-box">
                  <div className="widget-title">
                    <ul className="nav nav-tabs">
                      <li className="active"><a data-toggle="tab" href="#tab1">Tab1</a></li>
                      <li><a data-toggle="tab" href="#tab2">Tab2</a></li>
                      <li><a data-toggle="tab" href="#tab3">Tab3</a></li>
                    </ul>
                  </div>
                  <div className="widget-content tab-content">
                    <div id="tab1" className="tab-pane active">
                      <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment.</p>
                      <img src="img/demo/demo-image1.jpg" alt="demo-image"/></div>
                    <div id="tab2" className="tab-pane"> <img src="img/demo/demo-image2.jpg" alt="demo-image"/>
                      <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment.</p>
                    </div>
                    <div id="tab3" className="tab-pane">
                      <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. </p>
                      <img src="img/demo/demo-image3.jpg" alt="demo-image"/></div>
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
