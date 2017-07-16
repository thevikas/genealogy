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
        this.props.actions.findOrLoadPerson(this.props.match.params.personid).then(function()
        {
            console.log("PersonView promise done1");
        });

        this.state = {
            id_person: this.props.match.params.personid
          };
    }

    componentWillUnmount()
    {
        this.props.actions.setViewinfo({name: "",path: false});
    }

    componentWillReceiveProps(nextProps)
    {
        console.log("newprops new-pid,state-pid",nextProps.match.params.personid,this.state.id_person);
        if(nextProps.match.params.personid != this.state.id_person)
            this.props.actions.findOrLoadPerson(nextProps.match.params.personid).then(function()
            {
                console.log("PersonView promise done2");
            });

        this.setState({id_person: nextProps.match.params.personid})
        //if(nextProps.person.id_person)
        //    this.props.actions.setViewinfo({name: nextProps.person.name,path: '/people/view/' + nextProps.person.id_person});
    }

  render() {
    if(!this.props.person)
        return null;
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
  //father: PropTypes.object.isRequired,
  //mother: PropTypes.object.isRequired,
  //spouse: PropTypes.object.isRequired,
  actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
    console.log("mapStateToProps state?",state)
    return {
      person: state.person.person ? state.person.person : {},
      father: state.person.father ? state.person.father : {},
      mother: state.person.mother ? state.person.mother : {},
      spouse: state.person.spouse ? state.person.spouse : {},
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
