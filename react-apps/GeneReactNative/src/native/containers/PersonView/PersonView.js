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
        console.log("checking navigationOptions", navigation);
        return {
            title: navigation.navigation.state.params.name == undefined
                ? "Person View Loading"
                : navigation.navigation.state.params.name
        };
    };

    constructor(props) {
        super(props);
        this.state = {
            id_person: this.props.navigation.state.params.id_person
        };
        this.afterFindPromise = this.afterFindPromise.bind(this);
        this._changePerson = this._changePerson.bind(this);
    }

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

    componentWillReceiveProps(nextProps)
    {
        console.log("newprops new-pid,state-pid", nextProps, this.state.id_person);
        /*
        if(nextProps.match.params.personid != this.state.id_person)
            this.props.actions.findOrLoadPerson(nextProps.match.params.personid).then(this.afterFindPromise);

        this.setState({id_person: nextProps.match.params.personid})
        */
    }

    // Lifecycle method
    componentDidMount() {
        console.log("PersonView mounted!", this.props)
        this.props.navigation.title = "Mounting...";
        this.props.actions.findOrLoadPerson(this.state.id_person).then(this.afterFindPromise);
    }

    componentDidUpdate(prevProps, prevState)
    {
        console.log("componentDidUpdate")
    }

    _changePerson(id_person)
    {
        console.log("got clicked on father",id_person);
        this.props.actions.findOrLoadPerson(id_person).then(this.afterFindPromise);
        this.setState({id_person: id_person})
    }

    render() {
        const {navigate} = this.props.navigation;
        console.log("After finishing fetching", this.props);
        return (
            <View style={styles.container}>
                <View style={styles.mydata}>
                    <View style={styles.myrow}>
                        <Text style={styles.label}>Father Name</Text>
                        <Text onPress={() => this._changePerson(this.props.father.id_person)} style={styles.item}>{this.props.father.name}</Text>
                    </View>
                    <View style={styles.myrow}>
                        <Text style={styles.label}>Mother Name</Text>
                        <Text onPress={() => this._changePerson(this.props.mother.id_person)} style={styles.item}>{this.props.mother.name}</Text>
                    </View>
                    <View style={styles.myrow}>
                        <Text style={styles.label}>Spouse Name</Text>
                        <Text onPress={() => this._changePerson(this.props.mother.id_person)} style={styles.item}>{this.props.spouse.name}</Text>
                    </View>
                </View>
                <View style={styles.mychildren}>
                    <Text style={styles.childrenheader}>Children</Text>
                    <FlatList data={this.props.children} renderItem={({item}) => <Text onPress={() => this._changePerson(item.person.id_person)} style={styles.item}>{item.person.name}</Text>}/>
                </View>
            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'flex-start'
    },
    mydata: {
        flexDirection: 'column',
        justifyContent: 'flex-start',
        alignItems: 'flex-start'
    },
    mychildren: {
        flexDirection: 'column',
        justifyContent: 'flex-start',
        height: "80%"
    },
    myrow: {
        flexDirection: 'row'
    },
    label: {
        padding: 10,
        fontSize: 18,
        height: 44,
        width: "30%"
    },
    childrow: {

    },
    childrenheader: {
        padding: 10,
        fontSize: 22,
        fontWeight: 'bold'
    },
    item: {
        padding: 10,
        fontSize: 18,
        fontWeight: 'bold'
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
