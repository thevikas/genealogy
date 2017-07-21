import React, { Component, PropTypes } from 'react';

import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PActions from 'store/actions';

import PersonRowItem from 'containers/People/PersonRowItem'

export class People extends Component {

    // Lifecycle method
    componentDidMount() {
        this.props.actions.loadPeople();
        this.props.actions.setViewinfo({name: 'People',path: '/'});
    }

  render() {
    return (
          <div className="container-fluid">
              <div className="widget-box">
                  <div className="widget-title"> <span className="icon"> <i className="icon-th"></i> </span>
                    <h5>Static table</h5>
                  </div>
                  <div className="widget-content nopadding">
                    <table className="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Full Name</th>
                          <th>Age</th>
                          <th>Spouse</th>
                          <th>Father</th>
                          <th>Mother</th>
                        </tr>
                      </thead>
                      <tbody>
                        {this.props.people.map((personp, index) => <PersonRowItem key={personp.person.id_person} personp={personp}/>)}
                      </tbody>
                    </table>
                  </div>
                </div>
          </div>
    );
  }
}


People.propTypes = {
  people: PropTypes.array.isRequired,
  actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
  return {
    people: state.people
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
)(People);
