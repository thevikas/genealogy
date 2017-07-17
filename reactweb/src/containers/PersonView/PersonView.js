import React, { Component, PropTypes } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PActions from 'store/actions';

import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Link} from 'react-router-dom';
import Progress from "react-progress-2";
import PersonRowItem from 'containers/People/PersonRowItem'
import PersonLink from "components/PersonLink";

import { APPEND_TO_CHILDREN } from 'constants/ActionTypes';

export class PersonView extends Component {

    constructor(props) {
        // Pass props to parent class
        super(props);
        // Set initial state
        this.afterFindPromise = this.afterFindPromise.bind(this);
    }

    afterFindPromise()
    {
        console.log("PersonView promise done3",this.props);
        if(this.props.child_ids.length>0)
        {
            for(var i=0; i< this.props.child_ids.length; i++)
            {
                console.log('finding child',this.props.child_ids[i]);
                this.props.actions.findOrLoadPerson(this.props.child_ids[i],APPEND_TO_CHILDREN);
            }
        }
    }
    // Lifecycle method
    componentDidMount() {
        this.props.actions.findOrLoadPerson(this.props.match.params.personid).then(this.afterFindPromise);

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
            this.props.actions.findOrLoadPerson(nextProps.match.params.personid).then(this.afterFindPromise);

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

                  </form>
                </div>
              </div>

              <div className="widget-box">
                <div className="widget-title"> <span className="icon"> <i className="icon-align-justify"></i> </span>
                  <h5>Children</h5>
                </div>
                <div className="widget-content nopadding chat-users">

                    <div className="panel-content nopadding">
                        <ul className="contact-list">
                          {this.props.children.map((personp, index) => <ChildItem key={personp.person.id_person} person={personp.person}/>)}
                        </ul>
                      </div>

                </div>
            </div>
          </div>
    );
  }
}

export function ChildItem(props) {
    return <li id="user-Alex" className="online">
            <i className={"fa " + (props.person.gender ? "fa-male" : "fa-female")}/>
            <PersonLink show='name' person={props.person}>
                <span>{props.person.name}</span>
            </PersonLink>
        </li>
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
      child_ids: state.person.child_ids ? state.person.child_ids : [],
      children: state.person.children ? state.person.children : []
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
