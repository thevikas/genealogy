import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import PersonLink from "webcomponents/PersonLink";

export default class PersonRowItem extends Component {
  render() {
    return (
        <tr className="odd gradeX">
          <td><PersonLink show='name' person={this.props.personp.person}/></td>
          <td>{this.props.personp.person.age}</td>
          <td>{this.props.personp.spouse && <PersonLink show='name' person={this.props.personp.spouse}/>}</td>
          <td>{this.props.personp.father && <PersonLink show='name' person={this.props.personp.father}/>}}</td>
          <td>{this.props.personp.mother && <PersonLink show='name' person={this.props.personp.mother}/>}}</td>
        </tr>
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
