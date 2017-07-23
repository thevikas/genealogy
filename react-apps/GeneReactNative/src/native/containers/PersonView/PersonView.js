/**
 * @provi1desModule RecentPeople
 */
import React, {Component, PropTypes} from 'react';
import {StyleSheet, Text, View, FlatList, Button} from 'react-native';
import {styles} from 'libs/styles';
import PersonLink from 'components/PersonLink';
//redux START
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import * as PActions from '../../../store/actions';
import * as types from 'constants/ActionTypes';
//redux END

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
        this.props.actions.appendRecentPerson(this.props.person);
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
        console.log("got clicked on father", id_person);
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
                        <PersonLink person={this.props.father} _changePerson={this._changePerson}/>
                    </View>
                    <View style={styles.myrow}>
                        <Text style={styles.label}>Mother Name</Text>
                        <PersonLink person={this.props.mother} _changePerson={this._changePerson}/>
                    </View>
                    <View style={styles.myrow}>
                        <Text style={styles.label}>Spouse Name</Text>
                        <PersonLink person={this.props.spouse} _changePerson={this._changePerson}/>
                    </View>
                </View>
                {this.props.children.length>0 &&
                <View style={styles.mychildren}>
                    <Text style={styles.childrenheader}>Children</Text>
                    <FlatList data={this.props.children} renderItem={({item}) => <PersonLink person={item.person} _changePerson={this._changePerson}/>}/>
                </View>}
                {this.props.recent.length>0 &&
                <View style={styles.recent}>
                    <Text style={styles.childrenheader}>Recent</Text>
                    <FlatList data={this.props.recent} renderItem={({item}) => <PersonLink person={item} _changePerson={this._changePerson}/>}/>
                </View>}
            </View>
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
        recent: state.recentpeople
            ? state.recentpeople
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
