import React, { Component, PropTypes } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PActions from 'store/actions';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";
import PersonRowItem from 'containers/People/PersonRowItem'
import PersonLink from "components/PersonLink";

export class PersonView extends Component {

    // Lifecycle method
    componentDidMount() {
        this.props.actions.loadPeopleAndFindPerson(this.props.match.params.personid)
    }

  render() {
    return (
          <div className="container-fluid">
              <div className="widget-box">
                <div className="widget-title"> <span className="icon"> <i className="icon-align-justify"></i> </span>
                  <h5>Personal-info</h5>
                </div>
                <div className="widget-content nopadding">
                  <form action="#" method="get" className="form-horizontal">
                    <div className="control-group">
                      <label className="control-label">First Name :</label>
                      <div className="controls">
                        <div>{this.props.person.name}</div>
                      </div>
                    </div>

                    {this.props.person.age>0 &&
                    <div className="control-group">
                      <label className="control-label">Age :</label>
                      <div className="controls">
                        <div>{this.props.person.age} years</div>
                      </div>
                  </div>}

                  {this.props.spouse &&
                  <div className="control-group">
                    <label className="control-label">Spouse :</label>
                    <div className="controls">
                      <div><PersonLink show='name' person={this.props.spouse}/></div>
                    </div>
                </div>}

                {this.props.father &&
                <div className="control-group">
                  <label className="control-label">Father :</label>
                  <div className="controls">
                    <div><PersonLink show='name' person={this.props.father}/></div>
                  </div>
              </div>}

              {this.props.mother &&
              <div className="control-group">
                <label className="control-label">Mother :</label>
                <div className="controls">
                  <div><PersonLink show='name' person={this.props.mother}/></div>
                </div>
            </div>}

                    <div className="form-actions">
                      <button type="submit" className="btn btn-success">Save</button>
                    </div>
                  </form>
                </div>
              </div>
          </div>
    );
  }
}


PersonView.propTypes = {
  person: PropTypes.object.isRequired,
  father: PropTypes.object.isRequired,
  father: PropTypes.object.isRequired,
  spouse: PropTypes.object.isRequired,
  actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
    console.log('IN mapStateToProps, trying to find ', state.finder.id_person)
      const personp = state.people.filter((personp) => personp.person.id_person == state.finder.id_person)
      if(personp.length==0) return {
          person: {},
          projects: [],
          updates: []
      }
      return {
          person: personp[0].person,
          father: personp[0].father ? personp[0].father : {},
          mother: personp[0].mother ? personp[0].mother : {},
          spouse: personp[0].spouse ? personp[0].spouse : {},
          updates: [],
          projects: personp[0].projects
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
)(PersonView);
