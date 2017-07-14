import React, { Component, PropTypes } from 'react';
//import { bindActionCreators } from 'redux';
//import { connect } from 'react-redux';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';

export default class PersonRowItem extends Component {
  render() {
    return (
        <tr className="odd gradeX">
          <td>{this.props.personp.person.name}</td>
          <td>{this.props.personp.person.age}</td>
          <td>{this.props.personp.spouse && this.props.personp.spouse.name}</td>
          <td>{this.props.personp.father && this.props.personp.father.name}</td>
          <td>{this.props.personp.mother && this.props.personp.mother.name}</td>
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
