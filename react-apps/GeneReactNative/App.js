import React from 'react';
import { AppRegistry, StyleSheet, Text, View } from 'react-native';
import { Provider } from 'react-redux';
import { configureStore } from 'configureStore';
import { StackNavigator } from 'react-navigation';
import HomeScreen from 'containers/HomeScreen';
import ChatScreen from 'containers/ChatScreen';
import RecentPeople from 'containers/RecentPeople';
const store = configureStore();

const SimpleApp = StackNavigator({
    Home: { screen: HomeScreen },
    Chat: { screen: ChatScreen },
    RecentPeople: { screen: RecentPeople }
});


export default class App extends React.Component {
  render() {
    return (
    <Provider store={store}>
      <SimpleApp/>
    </Provider>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
