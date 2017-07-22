import React, {Component} from 'react';
import {Text, Image} from 'react-native';
import {styles} from 'libs/styles';

export default function PersonLink(props) {
        console.log("PersonLink loading",props);
        if (props.person.id_person != undefined)
            return (
                <Text style={styles.item} onPress={() => props._changePerson(props.person.id_person)}>
                    {props.person.name}
                    ({props.person.gender ? "M" : "F"}{props.person.age>0 && " " + props.person.age})
                </Text>
            )
        else
            return null;
        }
