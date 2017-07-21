/**
 * @provi1desModule RecentPeople
 */
 import React, { Component, PropTypes } from 'react';
import HomeScreen from 'containers/HomeScreen';
import { Text, View, Button } from 'react-native';
//redux START
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PActions from '../../../store/actions';
//redux END

export class RecentPeople extends React.Component {
  static navigationOptions = {
    title: 'Recent People',
  };
  render() {
    return (
      <View>
        <Text>Recent People List</Text>
      </View>
    );
  }
}

RecentPeople.propTypes = {
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
)(RecentPeople);
