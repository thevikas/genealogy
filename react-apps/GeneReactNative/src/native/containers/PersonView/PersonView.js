/**
 * @provi1desModule RecentPeople
 */
import React, {Component, PropTypes} from 'react';
import {StyleSheet, Text, View, FlatList, Button} from 'react-native';
//redux START
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import * as PActions from '../../../store/actions';
//redux END

import * as types from 'constants/ActionTypes';

class PersonView extends React.Component {
    static navigationOptions = function(navigation) {
        console.log("checking navigationOptions",navigation);
        return {title: navigation.navigation.state.params.name == undefined ? "Person View Loading" : navigation.navigation.state.params.name};
    };

    afterFindPromise()
    {
        this.props.navigation.setParams({name: this.props.person.name});
        console.log("PersonView promise done3", this.props);
        if (this.props.child_ids.length > 0) {
            for (var i = 0; i < this.props.child_ids.length; i++) {
                console.log('finding child', this.props.child_ids[i]);
                this.props.actions.findOrLoadPerson(this.props.child_ids[i], types.APPEND_TO_CHILDREN);
            }
        }
    }

    constructor(props) {
        super(props);
        this.state = {
            id_person: this.props.navigation.state.params.id_person
        };
        this.afterFindPromise = this.afterFindPromise.bind(this);
    }
    // Lifecycle method
    componentDidMount() {
        console.log("PersonView mounted!", this.props)
        this.props.navigation.title = "Mounting...";
        this.props.actions.findOrLoadPerson(this.state.id_person).then(this.afterFindPromise);
    }

    render() {
        const { navigate } = this.props.navigation;
        return (
            <View>
                <Text onPress={() => navigate("PersonView",{id_person: this.props.father.id_person})} style={styles.item}>{this.props.father.name}</Text>
                <Text onPress={() => navigate("PersonView",{id_person: this.props.mother.id_person})} style={styles.item}>{this.props.mother.name}</Text>
                <Text onPress={() => navigate("PersonView",{id_person: this.props.spouse.id_person})} style={styles.item}>{this.props.spouse.name}</Text>
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
        fontWeight: 'bold',
        height: 44
    }
})

PersonView.propTypes = {
    person: PropTypes.object.isRequired,
    //father: PropTypes.object.isRequired,
    //mother: PropTypes.object.isRequired,
    //spouse: PropTypes.object.isRequired,
    actions: PropTypes.object.isRequired
};

function mapStateToProps(state) {
    console.log("mapStateToProps state?", state)
    return {
        person: state.person.person
            ? state.person.person
            : {},
        father: state.person.father
            ? state.person.father
            : {},
        mother: state.person.mother
            ? state.person.mother
            : {},
        spouse: state.person.spouse
            ? state.person.spouse
            : {},
        child_ids: state.person.child_ids
            ? state.person.child_ids
            : [],
        children: state.person.children
            ? state.person.children
            : []
    };
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(PActions, dispatch)
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(PersonView);
