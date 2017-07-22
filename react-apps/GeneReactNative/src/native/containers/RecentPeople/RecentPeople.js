/**
 * @provi1desModule RecentPeople
 */
import React, { Component, PropTypes } from 'react';
import HomeScreen from 'containers/HomeScreen';
import { StyleSheet, Text, View, FlatList, Button } from 'react-native';
//redux START
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PActions from '../../../store/actions';
//redux END

class RecentPeople extends React.Component {
  static navigationOptions = {
    title: 'Recent People',
  };

  // Lifecycle method
  componentDidMount() {
      console.log("RecentPeople mounted!")
      this.props.actions.loadPeople();
  }

  render() {
    return (
      <View>
        <Text>Recent People List. People count: {this.props.people.length}</Text>

            <FlatList
                 data={this.props.people}
                 renderItem={({item}) => <Text style={styles.item}>{item.person.name}</Text>}
               />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
   flex: 1,
   paddingTop: 22
  },
  item: {
    padding: 10,
    fontSize: 18,
    height: 44,
  },
})

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
